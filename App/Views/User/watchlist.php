{{include('header.php')}}
<main>
    <section class="auction-container">
        <table class="auction-table">
            <h1>Liste d'enchères suivies</h1>
            {% if auctions|length > 0 %}
            <thead>
                <th>Titre</th>
                <th>Prix</th>
            </thead>
                <tbody>
                    {% for auction in auctions %}
                        <tr>
                            {% for stamp in auction %}
                                <td><a href="{{ path }}Auction/show/{{ stamp.id }}">{{ stamp.title }}</a></td>
                                <td>£ {{ stamp.current_price }}</td>
                                <td>
                                    <form action="{{ path }}User/unfollow" method="post">
                                        <input type="hidden" value="{{ stamp.id }}" name="auction_id">
                                        <input type="hidden" value="{{ session.id }}" name="user_id">
                                        <button type="submit">Ne plus suivre</button>
                                    </form>
                                </td>
                            {% endfor %}
                        </tr>
                    {% endfor %}
                </tbody>
            {% else %}
                <p>Vous ne suivez aucune enchère.</p>
            {% endif %}
        </table>
    </section>
</main>
{{include('footer.php')}}