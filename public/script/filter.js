window.addEventListener("load", function() {
    const filter = document.querySelectorAll("legend");

    console.log(filter);

    filter.forEach(function(element) {
        element.addEventListener("click", function() {
            const icon = element.querySelector("img");
            const filters = element.nextElementSibling;
            console.log(filters);

            if(icon.classList == "closed-icon"){
                icon.classList.remove("closed-icon");
                filters.classList.remove("hide-filters");
            }else{
                icon.classList.add("closed-icon");
                filters.classList.add("hide-filters");
            }
        });
    });
});