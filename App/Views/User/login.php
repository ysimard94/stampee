{{ include('header.php') }}
<body>
    <main>
        <form action="{{ path }}User/auth" method="post" class="createform">
            <h2>Connecter</h2>
            <span class="error">{{ errors|raw }}</span>
            <label>Nom d'utilisateur 
                <input type="text" name="username" value="{{ user.username }}">
            </label>
            <label>Mot de passe
                <input type="password" name="password">
            </label>
            <br>
            <input type="submit" value="Connecter">
        </form>
    </main>
</body>
{{ include('footer.php') }}
</html>