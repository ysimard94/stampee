window.addEventListener("load", function() {
    const menu = document.querySelector(".menu");
    const menuBtn = document.querySelector(".menu-btn");
    const userLogin = document.querySelector(".user-login");
    const userMenu = document.querySelector(".user-menu");
    const drpIcon = document.querySelector(".user-drpdown-icon");
    const filterParent = document.querySelector(".scnd-btn");
    const filterMenu = document.querySelector(".filter-menu");
    const filterArrow = document.querySelector(".filter-arrow");

    menuBtn.addEventListener("click", function() {
        if (menu.classList.contains("hide")) {
            menu.classList.remove("hide");
        } else {
            menu.classList.add("hide");
            console.log(menu);
        }
    });
    userLogin.addEventListener("click", function() {
        if (userMenu.classList.contains("hide-user-menu")) {
            drpIcon.classList.add("open");
            userMenu.classList.remove("hide-user-menu");
        } else {
            drpIcon.classList.remove("open");
            userMenu.classList.add("hide-user-menu");
            console.log(menu);
        }
    });

    filterParent.addEventListener("click", function() {
        if (filterMenu.classList.contains("hide-filter-menu")) {
            filterArrow.classList.remove("closed-icon");
            filterMenu.classList.remove("hide-filter-menu");
        } else {
            filterArrow.classList.add("closed-icon");
            filterMenu.classList.add("hide-filter-menu");
            console.log(menu);
        }
    });
});