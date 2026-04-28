@props(['challenge', 'game'])

<div class="visual-box">
    @php 
        $imagePath = $challenge->image_path ?? $challenge->stimulus_data['image_path'] ?? null;
        $revealPath = $challenge->reveal_image_path ?? $challenge->stimulus_data['reveal_image_path'] ?? null;
        
        $displayPath = $revealPath ?? $imagePath;
    @endphp
    
    @if($displayPath)
        <div class="image-wrapper">
            <img id="challenge-image" 
                 src="{{ asset('storage/' . $displayPath) }}" 
                 data-reveal="{{ asset('storage/' . $revealPath) }}"
                 alt="Challenge Image" 
                 class="game-image {{ $game->slug === 'guess-silhouette' ? 'silhouette-filter' : '' }}">
        </div>
    @else
        <div class="placeholder-wrapper">
            <p>Image not found</p>
        </div>
    @endif
</div>

<style>
    .visual-box {
        background: #ffffff; /* Pure white base */
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-radius: 32px; 
        overflow: hidden;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        margin-bottom: 1.5rem; 
        min-height: 450px; 
        position: relative;
    }
    
    .image-wrapper { 
        width: 100%; 
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px; 
    }
    
    .game-image { 
        max-width: 100%; 
        max-height: 500px; 
        border-radius: 4px; 
        object-fit: contain;
        transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: transparent;
    }

    /* Total Black on White Effect */
    .silhouette-filter { 
        background-color: #ffffff; /* Ensures transparent PNGs have a white background */
        
        /* 
           This combination targets the character to become pure black.
           The contrast(500%) + brightness(0.2) forces colors into extreme ends.
        */
        filter: grayscale(100%) contrast(500%) brightness(0.1);
        pointer-events: none;
    }

    /* Transition back to normal */
    .game-image:not(.silhouette-filter) {
        filter: none;
        background-color: transparent;
        transform: scale(1.05);
    }

    .placeholder-wrapper { padding: 4rem; color: #cbd5e1; font-weight: 700; }
</style>
