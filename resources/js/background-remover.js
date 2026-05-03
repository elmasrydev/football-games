import { removeBackground } from '@imgly/background-removal';

/**
 * Removes the background from an image in a Filament FileUpload field.
 * 
 * This function works by:
 * 1. Finding the uploaded file from FilePond (Filament's file upload library)
 * 2. Processing it with @imgly/background-removal (runs entirely in the browser)
 * 3. Uploading the result back via Livewire's native upload mechanism
 *    (this is the key — we can't just inject files into FilePond, we need to go through Livewire)
 * 4. Dispatching a Livewire event to refresh the component so FilePond picks up the new file
 */
window.removeImageBackground = async (statePath) => {
    console.log('removeImageBackground called for statePath:', statePath);
    
    // ── Step 1: Find the file to process ──
    // For existing uploads (edit page), FilePond shows a server-loaded file.
    // For new uploads, FilePond holds the actual File object.
    // We also need to handle the case where the file is already on the server.
    
    let file = null;
    let pondInstance = null;
    
    // Find the FilePond instance for this field
    // Filament wraps each FileUpload in a div with wire:id on the parent Livewire component
    const allPonds = document.querySelectorAll('.filepond--root');
    
    for (const pondEl of allPonds) {
        const pond = window.FilePond?.find(pondEl);
        if (pond && pond.getFiles().length > 0) {
            const pondFile = pond.getFiles()[0];
            
            // Check if the pond is for our field by looking at the parent structure
            const wrapper = pondEl.closest('[wire\\:key*="image_path"], [x-data*="image_path"], [id*="challenge_image"]');
            if (wrapper || allPonds.length === 1) {
                pondInstance = pond;
                
                if (pondFile.file) {
                    // New upload — we have the actual File object
                    file = pondFile.file;
                    console.log('File found in FilePond (new upload):', file.name);
                } else if (pondFile.source && typeof pondFile.source === 'string') {
                    // Existing upload — file is on the server, we need to fetch it
                    console.log('File is server-loaded, fetching from:', pondFile.source);
                    try {
                        const response = await fetch(pondFile.source);
                        const blob = await response.blob();
                        const fileName = pondFile.source.split('/').pop() || 'image.png';
                        file = new File([blob], fileName, { type: blob.type });
                        console.log('Fetched server file successfully:', file.name);
                    } catch (fetchErr) {
                        console.error('Failed to fetch server file:', fetchErr);
                    }
                }
                break;
            }
        }
    }
    
    // Broader search if we didn't find it
    if (!file && allPonds.length > 0) {
        for (const pondEl of allPonds) {
            const pond = window.FilePond?.find(pondEl);
            if (pond && pond.getFiles().length > 0) {
                const pondFile = pond.getFiles()[0];
                pondInstance = pond;
                
                if (pondFile.file) {
                    file = pondFile.file;
                    console.log('File found in FilePond (broad search):', file.name);
                } else if (pondFile.source && typeof pondFile.source === 'string') {
                    try {
                        const response = await fetch(pondFile.source);
                        const blob = await response.blob();
                        const fileName = pondFile.source.split('/').pop() || 'image.png';
                        file = new File([blob], fileName, { type: blob.type });
                        console.log('Fetched server file (broad search):', file.name);
                    } catch (fetchErr) {
                        console.error('Failed to fetch server file:', fetchErr);
                    }
                }
                if (file) break;
            }
        }
    }

    // Also try fetching from the preview image if FilePond didn't give us a file
    if (!file) {
        const previewImg = document.querySelector('.filepond--image-preview-wrapper img, .filepond--file-poster img');
        if (previewImg && previewImg.src) {
            console.log('Trying to fetch from preview image:', previewImg.src);
            try {
                const response = await fetch(previewImg.src);
                const blob = await response.blob();
                file = new File([blob], 'image.png', { type: blob.type });
                console.log('Fetched from preview image successfully');
            } catch (fetchErr) {
                console.error('Failed to fetch preview image:', fetchErr);
            }
        }
    }

    if (!file) {
        console.error('Could not find any file to process.');
        alert('Please upload an image first.');
        return;
    }

    // ── Step 2: Show loading overlay ──
    let overlay = null;
    const pondWrapper = pondInstance?._element?.closest('.fi-fo-file-upload') || 
                         document.querySelector('.fi-fo-file-upload');
    
    if (pondWrapper) {
        overlay = document.createElement('div');
        overlay.id = 'bg-removal-overlay';
        overlay.style.cssText = `
            position: absolute; inset: 0; z-index: 50;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: rgba(0,0,0,0.6); border-radius: 8px;
            color: white; font-size: 14px; font-weight: 500;
        `;
        overlay.innerHTML = `
            <svg style="animation: spin 1s linear infinite; width: 32px; height: 32px; margin-bottom: 8px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span id="bg-removal-status">Removing background...</span>
            <span id="bg-removal-progress" style="font-size: 12px; opacity: 0.7; margin-top: 4px;">Initializing...</span>
        `;
        pondWrapper.style.position = 'relative';
        pondWrapper.appendChild(overlay);
        
        // Add spin animation
        if (!document.getElementById('bg-removal-styles')) {
            const style = document.createElement('style');
            style.id = 'bg-removal-styles';
            style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
            document.head.appendChild(style);
        }
    }

    const updateProgress = (text) => {
        const el = document.getElementById('bg-removal-progress');
        if (el) el.textContent = text;
    };

    // ── Step 3: Process the image ──
    console.log('Processing background removal for:', file.name);
    
    try {
        const resultBlob = await removeBackground(file, {
            progress: (key, current, total) => {
                const pct = Math.round(current / total * 100);
                console.log(`${key}: ${pct}%`);
                
                if (key.includes('model')) {
                    updateProgress(`Downloading AI model... ${pct}%`);
                } else if (key.includes('wasm')) {
                    updateProgress(`Loading WASM runtime... ${pct}%`);
                } else if (key.includes('inference')) {
                    updateProgress('Processing image...');
                } else if (key.includes('encode')) {
                    updateProgress('Encoding result...');
                }
            }
        });

        const newFileName = file.name.replace(/\.[^/.]+$/, '') + '-no-bg.png';
        const newFile = new File([resultBlob], newFileName, { 
            type: 'image/png',
            lastModified: Date.now()
        });
        
        console.log('Background removed. New file size:', newFile.size);
        updateProgress('Uploading processed image...');

        // ── Step 4: Upload via Livewire ──
        // Find the Livewire component
        const livewireEl = document.querySelector('[wire\\:id]');
        if (!livewireEl) {
            throw new Error('Could not find Livewire component');
        }
        
        const wireId = livewireEl.getAttribute('wire:id');
        const wireComponent = window.Livewire?.find(wireId);
        
        if (!wireComponent) {
            throw new Error('Could not find Livewire component instance');
        }
        
        console.log('Found Livewire component, uploading via $wire.upload...');
        
        // Upload the file through Livewire's native upload mechanism
        // The statePath for Filament form data is prefixed with 'data.'
        await new Promise((resolve, reject) => {
            wireComponent.upload(
                statePath,
                newFile,
                () => {
                    console.log('Livewire upload complete!');
                    resolve();
                },
                (error) => {
                    console.error('Livewire upload error:', error);
                    reject(error);
                },
                (event) => {
                    console.log('Livewire upload progress:', event);
                }
            );
        });

        // Remove overlay and show success
        if (overlay) overlay.remove();
        
        // Show a brief success message
        const successMsg = document.createElement('div');
        successMsg.style.cssText = `
            position: fixed; top: 16px; right: 16px; z-index: 9999;
            padding: 12px 20px; border-radius: 8px;
            background: #059669; color: white; font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: opacity 0.3s;
        `;
        successMsg.textContent = '✓ Background removed successfully!';
        document.body.appendChild(successMsg);
        setTimeout(() => {
            successMsg.style.opacity = '0';
            setTimeout(() => successMsg.remove(), 300);
        }, 3000);
        
        console.log('Background removal complete!');

    } catch (error) {
        console.error('Background removal error:', error);
        if (overlay) overlay.remove();
        alert('Background removal failed: ' + error.message);
    }
};
