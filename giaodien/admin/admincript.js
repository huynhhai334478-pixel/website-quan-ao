document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".admin-content-left ul > li > a");

    menuItems.forEach(item => {
        item.addEventListener("click", function (e) {
            const submenu = this.nextElementSibling;
            if (submenu && submenu.classList.contains("submenu")) {
                e.preventDefault(); // Ngăn chặn hành động mặc định
                submenu.classList.toggle("active");
            }
        });
    });
});