{{ include('header.php') }}
    <main>
            <section class="auction flex">
                <div class="stamp-images flex">
                    <div>
                        <img src="{{ path }}assets/stamps_img/{{ mainImage.name }}" alt="" class="preview">
                    </div>
                    <div>
                        <img src="{{ path }}assets/stamps_img/{{ mainImage.name }}" width="330px"  alt="">
                        <p>Survoler pour agrandir</p>
                    </div>
                </div>
                <div class="auction-info flex flex-column">
                    <h1 class="w200 text-color_blue">{{ auction.title }}</h1>
                    <span class="error">{{ errors|raw }}</span>
                    <h2 class="w600">£ {{ auction.current_price }}</h2>
                    {% if auction.bid_number <= 1 %}
                        <p><b>{{ auction.bid_number }}</b> enchère</p>
                    {% else %}
                        <p><b>{{ auction.bid_number }}</b> enchères</p>
                    {% endif %}
                    {% if auction.auction_status_id == 1 %}
                        <p class="text-larger">Termine le {{ auction.date_end }}</p>
                        <form action="{{ path }}Auction/bid" method="post" class="auction-options flex">
                            <div>
                                <input type="hidden" value="{{ auctionId.id }}" name="auction_id">
                                <input type="hidden" value="{{ auction.stamp_id }}" name="auction_stamp_id">
                                <label for="bid">Prix</label>
                                <input type="text" placeholder="$" id="bid" name="bid">   
                                <div class="quick-bids flex">
                                    <a href="#" class="selected-bid"><span>$10</span></a>
                                    <a href="#"><span>$20</span></a>
                                    <a href="#"><span>$30</span></a>
                                    <a href="#"><span>$40</span></a>
                                </div>
                                <div class="flex">
                                    <img src="{{ path }}assets/img/paypal-icon.png" alt="">
                                    <img src="{{ path }}assets/img/visa-icon.png" alt="">
                                    <img src="{{ path }}assets/img/mastercard-icon.png" alt="">
                                </div>
                            </div>
                            <div class="flex flex-column bid-btns">
                                <button class="main-bid" type="submit">Miser</button>
                                <button>Mise rapide</button>
                        </form>
                        <form action="{{ path }}User/follow" class="follow-form" method="post">
                            <input type="hidden" value="{{ auctionId.id }}" name="auction_id">
                            <input type="hidden" value="{{ auction.stamp_id }}" name="auction_stamp_id">
                            <button type="submit" class="follow-btn">Suivre</button>
                        </form>
                    </div>
                    {% else %}
                        <p class="text-larger">Terminé</p>
                    {% endif %}
                </div>
            </section>
            <section class="border-top">
                <h1 class="text-color_blue">Détails</h1>
                <p>Condition : {{ condition.condition }}</p>
                <p>Pays : {{ auction.country }}</p>
                <p>Date de création : {{ auction.creation_date }}</p>
                <p>Couleurs : {{ auction.colors }}</p>
                <p>Certifié : {{ certification.certification }}</p>
            </section>
        <section class="border-top">
            <h3 class="text-color_blue text-large">Autres timbres du même pays</h3>
            <div class="catalog">
                <article class="card">
                    <div class="card-img-container">
                        <img src="{{ path }}assets/img/cardimg1.png" alt="">
                    </div>
                    <h3 class="text-large">Cambodia 1598-1603 set MNH</h3>
                    <div class="card-auction-info text-color_grey">
                        <span class="w600 text-large">£ 2.50</span>
                        <p>1 enchère</p>
                        <p>4 j 2h 3m restant</p>
                    </div>
                    <button class="text-medium">Miser</button>
                </article>   
                <article class="card">
                    <div class="card-img-container">
                        <img src="{{ path }}assets/img/cardimg2.png" alt="">
                    </div>
                    <h3 class="text-large">Cambodia 1995 - FDC - Scott #1417</h3>
                    <div class="card-auction-info text-color_grey">
                        <span class="w600 text-large">£ 2.50</span>
                        <p>1 enchère</p>
                        <p>4 j 2h 3m restant</p>
                    </div>
                    <button class="text-medium">Miser</button>
                </article>   
                <article class="card">
                    <div class="card-img-container">
                        <img src="{{ path }}assets/img/cardimg3.png" alt="">
                    </div>
                    <h3 class="text-large">Netherlands 1997 - MNH - Block - Souvenir Card - Scott #954</h3>
                    <div class="card-auction-info text-color_grey">
                        <span class="w600 text-large">£ 2.50</span>
                        <p>1 enchère</p>
                        <p>4 j 2h 3m restant</p>
                    </div>
                    <button class="text-medium">Miser</button>
                </article>   
                <article class="card">
                    <div class="card-img-container">
                        <img src="{{ path }}assets/img/cardimg4.png" alt="">
                    </div>
                    <h3 class="text-large">Guyana 1993 - FDC - Scott #2675b</h3>
                    <div class="card-auction-info text-color_grey">
                        <span class="w600 text-large">£ 2.50</span>
                        <p>1 enchère</p>
                        <p>4 j 2h 3m restant</p>
                    </div>
                    <button class="text-medium">Miser</button>
                </article>   
                <article class="card">
                    <div class="card-img-container">
                        <img src="{{ path }}assets/img/cardimg5.png" alt="">
                    </div>
                    <h3 class="text-large">GB # 33 PLATE 181 PENNY RED CAT</h3>
                    <div class="card-auction-info text-color_grey">
                        <span class="w600 text-large text-color_black">£ 2.50</span>
                        <p>1 enchère</p>
                        <p class="text-color_red">3h 3m restant</p>
                    </div>
                    <button class="text-medium">Miser</button>
                </article>
            </div> 
            <button class="right text-medium scnd-btn">Voir plus</button>
        </section>
    </main>
    {{ include('footer.php') }}
</body>