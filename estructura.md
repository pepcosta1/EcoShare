ecoshare\_girona/ 
├── config/ 
│ └── db.php                        # Connexió PDO a SQLite (database.sqlite) 
├── includes/ 
│ ├── header.php                    # Capçalera HTML reutilitzable 
│ ├── footer.php                    # Peu de pàgina HTML reutilitzable 
│ ├── session.php                   # Control de sessions i rols 
│ └── functions.php                 # Funcions de seguretat, XSS i cookies 
├── models/ 
│ ├── vehicle.php                   # Consultes SQL per als vehicles (CRUD) 
│ └── user.php                      # Lògica d'autenticació d'usuaris 
├── public/ 
│ ├── index.php                     # Pàgina d'inici (benvinguda) 
│ ├── cataleg.php                   # Catàleg de vehicles i filtres 
│ ├── vehicle\_detail.php           # Detall del vehicle i historial 
│ ├── reserve.php                   # Processament de reserves 
│ ├── meves\_reserves.php           # Llista de reserves de l'usuari 
│ ├── cancel\_reserve.php           # Cancel·lació d'una reserva 
│ ├── login.php                     # Formulari d'inici de sessió 
│ ├── login\_process.php            # Processament del login 
│ ├── signup.php                    # Formulari de registre 
│ ├── signup\_process.php           # Processament del registre 
│ ├── logout.php                    # Tancament de sessió 
│ └── admin/ 
│ ├── vehicles.php                  # Llista de gestió per a administradors 
│ ├── vehicle\_form.php             # Formulari per crear/editar vehicles 
│ └── vehicle\_delete.php           # Processament d'eliminació 
├── assets/ 
│ ├── css/ 
│ │ └── style.css                   # Estils i variables del mode clar/fosc 
│ ├── img/                          # Imatges dels vehicles 
│ └── js/ 
│ └── main.js                       # JavaScript per a la interfície 
├── database.sqlite                 # Base de dades SQLite 
├── schema.sql                      # Creació de les taules 
├── insert.sql                      # Dades inicials (rols, tipus i vehicles) 
└── README.md                       # Documentació del projecte
