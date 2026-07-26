$(function () {
    // SIDEBAR ACTIVE
    const sidebarLinks = document.querySelectorAll("#sidebar a");
    const currentUrl = window.location.href;

    sidebarLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add("border-violet-500", "text-violet-400");
            link.classList.remove("border-transparent", "text-white");
        } else {
            link.classList.add("border-transparent", "text-white");
            link.classList.remove("border-violet-500", "text-violet-400");
        }
    });
})

