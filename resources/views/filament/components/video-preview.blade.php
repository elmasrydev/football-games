<div class="video-preview-container"
    style="margin-top: 1rem; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #000;">
    @php
        $youtubeId = null;
        if ($youtube_url) {
            preg_match('/(?:v=|\/embed\/|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches);
            $youtubeId = $matches[1] ?? null;
        }
    @endphp

    @if($youtubeId)
        <iframe width="100%" height="300" src="https://www.youtube.com/embed/{{ $youtubeId }}" title="Video Preview"
            style="border: none;"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    @elseif($uploaded_video)
        <video width="100%" height="300" controls aria-label="Uploaded Video Preview">
            <source src="{{ asset('storage/' . $uploaded_video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @else
        <div
            style="height: 300px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 0.9rem;">
            No video to preview. Enter a YouTube URL or upload a file.
        </div>
    @endif
</div>