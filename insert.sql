-- insert.sql: dades inicials (rols, tipus i vehicles)
-- Els usuaris es creen des de signup.php (així la contrasenya queda amb hash)
-- Per fer admin un usuari: UPDATE user SET role_id = 1 WHERE email = '...';

INSERT INTO role (id, nom) VALUES (1, 'admin');
INSERT INTO role (id, nom) VALUES (2, 'user');

INSERT INTO tipus_vehicle (id, nom) VALUES (1, 'Cotxe');
INSERT INTO tipus_vehicle (id, nom) VALUES (2, 'Moto');
INSERT INTO tipus_vehicle (id, nom) VALUES (3, 'Bicicleta');
INSERT INTO tipus_vehicle (id, nom) VALUES (4, 'Patinet');

INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (1, 'Honda', 'CR-V e:PHEV', 'SUV', 1, 0, 78, 617, 'Des de 52.000 €', 'hondaCRV-e.png', 'https://honda.es');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (2, 'Citroën', 'AMI', 'Micro EV', 1, 0, 75, 63, 'Des de 7.990 €', 'citroenAmi.png', 'https://citroen.es');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (3, 'XEV', 'Yoyo', 'Micro EV', 1, 0, 150, 180, 'Des de 16.900 €', 'xevYoyo.png', 'https://xevcars.es');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (4, 'Cupra', 'Born', 'Compacte', 1, 0, 420, 385, 'Des de 38.000 €', 'cupraBron.png', 'https://cupraofficial.es');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (5, 'Silence', 'S02', 'Scooter Urbà', 2, 0, 133, 47, 'Des de 5.180 €', 'silence.png', 'https://silence.eco');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (6, 'Vespa', 'Elettrica', 'Ciclomotor', 2, 0, 100, 30, 'Des de 6.999 €', 'vespaEletrica.png', 'https://vespa.com');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (7, 'Specialized', 'Turbo Como', 'e-Bike', 3, 'No cal', 120, 0, 'Tarifa per minuts', 'turboComo.png', 'https://specialized.com');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (8, 'Riese & Müller', 'Load 75', 'e-Cargo Bike', 3, 'No cal', 100, 200, 'Tarifa B2B', 'rieseMuller.png', 'https://r-m.de');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (9, 'Xiaomi', 'Electric Scooter 4 Pro', 'e-Scooter', 4, 'No cal', 55, 0, 'Tarifa per minuts', 'XiaomiElectric.png', 'https://mi.com');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (10, 'Segway', 'Ninebot Max G3', 'e-Scooter Fleet', 4, 'No cal', 80, 0, 'Tarifa per minuts', 'segwayNinebot.png', 'https://segway.com');
INSERT INTO vehicles (id, marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url) VALUES (11, 'Renault', 'Kangoo E-Tech', 'Furgoneta', 1, 0, 300, 775, 'Des de 39.000 €', 'renaultKangoo.png', 'https://renault.es');

