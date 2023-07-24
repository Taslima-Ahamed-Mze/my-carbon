function toggleMenu() {
    const header = document.querySelector(".header");
    header.classList.toggle("menu-open");
}

document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-toggle");

    if (menuBtn) menuBtn.addEventListener("click", toggleMenu);
});