ecoshare\_girona/ 
├── config/ 
│ └── db.php # Connexió PDO a SQLite (database.sqlite) 
├── includes/ 
│ ├── header.php # Capçalera HTML reutilitzable 
│ ├── footer.php # Peu de pàgina HTML reutilitzable 
│ ├── session.php # Control de sessions i rols 
│ └── functions.php # Funcions de seguretat, XSS i cookies 
├── models/ 
│ ├── vehicle.php # Consultes SQL per als vehicles (CRUD) 
│ └── user.php # Lògica d'autenticació d'usuaris 
├── public/ 
│ ├── index.php # Catàleg principal i filtres 
│ ├── vehicle\_detail.php # Detall del vehicle i historial 
│ ├── reserve.php # Processament de reserves 
│ ├── login.php # Formulari d'inici de sessió 
│ ├── logout.php # Tancament de sessió 
│ └── admin/ 
│ ├── vehicles.php # Llista de gestió per a administradors 
│ ├── vehicle\_form.php # Formulari per crear/editar vehicles 
│ └── vehicle\_delete.php # Processament d'eliminació 
├── assets/ 
│ ├── css/ 
│ │ └── style.css # Estils i variables del mode clar/fosc 
│ └── js/ 
│ └── main.js # JavaScript per a la interfície 
├── database.sqlite # Base de dades SQLite 
└── README.md # Documentació del projecte