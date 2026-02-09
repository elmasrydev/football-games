function initAutocomplete(inputId, listId, searchUrl) {
    const answerInput = document.getElementById(inputId);
    const autocompleteList = document.getElementById(listId);
    let currentFocus = -1;

    if (!answerInput || !autocompleteList) return;

    answerInput.addEventListener('input', function(e) {
        const val = this.value;
        closeAllLists();
        if (!val || val.length < 2) return false;
        
        currentFocus = -1;
        fetchSuggestions(val);
    });

    answerInput.addEventListener('keydown', function(e) {
        let x = document.getElementById(listId);
        if (x) x = x.getElementsByTagName('div');
        if (e.keyCode == 40) { // Down
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) { // Up
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) { // Enter
            if (currentFocus > -1) {
                e.preventDefault();
                if (x) x[currentFocus].click();
            }
        }
    });

    async function fetchSuggestions(val) {
        try {
            const response = await fetch(`${searchUrl}?query=${encodeURIComponent(val)}`);
            const suggestions = await response.json();
            
            if (suggestions.length === 0) return;

            closeAllLists();
            
            suggestions.forEach(name => {
                const b = document.createElement('div');
                b.className = 'autocomplete-item';
                b.innerHTML = `<strong>${name.substr(0, val.length)}</strong>${name.substr(val.length)}`;
                b.innerHTML += `<input type='hidden' value="${name.replace('"', '&quot;')}">`;
                
                b.addEventListener('click', function(e) {
                    answerInput.value = this.getElementsByTagName('input')[0].value;
                    closeAllLists();
                    // Removed automatic Enter key provocation
                    // focus the input back
                    answerInput.focus();
                });
                
                autocompleteList.appendChild(b);
            });
        } catch (error) {
            console.error('Error fetching suggestions:', error);
        }
    }

    function addActive(x) {
        if (!x) return false;
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add('autocomplete-active');
    }

    function removeActive(x) {
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove('autocomplete-active');
        }
    }

    function closeAllLists(elmnt) {
        const x = document.getElementsByClassName('autocomplete-items');
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != answerInput) {
                x[i].innerHTML = '';
            }
        }
    }

    document.addEventListener('click', function (e) {
        closeAllLists(e.target);
    });
}

function clearAutocomplete(inputId, listId) {
    const input = document.getElementById(inputId);
    const list = document.getElementById(listId);
    
    if (input) {
        input.value = '';
        input.disabled = false;
        input.focus();
        
        // Re-enable form buttons if they were disabled
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) submitBtn.disabled = false;
        
        const giveUpBtn = document.getElementById('give-up-btn');
        if (giveUpBtn) giveUpBtn.disabled = false;
        
        const clearBtn = document.getElementById('clear-btn');
        if (clearBtn) clearBtn.disabled = false;

        // Reset feedback
        const feedback = document.getElementById('feedback');
        if (feedback) {
            feedback.innerText = '';
            feedback.className = 'feedback';
            feedback.style.display = ''; // Remove inline display: none/block to allow CSS classes to work
        }

        // Reset card borders if any
        const card = document.querySelector('.question-card');
        if (card) {
            card.style.borderColor = '';
            card.style.boxShadow = '';
        }
    }
    
    if (list) {
        list.innerHTML = '';
    }
}
