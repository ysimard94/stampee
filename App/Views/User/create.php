{{include('header.php')}}
<main>
    <form action="{{ path }}User/store" method="post" class="createform">
            <h1>Devenir membre</h1>
            <span class="error">{{ errors|raw }}</span>
            <label>Nom d'utilisateur 
                <br>
                <input type="text" name="username" value="{{ user.username }}">
            </label>
            <label>Courriel 
                <br>
                <input type="text" name="email" value="{{ user.email }}">
            </label>
            <label>Mot de passe
                <br>
                <input type="password" name="password">
            </label>
            <label>Genre
                <br>
                <input type="text" name="gender" value="{{ user.gender }}">
            </label>
            <label>Date de naissance
                <br>
                <input type="date" name="birthday" value="{{ user.birthday }}">
            </label>
            <label>Pays
                <br>
                <input type="text" name="country" value="{{ user.country }}">
            </label>
            <label>Ville
                <br>
                <input type="text" name="city" value="{{ user.city }}">
            </label>
            <label>Adresse
                <br>
                <input type="text" name="address" value="{{ user.address }}">
            </label>
            <label>Code Postal
                <br>
                <input type="text" name="postalcode" value="{{ user.postalcode }}">
            </label>
            <br>
            <input type="submit" value="Enregistrer" class="submit">
        </form>
    </main>
</body>
{{include('footer.php')}}
</html>