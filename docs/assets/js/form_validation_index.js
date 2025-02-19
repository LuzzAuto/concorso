document.addEventListener("DOMContentLoaded", function () {
	validateFastSearch();
	imgErrorHandler();
});

function validateFastSearch() {
	let form = document.getElementById("home_fastSearch_form");
	form.addEventListener("submit", function(event) {
		var ok = true;
		let msg = "";
		resetFormError(0);
		if(!validateMarca()) {
			ok = false;
			msg += "<p tabindex=\"0\" id=\"marca_err\">La marca che hai inserito non &egrave; valida, puoi usare solo lettere, numeri, spazi (non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if(!validateModello()) {
			ok = false;
			msg += "<p id=\"modello_err\">Il modello che hai inserito non &egrave; valido, puoi usare solo lettere, numeri, spazi (non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if(!validatePrezzo()) {
			ok = false;
			msg += "<p id=\"prezzoMax_err\">Il prezzo che hai inserito non &egrave; valido, inserisci un prezzo maggiore di 0.</p>";
		}
		if(!validateCondizione()) {
			ok = false;
			msg += "<p id=\"condizione_err\">La condizione che hai selezionato non &egrave; valida. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if(!ok) {
			addFormError(msg, 0);
			event.preventDefault();
		}
	});
}

/*
* Controllo la marca del veicolo
*/
function validateMarca() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var marca = document.getElementById("home_marca").value;
	return allowedChars.test(marca ? marca : "");
}

/*
* Controllo il modello del veicolo
*/
function validateModello() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var modello = document.getElementById("home_modello").value;
	return allowedChars.test(modello ? modello : "");
}

/*
* Controllo il modello del veicolo
*/
function validateCondizione() {
	const allowedChars = /^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/; // lettere maiuscole e minuscole, numeri
	var condizione = document.getElementById("home_condizione").value;
	return allowedChars.test(condizione ? condizione : "");
}

/*
* Controllo il prezzo massimo inserito
*/
function validatePrezzo() {
	var prezzoMax = document.getElementById("home_prezzoMax").value;
	return prezzoMax ? (isNaN(prezzoMax) || prezzoMax > 0) : true;
}

/*
 * Utilizzato per eliminare il border radius che andrebbe altrimenti a coprire il testo alt 
 *
function imgErrorHandler() {
	let imgs = document.getElementsByClassName("stemma_brand");
	for (let img of imgs) {
        img.addEventListener("error", function() {
            // Imposta il border-radius a 0
            this.style.borderRadius = 0;
        });
    }
}
*/