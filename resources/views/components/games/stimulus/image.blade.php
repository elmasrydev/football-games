@props(['challenge', 'game'])

<div class="visual-box" id="fabric-container">
    @php 
        $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
        $revealPath = $challenge->reveal_image_path ?? $challenge->stimulus_data['reveal_image_path'] ?? null;
        $displayPath = $revealPath ?? $imagePath;
    @endphp
    
    @if($displayPath)
        <div class="canvas-wrapper">
            <canvas id="silhouette-canvas"></canvas>
            {{-- Hidden source image --}}
            <img id="source-image" 
                 src="{{ asset('storage/' . $displayPath) }}" 
                 style="display: none;"
                 data-is-silhouette="{{ $game->slug === 'guess-silhouette' ? 'true' : 'false' }}">
        </div>
    @else
        <div class="placeholder-wrapper">
            <p>Image not found</p>
        </div>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

<style>
    .visual-box {
        background: #f8fafc; 
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.05);
        border-radius: 32px; 
        overflow: hidden;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        margin-bottom: 1.5rem; 
        min-height: 450px; 
        position: relative;
    }
    
    .canvas-wrapper { width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; }
    #silhouette-canvas { max-width: 100%; max-height: 500px; }
    .placeholder-wrapper { padding: 4rem; color: #cbd5e1; font-weight: 700; }
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
