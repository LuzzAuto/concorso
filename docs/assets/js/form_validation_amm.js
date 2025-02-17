//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateFormEliminaAuto();
    validateFormGestPrenotazione();
    validateFormAggiungiAuto();
});

function isNumber(value){
    try{
        if(isNaN(value)){
            return false;
        }
        return true;
    }
    catch(error){
        console.log("An error occurred: ", error.message);
    }
}

// ELIMINA AUTO

function validateFormEliminaAuto(){
    let form = document.getElementById('eliminaAutoFormAdmin');
    if(form){
        form.addEventListener('submit', function (event){
            let div = document.getElementsByClassName("form_errors")[2];
            div.innerHTML = "";
            let msg = "";
            let ok = true;
            
            if(!validateAuto()){
                msg+="<p>L'auto che hai selezionto non &egrave; valida.</p>";
                ok = false;
            }
                
            if(!validateEmptyAuto()){
                msg+="<p>Seleziona un'auto da eliminare.</p>";
                ok = false;
            }
            if(!ok){
                div.innerHTML += msg;
                event.preventDefault();
            }
        });
    }
}

function validateEmptyAuto(){
    var auto = document.getElementById("eliminaAutoAdmin").value;
    if(auto == ""){
        return false;
    }
    return true;
}

function validateAuto(){
    var auto = document.getElementById("eliminaAutoAdmin").value;
    const validChars = /^[0-9]+$/;
    if(!validChars.test(auto)){
        return false;
    }
    return true;
}

// GESTIONE PRENOTAZIONE

function validateFormGestPrenotazione(){
    let form = document.getElementById('gestionePrenotazioneFormAdmin');
    if(form){
        form.addEventListener('submit', function (event){
            resetFormError(0);

            let msg = "";
            let ok = true;

            if(!validatePrenotazione()){
                msg += "<p>La prenotazione che hai selezionato non &egrave valida</p>";
                ok = false;
            }
            if(!validateAzione()) {
                msg += "<p>L'azione che hai selezionato non &egrave; valida</p>";
                ok = false;
            }
            if(!ok){
                addFormError(msg, 0);
                event.preventDefault();
            }
            
        });
    }
}

function validatePrenotazione(){
    var prenotazione = document.getElementById("gestPrenAdmin").value;
    if(prenotazione != "" && isNumber(prenotazione)){
        return true;
    }
    return false;
}

function validateAzione(){
    var azione = document.getElementById("azioneAdmin").value;
    if(azione == "accetta" || azione == "rifiuta"){
        return true;
    }
    return false;
}

// AGGIUNGI AUTO

function validateFormAggiungiAuto(){
    let form = document.getElementById('aggiungiAutoFormAdmin');
    if(form){
        form.addEventListener('submit', function (event){
            resetFormError(1);

            let msg = "";
            let ok = true;

            if(!validateAltImmagineOut()){
                msg += "<p id=\"altImmagineOut_err\">L'alternativa testuale che hai inserito riguardante la prima immagine non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e i caratteri virgola e punto. Non devi superare i 100 caratteri di lunghezza.</p>";
                ok = false;
            }
            if(!validaAltimmagineIn()){
                msg += "<p id=\"altImmagineIn_err\">L'alternativa testuale che hai inserito riguardante la seconda immagine non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e i caratteri virgola e punto. Non devi superare i 100 caratteri di lunghezza.</p>";
                ok = false;
            }
            if(!validateMarca()){
                msg += "<p id=\"marca_err\">La marca che hai inserito non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\". Non devi superare i 50 caratteri di lunghezza.</p>";
                ok = false;
            }
            if(!validateModello()){
                msg += "<p id=\"modello_err\">Il modello che hai inserito non &egrave; valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\". Non devi superare i 50 caratteri di lunghezza.</p>";
                ok = false;
            }
            if(!validateAnno()){
                msg += "<p id=\"anno_err\">L'anno che hai inserito non &egrave; valido, inserisci un anno maggiore di 0 e di massimo 4 cifre.</p>";
                ok = false;
            }
            if(!validateColore()){
                msg += "<p id=\"colore_err\">Il colore che hai inserito non &egrave; valido, puoi usare solo lettere e spazi(non all'inizio e alla fine).</p>";
                ok = false;
            }
            if(!validateAlimentazione()){
                msg += "<p id=\"alimentazione_err\">Hai selezionato un'alimentazione non valida. Seleziona nuovamente la scelta desiderata.</p>";
                ok = false;
            }
            if(!validateCambio()){
                msg += "<p id=\"cambio_err\">Hai selezionato un tipo di cambio non valido. Seleziona nuovamente la scelta desiderata.</p>";
                ok = false;
            }
            if(!validateTrazione()){
                msg += "<p id=\"trazione_err\">Hai selezionato un tipo di trazione non valido. Seleziona nuovamente la scelta desiderata.</p>";
                ok = false;
            }
            if(!validatePotenza()){
                msg += "<p id=\"potenza_err\">Hai inserito una potenza non valida, inserisci una potenza maggiore di 0.</p>";
                ok = false;
            }
            if(!validatePeso()){
                msg += "<p id=\"peso_err\">Hai inserito un peso non valido, inserisci un peso maggiore di 0.</p>";
                ok = false;
            }
            if(!validatePrezzo()){
                msg += "<p id=\"prezzo_err\">Hai inserito un prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
                ok = false;
            }
            if(!validatePosti()){
                msg += "<p id=\"posti_err\">Hai inserito un numero di posti non valido, inserisci un numero maggiore di 0.</p>";
                ok = false;
            }
            if(!validateCondizione()){
                msg += "<p id=\"condizione_err\">hai selezionato una condizione non valida. Seleziona nuovamente la scelta desiderata.</p>";
                ok = false;
            }
            if(!validateChilometraggio()) {
				ok = false;
				msg += "<p id=\"chilometraggio_err\">Hai inserito un chilometraggio non valido, inserisci un valore maggiore di 0.</p>";
			}
			if(!validateNeopatentati()) {
				ok = false;
				msg += "<p id=\"neopatentati_err\">Hai selezionato un valore di neopatentati non valido. Seleziona nuovamente la scelta desiderata.</p>";
			}


            if(!ok){
                addFormError(msg, 1);
                event.preventDefault();
            }
            
        });
    }
}

