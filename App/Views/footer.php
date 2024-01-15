<footer>
     <nav class="footer-nav">
        <h2>Navigation</h2>
        <a href="{{ path }}Home/index">Accueil</a>
         <a href="{{ path }}Auction/index">Enchères</a>
        <a href="">Actualités</a>
        <a href="">À propos</a>
        <a href="">Contactez-nous</a>
     </nav>
     <div class="info">
        <img src="{{ path }}assets/img/logo.png" alt="logo stampee" class="logo">
        <p>24 Cambridge,</p>
        <p>Charing Cross Rd,</p>
        <p>WC2H 8AA,</p>
        <p>Londre,</p>
        <p>Royaume-Uni</p>
        <a href="">+44 20 3077 1189</a>
     </div>
     <nav class="footer-account">
         <h2>Votre compte</h2>
         {% if session %}
            <a href="{{ path }}User/edit">Votre compte</a>
            <a href="{{ path }}Auction/userList">Vos enchères</a>
            <a href="{{ path }}Auction/create">Créer une enchère</a>
            <a href="">Voir votre liste à suivre</a>
            <a href="">Historique d'achats</a>
            <a href="{{ path }}User/logout">Déconnexion</a>
         {% else %}
            <a href="{{ path }}User/login">Connexion</a>
            <a href="{{ path }}User/create">Inscription</a>
         {% endif %}
     </nav>
</footer>