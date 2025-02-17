document.addEventListener("DOMContentLoaded", function () {
	validateFastSearch();
});

function validateFastSearch() {
	let form = document.getElementById("list_filter_form");
	form.addEventListener("submit", function(event) {
		if(event.submitter.id != "list_clear") {
			var ok = true;
			let msg = "";
			
			resetFormError(0);

			if(!validateMarca()) {
				ok = false;
				msg += "<p id=\"marca_err\">La marca che hai inserito non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
			}
			if(!validateModello()) {
				ok = false;
				msg += "<p id=\"modello_err\">Il modello che hai inserito non &egrave; valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
			}
			if(!validateAnno()) {
				ok = false;
				msg += "<p id=\"anno_err\">L'anno che hai inserito non &egrave; valido, inserisci un anno maggiore di 0 e di massimo 4 cifre.</p>";
			}
			if(!validateColore()) {
				ok = false;
				msg += "<p id=\"colore_err\">Il colore che hai selezionato non &egrave; valido. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!validateAlimentazione()) {
				ok = false;
				msg += "<p id=\"alimentazione_err\">Hai selezionato un'alimentazione non valida. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!validateCambio()) {
				ok = false;
				msg += "<p id=\"cambio_err\">Hai selezionato un tipo di cambio non valido. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!validateTrazione()) {
				ok = false;
				msg += "<p id=\"trazione_err\">Hai selezionato un tipo di trazione non valid. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!validatePotenzaMin()) {
				ok = false;
				msg += "<p id=\"potenzaMin_err\">Hai inserito una potenza minima non valida, inserisci una potenza maggiore di 0 e minore o uguale alla potenza massima.</p>";
			}
			if(!validatePotenzaMax()) {
				ok = false;
				msg += "<p id=\"potenzaMax_err\">Hai inserito una potenza massima non valida, inserisci una potenza maggiore di 0 e maggiore o uguale alla potenza minima.</p>";
			}
			if(!validatePesoMin()) {
				ok = false;
				msg += "<p id=\"pesoMin_err\">Hai inserito un peso minimo non valido, inserisci un peso maggiore di 0 e minore o uguale al peso massimo.</p>";
			}
			if(!validatePesoMax()) {
				ok = false;
				msg += "<p id=\"pesoMax_err\">Hai inserito un peso massimo non valido, inserisci un peso maggiore di 0 e maggiore o uguale al peso minimo.</p>";
			}
			if(!validatePrezzo()) {
				ok = false;
				msg += "<p id=\"prezzoMax_err\">Hai inserito un prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
			}
			if(!validatePosti()) {
				ok = false;
				msg += "<p id=\"posti_err\">Hai inserito un numero di posti non valido, inserisci un numero maggiore di 0.</p>";
			}
			if(!validateCondizione()) {
				ok = false;
				msg += "<p id=\"condizione_err\">hai selezionato una condizione non valida. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!validateChilometraggio()) {
				ok = false;
				msg += "<p id=\"chilometraggio_err\">Hai inserito un chilometraggio non valido, inserisci un valore maggiore di 0.</p>";
			}
			if(!validateNeopatentati()) {
				ok = false;
				msg += "<p id=\"neopatentati_err\">Hai selezionato un valore di neopatentati non valido. Seleziona nuovamente la scelta desiderata.</p>";
			}
			if(!ok) {
				addFormError(msg, 0);
				event.preventDefault();
			}
		}
	});
}
/*
* Controllo la marca del veicolo
*/
function validateMarca() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var marca = document.getElementById("list_filter_marca").value;
	return allowedChars.test(marca ? marca : "");
}
/*
* Controllo il modello del veicolo
*/
function validateModello() {
	const allowedChars = /^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/; // lettere maiuscole e minuscole, numeri e il carattere trattino(-)
	var modello = document.getElementById("list_filter_modello").value;
	return allowedChars.test(modello ? modello : "");
}
/*
* Controllo l'anno del veicolo
*/
function validateAnno() {
	const allowedChars = /^\d{1,4}$/; // solo numeri, max 4 cifre
	var anno = document.getElementById("list_filter_anno").value;
	return anno ? (isNaN(anno) || (allowedChars.test(anno) && anno > 0)) : true;
}

