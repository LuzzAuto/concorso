document.addEventListener("DOMContentLoaded", function () {
    // Gestione menù ad hamburger
    adjustMenuOnResize();
    // Evento click filtro listino
    switchToggle();
});
/*
* Gestione menù ad hamburger
*/
function adjustMenuOnResize() {
    let tasto = document.getElementById("menu-button-container");

    if(tasto) {
        let menu = document.getElementById("menu");
        let links = menu.querySelectorAll("a");
        function menuOpenClose() {
            // Cambia tra menù visibile e nascosto
            if (tasto.getAttribute("data-hidden")==="false") {
                menu.setAttribute("tabindex","0");
                menu.setAttribute("aria-hidden", "false");
                links.forEach(link => {
                    link.setAttribute("tabindex", (link.id === "here" ? "-1" : "0"));
                    link.setAttribute("aria-hidden", (link.id === "here" ? "true" : "false"));
                });
                tasto.setAttribute("aria-label","Seleziona per comprimere il menù di navigazione");
            } else {
                menu.setAttribute("tabindex","-1");
                menu.setAttribute("aria-hidden", "true");
                if (window.innerWidth > 1024) links.forEach(link => {
                    link.setAttribute("tabindex", (link.id === "here" ? "-1" : "0"));
                    link.setAttribute("aria-hidden", (link.id === "here" ? "true" : "false"));
                });
                else links.forEach(link => {
                    link.setAttribute("tabindex", "-1");
                    link.setAttribute("aria-hidden", "true");
                });
                tasto.setAttribute("aria-label","Seleziona per espandere il menù di navigazione");
            }
        }
        tasto.addEventListener('click', function() {
            // Cambia tra linee e croce
            if (tasto.getAttribute("data-hidden")==="false") tasto.setAttribute("data-hidden", "true");
            else tasto.setAttribute("data-hidden", "false");
            menuOpenClose();
        });

        // Esegui al caricamento e al resize
        if (window.innerWidth > 1024) {
            tasto.setAttribute("data-hidden", "true");
            tasto.setAttribute("tabindex", "-1");
            tasto.setAttribute("aria-hidden", "true");
        }
        else {
            tasto.setAttribute("data-hidden", "false");
            tasto.setAttribute("tabindex", "0");
            tasto.setAttribute("aria-hidden", "false");
        }
        menuOpenClose();
        window.addEventListener('resize', function(){
            if (window.innerWidth > 1024) {
                tasto.setAttribute("data-hidden", "true");
                tasto.setAttribute("tabindex", "-1");
                tasto.setAttribute("aria-hidden", "true");
            }
            else {
                tasto.setAttribute("data-hidden", "false");
                tasto.setAttribute("tabindex", "0");
                tasto.setAttribute("aria-hidden", "false");
            }
            menuOpenClose();
        });
    }
}
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
        // Esegui al caricamento e al resize
        toggleInput.setAttribute("data-hidden", "false");
        filterOpenClose();
        window.addEventListener('resize', function() {
            toggleInput.setAttribute("data-hidden", "false");
            filterOpenClose();
        });
    }
}