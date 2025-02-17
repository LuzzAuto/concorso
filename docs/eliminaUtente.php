<?php

function ripristinoInput(){
	$elimHTML = file_get_contents('eliminaUtente.html');
	//RIPRISTINO DELL'INPUT INSERITO
	$elimHTML = str_replace("[password]", htmlspecialchars(isset($_POST['password']) ? $_POST['password'] : ''), $elimHTML);
	return $elimHTML;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$elimHTML = file_get_contents('eliminaUtente.html');

$err = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
session_start();
if (!isset($_SESSION["utente"])) {
	header("location: login.php");
	exit();
}


//CONTROLLO SE SONO SETTATI TUTTI I CAMPI E CHE NON SIANO VUOTI
if(isset($_POST["password"])){

	if(empty($_POST["password"])){
		$err = $err . "<p>Devi compilare tutti i campi.</p>";
        $elimHTML = ripristinoInput();
		echo str_replace("[err]", $err, $elimHTML);
		exit();
	}
	else{

		//ESECUZIONE DELLA QUERY
		try{
			$db = new DBConnection();
			$ris = $db->deleteUser($_SESSION["utente"], $_POST["password"]);
			$db->closeConnection();
			unset($db);
			if($ris == -1){
				$err = $err . "<p>La <span lang='en-GB'>password</span> che hai inserito &egrave; errata.</p>";
				$elimHTML = ripristinoInput();
				echo str_replace("[err]", $err, $elimHTML);
			}
			else{
				header("location: logout.php");
			}
		}
		catch(Exception){
			header("location: 500.html");
			exit();
		}

	}

}
else{
	$elimHTML = ripristinoInput();
	echo str_replace("[err]", $err, $elimHTML);
}

?>