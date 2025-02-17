/* Se hai bisogno di aggiungere qualcosa, segui le indicazioni sotto. */
create table Veicolo
(
    id             int auto_increment
        primary key,
    marca          varchar(32) not null,
    modello        varchar(30) not null,
    condizione     varchar(30) null,
    prezzo         double      null,
    anno           int         not null,
    chilometraggio int         null,
    colore         varchar(30) not null,
    alimentazione  varchar(30) null,
    cambio         varchar(30) null,
    trazione       varchar(30) null,
    potenza        int         null,
    peso           int         null,
    neopatentati   int         null,
    numeroPosti    int         null,
    foto           varchar(255) null,
    alts           text        null
);

create table Utente
(
    username    varchar(30)  not null
        primary key,
    password    varchar(255) not null,
    nome        varchar(30)  not null,
    cognome     varchar(30)  not null,
    dataNascita date         not null
);

create table Prenotazione
(
    codice   int auto_increment
        primary key,
    username varchar(30) not null,
    idAuto   int         not null,
    dataOra  datetime    not null,
    stato    int         not null,
    constraint Prenotazione_Veicolo_id_fk
        foreign key (idAuto) references Veicolo (id),
    constraint Prenotazione_Utente_username_fk
        foreign key (username) references Utente (username)
);


/*
INSERIMENTO UTENTI BASE
*/
INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES ("user", "$2y$10$1dHGE98yho9p0CmQifWsROlgG/eScdJhIQhiwx9gqHBUz5hPHCYJ6", "user", "user", "2025-01-01");
INSERT INTO Utente (username, password, nome, cognome, dataNascita) VALUES ("admin", "$2y$10$lWpeMfosLTT14Ex827SfKOk0E22zml9vuvqcH0BpICKB6r1qUwwnS", "admin", "admin", "2025-01-01");

/*
    TABELLA Veicolo:

                                    ### LINEE GUIDA: ###
    marca: per esteso; se necessario sigla e nome, es. "DM - Digital Motion", sempre con questo formato. Inoltre deve essere uguale a come è scritto nel folder img/Cars/
    modello: stringa, sempre con la maiuscola iniziale
    condizione: solo "Nuovo", "Usato" o "KM 0"
    prezzo: double, no apostrofi o altre cose strane
    anno: int
    chilometraggio: int
    colore: stringa a piacere ma non mettere cose troppo complesse come "Blu metallizzato fiordaliso", meglio "Blu chiaro", sempre con la maiuscola iniziale
    alimentazione: solo "Benzina", "Gasolio", "Elettrico", "Metano" o "Ibrido"
    cambio: solo "Manuale" o "Automatico"
    trazione: solo "Anteriore", "Posteriore" o "Integrale"
    potenza: int
    peso: int
    neopatentati: 0=non abilitati, 1=abilitati
    numeroPosti: int
    foto: nome del file immagine, se ce ne sono più di una separare con "+", es. "mudol.jpeg+mudol-interni.jpeg"; ATTENZIONE: in listino la copertina è sempre la prima foto

    Attenzione alle maiuscole ed agli spazi nelle stringhe.

    ESEMPIO DI INSERIMENTO DI UN VEICOLO:
    INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, foto)
    VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.jpeg+mudol-interni.jpeg');
*/

/* UniPD */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'BotanicOrt', 'KM 0', 28000, 2022, 0, 'Grigio', 'Ibrido', 'Automatico', 'Anteriore', 160, 1400, 0, 5, 
    'botanicort.webp+botanicort-interni.webp', 
    "Auto berlina grigia metallizzata, quattro porte, design elegante e moderno+
    Interni di lusso con sedili in pelle marrone, finiture in legno e schermo di infotainment");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'Planetary', 'Nuovo', 38500, 2024, 0, 'Blu chiaro', 'Ibrido', 'Automatico', 'Anteriore', 150, 1705, 0, 8, 
    'planetary.webp+planetary-interni.webp', 
    "Auto monovolume moderna elegante blu brillante, cinque porte, grandi finestrini, fari a LED+
    Interni beige in pelle, cruscotto in legno, touchscreen grande e tetto panoramico");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('UniPD - Universal Premium Design', 'Scrovenger', 'Nuovo', 42000, 2024, 0, 'Nero', 'Ibrido', 'Automatico', 'Integrale', 180, 1850, 0, 5, 
    'scrovenger.webp+scrovenger-interni.webp', 
    "Station wagon nera, elegante con linee affilate, grandi ruote in lega, vetri oscurati+
    Sedili in pelle beige, console e cruscotto marroni, schermo touchscreen e tetto panoramico");

