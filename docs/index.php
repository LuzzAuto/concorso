<?php

function ripristinoInput(){
	$indexHTML = file_get_contents('index.html');
	//RIPRISTINO DELL'INPUT INSERITO
	// Se c'è input salvato in $_GET, mette quello, altrimenti valore di default (stringa vuota o select default)
	$indexHTML = str_replace("[marca]", htmlspecialchars(isset($_GET['marca']) ? 'value="' . $_GET['marca'] . '"' : ''), $indexHTML);
	$indexHTML = str_replace("[modello]", htmlspecialchars(isset($_GET['modello']) ? 'value="' . $_GET['modello'] . '"' : ''), $indexHTML);

	//replace condizione
	if(htmlspecialchars(isset($_GET['condizione']))) {
		$indexHTML = str_replace("[" . $_GET['condizione'] . "]", "selected ", $indexHTML);
	}
	// rimpiazzo di default -> seleziono qualsiasi
	$indexHTML = str_replace(["[qualsiasiCd]", "[nuovo]", "[usato]", "[km0]"], ["selected ", "", "", ""], $indexHTML);

	$indexHTML = str_replace("[prezzoMax]", htmlspecialchars(isset($_GET['prezzoMax']) ? 'value="' . $_GET['prezzoMax'] . '"' : ''), $indexHTML);
	return $indexHTML;
}

require_once "dbConnection.php";
use DB\DBConnection;

//DA SOSTITUIRE CON PERCORSO FILE HTML
$indexHTML = file_get_contents("index.html");

$err = "";

if(isset($_GET["marca"]) || isset($_GET["modello"]) || isset($_GET["condizione"]) || isset($_GET["prezzoMax"])) {

    //CONTROLLI SULL'INPUT
	//CONTROLLI SULL'INPUT
	if (isset($_GET["marca"]) && !preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["marca"])) {
		$err = $err . "<p>Marca non valida, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (isset($_GET["modello"]) && !preg_match("/^([A-Za-z0-9\-]+( [A-Za-z0-9\-]+)*)?$/", $_GET["modello"])) {
		$err = $err . "<p>Modello non valido, puoi usare solo lettere, numeri, spazi(non all'inizio e alla fine) e il carattere \"-\".</p>";
	}
	if (isset($_GET["condizione"]) && !preg_match("/^([A-Za-z0-9]+( [A-Za-z0-9]+)*)?$/", $_GET["condizione"])) {
		$err = $err . "<p>Selezione condizione non valida. Seleziona nuovamente la scelta desiderata.</p>";
	}
	if (isset($_GET["prezzoMax"]) && is_numeric($_GET["prezzoMax"]) && (!preg_match("/^(\d+)?$/", $_GET["prezzoMax"]) || intval($_GET["prezzoMax"]) <= 0)) {
		$err = $err . "<p>Prezzo non valido, inserisci un prezzo maggiore di 0.</p>";
	}

	//CONTROLLO ERRORI
	if (!empty($err)) {
		$indexHTML = ripristinoInput();
		echo str_replace("[err]", $err, $indexHTML);
		exit();
	}

	// PASSAGGIO A LISTINO.PHP
	// Aggiungo i valori di default di listino
	$queryString = http_build_query($_GET) . "&anno=&colore=qualsiasi&alimentazione=qualsiasi&cambio=qualsiasi&trazione=qualsiasi&potenzaMin=&potenzaMax=&pesoMin=&pesoMax=&posti=&chilometraggio=&action=Applica+filtri";
	header("location: listino.php?$queryString");

} else {
	$indexHTML = ripristinoInput();
	echo str_replace("[err]", $err, $indexHTML);
}

?>