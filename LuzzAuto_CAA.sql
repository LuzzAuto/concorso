SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `Prenotazione` (
  `codice` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `idAuto` int(11) NOT NULL,
  `dataOra` datetime NOT NULL,
  `stato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Prenotazione` (`codice`, `username`, `idAuto`, `dataOra`, `stato`) VALUES
(1, 'user', 1, '2025-01-10 12:00:00', 0),
(2, 'user', 4, '2025-12-06 17:00:00', 1),
(3, 'user', 2, '2025-03-09 14:00:00', 0),
(4, 'user', 6, '2025-06-01 10:00:00', -1);

CREATE TABLE `Utente` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `dataNascita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Utente` (`username`, `password`, `nome`, `cognome`, `dataNascita`) VALUES
('admin', '$2y$10$lWpeMfosLTT14Ex827SfKOk0E22zml9vuvqcH0BpICKB6r1qUwwnS', 'admin', 'admin', '2025-01-01'),
('user', '$2y$10$1dHGE98yho9p0CmQifWsROlgG/eScdJhIQhiwx9gqHBUz5hPHCYJ6', 'user', 'user', '2025-01-01');

CREATE TABLE `Veicolo` (
  `id` int(11) NOT NULL,
  `marca` varchar(32) NOT NULL,
  `modello` varchar(30) NOT NULL,
  `condizione` varchar(30) DEFAULT NULL,
  `prezzo` double DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `chilometraggio` int(11) DEFAULT NULL,
  `colore` varchar(30) NOT NULL,
  `alimentazione` varchar(30) DEFAULT NULL,
  `cambio` varchar(30) DEFAULT NULL,
  `trazione` varchar(30) DEFAULT NULL,
  `potenza` int(11) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL,
  `neopatentati` int(11) DEFAULT NULL,
  `numeroPosti` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `alts` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Veicolo` (`id`, `marca`, `modello`, `condizione`, `prezzo`, `anno`, `chilometraggio`, `colore`, `alimentazione`, `cambio`, `trazione`, `potenza`, `peso`, `neopatentati`, `numeroPosti`, `foto`, `alts`) VALUES
(1, 'UniPD - Universal Premium Design', 'BotanicOrt', 'KM 0', 28000, 2022, 0, 'Grigio', 'Ibrido', 'Automatico', 'Anteriore', 160, 1400, 0, 5, 'botanicort.webp+botanicort-interni.webp', 'Auto berlina grigia metallizzata, quattro porte, design elegante e moderno+\n    Interni di lusso con sedili in pelle marrone, finiture in legno e schermo di infotainment'),
(2, 'UniPD - Universal Premium Design', 'Planetary', 'Nuovo', 38500, 2024, 0, 'Blu chiaro', 'Ibrido', 'Automatico', 'Anteriore', 150, 1705, 0, 8, 'planetary.webp+planetary-interni.webp', 'Auto monovolume moderna elegante blu brillante, cinque porte, grandi finestrini, fari a LED+\n    Interni beige in pelle, cruscotto in legno, touchscreen grande e tetto panoramico'),
(3, 'UniPD - Universal Premium Design', 'Scrovenger', 'Nuovo', 42000, 2024, 0, 'Nero', 'Ibrido', 'Automatico', 'Integrale', 180, 1850, 0, 5, 'scrovenger.webp+scrovenger-interni.webp', 'Station wagon nera, elegante con linee affilate, grandi ruote in lega, vetri oscurati+\n    Sedili in pelle beige, console e cruscotto marroni, schermo touchscreen e tetto panoramico'),
(4, 'EXFiat - EXcellence Fiat', 'Panda Limo', 'Usato', 18000, 2006, 190000, 'Rosso', 'Benzina', 'Manuale', 'Integrale', 47, 1960, 1, 3, 'panda-limo-1.webp+panda-limo-2.webp+panda-limo-interni.webp', 'Auto limousine rossa, due porte, design inusuale e squadrato+\n    Auto limousine rossa, due porte, vari finestrini sulla fiancata destra+\n    Interni in velluto rosso, spazi ampi, design retrò'),
(5, 'EXFiat - EXcellence Fiat', 'Due Cavalli', 'Usato', 15000, 2024, 12000, 'Verde', 'Metano', 'Manuale', 'Anteriore', 2, 500, 1, 4, 'due-cavalli.webp', 'Carrozza tradizionale, colore verde scuro con ruote rosse, sedili neri'),
(6, 'EXFiat - EXcellence Fiat', 'Nove Renne', 'Usato', 0, 1823, 1320000000, 'Rosso', 'Metano', 'Manuale', 'Anteriore', 1000000, 800, 0, 1, 'nove-renne.webp', 'Slitta vintage rossa in legno con lati curvilinei, sedile in pelle imbottita, pattini metallici'),
(7, 'ESU - European Sports Unlimited', 'Piövegg', 'Nuovo', 2300000, 2023, 0, 'Nero', 'Gasolio', 'Manuale', 'Posteriore', 1000, 1300, 0, 2, 'piövegg-1.webp+piövegg-2.webp+piövegg-interni.webp', 'Auto sportiva nero opaco, due porte, design aerodinamico, vista posteriore a tre quarti+\n    Auto sportiva nera, due porte, linee affilate, fari LED, prese d\'aria sul cofano, griglia a maglia+\n    Interni lussuosi con sedili in pelle nera, cruscotto nero, schermo touchscreen'),
(8, 'ESU - European Sports Unlimited', 'Muriald', 'KM 0', 1200000, 2020, 0, 'Verde chiaro', 'Benzina', 'Automatico', 'Integrale', 850, 1400, 0, 2, 'muriald.webp+muriald-interni.webp', 'Auto sportiva verde brillante, due porte, design aerodinamico e aggressivo, fari angolari moderni+\n    Interni di lusso con sedili in pelle verde, cruscotto digitale e volante coordinato'),
(9, 'ESU - European Sports Unlimited', 'Belzuny', 'Nuovo', 56600, 2024, 0, 'Arancione', 'Gasolio', 'Automatico', 'Integrale', 450, 2200, 0, 5, 'belzuny.webp+belzuny-interni.webp', 'Auto SUV arancione brillante, quattro porte, design grintoso, fari LED moderni, griglia prominente+\n    Interni lussuosi, sedili in pelle nera, inserti arancioni, grande schermo touchscreen'),
(10, 'DM - Digital Motion', 'Archimedial', 'KM 0', 17000, 2022, 0, 'Bianco', 'Elettrico', 'Automatico', 'Anteriore', 95, 1200, 1, 5, 'archimedial.webp+archimedial-interni.webp', 'City car bianca, design moderno e futuristico, quattro porte, tetto nero, fari angolari a LED+\n    Interni eleganti e moderni, sedili in similpelle, cruscotto spazioso, ampio touchscreen'),
(11, 'DM - Digital Motion', 'Mudol', 'Nuovo', 65800, 2024, 0, 'Blu chiaro', 'Elettrico', 'Automatico', 'Integrale', 490, 1765, 0, 5, 'mudol.webp+mudol-interni.webp', 'Auto berlina blu chiaro metallizzata, quattro porte, design elegante e lineare, fari affilati+\n    Sedili in similpelle, cruscotto digitale, ampio schermo, striscia LED soffusa, design lussuoso');


ALTER TABLE `Prenotazione`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `Prenotazione_Veicolo_id_fk` (`idAuto`),
  ADD KEY `Prenotazione_Utente_username_fk` (`username`);

ALTER TABLE `Utente`
  ADD PRIMARY KEY (`username`);

ALTER TABLE `Veicolo`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Prenotazione`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `Veicolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `Prenotazione`
  ADD CONSTRAINT `Prenotazione_Utente_username_fk` FOREIGN KEY (`username`) REFERENCES `Utente` (`username`),
  ADD CONSTRAINT `Prenotazione_Veicolo_id_fk` FOREIGN KEY (`idAuto`) REFERENCES `Veicolo` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
