document.addEventListener("DOMContentLoaded", function () {
    // Gestione ingrandimento foto desktop dettaglio auto
    adjustPhoto();
});
/*
* Gestione menù ad hamburger
*/
function adjustPhoto() {
    let images = document.querySelectorAll("#details_box_carousel img");

    images.forEach(img => {
        img.addEventListener("click", function () {
            // Rimuove l'ingrandimento da tutte le immagini
            images.forEach(i => i.classList.remove("expanded"));
            
            // Applica l'ingrandimento solo all'immagine cliccata
            this.classList.add("expanded");
        });
    });   
}