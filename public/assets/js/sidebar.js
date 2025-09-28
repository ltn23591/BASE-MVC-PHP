document.addEventListener("DOMContentLoaded", function () {
    console.log("Sidebar JS loaded"); // test xem có chạy không

    const toggles = document.querySelectorAll("[data-toggle]");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function () {
            const targetId = this.getAttribute("data-toggle");
            const menu = document.getElementById(targetId);
            const icon = this.querySelector("svg");

            if (menu) {
                menu.classList.toggle("hidden"); // toggle submenu
                if (icon) {
                    icon.classList.toggle("rotate-180"); // xoay mũi tên
                }
            } else {
                console.error("Không tìm thấy submenu với id:", targetId);
            }
        });
    });
});
