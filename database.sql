-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 12, 2024 alle 11:45
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seidita_sara`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `blog`
--

CREATE TABLE `blog` (
  `ID_blog` int(10) UNSIGNED NOT NULL,
  `titolo_blog` varchar(255) DEFAULT NULL,
  `descrizione_blog` varchar(255) DEFAULT NULL,
  `data_blog` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `autore_blog` int(10) UNSIGNED NOT NULL,
  `categoria_blog` int(10) UNSIGNED NOT NULL,
  `sottocategoria_blog` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `blog`
--

INSERT INTO `blog` (`ID_blog`, `titolo_blog`, `descrizione_blog`, `data_blog`, `autore_blog`, `categoria_blog`, `sottocategoria_blog`) VALUES
(24, 'primo blog di rosmerade', 'Questo è il mio primo blog', '2024-05-29 13:15:51', 36, 15, 26),
(27, 'ricette', 'Blog di ricette di Sara', '2024-05-29 13:40:25', 38, 19, 29),
(29, 'secondo blog di rosmerade', 'Rosmerade il mio secondo blog', '2024-05-31 07:37:43', 36, 16, 30),
(31, 'signore degli anelli', 'Blog per postare contenuti sul Signore degli Anelli', '2024-06-04 16:01:35', 40, 23, 31),
(35, 'titolo 1', 'Blog uno', '2024-06-05 08:18:35', 41, 15, 26),
(37, 'videogiochi preferiti', 'Blog sui miei videogiochi preferiti', '2024-06-06 08:25:57', 37, 23, 34),
(38, 'blog numero due di mimesi', 'Questo è il mio secondo blog', '2024-06-11 09:31:13', 37, 15, 24),
(39, 'prova blog numero 3', 'Questo è il mio terzo blog', '2024-06-11 09:31:35', 37, 15, 26),
(40, 'blog 4', 'blog 4', '2024-06-11 09:31:47', 37, 15, 24),
(42, 'blog2', 'blog2', '2024-06-11 09:32:55', 38, 25, 23),
(43, 'blog3', 'blog3', '2024-06-11 09:33:13', 38, 25, 23),
(44, 'blog4', 'blog4', '2024-06-11 09:33:28', 38, 15, 26),
(45, 'blog5', 'Ultimo blog ', '2024-06-11 09:33:48', 38, 15, 26);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `ID_categoria` int(10) UNSIGNED NOT NULL,
  `nome_categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`ID_categoria`, `nome_categoria`) VALUES
