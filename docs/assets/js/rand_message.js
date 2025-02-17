document.addEventListener("DOMContentLoaded", function () {
    const messages = [
        [[""],["Navigatore satellitare con percorso impostato"],["Oh, hai sbagliato strada?"],["usa il navigatore"]],
        [["-1"],["Safety car in pista"],["Ehi! Sei fuori pista!"],["chiama la <span lang='en-GB'>safety car</span>"]],
        [["-2"],["Auto in strada con molta nebbia"],["Nebbia fitta all'orizzonte!"],["accendi i fari antinebbia"]],
        [["-3"],["Strada transennata da un cantiere"],["Strada chiusa per lavori in corso."],["trova un percorso alternativo"]],
        [["-4"],["Auto con pneumatico forato caricata sul carro attrezzi"],["Hai forato!"],["chiama il carro attrezzi"]],
        [["-5"],["Bandiera nera di squalifica sventolata in una gara automobilistica"],["Bandiera nera!"],["fermati ai <span lang='en-GB'>box</span>"]],
        [["-6"],["Strada interrotta da un muro con il dipinto della strada stessa"],["Strada interrotta!"],["fai inversione"]]
    ];
    // Scegli un messaggio casualmente
    const randomMessage = messages[Math.floor(Math.random() * messages.length)];
    // Mostra il messaggio nella pagina
    document.getElementById('404_message').innerHTML = 
    "<img src='assets/img/Content/error404" + randomMessage[0] + ".webp' height=260em width=260em alt='" + randomMessage[1] + "'>\
    <h1>" + randomMessage[2] + "</h1>\
    <h2>La pagina che stai cercando non esiste.</h2>\
    <p>Ci dispiace, non riusciamo a trovare la risorsa richiesta nel nostro sito. Assicurati di aver inserito l'indirizzo corretto.\
    Se il problema persiste <a href='about.html#aboutUs_reachUs'>non esitare a contattarci</a>; altrimenti, \
    <a href='/'>" + randomMessage[3] + " e torna alla <span lang='en-GB'>home</span></a>.</p>\
    <p>Grazie per la comprensione!</p>";
});