/*
* Controllo l'alt della prima immagine
*/
function validateAltImmagineOut(){
    var altImmagineOut = document.getElementById("altImmagineOutAdmin").value;
    const allowedChars = /^([A-Za-z0-9,.]+( [A-Za-z0-9,.]+)*)?$/;
    return altImmagineOut ? (allowedChars.test(altImmagineOut) && altImmagineOut.length <= 100) : true;
}

/*
* Controllo l'alt della seconda immagine
*/
function validaAltimmagineIn(){
    var altImmagineIn = document.getElementById("altImmagineInAdmin").value;
    const allowedChars = /^([A-Za-z0-9,.]+( [A-Za-z0-9,.]+)*)?$/;
    return altImmagineIn ? (allowedChars.test(altImmagineIn) && altImmagineIn.length <= 100) : true;
}

/*
* Controllo la marca del veicolo
*/
function validateMarca() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var marca = document.getElementById("marcaAdmin").value;
	return allowedChars.test(marca ? marca : "");
}

/*
* Controllo il modello del veicolo
*/
function validateModello() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var modello = document.getElementById("modelloAdmin").value;
	return allowedChars.test(modello ? modello : "");
}

/*
* Controllo l'anno del veicolo
*/
function validateAnno() {
	const allowedChars = /^\d{1,4}$/; // solo numeri, max 4 cifre
	var anno = document.getElementById("annoAdmin").value;
	return anno ? (isNaN(anno) || (allowedChars.test(anno) && anno > 0)) : true;
}

/*
* Controllo il colore del veicolo
*/
function validateColore() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var colore = document.getElementById("coloreAdmin").value;
	return allowedChars.test(colore ? colore : "");
}

/*
* Controllo il tipo di alimentazione del veicolo
*/
function validateAlimentazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var alimentazione = document.getElementById("alimentazioneAdmin").value;
	return allowedChars.test(alimentazione ? alimentazione : "");
}

/*
* Controllo il tipo di cambio del veicolo
*/
function validateCambio() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var cambio = document.getElementById("cambioAdmin").value;
	return allowedChars.test(cambio ? cambio : "");
}

/*
* Controllo il tipo di trazione del veicolo
*/
function validateTrazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var trazione = document.getElementById("trazioneAdmin").value;
	return allowedChars.test(trazione ? trazione : "");
}

/*
* Controllo la potenza del veicolo
*/
function validatePotenza() {
	var potenza = document.getElementById("potenzaAdmin").value;
    return potenza ? (potenza != "" && isNumber(potenza) && potenza > 0) : true;
}

/*
* Controllo il peso inserito
*/
function validatePeso() {
	var peso = document.getElementById("pesoAdmin").value;
    return peso ? (peso != "" && isNumber(peso) && peso > 0) : true;
}

/*
* Controllo il numero di posti inserito
*/
function validatePosti() {
    var posti = document.getElementById("numero_postiAdmin").value;
    return posti ? (posti != "" && isNumber(posti) && posti > 0) : true;
}

/*
* Controllo il modello del veicolo
*/
function validateCondizione() {
    const allowedChars = /^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/; // lettere maiuscole e minuscole
    var condizione = document.getElementById("condizioneAdmin").value;
    return allowedChars.test(condizione ? condizione : "");
}

/*
* Controllo il prezzo massimo inserito
*/
function validatePrezzo() {
    var prezzo = document.getElementById("prezzoAdmin").value;
    return prezzo ? (prezzo != "" && isNumber(prezzo) && prezzo > 0) : true;
}

/*
* Controllo il chilometraggio inserito
*/
function validateChilometraggio() {
    var chilometraggio = document.getElementById("chilometraggioAdmin").value;
    return chilometraggio ? (chilometraggio != "" && isNumber(chilometraggio) && chilometraggio > 0) : true;
}

/*
* Controllo selezione neopatentati
*/
function validateNeopatentati() {
	var neopatentati = document.getElementById("neopatentatiID").value;
	return neopatentati && neopatentati != 0 ? neopatentati == 1 : true;
}