<?php

function ripristinoInput(){
	$loginHTML = file_get_contents('login.html');
	//RIPRISTINO DELL'INPUT INSERITO
	$loginHTML = str_replace("[username]", htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : ''), $loginHTML);
	$loginHTML = str_replace("[password]", htmlspecialchars(isset($_POST['password']) ? $_POST['password'] : ''), $loginHTML);
	return $loginHTML;
}

require_once 'dbConnection.php';
use DB\DBConnection;

$loginHTML = file_get_contents('login.html');

$err = "";

//CONTROLLO SE UTENTE IN SESSION STORAGE GIA' SETTATO
session_start();
if (isset($_SESSION["utente"])) {
	header("location: utente.php");
	exit();
}


//CONTROLLO SE SONO SETTATI TUTTI I CAMPI E CHE NON SIANO VUOTI
if(isset($_POST["username"]) && isset($_POST["password"])){

	if(empty($_POST["username"]) || empty($_POST["password"])){
		$err = $err . "<p>Devi compilare tutti i campi.</p>";
        $loginHTML = ripristinoInput();
		echo str_replace("[err]", $err, $loginHTML);
		exit();
	}
	else{

		//ESECUZIONE DELLA QUERY
		try{
			$db = new DBConnection();
			$ris = $db->loginUser($_POST["username"], $_POST["password"]);
			$db->closeConnection();
			unset($db);
			if($ris == -1){
				$err = $err . "<p>L'<span lang='en-GB'>username</span> che hai inserito non &egrave; stato trovato.</p>";
				$loginHTML = ripristinoInput();
				echo str_replace("[err]", $err, $loginHTML);
			}
			else{
				if($ris == 1){
					if($_POST["username"] == "admin"){
						$_SESSION['utente'] = $_POST["username"];
						if(isset($_COOKIE['backToOrigin'])){
							setcookie("backToOrigin", "", time() - 7200);
						}
						header("location: amministratore.php");
					}
					else{
						$_SESSION['utente'] = $_POST["username"];
						//CONTROLLO BACK TO ORIGIN PER TORNARE ALLA PAGINA DI PROVENIENZA
						if(isset($_COOKIE['backToOrigin'])){
							$oldPath = $_COOKIE['backToOrigin'];
							setcookie("backToOrigin", "", time() - 7200);
							header("location: " . $oldPath);
						}
						else{
							header("location: utente.php");
						}
					}
				}
				else{
					$err = $err . "<p>La<span lang='en-GB'>password</span> che hai inserito &egrave; errata.</p>";
				    $loginHTML = ripristinoInput();
				    echo str_replace("[err]", $err, $loginHTML);
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
	$loginHTML = ripristinoInput();
	echo str_replace("[err]", $err, $loginHTML);
}

?>