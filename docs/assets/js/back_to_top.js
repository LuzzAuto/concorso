var lastScrollTop = 0;
window.addEventListener("scroll", function(){ 
    var buttonBacktoTop = document.getElementById("backToTopButton");
    var st = document.documentElement.scrollTop;
    var scrollHeight = document.documentElement.scrollHeight;
    var clientHeight = document.documentElement.clientHeight;

    var isScrollingUp = st < lastScrollTop; // Controlla se si sta scorrendo verso l'alto
    var isNearBottom = (scrollHeight - (st + clientHeight)) < 350; // Vicino alla fine della pagina

    if (st == 0 || (!isScrollingUp && !isNearBottom)) {
        buttonBacktoTop.className = "backToTopHidden";
    } else {
        buttonBacktoTop.className = "backToTopShow";
    }

    lastScrollTop = st <= 0 ? 0 : st;
}, false);