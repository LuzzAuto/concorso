document.addEventListener("DOMContentLoaded", function () {
    // Evento click filtro listino
    switchToggle();
});
/*
* Assicuriamo il funzionamento dell'espansione del filtro da mobile e la corretta gestione del aria-label
*/
function switchToggle() {
    let toggleButton = document.getElementById('list_toggle_button');
    if(toggleButton){ 
        let toggleInput = document.getElementById('list_filter_header');
        let filterForm = document.getElementById('list_filter_form');
        let inputs = filterForm.querySelectorAll("input, select");   
        function filterOpenClose() {
            // Controlla toggle
            if (toggleInput.getAttribute("data-hidden")==="false") {
                // Mostra toggle se su mobile altrimenti rimuovi
                if(window.innerWidth <= 1024) {
                    toggleButton.setAttribute("tabindex", "0");
                    toggleButton.setAttribute("aria-hidden", "false");
                } else {
                    toggleButton.setAttribute("tabindex", "-1");
                    toggleButton.setAttribute("aria-hidden", "true");
                }
                // Mostra campi input
                inputs.forEach(input => {
                    input.setAttribute("tabindex", "0");
                    input.setAttribute("aria-hidden", "false");
                });
            } else {
                // Rimuovi menù
                // Rimuovi toggle non serve perché su mobile
                // Rimuovi campi input
                inputs.forEach(input => {
                    input.setAttribute("tabindex", "-1");
                    input.setAttribute("aria-hidden", "true");
                });
            }
        }
        // Ascolta pressioni toggle
        toggleButton.addEventListener('click', function() {
            // Cambio stato ed espansione/riduzione menù
            if (toggleInput.getAttribute("data-hidden")==="false") toggleInput.setAttribute("data-hidden", "true");
            else toggleInput.setAttribute("data-hidden", "false");
            filterOpenClose();
            // Impostazione ARIA attributes
            toggleButton.setAttribute('aria-expanded', toggleInput.getAttribute("data-hidden")==="false" ? "true" : "false");
            toggleButton.setAttribute('aria-label', toggleInput.getAttribute("data-hidden")==="false" ? 'Seleziona per comprimere il form filtro' : 'Seleziona per espandere il form filtro');
        });
    }
}