<?php

require_once "dbConnection.php";
use DB\DBConnection;

function ripristinoInput($listinoHTML) {
	// $listinoHTML = file_get_contents("listino.html");
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$listinoHTML = str_replace('[marca]', isset($_GET['marca']) ? 'value="' . htmlspecialchars($_GET['marca']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace('[modello]', isset($_GET['modello']) ? 'value="' . htmlspecialchars($_GET['modello']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace('[anno]', isset($_GET['anno']) ? 'value="' . htmlspecialchars($_GET['anno']) . '"': '', $listinoHTML);
	
	// rimpiazzo di default -> seleziono qualsiasi
	
	try {
		$db = new DBConnection();

		$colori = $db->getAllVehicleColors();

		$db->closeConnection();
		unset($db);

		$listaColori = '';
		array_unshift($colori, "Qualsiasi");

		foreach($colori as $color) {
			//replace colore
			if(!(isset($_GET['colore']) && $_GET['colore'] == strtolower($color))) {
				$listaColori .= '<option ' . (strcmp(strtolower($color),"qualsiasi") !== 0 ? 'value="' . strtolower($color) : 'selected value="qualsiasi') . '">' . $color . '</option>';
			}
			else {
				$listaColori .= '<option selected value="' . (strcmp(strtolower($color),"qualsiasi") !== 0 ? strtolower($color) : "qualsiasi") . '">' . $color . '</option>';
			}
		}
	} catch(Exception $e) {
		header("location: 500.html");
		exit();
	}
	$listinoHTML = str_replace("[colori]", $listaColori, $listinoHTML);

	//replace alimentazione
	if(htmlspecialchars(isset($_GET['alimentazione']))) {
		$listinoHTML = str_replace("[" . $_GET['alimentazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiA]", "[benzina]", "[gasolio]", "[elettrico]", "[metano]", "[ibrido]"], ["selected ", "", "", "", "", ""], $listinoHTML);

	//replace cambio
	if(htmlspecialchars(isset($_GET['cambio']))) {
		$listinoHTML = str_replace("[" . $_GET['cambio'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiCb]", "[manuale]", "[automatico]"], ["selected ", "", ""], $listinoHTML);

	//replace trazione
	if(htmlspecialchars(isset($_GET['trazione']))) {
		$listinoHTML = str_replace("[" . $_GET['trazione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiT]", "[anteriore]", "[posteriore]", "[integrale]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace('[potenzaMin]', isset($_GET['potenzaMin']) ? 'value="' . htmlspecialchars($_GET['potenzaMin']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace('[potenzaMax]', isset($_GET['potenzaMax']) ? 'value="' . htmlspecialchars($_GET['potenzaMax']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace('[pesoMin]', isset($_GET['pesoMin']) ? 'value="' . htmlspecialchars($_GET['pesoMin']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace('[pesoMax]', isset($_GET['pesoMax']) ? 'value="' . htmlspecialchars($_GET['pesoMax']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace("[neopatentati]", htmlspecialchars(isset($_GET['neopatentati']) && intval($_GET["neopatentati"]) == 1 ? 'checked ' : ''), $listinoHTML);
	$listinoHTML = str_replace('[posti]', isset($_GET['posti']) ? 'value="' . htmlspecialchars($_GET['posti']) . '"': '', $listinoHTML);

	//replace condizione
	if(htmlspecialchars(isset($_GET['condizione']))) {
		$listinoHTML = str_replace("[" . $_GET['condizione'] . "]", "selected ", $listinoHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$listinoHTML = str_replace(["[qualsiasiCd]", "[nuovo]", "[usato]", "[km0]"], ["selected ", "", "", ""], $listinoHTML);

	$listinoHTML = str_replace("[prezzoMax]", isset($_GET['prezzoMax']) ? 'value="' . htmlspecialchars($_GET['prezzoMax']) . '"': '', $listinoHTML);
	$listinoHTML = str_replace("[chilometraggio]", isset($_GET['chilometraggio']) ? 'value="' . htmlspecialchars($_GET['chilometraggio']) . '"': '', $listinoHTML);

	return $listinoHTML;
}

function getVehiclesFromDB($params, $listinoHTML) {
	try{
		$db = new DBConnection();

		//IMPOSTARE DATI COME INDICATO NEI FILTRI
		

		$ris = $db->getFilteredVehicles($params);

		$db->closeConnection();
		unset($db);

		$listaAuto = '';

		if($ris){
			// Qui ci sono auto
			$listaAuto = '<ul id="list_car_list">';
			foreach($ris as $vehicle) {
				$listaAuto .= '
					<li class="list_car_item">
						<div class="list_car_image">';
							
						// Gestione delle immagini
						$fotos = explode(separator: "+", string: $vehicle['foto']);
						$alts = explode(separator:'+', string: $vehicle['alts']);
						$foto = '<img src="assets/img/Cars/' . str_replace(' ', '%20', htmlspecialchars(string: $vehicle['marca'])) . '/' . str_replace(' ', '%20', htmlspecialchars(string: $fotos[0])) . '" alt=" ' . htmlspecialchars(string: $alts[0]) . '">';
						$listaAuto .= $foto;

				$listaAuto .= '
						</div>
							<dl class="list_car_info">
									<dt>Marca</dt>
									<dd>' . $vehicle["marca"] . '</dd>
									<dt>Modello</dt>
									<dd>' . $vehicle["modello"] . '</dd>
									<dt>Condizioni</dt>
									<dd>' . (($vehicle['condizione']=="KM 0") ? "<abbr title='chilometro zero'>KM 0</abbr>" : $vehicle['condizione']) . '</dd>
									<dt>Prezzo</dt>
									<dd><abbr title="Euro">&euro;</abbr> ' . $vehicle["prezzo"] . '</dd>
							</dl>
							<a class="list_car_item_link" href="auto.php?id=' . $vehicle["id"] . '">Vedi dettagli</a>
					</li>';
			}
			$listaAuto .='</ul>';
		} else {
			$listaAuto ='<p class="list_car_list_empty">Nessun veicolo compatibile con i filtri impostati</p>';
		}

		$listinoHTML = ripristinoInput($listinoHTML);
		$listinoHTML = preg_replace('/<ul id="list_car_list">.*?<\/ul>/s', $listaAuto, $listinoHTML);
		
		return $listinoHTML;
	}
	catch(Exception){
		header("location: 500.html");
		exit();
	}
}

//DA SOSTITUIRE CON PERCORSO FILE HTML
$listinoHTML = file_get_contents("listino.html");

// session_start();

$err = "";

if(isset($_GET['action']) && $_GET['action'] == 'Applica filtri') {
	if(isset($_GET["marca"]) || isset($_GET["modello"]) || isset($_GET["anno"]) || isset($_GET["colore"]) 
		|| isset($_GET["alimentazione"]) || isset($_GET["cambio"]) || isset($_GET["trazione"]) || isset($_GET["potenzaMin"]) || isset($_GET["potenzaMax"]) 
		|| isset($_GET["pesoMin"]) || isset($_GET["pesoMax"]) || isset($_GET["neopatentati"]) || isset($_GET["posti"]) || isset($_GET["condizione"]) 
		|| isset($_GET["prezzoMax"]) || isset($_GET["chilometraggio"])) {


		//CONTROLLI SULL'INPUT
		if (isset($_GET["marca"]) && !preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["marca"])) {
			$err = $err . "<p id=\"marca_err\">La marca che hai inserito non &egrave; valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if (isset($_GET["modello"]) && !preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["modello"])) {
			$err = $err . "<p id=\"modello_err\">Il modello che hai inserito non &egrave; valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
		}
		if (isset($_GET["anno"]) && is_numeric($_GET["anno"]) && (!preg_match("/^\d{1,4}$/", $_GET["anno"]) || intval($_GET["anno"]) <= 0)) {
			$err = $err . "<p id=\"anno_err\">L'anno che hai inserito non &egrave; valido, inserisci un anno maggiore di 0 e di massimo 4 cifre.</p>";
		}
		if (isset($_GET["colore"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["colore"])) {
			$err = $err . "<p id=\"colore_err\">Il colore che hai selezionato non &egrave; valido. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if (isset($_GET["alimentazione"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["alimentazione"])) {
			$err = $err . "<p id=\"alimentazione_err\">Hai selezionato un'alimentazione non valida. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if (isset($_GET["cambio"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["cambio"])) {
			$err = $err . "<p id=\"cambio_err\">Hai selezionato un tipo di cambio non valido. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if (isset($_GET["trazione"]) && !preg_match("/^([A-Za-z]+( [A-Za-z]+)*)?$/", $_GET["trazione"])) {
			$err = $err . "<p id=\"trazione_err\">Hai selezionato un tipo di trazione non valido. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if (isset($_GET["potenzaMin"]) && is_numeric($_GET["potenzaMin"])) {
			if (!preg_match("/^(\d+)?$/", $_GET["potenzaMin"]) || intval($_GET["potenzaMin"]) <= 0 || (!empty($_GET["potenzaMax"]) ? (intval($_GET["potenzaMin"]) > intval($_GET["potenzaMax"])) : false)) {
				$err = $err . "<p id=\"potenzaMin_err\">Hai inserito una potenza minima non valida, inserisci una potenza maggiore di 0 e minore o uguale alla potenza massima.</p>";
			}
		}
		if (isset($_GET["potenzaMax"]) && is_numeric($_GET["potenzaMax"])) {
			if (!preg_match("/^(\d+)?$/", $_GET["potenzaMax"]) || intval($_GET["potenzaMax"]) <= 0 || (!empty($_GET["potenzaMin"]) ? (intval($_GET["potenzaMax"]) < intval($_GET["potenzaMin"])) : false)) {
				$err = $err . "<p id=\"potenzaMax_err\">Hai inserito una potenza massima non valida, inserisci una potenza maggiore di 0 e maggiore o uguale alla potenza minima.</p>";
			}
		}
		if (isset($_GET["pesoMin"]) && is_numeric($_GET["pesoMin"])) {
			if (!preg_match("/^(\d+)?$/", $_GET["pesoMin"]) || intval($_GET["pesoMin"]) <= 0 || (!empty($_GET["pesoMax"]) ? (intval($_GET["pesoMin"]) > intval($_GET["pesoMax"])) : false)) {
				$err = $err . "<p id=\"pesoMin_err\">Hai inserito un peso minimo non valido, inserisci un peso maggiore di 0 e minore o uguale al peso massimo.</p>";
			}
		}
		if (isset($_GET["pesoMax"]) && is_numeric($_GET["pesoMax"])) {
			if (!preg_match("/^(\d+)?$/", $_GET["pesoMax"]) || intval($_GET["pesoMax"]) <= 0 || (!empty($_GET["pesoMin"]) ? (intval($_GET["pesoMax"]) < intval($_GET["pesoMin"])) : false)) {
				$err = $err . "<p id=\"pesoMax_err\">Hai inserito un peso massimo non valido, inserisci un peso maggiore di 0 e maggiore o uguale al peso minimo.</p>";
			}
		}
		if (isset($_GET["posti"]) && is_numeric($_GET["posti"]) && (!preg_match("/^(\d+)?$/", $_GET["anno"]) || intval($_GET["anno"]) <= 0)) {
			$err = $err . "<p id=\"posti_err\">Hai inserito un numero di posti non valido, inserisci un numero maggiore di 0.</p>";
		}
		if (isset($_GET["condizione"]) && !preg_match("/^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/", $_GET["condizione"])) {
			$err = $err . "<p id=\"condizione_err\">hai selezionato una condizione non valida. Seleziona nuovamente la scelta desiderata.</p>";
		}
		if (isset($_GET["prezzoMax"]) && is_numeric($_GET["prezzoMax"]) && (!preg_match("/^(\d+)?$/", $_GET["prezzoMax"]) || intval($_GET["prezzoMax"]) <= 0)) {
				$err = $err . "<p id=\"prezzoMax_err\">Hai inserito un prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
		}
		if (isset($_GET["chilometraggio"]) && is_numeric($_GET["chilometraggio"]) && (!preg_match("/^(\d+)?$/", $_GET["chilometraggio"]) || intval($_GET["chilometraggio"]) <= 0)) {
			$err = $err . "<p id=\"chilometraggio_err\">Hai inserito un chilometraggio non valido, inserisci un valore maggiore di 0.</p>";
		}
		if (!empty($_GET["neopatentati"]) && intval($_GET["neopatentati"]) != 1) {
			$err = $err . "<p id=\"neopatentati_err\">Hai selezionato un valore di neopatentati non valido. Seleziona nuovamente la scelta desiderata.</p>";
		}

		//CONTROLLO ERRORI
		if (!empty($err)) {
			$listinoHTML = ripristinoInput($listinoHTML);
			echo str_replace("[err]", $err, $listinoHTML);
			exit();
		}

		//ESECUZIONE DELLA QUERY

		$params = array();
		foreach($_GET as $param => $value) {
			switch($param) {
				// Per i valori double o interi, se uso intval/doubleval e ho stringa vuota di partenza, diventa 0/0.0

				// Per i valori interi	
				case "potenzaMin":
				case "potenzaMax":
				case "pesoMin":
				case "pesoMax":
				case "posti":
				case "anno":
				case "neopatentati":
				case "prezzoMax":
				case "chilometraggio":
					if(intval($value) != 0) {
						$params[$param] = intval($value);
					}
					break;
				case "action":
					break;
				// Per le stringhe
				default:
					if((!str_contains($value, "qualsiasi")) && $value !== "") {
						$params[$param] = $value;
					}
					break;
			}
		}

		// Qui chiamo funziona per ricavare auto
		$listinoHTML = getVehiclesFromDB($params, $listinoHTML);

		echo str_replace("[err]", $err, $listinoHTML);
	}
		
} else if(isset($_GET['action']) && $_GET['action'] == 'Rimuovi filtri') {
	unset($_GET);
	$listinoHTML = getVehiclesFromDB(array(), $listinoHTML);
	echo str_replace("[err]", $err, $listinoHTML);
} else {
	$listinoHTML = getVehiclesFromDB(array(), $listinoHTML);
	echo str_replace("[err]", $err, $listinoHTML);
}

/*

isset($_GET['marca']) ? $_GET['marca'] : '')

if(isset($_GET['action']) && $_GET['action'] == 'Applica filtri') {
	if() {
	
		if(isset($_COOKIE["isFilterRemoved"])) {
			setcookie("isFilterRemoved", "", time() - 3600, "/");
		}
	}  else {
	// Se ho impostato come valore nel GET solo action=Applica+filtri
	header("location: listino.php");
	}
} else if (isset($_GET['action']) && $_GET['action'] == 'Rimuovi filtri') {
	setcookie("isFilterRemoved", str_replace("Rimuovi+filtri", "Applica+filtri", $_SERVER["REQUEST_URI"]));
	header("location: " . str_replace("Rimuovi+filtri", "Applica+filtri", $_SERVER["REQUEST_URI"]));
} else {
 
}

*/

?>