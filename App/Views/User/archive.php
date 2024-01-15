{{include('header.php')}}
<main>
    <section class="auction-container">
        <table class="auction-table">
            <h1>Archive de vos enchères</h1>
            {% if auctions|length > 0 %}
            <thead>
                <th>Titre</th>
                <th>Prix</th>
            </thead>
                <tbody>
                    {% for auction in auctions %}
                        <tr>
                            {% for stamp in auction %}
                                {% if stamp.auction_status_id == 2 %}
                                    <td><a href="{{ path }}Auction/show/{{ stamp.id }}">{{ stamp.title }}</a></td>
                                    <td>£ {{ stamp.current_price }}</td>
                                {% endif %}
                            {% endfor %}
                        </tr>
                    {% endfor %}
                </tbody>
            {% else %}
                <p>Vous n'avez aucune enchère en cours</p>
            {% endif %}
        </table>
    </section>
</main>
{{include('footer.php')}}