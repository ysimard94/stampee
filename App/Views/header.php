<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="{{ path }}css/style.css">
    <link rel="stylesheet" href="{{ path }}css/typography.css">
    <link rel="stylesheet" href="{{ path }}css/header.css">
    <link rel="stylesheet" href="{{ path }}css/nav.css">
    <link rel="stylesheet" href="{{ path }}css/hero-banner.css">
    <link rel="stylesheet" href="{{ path }}css/banner.css">
    <link rel="stylesheet" href="{{ path }}css/catalog.css">
    <link rel="stylesheet" href="{{ path }}css/card.css">
    <link rel="stylesheet" href="{{ path }}css/footer.css">
    <link rel="stylesheet" href="{{ path }}css/buttons.css">
    <link rel="stylesheet" href="{{ path }}css/auction.css">
    <link rel="stylesheet" href="{{ path }}css/filter.css">
    <link rel="stylesheet" href="{{ path }}css/createform.css">
    <link rel="stylesheet" href="{{ path }}css/table.css">
    <link rel="stylesheet" href="{{ path }}css/user-auctions.css">

    <script src="{{ path }}script/menu.js"></script>
    <script src="{{ path }}script/filter.js"></script>

    <style> @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400&display=swap'); </style>
</head>
<body>
    <header>

        <a href="{{ path }}Home/index"><img src="{{ path }}assets/img/logo.png" alt="logo stampee" class="logo"></a>
        <div class="header-options">
            <div class="user-login">
                {% if session %}
                <span>Bienvenue {{ session.username }} <span class="user-drpdown-icon">▼</span></span>
                
                <a href="{{ path }}User/logout">Déconnexion</a>
                {% else %}
                <a href="{{ path }}User/login">Connexion</a>
                <span>|</span>
                <a href="{{ path }}User/create">Inscription</a>
                {% endif %}
                {% if session %}
                    <div class="user-menu hide-user-menu">
                        <a href="{{ path }}User/edit">Votre compte</a>
                        <a href="{{ path }}Auction/userList">Vos enchères</a>
                        <a href="{{ path }}User/archive">Archive d'enchères</a>
                        <a href="{{ path }}Auction/create">Créer une enchère</a>
                        <a href="{{ path }}User/watchlist">Voir votre liste à suivre</a>
                    </div>
                {% endif %}
            </div>
            <div class="lang-options">
                <a href="#"><span class="selected">FR</span></a>
                <a href="#"><span>ENG</span></a>
            </div>
        </div>
    </header>
    <nav>
        <img src="{{ path }}assets/img/menu-icon.png" alt="menu icon" class="menu-btn">
        <div class="menu hide">
            <a href="{{ path }}Home/index">ACCUEIL</a>
            <a href="{{ path }}Auction/index">ENCHÈRES</a>
            <a href="">ACTUALITÉS</a>
            <a href="">À PROPOS</a>
            <a href="">CONTACTEZ-NOUS</a>
        </div>
        <form class="search" action="{{ path }}Auction/search" method="post" >
            <label for="search">Search</label>
            <input type="text" class="search-bar" placeholder="Recherche" id="search" name="search">
            <input type="image" src="{{ path }}assets/img/search-icon.png">
        </form>
    </nav>