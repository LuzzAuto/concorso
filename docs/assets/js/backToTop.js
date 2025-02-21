//BACK TO TOP
var lastScrollTop = 0;
window.addEventListener("scroll", function(){ 
    var buttonBacktoTop = document.getElementById("backToTopButton");
    var st = document.documentElement.scrollTop;
    if (st == 0){ // || st > lastScrollTop
        buttonBacktoTop.className = "backToTopHidden";
    }else{
        buttonBacktoTop.className = "backToTopShow";
    }
    lastScrollTop = st <= 0 ? 0 : st;
 }, false);