{{ include('header.php') }}    
<main>
    <form action="{{ path }}User/update" method="post" class="createform">
        <h1>Modifier</h1>
        {% for user in users %}
            <input type="hidden" name="id" value="{{ user.id }}">
            <span>Utilisateur : {{ user.username }}</span>
            <label>Courriel 
                <br>
                <input type="text" name="email" value="{{ user.email }}">
            </label>
            <label>Mot de passe
                <br>
                <input type="password" name="password" value="{{ user.password }}">
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
            <input type="submit" value="Modifier" class="submit">
        </form>
        {% endfor %}
    </main>
</body>
{{ include('footer.php') }}
</html>