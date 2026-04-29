@props(['challenge', 'game'])

<div class="visual-box" id="fabric-container">
    @php 
        $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
        $revealPath = $challenge->reveal_image_path ?? $challenge->stimulus_data['reveal_image_path'] ?? null;
        $displayPath = $imagePath ?? $revealPath;
        $isSilhouette = $game->slug === 'guess-silhouette';
    @endphp
    
    @if($displayPath)
        <div class="canvas-wrapper">
            <div class="visual-frame"></div>
            <div class="image-stage-copy">
                <span class="stimulus-tag">{{ $isSilhouette ? __('Challenge Mode') : __('Image') }}</span>
                <strong>{{ $isSilhouette ? __('Solve the mystery!') : $game->localized_title }}</strong>
            </div>
            <canvas id="silhouette-canvas"></canvas>
            {{-- Hidden source image --}}
            <img id="source-image" 
                  src="{{ asset('storage/' . $displayPath) }}" 
                  style="display: none;"
                 data-is-silhouette="{{ $isSilhouette ? 'true' : 'false' }}">
        </div>
    @else
        <div class="placeholder-wrapper">
            <p>{{ __('Image not found') }}</p>
        </div>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

<style>
    .visual-box {
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.14), transparent 28%),
            radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.12), transparent 24%),
            rgba(var(--surface-muted-rgb), 0.82);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-soft);
        border-radius: 32px;
        overflow: hidden;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        margin-bottom: 1rem;
        min-height: clamp(220px, 35vw, 420px);
        position: relative;
    }
    
    .canvas-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        padding: 3.5rem 1rem 1rem;
    }

    .visual-frame {
        position: absolute;
        inset: 1rem;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.06), rgba(16, 185, 129, 0.08));
        border: 1px solid rgba(255, 255, 255, 0.12);
        pointer-events: none;
    }

    .image-stage-copy {
        position: absolute;
        top: 1.2rem;
        inset-inline-start: 1.2rem;
        z-index: 2;
        display: grid;
        gap: 0.35rem;
        max-width: min(100%, 320px);
    }

    .stimulus-tag {
        display: inline-flex;
        width: fit-content;
        padding: 0.42rem 0.75rem;
        border-radius: 999px;
        background: rgba(var(--surface-rgb), 0.75);
        border: 1px solid var(--border-soft);
        color: var(--text-soft);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .image-stage-copy strong {
        color: var(--text);
        font-family: var(--font-display);
        font-size: clamp(1.05rem, 2vw, 1.35rem);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    #silhouette-canvas {
        max-width: calc(100% - 2rem);
        max-height: 460px;
        position: relative;
        z-index: 1;
        filter: drop-shadow(0 18px 30px rgba(15, 23, 42, 0.18));
    }

    .placeholder-wrapper {
        padding: 4rem;
        color: var(--text-soft);
        font-weight: 700;
        text-align: center;
    }

    @media (max-width: 640px) {
        .canvas-wrapper {
            padding: 4.8rem 0.7rem 0.7rem;
        }

        .visual-frame {
            inset: 0.7rem;
        }

        #silhouette-canvas {
            max-width: calc(100% - 1.4rem);
            max-height: 360px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imgElement = document.getElementById('source-image');
    if (!imgElement) return;

    const isSilhouetteGame = imgElement.dataset.isSilhouette === 'true';
    const canvas = new fabric.Canvas('silhouette-canvas', { selection: false });

    // Important for filtering same-origin or CORS images
    fabric.Image.fromURL(imgElement.src, function(img) {
        const maxWidth = 500;
        const maxHeight = 500;
        const scale = Math.min(maxWidth / img.width, maxHeight / img.height);
        
        canvas.setDimensions({
            width: img.width * scale,
            height: img.height * scale
        });

        img.set({
            scaleX: scale,
            scaleY: scale,
            originX: 'center',
            originY: 'center',
            left: canvas.width / 2,
            top: canvas.height / 2,
            selectable: false
        });

        if (isSilhouetteGame) {
            // 1. Remove the white background (Chroma Key)
            const removeWhite = new fabric.Image.filters.RemoveColor({
                color: '#FFFFFF',
                distance: 0.15 // Small distance to catch near-white pixels
            });

            // 2. Force remaining pixels to Black
            const blackFilter = new fabric.Image.filters.ColorMatrix({
                matrix: [
                    0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0,
                    0, 0, 0, 1, 0
                ]
            });

            img.filters.push(removeWhite, blackFilter);
            img.applyFilters();
        }

        canvas.add(img);
        canvas.renderAll();

        window.revealSilhouette = function() {
            img.filters = [];
            img.applyFilters();
            canvas.renderAll();
            
            // Pop animation
            img.animate('scaleX', scale * 1.05, {
                duration: 150,
                onChange: canvas.renderAll.bind(canvas),
                onComplete: () => img.animate('scaleX', scale, { duration: 150, onChange: canvas.renderAll.bind(canvas) })
            });
            img.animate('scaleY', scale * 1.05, { duration: 150, onChange: canvas.renderAll.bind(canvas),
                onComplete: () => img.animate('scaleY', scale, { duration: 150, onChange: canvas.renderAll.bind(canvas) })
             });
        };

        const oldHighlight = window.highlightSuccess;
        window.highlightSuccess = function() {
            if (oldHighlight) oldHighlight();
            if (window.revealSilhouette) window.revealSilhouette();
        };
    }, { crossOrigin: 'anonymous' });
});
</script>