/* EXFiat */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Panda Limo', 'Usato', 18000, 2006, 190000, 'Rosso', 'Benzina', 'Manuale', 'Integrale', 47, 1960, 1, 3, 
    'panda-limo-1.webp+panda-limo-2.webp+panda-limo-interni.webp',
    "Auto limousine rossa, due porte, design inusuale e squadrato+
    Auto limousine rossa, due porte, vari finestrini sulla fiancata destra+
    Interni in velluto rosso, spazi ampi, design retrò");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Due Cavalli', 'Usato', 15000, 2024, 12000, 'Verde', 'Metano', 'Manuale', 'Anteriore', 2, 500, 1, 4, 
    'due-cavalli.webp',
    "Carrozza tradizionale, colore verde scuro con ruote rosse, sedili neri");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('EXFiat - EXcellence Fiat', 'Nove Renne', 'Usato', 0, 1823, 1320000000, 'Rosso', 'Metano', 'Manuale', 'Anteriore', 1000000, 800, 0, 1, 
    'nove-renne.webp',
    "Slitta vintage rossa in legno con lati curvilinei, sedile in pelle imbottita, pattini metallici");

/* ESU */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Piövegg', 'Nuovo', 2300000, 2023, 0, 'Nero', 'Gasolio', 'Manuale', 'Posteriore', 1000, 1300, 0, 2, 
    'piövegg-1.webp+piövegg-2.webp+piövegg-interni.webp',
    "Auto sportiva nero opaco, due porte, design aerodinamico, vista posteriore a tre quarti+
    Auto sportiva nera, due porte, linee affilate, fari LED, prese d'aria sul cofano, griglia a maglia+
    Interni lussuosi con sedili in pelle nera, cruscotto nero, schermo touchscreen");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Muriald', 'KM 0', 1200000, 2020, 0, 'Verde chiaro', 'Benzina', 'Automatico', 'Integrale', 850, 1400, 0, 2, 
    'muriald.webp+muriald-interni.webp',
    "Auto sportiva verde brillante, due porte, design aerodinamico e aggressivo, fari angolari moderni+
    Interni di lusso con sedili in pelle verde, cruscotto digitale e volante coordinato");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('ESU - European Sports Unlimited', 'Belzuny', 'Nuovo', 56600, 2024, 0, 'Arancione', 'Gasolio', 'Automatico', 'Integrale', 450, 2200, 0, 5, 
    'belzuny.webp+belzuny-interni.webp',
    "Auto SUV arancione brillante, quattro porte, design grintoso, fari LED moderni, griglia prominente+
    Interni lussuosi, sedili in pelle nera, inserti arancioni, grande schermo touchscreen");

/* DM */
INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('DM - Digital Motion', 'Archimedial', 'KM 0', 17000, 2022, 0, 'Bianco', 'Elettrico', 'Automatico', 'Anteriore', 95, 1200, 1, 5, 
    'archimedial.webp+archimedial-interni.webp',
    "City car bianca, design moderno e futuristico, quattro porte, tetto nero, fari angolari a LED+
    Interni eleganti e moderni, sedili in similpelle, cruscotto spazioso, ampio touchscreen");

INSERT INTO Veicolo (marca, modello, condizione, prezzo, anno, chilometraggio, colore, alimentazione, cambio, trazione, potenza, peso, neopatentati, numeroPosti, 
    foto, alts)
VALUES ('DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 
    'mudol.webp+mudol-interni.webp',
    "Auto berlina blu chiaro metallizzata, quattro porte, design elegante e lineare, fari affilati+
    Sedili in similpelle, cruscotto digitale, ampio schermo, striscia LED soffusa, design lussuoso");

/* ? */











/*
    TABELLA Utente:

                                    ### LINEE GUIDA: ###
    username: stringa, non più lunga di 30 caratteri
    password: stringa, non più lunga di 255 caratteri
    nome: stringa, non più lunga di 30 caratteri
    cognome: stringa, non più lunga di 30 caratteri
    dataNascita: data, formato "YYYY-MM-DD"

    ESEMPIO DI INSERIMENTO DI UN UTENTE:
    INSERT INTO Utente (username, password, nome, cognome, dataNascita)
    VALUES ('mario.rossi', 'password', 'Mario', 'Rossi', '1990-01-01');
*/








/*
    TABELLA Prenotazione:

                                    ### LINEE GUIDA: ###
    username: stringa, non più lunga di 30 caratteri
    idAuto: int, corrispondente all'id del veicolo
    dataOra: data e ora, formato "YYYY-MM-DD HH:MM:SS"
    stato: 0=pendente, 1=confermata, -1=rifiutata

    ESEMPIO DI INSERIMENTO DI UNA PRENOTAZIONE:
    INSERT INTO Prenotazione (username, idAuto, dataOra, stato)
    VALUES ('mario.rossi', 1, '2024-01-01 12:00:00', 0);
*/

INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES ('user', 1, '2025-01-10 12:00:00', 0);
INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES ('user', 4, '2025-12-06 17:00:00', 0);
INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES ('user', 2, '2025-03-09 14:00:00', 0);
INSERT INTO Prenotazione (username, idAuto, dataOra, stato) VALUES ('user', 6, '2025-06-01 10:00:00', 0);