(1, 'animale'),
(2, 'Prova'),
(3, 'test'),
(4, 'Testprova'),
(5, 'BlogPadre'),
(6, 'Provatre'),
(7, 'provaquattro'),
(8, 'Provacinque'),
(9, 'provac'),
(10, 'Cinque'),
(11, 'CatProva'),
(12, 'Senza categoria'),
(13, 'Luoghi'),
(14, 'Ultimo'),
(15, 'Generico'),
(16, 'Generale'),
(17, 'Alfabeto'),
(18, 'Natura'),
(19, 'Cucina'),
(20, 'Cinema e tv'),
(21, 'sddsasaddsda'),
(22, 'Cinema'),
(23, 'Intrattenimento'),
(24, 'Generico e vario'),
(25, 'blog');

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `ID_commento` int(10) UNSIGNED NOT NULL,
  `testo_commento` text NOT NULL,
  `data_commento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `post_commento` int(10) UNSIGNED NOT NULL,
  `utente_commento` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`ID_commento`, `testo_commento`, `data_commento`, `post_commento`, `utente_commento`) VALUES
(1, 'Bel post!', '2024-05-29 13:21:54', 32, 37),
(5, 'Ciao!', '2024-05-29 15:46:12', 32, 37),
(6, '', '2024-05-29 15:46:43', 35, 37),
(7, 'Prova', '2024-05-29 16:00:50', 32, 36),
(8, 'Bello!', '2024-05-31 07:44:54', 35, 37),
(9, 'Mi piace questo post', '2024-06-04 16:03:24', 32, 40),
(12, 'cff', '2024-06-05 08:03:09', 32, 41),
(16, 'dd', '2024-06-05 08:17:14', 32, 41),
(19, 'Nuovo commento', '2024-06-06 07:49:00', 32, 37),
(20, 'Bellissimo', '2024-06-11 10:05:54', 32, 38);

-- --------------------------------------------------------

--
-- Struttura della tabella `co_autore`
--

CREATE TABLE `co_autore` (
  `ID_CoAutore` int(10) UNSIGNED NOT NULL,
  `blog_coautore` int(10) UNSIGNED NOT NULL,
  `utente_coautore` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `co_autore`
--

INSERT INTO `co_autore` (`ID_CoAutore`, `blog_coautore`, `utente_coautore`) VALUES
(3, 24, 37),
(8, 35, 38);

-- --------------------------------------------------------

--
-- Struttura della tabella `feedback`
--

CREATE TABLE `feedback` (
  `ID_feedback` int(10) UNSIGNED NOT NULL,
  `post_feedback` int(10) UNSIGNED NOT NULL,
  `utente_feedback` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `feedback`
--

INSERT INTO `feedback` (`ID_feedback`, `post_feedback`, `utente_feedback`) VALUES
(8, 32, 40),
(5, 35, 37);

--
-- Trigger `feedback`
--
DELIMITER $$
CREATE TRIGGER `deleteLikeCounter` AFTER DELETE ON `feedback` FOR EACH ROW update post set conteggio_like_post = COALESCE(conteggio_like_post, 0) - 1
where OLD.post_feedback = post.ID_post
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateLikeCounter` AFTER INSERT ON `feedback` FOR EACH ROW update post set conteggio_like_post = COALESCE(conteggio_like_post, 0) + 1
where NEW.post_feedback = post.ID_post
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `ID_post` int(10) UNSIGNED NOT NULL,
  `titolo_post` varchar(255) DEFAULT NULL,
  `testo_post` text NOT NULL,
  `data_post` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `autore_post` int(10) UNSIGNED NOT NULL,
  `blog_post` int(10) UNSIGNED NOT NULL,
  `conteggio_like_post` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`ID_post`, `titolo_post`, `testo_post`, `data_post`, `autore_post`, `blog_post`, `conteggio_like_post`) VALUES
