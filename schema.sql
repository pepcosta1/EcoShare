-- Esquema de database.sqlite (regenerat a partir de les columnes que fa servir el codi)

CREATE TABLE IF NOT EXISTS role (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INTEGER NOT NULL DEFAULT 2,
    FOREIGN KEY (role_id) REFERENCES role(id)
);

CREATE TABLE IF NOT EXISTS vehicles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    marca VARCHAR(50) NOT NULL,
    model VARCHAR(100) NOT NULL,
    categoria VARCHAR(30),
    tipus VARCHAR(50),
    etiqueta VARCHAR(10),
    autonomia_electrica VARCHAR(30),
    maleter VARCHAR(30),
    preu_text VARCHAR(50),
    imatge_url VARCHAR(255),
    detalls_url VARCHAR(255)
);
