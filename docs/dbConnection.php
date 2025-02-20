<?php
namespace DB;

use Exception;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DBConnection {
	#private const HOST_DB = "tecweb.studenti.math.unipd.it";
	private const HOST = "db";            		//localhost
	private const NAME = "LuzzAutoDB";			//fbellon
	private const USER = "userdb";				//fbellon
	private const PASS = "userdb";

	private $connection;

	public function __construct() {
		try {
			$this->connection = mysqli_connect(self::HOST, self::USER, self::PASS, self::NAME);
		} catch (Exception $e) {
			throw $e;
		}
	}
	public function getConnection() {
		if (!$this->connection->connect_errno)
			return $this->connection;
	}
	public function closeConnection() {
		if (!$this->connection->connect_errno)
			$this->connection->close();
	}

	//FUNZIONE DI REGISTRAZIONE DI UN UTENTE NEL DB
	public function registerUser($username, $password, $nome, $cognome, $dataNascita) {

		$queryControllo = "SELECT * FROM Utente WHERE username = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("s", $username);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$numRows = count($rows);

		if($numRows != 0){
			return -1;
		}

		// Preparazione della query SQL con placeholder
		$query = "INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES (?, ?, ?, ?, ?)";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri ("sssss" = 5 stringhe)
		$stmt->bind_param("sssss", $username, $password, $nome, $cognome, $dataNascita);

		// Esecuzione della query
		$result = $stmt->execute();

		// Controllo del risultato
		if ($result) {
			return 1;
		} else {
			return 0;
		}
			
	}

	//FUNZIONE DI LOGIN DI UN UTENTE
	public function loginUser($username, $password) {

		$queryControllo = "SELECT username, password FROM Utente WHERE username = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("s", $username);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$numRows = count($rows);

		if($numRows == 0){
			return -1;
		}
		else{
			if(password_verify($password, $rows[0]['password'])){
				return 1;
			}
			else{
				return 0;
			}
		}
			
	}

	//FUNZIONE DI REGISTRAZIONE DI UN UTENTE NEL DB
	public function insertPrenotazione($username, $idAuto, $data) {

		$queryControllo = "SELECT * FROM Veicolo WHERE id = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("i", $idAuto);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$numRows = count($rows);

		if($numRows == 0){
			return -1;
			//L'AUTO NON ESISTE
		}

		$queryControllo2 = "SELECT * FROM Prenotazione WHERE username = ? AND idAuto = ? AND dataOra = ?";
		// Preparazione dello statement
		$stmt2 = $this->connection->prepare($queryControllo2);
		if ($stmt2 === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt2->bind_param("sis", $username, $idAuto, $data);
		// Esecuzione della query
		if (!$stmt2->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt2->error);
		}
		// Ottenimento del risultato
		$result2 = $stmt2->get_result();
		$rows2 = $result2->fetch_all(MYSQLI_ASSOC);
		$numRows2 = count($rows2);

		if($numRows2 != 0){
			return -2;
			//PRENOTAZIONE GIA' ESISTENTE
		}

		// Preparazione della query SQL con placeholder
		$query = "INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES (?, ?, ?, 0)";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri ("sssss" = 5 stringhe)
		$stmt->bind_param("sis", $username, $idAuto, $data);

		// Esecuzione della query
		$result = $stmt->execute();

		// Controllo del risultato
		if ($result) {
			return 1;
			//INSERITA CON SUCCESSO
		} else {
			return 0;
			//ERRORE NELL'INSERIMENTO
		}
			
	}

	// FUNZIONE PER RICAVARE I VEICOLI CON FILTRI APPLICATI PRESENTI NEL DB
	/*
	* Uso array associativo params dove metto i vari valori. Se valore vuoto, non lo setto in params
	*/
	public function getFilteredVehicles($params) {

		$query = "SELECT * FROM Veicolo";

		$result = array();

		// Se params non è vuoto, aggiungo clausola WHERE
		if(!empty($params)) {
			$query .= " WHERE";
			$paramS = "";
			$paramA = array();

			// Faccio controllo per ogni parametro auto

			if(isset($params["marca"])) {
				$query .= " marca LIKE ? AND";
				array_push($paramA, "%" . $params["marca"] . "%");
				$paramS .= "s";
			}

			if(isset($params["modello"])) {
				$query .= " modello LIKE ? AND";
				array_push($paramA, "%" . $params["modello"] . "%");
				$paramS .= "s";
			}

			if(isset($params["anno"])) {
				$query .= " anno = ? AND";
				array_push($paramA, $params["anno"]);
				$paramS .= "i";
			}

			if(isset($params["colore"])) {
				$query .= " colore LIKE ? AND";
				array_push($paramA, "%" . $params["colore"] . "%");
				$paramS .= "s";
			}

			if(isset($params["alimentazione"])) {
				$query .= " alimentazione LIKE ? AND";
				array_push($paramA, "%" . $params["alimentazione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["cambio"])) {
				$query .= " cambio LIKE ? AND";
				array_push($paramA, "%" . $params["cambio"] . "%");
				$paramS .= "s";
			}

			if(isset($params["trazione"])) {
				$query .= " trazione LIKE ? AND";
				array_push($paramA, "%" . $params["trazione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["potenzaMin"])) {
				$query .= " potenza >= ? AND";
				array_push($paramA, $params["potenzaMin"]);
				$paramS .= "i";
			}

			if(isset($params["potenzaMax"])) {
				$query .= " potenza <= ? AND";
				array_push($paramA, $params["potenzaMax"]);
				$paramS .= "i";
			}

			if(isset($params["pesoMin"])) {
				$query .= " peso >= ? AND";
				array_push($paramA, $params["pesoMin"]);
				$paramS .= "i";
			}

			if(isset($params["pesoMax"])) {
				$query .= " peso <= ? AND";
				array_push($paramA, $params["pesoMax"]);
				$paramS .= "i";
			}

			if(isset($params["neopatentati"])) {
				$query .= " neopatentati = ? AND";
				array_push($paramA, $params["neopatentati"]);
				$paramS .= "i";
			}

			if(isset($params["posti"])) {
				$query .= " numeroPosti = ? AND";
				array_push($paramA, $params["posti"]);
				$paramS .= "i";
			}

			if(isset($params["condizione"])) {
				$query .= " condizione LIKE ? AND";
				array_push($paramA, "%" . $params["condizione"] . "%");
				$paramS .= "s";
			}

			if(isset($params["prezzoMax"])) {
				$query .= " prezzo <= ? AND";
				array_push($paramA, $params["prezzoMax"]);
				$paramS .= "d";
			}

			if(isset($params["chilometraggio"])) {
				$query .= " chilometraggio <= ? AND";
				array_push($paramA, $params["chilometraggio"]);
				$paramS .= "i";
			}

			//rimuovo ULTIMO AND dalla stringa
			$query = substr($query, 0, -4);
		}

		$query .= " ORDER BY marca ASC";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// echo $stmt->param_count;

		if(!empty($params)) {
			// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
			$stmt->bind_param($paramS, ...$paramA);
		}

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		return $rows;
	}

	public function getAllVehicleColors() {
		$query = "SELECT DISTINCT colore FROM Veicolo";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		$colors = array();

		foreach($rows as $color)
			array_push($colors, $color["colore"]);
			
		return $colors;
	}

	//FUNZIONE PER RICAVARE DETTAGLI VEICOLO DA ID
	public function getVehicleDetails($id) {
		$query = "SELECT * FROM Veicolo WHERE ID = ?";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
		$stmt->bind_param("i", $id);

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$row = $result->fetch_all(MYSQLI_ASSOC);

		if(count($row) == 1){
			return $row[0];
		}

		return -1;
	}


	//FUNZIONE PER PRENDERE NOME, COGNOME E USERNAME DA USERNAME
	public function getNomeCognomeUser($username) {
		$query = "SELECT nome, cognome, username FROM Utente WHERE username = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Binding dei parametri
		$stmt->bind_param("s", $username);
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}
	
	

	//FUNZIONE PER PRENDERE LE PRENOTAZIONI DI UN USERNAME(codice, marca, modello)
	public function getPrenElimina($username) {
		$query = "SELECT p.codice, v.marca, v.modello
				  FROM Prenotazione p
				  JOIN Veicolo v ON p.idAuto = v.id
				  WHERE p.username = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Binding dei parametri
		$stmt->bind_param("s", $username);
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}



	//FUNZIONE PER PRENDERE LE PRENOTAZIONI DI UN USERNAME(codice, marca, modello, data, stato)
	public function getPrenotazioniUtente($username) {
		$query = "SELECT p.codice, v.marca, v.modello, p.dataOra, p.stato
					FROM Prenotazione p
					JOIN Veicolo v ON p.idAuto = v.id
					WHERE p.username LIKE ?
					ORDER BY p.codice";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Binding dei parametri
		$stmt->bind_param("s", $username);

		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}

		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);

		return $rows;
	}


	//FUNZIONE PER PRENDERE TUTTE LE PRENOTAZIONI PRESENTI NEL DB
	public function getAllPrenotazioni() {
		$query = "SELECT p.codice, p.username, v.marca, v.modello, p.dataOra, p.stato
					FROM Prenotazione p
					JOIN Veicolo v ON p.idAuto = v.id
					ORDER BY p.codice";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Ottenimento del risultato
		$result = $stmt->get_result();
		if ($result === false) {
			die("Errore nell'ottenimento del risultato: " . $stmt->error);
		}
	
		$rows = $result->fetch_all(MYSQLI_ASSOC);
	
		// Chiusura dello statement
		$stmt->close();
	
		return $rows;
	}


	//FUNZIONE PER AGGIORNARE LO STATO DELLA PRENOTAZIONE
	function updateStatoPrenotazione($codicePrenotazione, $stato) {
		$query = "UPDATE Prenotazione SET stato = ? WHERE codice = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Binding dei parametri
		$stmt->bind_param("is", $stato, $codicePrenotazione);
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Controllo righe modificate
		if ($stmt->affected_rows > 0) {
			return true; // Stato aggiornato con successo
		} else {
			return false; // Nessuna prenotazione corrisponde al codice fornito
		}
	}
	

	//FUNZIONE PER CANCELLARE LE PRENOTAZIONI
	public function deletePrenotazione($codicePrenotazione) {
		
		$query = "DELETE FROM Prenotazione WHERE codice = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("s", $codicePrenotazione)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Controllo righe eliminate
		if ($stmt->affected_rows > 0) {
			return true; // Prenotazione eliminata con successo
		} else {
			return false; // Nessuna prenotazione corrisponde al codice fornito
		}
	}

	//FUNZIONE PER AGGIORNARE IL NOME
	public function updateNome($username, $nuovoNome) {

		$query = "UPDATE Utente SET nome = ? WHERE username = ?;";
		
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("ss", $nuovoNome, $username)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
		
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		
		// Controllo del risultato
		if ($stmt->affected_rows > 0) {
			return true; 
		} else {
			return false;
		}
	}

	//FUNZIONE PER AGGIORNARE IL COGNOME
	public function updateCognome($username, $nuovoCognome) {
    
		$query = "UPDATE Utente SET cognome = ? WHERE username = ?;";
		
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("ss", $nuovoCognome, $username)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
		
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		
		// Controllo del risultato
		if ($stmt->affected_rows > 0) {
			return true; 
		} else {
			return false; 
		}
	}

	//FUNZIONE PER AGGIORNARE USERNAME
	public function updateUsername($username, $nuovoUsername) {
		// Inizio transazione
		$this->connection->begin_transaction();
	
		try {
			// 0. Controllo se username è già in uso
			$queryControllo = "SELECT COUNT(*) FROM Utente WHERE username = ?";

			// Preparazione dello statement
			$stmtControllo = $this->connection->prepare($queryControllo);
			if ($stmtControllo === false) {
				throw new Exception("Errore nella preparazione dello statement per il controllo: " . $this->connection->error);
			}

			// Associazione dei parametri alla query
			if (!$stmtControllo->bind_param("s", $nuovoUsername)) {
				throw new Exception("Errore nell'associazione dei parametri per il controllo: " . $stmtControllo->error);
			}

			// Esecuzione della query
			if (!$stmtControllo->execute()) {
				throw new Exception("Errore nell'esecuzione dello statement per il controllo: " . $stmtControllo->error);
			}

			$stmtControllo->bind_result($count);
			$stmtControllo->fetch();
			$stmtControllo->close();
	
			if ($count > 0) {
				return -2;		//se username già in uso
			}
	
			
			$this->connection->query("SET foreign_key_checks = 0;");		//disabilito temporaneamente la fk
	
			// 1. Aggiornare la tabella Prenotazione
			$queryPrenotazione = "UPDATE Prenotazione SET username = ? WHERE username = ?";

			// Preparazione dello statement
			$stmtPrenotazione = $this->connection->prepare($queryPrenotazione);
			if ($stmtPrenotazione === false) {
				throw new Exception("Errore nella preparazione dello statement per Prenotazione: " . $this->connection->error);
			}

			// Associazione dei parametri alla query
			if (!$stmtPrenotazione->bind_param("ss", $nuovoUsername, $username)) {
				throw new Exception("Errore nell'associazione dei parametri per Prenotazione: " . $stmtPrenotazione->error);
			}

			// Esecuzione della query
			if (!$stmtPrenotazione->execute()) {
				throw new Exception("Errore nell'esecuzione dello statement per Prenotazione: " . $stmtPrenotazione->error);
			}
			
	
			// 2. Aggiornare la tabella Utente
			$queryUtente = "UPDATE Utente SET username = ? WHERE username = ?";

			// Preparazione dello statement
			$stmtUtente = $this->connection->prepare($queryUtente);
			if ($stmtUtente === false) {
				throw new Exception("Errore nella preparazione dello statement per Utente: " . $this->connection->error);
			}

			// Associazione dei parametri alla query
			if (!$stmtUtente->bind_param("ss", $nuovoUsername, $username)) {
				throw new Exception("Errore nell'associazione dei parametri per Utente: " . $stmtUtente->error);
			}

			// Esecuzione della query
			if (!$stmtUtente->execute()) {
				throw new Exception("Errore nell'esecuzione dello statement per Utente: " . $stmtUtente->error);
			}
	
	
			$this->connection->query("SET foreign_key_checks = 1;");		// Riabilita la fk

			// Commit della transazione se entrambe le operazioni sono riuscite
			$this->connection->commit();
	
			return 1;
		} catch (Exception $e) {
			$this->connection->rollback();	//in caso di errore ripristino allo stato precedente
	
			return -1;
		}
	}
	
	
	//FUNZIONE PER AGGIORNARE LA PASSWORD
	public function updatePassword($username, $vecchiaPassword, $nuovaPassword) {
		try {
			// 1. Prendo la password corretta dall'utente
			$query = "SELECT password FROM Utente WHERE username = ?;";

			// Preparazione dello statement
			$stmt = $this->connection->prepare($query);
			if ($stmt === false) {
				throw new Exception("Errore nella preparazione dello statement: " . $this->connection->error);
			}
	
			// Associazione dei parametri alla query
			if (!$stmt->bind_param("s", $username)) {
				throw new Exception("Errore nell'associazione dei parametri: " . $stmt->error);
			}
	
			// Esecuzione della query
			if (!$stmt->execute()) {
				throw new Exception("Errore nell'esecuzione della query: " . $stmt->error);
			}
	
			// Recupero del risultato
			$result = $stmt->get_result();
			if ($result->num_rows === 0) {
				throw new Exception("Utente non trovato.");
			}
	
			$row = $result->fetch_assoc();		//prendo la password memorizzata
			$passwordMemorizzata = $row['password'];
	
			// Confronto della vecchia password con quella memorizzata
			if (!password_verify($vecchiaPassword, $passwordMemorizzata)) {
				return -2; 	// Significa che non corrisponde
			}
	
			// 2. Aggiorno la password 
			$queryUpdate = "UPDATE Utente SET password = ? WHERE username = ?;";

			// Preparazione dello statement
			$stmtUpdate = $this->connection->prepare($queryUpdate);
			if ($stmtUpdate === false) {
				throw new Exception("Errore nella preparazione dello statement per l'update: " . $this->connection->error);
			}
	
			// Crittografia della nuova password
			$nuovaPasswordCriptata = password_hash($nuovaPassword, PASSWORD_DEFAULT);
	
			// Associazione dei parametri alla query
			if (!$stmtUpdate->bind_param("ss", $nuovaPasswordCriptata, $username)) {
				throw new Exception("Errore nell'associazione dei parametri per l'update: " . $stmtUpdate->error);
			}
	
			// Esecuzione della query
			if (!$stmtUpdate->execute()) {
				throw new Exception("Errore nell'esecuzione della query di aggiornamento: " . $stmtUpdate->error);
			}
			
			// Verifico se la password è stata aggiornata
			if ($stmtUpdate->affected_rows > 0) {
				return 1;
			} else {
				return -1;
			}

		} catch (Exception $e) {
			return -1;
		}
	}


	//FUNZIONE PER INSERIRE LE AUTO
	public function insertAuto($marca, $modello, $anno, $colore, $alimentazione, $cambio, $trazione, $potenza, $peso, $neopatentati, $numeroPosti, $condizione, $chilometraggio, $prezzo, $foto, $alts) {
		$query = "INSERT INTO Veicolo (marca, modello, anno, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, condizione, chilometraggio, prezzo, foto, alts) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}

		// Bind dei parametri (s = stringa, i = intero, d = double/float, b = blob)
		$stmt->bind_param("ssissssiiiisidss", $marca, $modello, $anno, $colore, $alimentazione, $cambio, $trazione, $potenza, $peso, $neopatentati, $numeroPosti, $condizione, $chilometraggio, $prezzo, $foto, $alts);

		// Esecuzione della query
		$result = $stmt->execute();

		// Controllo del risultato
		if ($result) {
			return 1;
		} else {
			return 0;
		}
	
	}

	//FUNZIONE PER CANCELLARE LE AUTO
	public function deleteAuto($idAuto) {
		
		$query = "DELETE FROM Veicolo WHERE id = ?;";
	
		// Preparazione dello statement
		$stmt = $this->connection->prepare($query);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
	
		// Associazione dei parametri alla query
		if (!$stmt->bind_param("i", $idAuto)) {
			die("Errore nell'associazione dei parametri: " . $stmt->error);
		}
	
		// Esecuzione dello statement
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
	
		// Controllo righe eliminate
		if ($stmt->affected_rows > 0) {
			return true; // Auto eliminata con successo
		} else {
			return false; // Nessuna auto corrisponde all'id fornito
		}
	}

	//FUNZIONE DI LOGIN DI UN UTENTE
	public function deleteUser($username, $password) {

		$queryControllo = "SELECT username, password FROM Utente WHERE username = ?";
		// Preparazione dello statement
		$stmt = $this->connection->prepare($queryControllo);
		if ($stmt === false) {
			die("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		// Bind dei parametri
		$stmt->bind_param("s", $username);
		// Esecuzione della query
		if (!$stmt->execute()) {
			die("Errore nell'esecuzione dello statement: " . $stmt->error);
		}
		// Ottenimento del risultato
		$result = $stmt->get_result();
		$rows = $result->fetch_all(MYSQLI_ASSOC);
		
		if(!password_verify($password, $rows[0]['password'])){
			return -1;
		}
		else{
			//ELIMINAZIONE PRENOTAZIONI
			$query1 = "DELETE FROM Prenotazione WHERE username = ?;";
			// Preparazione dello statement
			$stmt1 = $this->connection->prepare($query1);
			if ($stmt1 === false) {
				die("Errore nella preparazione dello statement: " . $this->connection->error);
			}
		
			// Associazione dei parametri alla query
			if (!$stmt1->bind_param("s", $username)) {
				die("Errore nell'associazione dei parametri: " . $stmt1->error);
			}
		
			// Esecuzione dello statement
			if (!$stmt1->execute()) {
				die("Errore nell'esecuzione dello statement: " . $stmt1->error);
			}

			//ELIMINAZIONE UTENTE
			$query = "DELETE FROM Utente WHERE username = ?;";
			// Preparazione dello statement
			$stmt = $this->connection->prepare($query);
			if ($stmt === false) {
				die("Errore nella preparazione dello statement: " . $this->connection->error);
			}
		
			// Associazione dei parametri alla query
			if (!$stmt->bind_param("s", $username)) {
				die("Errore nell'associazione dei parametri: " . $stmt->error);
			}
		
			// Esecuzione dello statement
			if (!$stmt->execute()) {
				die("Errore nell'esecuzione dello statement: " . $stmt->error);
			}
			return 0;
		}
		
			
	}



}



?>
