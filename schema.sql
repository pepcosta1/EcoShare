-- schema.sql: estructura de la base de dades EcoShare
-- Per crear la BD: sqlite3 database.sqlite < schema.sql

PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS reserva;
DROP TABLE IF EXISTS vehicles;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS tipus_vehicle;
DROP TABLE IF EXISTS role;

PRAGMA foreign_keys = ON;

CREATE TABLE role (
    id INTEGER PRIMARY KEY,
    nom TEXT NOT NULL UNIQUE
);

CREATE TABLE tipus_vehicle (
    id INTEGER PRIMARY KEY,
    nom TEXT NOT NULL UNIQUE
);

CREATE TABLE user (
    id INTEGER PRIMARY KEY,
    nom TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role_id INTEGER NOT NULL,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE vehicles (
    id INTEGER PRIMARY KEY,
    marca TEXT NOT NULL,
    model TEXT NOT NULL,
    categoria TEXT,
    tipus_id INTEGER NOT NULL,
    etiqueta TEXT,
    autonomia_electrica INTEGER,
    maleter INTEGER,
    preu_text TEXT,
    imatge_url TEXT,
    detalls_url TEXT,
    FOREIGN KEY (tipus_id) REFERENCES tipus_vehicle(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Reserves: un usuari reserva un vehicle entre dues dates.
-- Les dates es guarden com a text 'AAAA-MM-DD HH:MM' (format ISO),
-- així es poden comparar directament amb < i > a SQL.
CREATE TABLE reserva (
    id INTEGER PRIMARY KEY,
    user_id INTEGER NOT NULL,
    vehicle_id INTEGER NOT NULL,
    data_inici TEXT NOT NULL,
    data_fi TEXT NOT NULL,
    estat TEXT NOT NULL DEFAULT 'activa',      -- 'activa' o 'cancel·lada'
    creada_el TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE ON UPDATE CASCADE
);
