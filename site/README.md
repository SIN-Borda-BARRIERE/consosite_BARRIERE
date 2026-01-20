Méthodologie:

    1. Analyse du besoin (cahier des charges)
    2. Organisation des fichiers
    3. Modélisation des données (SQL)
    4. Logique backend (PHP, sur papier)
    5. Logique des règles (dates, droits)
    6. Préparation des pages (PHP + HTML)
    7. Préparation des exports (CSV / PDF)
    8. frontend (CSS)


/////


explication de l'architecture:

    index.php       → point d’entrée
    auth/           → sécurité
    api/            → actions invisibles
    pages/          → pages visibles


/////


carte heuristique du site

    /site/
    │
    │
    ├── /auth/
    │   ├── login.php
    │   ├── logout.php
    │   └── register.php 
    │
    ├── /API/
    │   ├── save_value.php
    │   ├── get_history.php
    │   ├── get_stats.php
    │   ├── update_user.php
    │   ├── export_csv.php
    │   └── export_pdf.php
    │
    ├── /pages/
    │   ├── homepage.php
    │   ├── history.php
    │   └── charts-dashboard.php
    │
    ├── app.js
    │
    ├── database.php
    ├── index.php
    │
    ├── README.md
    ├── energy_tracker.sql
    └── style.css


/////


Cahier des charges:

Page d'accueil : Présentation générale du site et des objectifs (gérer la consommation énergétique).
Formulaire d'ajout de données : Un utilisateur peut entrer les données relatives à sa consommation énergétique (électricité only) pour chaque jour, une fois par jour.
Tableau de bord : Un espace où l'utilisateur peut voir les graphiques de sa consommation sur une période donnée (par exemple, sur une semaine ou un moisvia des boutons. pas de conso negatives.).
Historique des données : L'utilisateur peut consulter l'historique de ses consommations.
Alertes et Conseils : Si la consommation dépasse certains seuils, des alertes sont envoyées, et des conseils d'économie d'énergie sont proposés.
Export des données : L'utilisateur peut télécharger ses données sous format CSV ou PDF.


/////
 à faire:

    history:
        permonth
        suppr
        css
        no form?
        add profile picture
    
    dashboard:
        addapt
        css
        stats
    
    loggin/logout
        css
    
    all + sql
        add profile picture
        csv and pdf export