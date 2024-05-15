// Menu function, very important!
function toggleMenu() {
    var menu = document.getElementById("menu");
    menu.classList.toggle("active");
    
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("active");
}