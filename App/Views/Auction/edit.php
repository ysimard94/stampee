{{ include('header.php') }}
<main>
    <form action="{{ path }}Auction/update" method="post" class="createform">
        <h1>Modifier</h1>
        {% for auction in auctions %}
            <input type="hidden" name="id" value="{{ auction.stamp_id }}">
            <span>Enchère : {{ auction.title }}</span>
            <label>Titre
                <br>
                <input type="text" name="title" value="{{ auction.title }}">
            </label>
            <label>Pays
                <br>
                <input type="text" name="country" value="{{ auction.country }}">
            </label>
            <label>Date de création
                <br>
                <input type="date" name="creation_date" value="{{ auction.creation_date }}">
            </label>
            <label>Couleurs
                <br>
                <input type="text" name="colors" value="{{ auction.colors }}">
            </label>
            <label>Dimensions
                <br>
                <input type="text" name="dimensions" value="{{ auction.dimensions }}">
            </label>
            <label>Condition
                <br>
                <select name="condition_id"">
                    <option value="1" {% if auction.condition_id == 1 %} selected="selected"{% endif %}>Parfaite</option>
                    <option value="2" {% if auction.condition_id == 2 %} selected="selected"{% endif %}>Excellente</option>
                    <option value="3" {% if auction.condition_id == 3 %} selected="selected"{% endif %}>Bonne</option>
                    <option value="4" {% if auction.condition_id == 4 %} selected="selected"{% endif %}>Moyenne</option>
                    <option value="5" {% if auction.condition_id == 5 %} selected="selected"{% endif %}>Endommagé</option>
                </select>
            </label>
            <label>Certifié
                <br>
                <select name="certification_id">
                    <option value="1" {% if auction.certification_id == 1 %} selected="selected"{% endif %}>Oui</option>
                    <option value="2" {% if auction.certification_id == 2 %} selected="selected"{% endif %}>Non</option>
                </select>
            </label>
            <input type="submit" value="Modifier" class="submit">
        </form>
        <form action="{{ path }}User/deleteAuction" method="post"class="createform">
            <input type="hidden" name="id" value="{{ auction.stamp_id }}">
            <input type="submit" value="Supprimer" class="submit">
        </form>
        {% endfor %}
    </main>
</body>
{{ include('footer.php') }}
</html>