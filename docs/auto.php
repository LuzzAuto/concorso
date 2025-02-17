<?php

require_once "dbConnection.php";
use DB\DBConnection;

$autoHTML = file_get_contents(filename: 'auto.html');

if (!isset($_GET['id'])) {
    if(!isset($_COOKIE['auto_details_id'])){
        header(header: "location: listino.php");
        exit();
    }
    $_GET['id'] = $_COOKIE['auto_details_id'];
}

setcookie('auto_details_id', $_GET['id'], time() + 3600, '/');

try {
    $connessione = new DBConnection();
    $dettagli = $connessione->getVehicleDetails($_GET['id']);
    $connessione->closeConnection();

    if ($dettagli != -1) {
        $immagini = "";
        $fotos = explode(separator: "+", string: $dettagli['foto']); // Divide la stringa in un array di nomi di foto
        $alts = explode(separator:'+', string: $dettagli['alts']); // Divide la stringa in un array di alt

        // Itera sull'array dei nomi di foto
        foreach ($fotos as $foto) {
            // Genera il codice HTML per ogni immagine
            $immagini .= '<img src="assets/img/Cars/' . str_replace(' ', '%20', htmlspecialchars(string: $dettagli['marca'])) . '/' . str_replace(' ', '%20', htmlspecialchars(string: $foto)) . '" 
            alt="' . htmlspecialchars(string: $alts[array_search(needle: $foto, haystack: $fotos)]) . '">';
        }

        $stringaDettagli = '
        <h2>Dettagli</h2>
        <dl>
            <div>
                <dt>Anno</dt>
                <dd>' . $dettagli['anno'] . '</dd>
            </div>
            <div>
                <dt>Chilometraggio</dt>
                <dd>' . $dettagli['chilometraggio'] . ' <abbr title="chilometri">km</abbr></dd>
            </div>
            <div>
                <dt>Colore</dt>
                <dd>' . $dettagli['colore'] . '</dd>
            </div>
            <div>
                <dt>Alimentazione</dt>
                <dd>' . $dettagli['alimentazione'] . '</dd>
            </div>
            <div>
                <dt>Cambio</dt>
                <dd>' . $dettagli['cambio'] . '</dd>
            </div>
            <div>
                <dt>Trazione</dt>
                <dd>' . $dettagli['trazione'] . '</dd>
            </div>
            <div>
                <dt>Potenza</dt>
                <dd>' . $dettagli['potenza'] . ' <abbr title="cavalli vapore">CV</abbr></dd>
            </div>
            <div>
                <dt>Peso</dt>
                <dd>' . $dettagli['peso'] . ' <abbr title="chili">kg</abbr></dd>
            </div>
            <div>
                <dt>Neopatentati abilitati</dt>
                <dd>' . (($dettagli['neopatentati']==1)?'Sì':'No') . '</dd>
            </div>
            <div>
                <dt>Posti</dt>
                <dd>' . $dettagli['numeroPosti'] . '</dd>
            </div>
        </dl>';

        $stringaBottoni = '
        <dl>
            <dt>Marca</dt>
            <dd>' . $dettagli['marca'] . '</dd>
            <dt>Modello</dt>
            <dd>' . $dettagli['modello'] . '</dd>
            <dt>Condizioni</dt>
            <dd>' . (($dettagli['condizione']=="KM 0") ? "<abbr title='chilometro zero'>KM 0</abbr>" : $dettagli['condizione']) . '</dd>
            <dt>Prezzo</dt>
            <dd><abbr title="Euro">&euro;</abbr> ' . $dettagli['prezzo'] . '</dd>
        </dl>

        <a class="list_button" href="test_drive.php#test_drive_prenota">Prenota un test drive</a>';

    } else {
        $immagini = "<img src=\"assets/img/Content/auto-non-trovata.webp\" alt=\"Auto ricoperta di schiuma\">";
        $stringaDettagli = "
            <h2>Qualcuno potrebbe aver portato il veicolo all'autolavaggio</h2>
            <h3>Non riusciamo a trovare i dettagli del veicolo specificato</h3>
            <p>Il veicolo che stai cercando non è disponibile nel nostro concessionario in questo momento.
            Puoi riprovare più tardi oppure <a href='listino.php'>tornare al nostro listino</a>.</p>
            ";
        $stringaBottoni = "";
    }

    $autoHTML = str_replace(search: "[immagini_auto]", replace: $immagini, subject: $autoHTML);
    $autoHTML = str_replace(search: "[dettagli_auto]", replace: $stringaDettagli, subject: $autoHTML);
    echo str_replace(search: "[bottoni_auto]", replace: $stringaBottoni, subject: $autoHTML);
} catch(Exception){
    header(header: "location: 500.html");
    exit();
}

?>