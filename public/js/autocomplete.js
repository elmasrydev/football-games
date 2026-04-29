function clearAutocomplete(inputId, listId) {
    const input = document.getElementById(inputId);
    const list = document.getElementById(listId);

    if (input) {
        input.value = '';
    }

    if (list) {
        list.innerHTML = '';
        list.style.display = 'none';
    }
}

function initAutocomplete(inputId, listId, searchUrl) {
    const input = document.getElementById(inputId);
    const list = document.getElementById(listId);

    if (!input || !list || !searchUrl) {
        return;
    }

    let activeIndex = -1;
    let items = [];
    let controller = null;

    function closeList() {
        list.innerHTML = '';
        list.style.display = 'none';
        activeIndex = -1;
        items = [];
    }

    function renderOptions(results) {
        items = results;
        list.innerHTML = '';

        if (!results.length) {
            closeList();
            return;
        }

        results.forEach((result, index) => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.textContent = result;
            item.addEventListener('mousedown', (event) => {
                event.preventDefault();
                input.value = result;
                closeList();
            });
            list.appendChild(item);
        });

        list.style.display = 'block';
    }

    function setActive(nextIndex) {
        const rendered = list.querySelectorAll('.autocomplete-item');
        rendered.forEach((item) => item.classList.remove('autocomplete-active'));

        if (!rendered.length) {
            activeIndex = -1;
            return;
        }

        if (nextIndex < 0) {
            nextIndex = rendered.length - 1;
        }

        if (nextIndex >= rendered.length) {
            nextIndex = 0;
        }

        activeIndex = nextIndex;
        rendered[activeIndex].classList.add('autocomplete-active');
    }

    input.addEventListener('input', async function() {
        const query = this.value.trim();

        if (controller) {
            controller.abort();
        }

        if (query.length < 2) {
            closeList();
            return;
        }

        controller = new AbortController();

        try {
            const response = await fetch(`${searchUrl}?query=${encodeURIComponent(query)}`, {
                signal: controller.signal,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                closeList();
                return;
            }

            const results = await response.json();
            renderOptions(Array.isArray(results) ? results : []);
        } catch (error) {
            if (error.name !== 'AbortError') {
                closeList();
            }
        }
    });

    input.addEventListener('keydown', function(event) {
        const rendered = list.querySelectorAll('.autocomplete-item');

        if (!rendered.length) {
            return;
        }

        if (event.key === 'ArrowDown') {
            event.preventDefault();
            setActive(activeIndex + 1);
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();
            setActive(activeIndex - 1);
        }

        if (event.key === 'Enter' && activeIndex > -1) {
            event.preventDefault();
            input.value = items[activeIndex];
            closeList();
        }

        if (event.key === 'Escape') {
            closeList();
        }
    });

    document.addEventListener('click', function(event) {
        if (!list.contains(event.target) && event.target !== input) {
            closeList();
        }
    });
}
