-- 1. Creazione del Database
CREATE DATABASE IF NOT EXISTS banca;
USE banca;

-- 2. Tabella UTENTE
-- Contiene i dati personali dei clienti e le credenziali di accesso.
CREATE TABLE IF NOT EXISTS utente (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Ospedita l'hash della password (password_hash)
    username VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    secondName VARCHAR(100) DEFAULT NULL,
    surname VARCHAR(100) NOT NULL,
    birth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,     -- Valori previsti nel form: 'M', 'F', 'Altro', 'ND'
    phone VARCHAR(20) DEFAULT NULL,
    role VARCHAR(20) DEFAULT 'user'  -- Gestisce i permessi (es. 'admin' controllato nell'header)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabella CONTO_BANCARIO
-- Associa i conti correnti ai rispettivi utenti.
CREATE TABLE IF NOT EXISTS conto_bancario (
    id_conto INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    titolo VARCHAR(100) NOT NULL,     -- Es. "Risparmio"
    iban VARCHAR(34) NOT NULL UNIQUE, -- Lunghezza massima standard IBAN
    saldo DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
    valuta VARCHAR(3) DEFAULT 'EUR',  -- Richiesto in card-conto.php
    FOREIGN KEY (id_utente) REFERENCES utente(id_utente) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabella USER_TOKENS
-- Tabella di supporto per la funzionalità "Ricordami" (Remember Me) tramite cookie.
CREATE TABLE IF NOT EXISTS user_tokens (
    id_token INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utente) REFERENCES utente(id_utente) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabella MOVIMENTO
-- Registra i flussi finanziari (es. bonifici) utilizzati anche per generare il grafico dell'andamento.
CREATE TABLE IF NOT EXISTS movimento (
    id_movimento INT AUTO_INCREMENT PRIMARY KEY,
    id_conto INT NOT NULL,
    importo DECIMAL(15, 2) NOT NULL,
    iban_destinatario VARCHAR(34) NOT NULL,
    iban_mittente VARCHAR(34) NOT NULL,
    titolo VARCHAR(255) NOT NULL,      -- Corrisponde all'intestazione del beneficiario nel form
    descrizione TEXT,                  -- Corrisponde alla causale
    tipo VARCHAR(10) NOT NULL,         -- 'entrata' o 'uscita' (usato in spese-grafico.php)
    data_movimento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_conto) REFERENCES conto_bancario(id_conto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabella SPESE
-- Utilizzata nella dashboard per mostrare il blocco delle "Ultime 10 transazioni".
CREATE TABLE IF NOT EXISTS spese (
    id_spesa INT AUTO_INCREMENT PRIMARY KEY,
    id_conto INT NOT NULL,
    importo DECIMAL(15, 2) NOT NULL,
    descrizione VARCHAR(255) NOT NULL,
    data_aggiunta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_conto) REFERENCES conto_bancario(id_conto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