(32, 'Primo post', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-06-06 07:48:54', 36, 24, 1),
(35, 'Torta di riso', 'Torta di riso Massese della monella , anche se sarebbe più corretto della nonna, finalmente dopo numerosi tentativi tutti fallimentari sono riuscita a preparare la mitica torta di riso che da noi viene preparata per Pasqua e per il 24 Maggio in cui festeggiamo la Madonna dei Quercioli. Una torta cremosa ,il vanto delle nonne io da bambina ero incantata dalla preparazione un rito, la cottura avveniva nel forno del panaio che per quel giorno era acceso solo per le torte del paese . Ognuno ha la sua ricetta e i suoi trucchi ,a chi piace con più riso con più crema, e tutti fanno la più buona torta di riso,ci sono gare assaggiatori ufficiali questa è la mia che finalmente soddisfa i nostri palati grazie ai consigli del nostro caro amico Giuseppe che ringrazio ogni anno.', '2024-05-29 15:46:46', 38, 27, 1),
(38, 'Prologo parte uno', 'Tutto ebbe inizio con la forgiatura dei grandi Anelli, tre furono dati agli elfi, gli esseri immortali più saggi e leali di tutti, sette ai re dei nani, grandi minatori e costruttori di città nelle montagne, e nove, nove Anelli furono dati alla razza degli uomini, che più di qualunque cosa desiderano il potere... perchè in qusti anelli erano sigillati la forza e la volontà di governare tutte le razze. Ma tutti loro furono ingannati, perché venne creato un altro anello... Nella terra di Mordor, tra le fiamme del Monte Fato, Sauron, l\'Oscuro Signore, forgiò in segreto un Anello sovrano, per controllare tutti gli altri.\r\nE in quest\'anello riversò la sua crudeltà, la sua malvagità e la sua volontà di dominare ogni forma di vità.', '2024-06-04 16:02:32', 40, 31, 0),
(42, 'Primo post', 'dvdfvfdvdfvfdvdfvdfvf', '2024-06-11 10:06:13', 38, 42, 0),
(43, 'Secondo post', 'Prova', '2024-06-11 10:13:41', 38, 42, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `premium`
--

CREATE TABLE `premium` (
  `ID_premium` int(10) UNSIGNED NOT NULL,
  `utente_premium` int(10) UNSIGNED NOT NULL,
  `data_inizio_premium` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_fine_premium` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `premium`
--

INSERT INTO `premium` (`ID_premium`, `utente_premium`, `data_inizio_premium`, `data_fine_premium`) VALUES
(11, 37, '2024-05-28 22:00:00', '2024-06-28 22:00:00'),
(13, 36, '2024-05-29 14:01:55', '2024-06-29 14:01:55'),
(14, 41, '2024-06-05 08:21:38', '2024-07-05 08:21:38');

-- --------------------------------------------------------

--
-- Struttura della tabella `sottocategoria`
--

CREATE TABLE `sottocategoria` (
  `ID_sottocategoria` int(10) UNSIGNED NOT NULL,
  `categoria_padre` int(10) UNSIGNED NOT NULL,
  `nome_sottocategoria` varchar(255) NOT NULL,
  `categoria_figlio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sottocategoria`
--

INSERT INTO `sottocategoria` (`ID_sottocategoria`, `categoria_padre`, `nome_sottocategoria`, `categoria_figlio`) VALUES
(1, 1, 'cane', 0),
(3, 2, 'Prova', 2),
(11, 4, 'testprova', 4),
(12, 6, 'provatredue', 6),
(13, 7, 'provaquattro', 7),
(14, 8, 'provacinque', 8),
(15, 9, 'provac', 9),
(17, 11, 'sottocatprova', 11),
(18, 12, 'nosottocategoria', 12),
(19, 1, 'gatto', 1),
(21, 13, 'Casa', 13),
(22, 14, 'Blog', 14),
(23, 15, 'Generico', 15),
(24, 15, 'Varie', 15),
(25, 17, 'ABC', 17),
(26, 15, 'Vario', 15),
(27, 18, 'Fiori', 18),
(28, 2, 'Sottoprova', 2),
(29, 19, 'Ricette', 19),
(30, 16, 'Aforismi', 16),
(31, 20, 'Film', 20),
(32, 21, 'sd', 21),
(34, 23, 'Videogiochi', 23);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `ID_utente` int(10) UNSIGNED NOT NULL,
  `username_utente` varchar(255) NOT NULL,
  `email_utente` varchar(255) NOT NULL,
  `pw_utente` varchar(255) NOT NULL,
  `tipo_utente` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`ID_utente`, `username_utente`, `email_utente`, `pw_utente`, `tipo_utente`) VALUES
(36, 'Rosmerade2', 'Rosmerade@email.it', 'b0fcaee53085d1b573832e4755b7d068', 'Premium'),
(37, 'Mimesi', 'Mimesi@email.it', '27a8bfa0407d6ef41b649c9dc2f2e16c', 'Premium'),
(38, 'Sara', 'SaraSix@email.it', '25d55ad283aa400af464c76d713c07ad', 'Semplice'),
(39, 'Sara2', 'sara2@studenti.it', '25d55ad283aa400af464c76d713c07ad', 'Semplice'),
(40, 'SaraSix', 'SaraSixArt@gmail.com', '27a8bfa0407d6ef41b649c9dc2f2e16c', 'Semplice'),
(41, 'Barbara', 'Barbara@uni.it', '25d55ad283aa400af464c76d713c07ad', 'Premium'),
(42, 'NuovoUtente', 'UtenteNuovo@gmail.it', '25d55ad283aa400af464c76d713c07ad', 'Semplice');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`ID_blog`),
  ADD KEY `utente` (`autore_blog`),
  ADD KEY `categoria` (`categoria_blog`),
  ADD KEY `sottocategoria` (`sottocategoria_blog`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_categoria`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`ID_commento`),
  ADD KEY `post` (`post_commento`),
  ADD KEY `utente2` (`utente_commento`);

--
-- Indici per le tabelle `co_autore`
--
ALTER TABLE `co_autore`
  ADD PRIMARY KEY (`ID_CoAutore`),
  ADD KEY `blog-coautore` (`blog_coautore`),
  ADD KEY `utente-coautore` (`utente_coautore`);

--
-- Indici per le tabelle `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID_feedback`),
  ADD UNIQUE KEY `post_feedback` (`post_feedback`,`utente_feedback`),
  ADD UNIQUE KEY `const_feed` (`utente_feedback`,`post_feedback`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `autore post` (`autore_post`),
  ADD KEY `blog` (`blog_post`);

--
-- Indici per le tabelle `premium`
--
ALTER TABLE `premium`
  ADD PRIMARY KEY (`ID_premium`),
  ADD UNIQUE KEY `const_premium` (`utente_premium`);

--
-- Indici per le tabelle `sottocategoria`
--
ALTER TABLE `sottocategoria`
  ADD PRIMARY KEY (`ID_sottocategoria`),
  ADD KEY `categoria padre` (`categoria_padre`),
  ADD KEY `categoria figlio` (`categoria_figlio`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`ID_utente`),
  ADD UNIQUE KEY `username_utente` (`username_utente`),
  ADD UNIQUE KEY `email_utente` (`email_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blog`
--
ALTER TABLE `blog`
  MODIFY `ID_blog` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_categoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `ID_commento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `co_autore`
--
ALTER TABLE `co_autore`
  MODIFY `ID_CoAutore` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID_feedback` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `ID_post` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `premium`
--
ALTER TABLE `premium`
  MODIFY `ID_premium` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `sottocategoria`
--
ALTER TABLE `sottocategoria`
  MODIFY `ID_sottocategoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `ID_utente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria_blog`) REFERENCES `categoria` (`ID_categoria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sottocategoria` FOREIGN KEY (`sottocategoria_blog`) REFERENCES `sottocategoria` (`ID_sottocategoria`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utente` FOREIGN KEY (`autore_blog`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `post` FOREIGN KEY (`post_commento`) REFERENCES `post` (`ID_post`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utente2` FOREIGN KEY (`utente_commento`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `co_autore`
--
ALTER TABLE `co_autore`
  ADD CONSTRAINT `blog-coautore` FOREIGN KEY (`blog_coautore`) REFERENCES `blog` (`ID_blog`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `utente-coautore` FOREIGN KEY (`utente_coautore`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `post feedback` FOREIGN KEY (`post_feedback`) REFERENCES `post` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utente feedback` FOREIGN KEY (`utente_feedback`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `autore post` FOREIGN KEY (`autore_post`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blog` FOREIGN KEY (`blog_post`) REFERENCES `blog` (`ID_blog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `premium`
--
ALTER TABLE `premium`
  ADD CONSTRAINT `utente premium` FOREIGN KEY (`utente_premium`) REFERENCES `utente` (`ID_utente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sottocategoria`
--
ALTER TABLE `sottocategoria`
  ADD CONSTRAINT `categoria figlio` FOREIGN KEY (`categoria_figlio`) REFERENCES `categoria` (`ID_categoria`),
  ADD CONSTRAINT `categoria padre` FOREIGN KEY (`categoria_padre`) REFERENCES `categoria` (`ID_categoria`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
