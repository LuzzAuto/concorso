<?php

require_once 'dbConnection.php';
use DB\DBConnection;

function creaTabellaPrenotazioni($username) {
    // Variabile per memorizzare il risultato
    $campiTabella = '';
    
    try {
        // Connessione al database
        $db = new DBConnection();
        
        // Recupera le prenotazioni per l'utente
        $prenotazione = $db->getPrenotazioniUtente($username);
        
        // Chiudi la connessione
        $db->closeConnection();
        unset($db);
        
        // Se non ci sono prenotazioni, mostro il messaggio corrispondente
        if (empty($prenotazione)) {
            $campiTabella = "<p id='prenIndispUtente'>Non ci sono prenotazioni disponibili.</p>";
        } else {
            // Altrimenti creo il markup della tabella
            $campiTabella = "
                            <p id='descTable' aria-hidden='true'>
                            La tabella descrive le prenotazioni dei test drive da parte dell'utente, è organizzata in colonne
                            con numero prenotazione, modello auto, data <span lang='en-GB'>Test Drive</span> e stato della prenotazione 
                            </p>
                            <table class='tabellaPrenUtente' aria-describedby='descTable'>
                            <caption class='nomeRiqPrenUtente'>Prenotazioni</caption>
                                <thead>
                                <tr>
                                    <th scope='col' abbr='Numero'>Numero prenotazione</th>
                                    <th scope='col' abbr='modello'>Modello Auto</th>
                                    <th scope='col' abbr='data'>Data <span lang='en-GB'>Test Drive</span></th>
                                    <th scope='col' >Stato</th>
                                </tr>
                                </thead>
                                <tbody>";
            // Ciclo su ogni prenotazione per generare le righe
            foreach ($prenotazione as $row) {
                $statoTestuale = "";
                if ($row['stato'] == 1) {
                    $statoTestuale = "<span class='accettatoUtente'>Accettato</span>";
                } else if ($row['stato'] == -1) {
                    $statoTestuale = "<span class='rifiutatoUtente'>Rifiutato</span>";
                } else {
                    $statoTestuale = "<span class='attesaUtente'>In attesa</span>";
                }

                // Aggiungi una riga per la prenotazione
                $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'] . "-" . $row['dataOra'] . "-" . $row['stato']; 
                $campiTabella .= "<tr>
                                    <th scope='row' data-title='Codice'>" . $row["codice"] . "</th>
                                    <td data-title='Auto'>" . $row["marca"] . " " . $row['modello'] . "</td>
                                    <td data-title='Data'><time datetime='" . $row['dataOra'] . "'>" . $row['dataOra'] . "</time></td>
                                    <td data-title='Stato'>" . $statoTestuale . "</td>
                                  </tr>";
            }
            $campiTabella .= "</tbody>
                              </table>"; 
        }
    } catch (Exception $e) {
        // Gestisco l'errore nel caso di problemi con la connessione
        header("location: 500.html");
        exit();
    }

    return $campiTabella; // Restituisco il markup generato della tabella
}

session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION["utente"])) {
    header("location: login.php");
    exit();
}
// Controllo se l'amministratore è loggato
if (isset($_SESSION["utente"]) && $_SESSION["utente"] =="admin") {
    header("location: amministratore.php");
    exit();
}

//INFORMAZIONI UTENTE

// Recupero username dalla sessione
$username = $_SESSION["utente"];

$db = new DBConnection();

try {

    $utente = $db->getNomeCognomeUser($username);

    if (!empty($utente)) {
        $nome = $utente[0]['nome'];
        $cognome = $utente[0]['cognome'];
        $username = $utente[0]['username'];
    } else {
        $nome = 'Nome non trovato';
        $cognome = 'Cognome non trovato';
        $username = 'Utente non trovato';
    }

    $db->closeConnection();

} catch (Exception $e) {
    header("location: 500.html");
    exit();
}


// Carico template html
$pagina = file_get_contents('utente.html');

// Sostituisco i segnaposto nel template con i dati recuperati
$pagina = str_replace('[nome]', htmlspecialchars($nome), $pagina);
$pagina = str_replace('[cognome]', htmlspecialchars($cognome), $pagina);
$pagina = str_replace('[username]', htmlspecialchars($username), $pagina);




//TABELLA PRENOTAZIONI

$campiTabella = creaTabellaPrenotazioni($username);
$pagina = str_replace("[campiTabella]", $campiTabella, $pagina);





//GESTIONE PRENOTAZIONE
$err = "";


//esecuzione della query
try{
    $db = new DBConnection();
    $prenotazione = $db->getPrenElimina($username);
    $db->closeConnection();

    unset($db);

    $prenotazioni = '';

    //inserimento veicoli nel select
    foreach($prenotazione as $row){
        $val = $row["codice"] . "-" . $row["marca"] . "-" . $row['modello'];

        //reimposto il valore settato
        if(isset($_POST['gestPrenUtente']) && $_POST['gestPrenUtente'] == $val){
            $prenotazioni .= "<option value='" . $val . "' selected>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        else{
            $prenotazioni .= "<option value='" . $val . "'>" . $row["codice"] . " - " . $row["marca"] . " " . $row['modello'] . "</option>";
        }
        
    }
    $pagina = str_replace("[prenotazioni]", $prenotazioni, $pagina);

}
    
catch(Exception $e){
    header("location: 500.html");
    exit();
}


if (isset($_POST['gestPrenUtente'])) {

    // Controllo sul campo vuoto
    if (empty($_POST['gestPrenUtente'])) {
        $err .= "<p>Devi compilare tutti i campi.</p>";
        $pagina = str_replace("[err]", $err, $pagina);
        echo $pagina;
        exit();
    }

    // Controllo sull'input (validazione)
    if (!preg_match("/^[A-Za-z0-9\-\s]+$/", $_POST["gestPrenUtente"])) {
        $err = $err . "<p>La prenotazione che hai selezionato non &egrave; valida</p>";
    }

    // Restituzione errori in caso di problemi di validazione
    if (!empty($err)) {
        $pagina = str_replace("[err]", $err, $pagina);
        echo $pagina;
        exit();
    }

    // Recupero ID della prenotazione
    $idPrenotazione = explode("-", $_POST["gestPrenUtente"])[0];
    $idPrenotazione = htmlspecialchars($idPrenotazione);

    // Tentativo di cancellazione della prenotazione
    try {
        $db = new DBConnection();
        $ris = $db->deletePrenotazione($idPrenotazione); // Assume che la funzione restituisca un booleano (true/false)
        $db->closeConnection();
        unset($db);

        if ($ris==true) {
                // Prenotazione cancellata con successo
                header("location: utente.php");
        } else {
            // Prenotazione non trovata
            $err .= "<p>La prenotazione che hai selezionato non esiste. (ID: " . $idPrenotazione . ")</p>";
        }

    } catch (Exception $e) {
        // Gestione errori e logging
        //error_log("Errore: " . $e->getMessage());
        header("location: 500.html");
        exit();
    }

    // Aggiornamento della pagina con esito finale
    $pagina = str_replace("[err]", $err, $pagina);

}else{
    $pagina = str_replace("[err]", $err, $pagina);
}


echo $pagina;
?>