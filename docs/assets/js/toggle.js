document.addEventListener("DOMContentLoaded", function () {
    // Gestione menù ad hamburger
    adjustMenuOnResize();
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
            tasto.setAttribute("data-hidden", "true");
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
                tasto.setAttribute("data-hidden", "true");
                tasto.setAttribute("tabindex", "0");
                tasto.setAttribute("aria-hidden", "false");
            }
            menuOpenClose();
        });
    }
}

//BACK TO TOP
var lastScrollTop = 0;
window.addEventListener("scroll", function(){ 
    var buttonBacktoTop = document.getElementById("backToTopButton");
    var st = document.documentElement.scrollTop;
    if (st == 0){ // || st > lastScrollTop
        buttonBacktoTop.className = "backToTopHidden";
    }else{
        buttonBacktoTop.className = "backToTopShow";
    }
    lastScrollTop = st <= 0 ? 0 : st;
 }, false);