/*
* Controllo il colore del veicolo
*/
function validateColore() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var colore = document.getElementById("list_filter_colore").value;
	return allowedChars.test(colore ? colore : "");
}
/*
* Controllo il tipo di alimentazione del veicolo
*/
function validateAlimentazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var alimentazione = document.getElementById("list_filter_alimentazione").value;
	return allowedChars.test(alimentazione ? alimentazione : "");
}
/*
* Controllo il tipo di cambio del veicolo
*/
function validateCambio() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var cambio = document.getElementById("list_filter_cambio").value;
	return allowedChars.test(cambio ? cambio : "");
}
/*
* Controllo il tipo di trazione del veicolo
*/
function validateTrazione() {
	const allowedChars = /^([A-Za-z]+( [A-Za-z]+)*)?$/; // lettere maiuscole e minuscole
	var trazione = document.getElementById("list_filter_trazione").value;
	return allowedChars.test(trazione ? trazione : "");
}
/*
* Controllo la potenza minima del veicolo
*/
function validatePotenzaMin() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var potenzaMin = document.getElementById("list_filter_potenzaMin").value;
	var potenzaMax = document.getElementById("list_filter_potenzaMax").value;
	return potenzaMin ? (isNaN(potenzaMin) || (allowedChars.test(potenzaMin) && potenzaMin > 0 && (potenzaMax ? potenzaMin <= potenzaMax : true))) : true;
}
/*
* Controllo la potenza massima del veicolo
*/
function validatePotenzaMax() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var potenzaMax = document.getElementById("list_filter_potenzaMax").value;
	var potenzaMin = document.getElementById("list_filter_potenzaMin").value;
	return potenzaMax ? (isNaN(potenzaMax) || (allowedChars.test(potenzaMax) && potenzaMax > 0 && (potenzaMin ? potenzaMax >= potenzaMin : true))) : true;
}
/*
* Controllo il peso minimo inserito
*/
function validatePesoMin() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var pesoMin = document.getElementById("list_filter_pesoMin").value;
	var pesoMax = document.getElementById("list_filter_pesoMax").value;
	return pesoMin ? (isNaN(pesoMin) || (allowedChars.test(pesoMin) && pesoMin > 0 && (pesoMax ? pesoMin <= pesoMax : true))) : true;
}
/*
* Controllo il peso massimo inserito
*/
function validatePesoMax() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var pesoMax = document.getElementById("list_filter_pesoMax").value;
	var pesoMin = document.getElementById("list_filter_pesoMin").value;
	return pesoMax ? (isNaN(pesoMax) || (allowedChars.test(pesoMax) && pesoMax > 0 && (pesoMin ? pesoMax >= pesoMin : true))) : true;
}
/*
* Controllo il numero di posti inserito
*/
function validatePosti() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var posti = document.getElementById("list_filter_posti").value;
	return posti ? (isNaN(posti) || (allowedChars.test(posti) && posti > 0)) : true;
}
/*
* Controllo il modello del veicolo
*/
function validateCondizione() {
	const allowedChars = /^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/; // lettere maiuscole e minuscole, numeri
	var condizione = document.getElementById("list_filter_condizione").value;
	return allowedChars.test(condizione ? condizione : "");
}
/*
* Controllo il prezzo massimo inserito
*/
function validatePrezzo() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var prezzoMax = document.getElementById("list_filter_prezzo").value;
	return prezzoMax ? (isNaN(prezzoMax) || (allowedChars.test(prezzoMax) && prezzoMax > 0)) : true;
}
/*
* Controllo il chilometraggio inserito
*/
function validateChilometraggio() {
	const allowedChars = /^(\d+)?$/; // solo numeri
	var chilometraggio = document.getElementById("list_filter_chilometraggio").value;
	return chilometraggio ? (isNaN(chilometraggio) || (allowedChars.test(chilometraggio) && chilometraggio > 0)) : true;
}
/*
* Controllo selezione neopatentati
*/
function validateNeopatentati() {
	var neopatentati = document.getElementById("neopatentatiID").value;
	return neopatentati && neopatentati != 0 ? neopatentati == 1 : true;
}