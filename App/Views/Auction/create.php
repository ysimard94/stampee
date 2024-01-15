{{include('header.php')}}
<main>
    <form action="{{ path }}Auction/store" method="post" enctype="multipart/form-data" class="createform">
            <h1>Créer une enchère</h1>
            <span class="error">{{ errors|raw }}</span>
            <label>Prix de départ
                <br>
                <input type="text" name="floor_price" value="{{ user.floor_price }}">
            </label>
            <label>Date de fin
                <br>
                <input type="date" name="date_end" min="{{ mindate }}" value="{{ user.date_end }}">
            </label>
            <label>Titre
                <br>
                <input type="text" name="title" value="{{ user.title }}">
            </label>
            <label>Pays
                <br>
                <input type="text" name="country" value="{{ user.country }}">
            </label>
            <label>Condition
                <br>
                <select name="condition_id">
                    <option value="1">Parfaite</option>
                    <option value="2">Excellente</option>
                    <option value="3">Bonne</option>
                    <option value="4">Moyenne</option>
                    <option value="5">Endommagé</option>
                </select>
            </label>
            <label>Certifié
                <br>
                <select name="certification_id">
                    <option value="1">Oui</option>
                    <option value="2">Non</option>
                </select>
            </label>
            <label>Couleurs
                <br>
                <input type="text" name="colors" value="{{ user.colors }}">
            </label>
            <label>Dimensions
                <br>
                <input type="text" name="dimensions" value="{{ user.dimensions }}">
            </label>
            <label>Date de création
                <br>
                <input type="date" name="creation_date" max="{{ maxdate }}" value="{{ user.creation_date }}">
            </label>
            <label>Images du timbre (formats jpg, png et jpeg)
                <input type="file" name="file[]" multiple>
            </label>
            <br>
            <input type="hidden" name="user_id" value="{{ session.id }}">
            <input type="submit" value="Enregistrer" class="submit">
        </form>
    </main>
</body>
{{include('footer.php')}}
</html>