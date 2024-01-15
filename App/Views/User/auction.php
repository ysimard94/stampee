{{include('header.php')}}
<main>
    <section class="auction-container">
        <table class="auction-table">
            <h1>Vos enchères en cours</h1>
            {% if auctions|length > 0 %}
            <thead>
                <th>Titre</th>
                <th>Prix</th>
            </thead>
                <tbody>
                    {% for auction in auctions %}
                        {% for stamp in auction %}
                            {% if stamp.auction_status_id != 2 %}
                                {% if stamp.auction_status_id != 3 %}
                                    <tr>
                                        <td><a href="{{ path }}Auction/show/{{ stamp.id }}">{{ stamp.title }}</a></td>
                                        <td>£ {{ stamp.current_price }}</td>
                                        <td><a href="{{ path }}Auction/edit/{{ stamp.id }}">Modifier</a></td>
                                    </tr>
                                {% endif %}
                            {% endif %}
                        {% endfor %}
                    {% endfor %}
                </tbody>
            {% else %}
                <p>Vous n'avez aucune enchère en cours</p>
            {% endif %}
        </table>
    </section>
</main>
{{include('footer.php')}}