{{ include('header.php') }}
<main class="flex">
    <aside>
        <div class="list-choice" style="margin-bottom: 15px;">
            <img src="../assets/img/linedlist.png" alt="">
            <img src="../assets/img/gridlist.png" alt="">
        </div>
        <fieldset>
            <legend>PRIX <img src="../assets/img/dropdwnarrow.png" alt=""></legend>
            <div class="price-filters">
                <label for="minimum">Minimum
                    <input type="text" name="minimum" id="minimum" placeholder="$">
                </label>
                <label for="maximum">Maximum
                    <input type="text" name="maximum" id="maximum" placeholder="$">
                </label>
            </div>
        </fieldset>
        <fieldset>
            <legend>CONDITION <img src="../assets/img/dropdwnarrow.png" alt=""></legend>
            <div>
                <label class="container">Parfaite
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Excellente
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Bonne
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Moyenne
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Endommagée
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
        </fieldset>
        <fieldset>
            <legend>PAYS <img src="../assets/img/dropdwnarrow.png" alt="" class="closed-icon"></legend>
        </fieldset>
        <fieldset>
            <legend>CERTIFIÉ <img src="../assets/img/dropdwnarrow.png" alt="" class="closed-icon"></legend>
            <div>
                <label class="container">Oui
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
                <label class="container">Non
                    <input type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
        </fieldset>
        <button>Appliquer</button>
    </aside>

    <section class="margin-left-reset padding-bottom-reset">
        <div class="flex flex-align-center">
            <h1 class="text-medium">Il y a {{ count }} résultats</h1>
            <div class="right">
                <button class="scnd-btn text-medium">Trier par <img src="../assets/img/dropdwnarrow.png" alt="" class="filter-arrow closed-icon"></button>
                <div class="filter-menu hide-filter-menu">
                        <a href="{{ path }}Auction/sortAsc">Titre ASC</a>
                        <a href="{{ path }}Auction/sortDesc">Titre DESC</a>
                </div>
            </div>
        </div>
        <div class="grid-list">
            {% for auction in auctions %}
                {% for stamp in stamps %}
                    {% for image in images %}
                        {% if auction.stamp_id == stamp.id and stamp.id == image.stamp_image_id and auction.auction_status_id == 1 %}
                            <article class="card">
                                <div class="card-img-container">
                                    <img src="../assets/stamps_img/{{image.name}}" alt="">
                                </div>
                                <h3 class="text-large">{{ stamp.title }}</h3>
                                <div class="card-auction-info text-color_grey">
                                    <span class="w600 text-large">£ {{ auction.current_price }}</span>
                                    {% if auction.bid_number <= 1 %}
                                        <p>{{ auction.bid_number }} enchère</p>
                                    {% else %}
                                        <p>{{ auction.bid_number }} enchères</p>
                                    {% endif %}
                                    <p>Fin {{ auction.date_end }}</p>
                                </div>
                                
                                <a href="{{ path }}Auction/show/{{ auction.id }}" class="bid-btn">Miser</a>
                            </article>
                        {% endif %}
                    {% endfor %}
                {% endfor %}
            {% endfor %}
        </div> 
        <div class="flex flex-align-center flex-wrap margin-reset padding-reset">

                <p>Résultats par page : </p>
                <div class="result-options">
                    <a href=""><span class="selected-option">24</span></a>
                    <a href=""><span>48</span></a>
                    <a href=""><span>72</span></a>
                </div>

            <button class=" text-larger button-style-reset right">Remontez <img src="../assets/img/go-up.png" alt=""></button>
        </div>
    </section>
</main>
{{ include('footer.php') }}
