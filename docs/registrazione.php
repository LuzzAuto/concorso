<?php

function ripristinoInput(){
	$registrazioneHTML = file_get_contents('registrazione.html');
	//RIPRISTINO DELL'INPUT INSERITO
	$registrazioneHTML = str_replace("[nome]", htmlspecialchars(isset($_POST['nome']) ? $_POST['nome'] : ''), $registrazioneHTML);
	$registrazioneHTML = str_replace("[cognome]", htmlspecialchars(isset($_POST['cognome']) ? $_POST['cognome'] : ''), $registrazioneHTML);
	$registrazioneHTML = str_replace("[username]", htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : ''), $registrazioneHTML);
	$registrazioneHTML = str_replace("[password]", htmlspecialchars(isset($_POST['password']) ? $_POST['password'] : ''), $registrazioneHTML);
	$registrazioneHTML = str_replace("[password2]", htmlspecialchars(isset($_POST['password2']) ? $_POST['password2'] : ''), $registrazioneHTML);
	$registrazioneHTML = str_replace("[data]", htmlspecialchars(isset($_POST['data']) ? $_POST['data'] : ''), $registrazioneHTML);
	return $registrazioneHTML;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$registrazioneHTML = file_get_contents('registrazione.html');

$err = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
session_start();
if (isset($_SESSION["utente"])) {
	header("location: utente.php");
	exit();
}


//CONTROLLO SE SONO SETTATI TUTTI I CAMPI E CHE NON SIANO VUOTI
if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password2"]) && isset($_POST["data"])){

	if(empty($_POST["nome"]) || empty($_POST["cognome"]) || empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["data"])){
		$err = $err . "<p>Devi compilare tutti i campi.</p>";
		$registrazioneHTML = ripristinoInput();
		echo str_replace("[err]", $err, $registrazioneHTML);
		exit();
	}
	else{

		//CONTROLLI SULL'INPUT
		if (!preg_match("/^[A-Za-z]+$/", $_POST["nome"])) {
			$err = $err . "<p>Nome non valido, puoi usare solo lettere.</p>";
		}
		if (!preg_match("/^[A-Za-z]+$/", $_POST["cognome"])) {
			$err = $err . "<p>Cognome non valido, puoi usare solo lettere</p>";
		}
		if (strlen($_POST["username"]) > 30) {
			$err = $err . "<p>L'<span lang='en-GB'>username</span> deve essere lungo al massimo 30 caratteri.</p>";
		}
		if (!preg_match("/^[A-Za-z0-9]+$/", $_POST["username"])) {
			$err = $err . "<p><span lang='en-GB'>Username</span> non valido, puoi usare solo lettere o numeri.</p>";
		}
		if (strlen($_POST["password"]) < 8) {
			$err = $err . "<p>La <span lang='en-GB'>password</span> deve essere di almeno 8 caratteri.</p>";
		}
		if (!preg_match("/\d/", $_POST["password"]) || ! preg_match("/[a-zA-Z]/", $_POST["password"])) {
			$err = $err . "<p>La <span lang='en-GB'>password</span> deve contenere almeno una lettera e un numero.</p>";
		}
		if ($_POST["password"] != $_POST["password2"]) {
			$err = $err . "<p>Le <span lang='en-GB'>password</span> non coincidono.</p>";
		}
		if (strtotime($_POST["data"]) > strtotime(date("Y-m-d")) || !preg_match('/^[0-9\-]+$/', $_POST["data"])) {
			$err = $err . "<p>La data che hai inserito non &egrave; valida. Usa formato gg/mm/aaaa</p>";
		}
		

		//CONTROLLO ERRORI
		if (!empty($err)) {
			$registrazioneHTML = ripristinoInput();
			echo str_replace("[err]", $err, $registrazioneHTML);
			exit();
		}

		//ESECUZIONE DELLA QUERY
		try{
			$db = new DBConnection();
			$ris = $db->registerUser($_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["nome"], $_POST["cognome"], $_POST["data"]);
			$db->closeConnection();
			unset($db);
			if($ris == -1){
				$err = $err . "<p>L'<span lang='en-GB'>username</span> che hai inserito &egrave; già in uso.</p>";
				$registrazioneHTML = ripristinoInput();
				echo str_replace("[err]", $err, $registrazioneHTML);
			}
			else{
				if($ris){
					$_SESSION['utente'] = $_POST["username"];
					//CONTROLLO BACK TO ORIGIN PER TORNARE ALLA PAGINA DI PROVENIENZA
                    if(isset($_COOKIE['backToOrigin'])){
                        header("location: " . $_COOKIE['backToOrigin']);
                        setcookie("backToOrigin", "", time() - 3600, "/");
                    }
                    else{
                        header("location: utente.php");
                    }
				}
				else{
					header("location: 500.html");
					exit();
				}
			}
		}
		catch(Exception){
			header("location: 500.html");
			exit();
		}
		

	}

}
else{
	$registrazioneHTML = ripristinoInput();
	echo str_replace("[err]", $err, $registrazioneHTML);
}


?>