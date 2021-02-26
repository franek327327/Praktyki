//menu

var blinkTextMenuLinks = document.querySelectorAll(".blink-text-menu li a");

blinkTextMenuLinks.forEach(function(link) {
    var letters = link.textContent.split("");
    link.textContent = "";
    letters.forEach(function(letter, i) {
        i += 1;
        var span = document.createElement("span");
        var delay = i / 20;
        if (i % 2 === 0) {
            delay -= 0.1;
        } else {
            delay += 0.05;
        }
        var letterOut = document.createElement("span");
        letterOut.textContent = letter;
        letterOut.style.transitionDelay = delay + "s";
        letterOut.classList.add("out");
        span.append(letterOut);
        var letterIn = document.createElement("span");
        letterIn.textContent = letter;
        letterIn.style.transitionDelay = delay + "s";
        letterIn.classList.add("in");
        span.append(letterIn);
        link.append(span);
    });
});

// Profil
/*
const profil = document.querySelector("#profil");
const profilShowBtn = document.querySelector("#showProfil");
const profilCloseBtn = document.querySelector("#closeProfil");

profilShowBtn.addEventListener("click", function() {

    profil.style.display = "block";
	profil.classList.add("profilAnim");
    profil.classList.remove("profilAnimRev");
});

profilCloseBtn.addEventListener("click", function() {

    profil.style.display = "block";
	profil.classList.add("profilAnimRev");
    profil.classList.remove("profilAnim");
});
*/

 const buttons = document.querySelectorAll(".tab-el");

 for(const btn of buttons){
    
    btn.addEventListener("click", function(){
        const contentHref = btn.children[0].getAttribute("href");
        const content = document.querySelector(contentHref);
        const contentAll = document.querySelectorAll(".tab-content");
        for(const contest of contentAll){
            contest.classList.remove("tab-content-active");
        }
        content.classList.add("tab-content-active");
        
        const contener = document.querySelector(".tab-contents")
        contener.style.display = "block";
	    contener.classList.add("profilAnim");
        contener.classList.remove("profilAnimRev");
     });
   
 }

 const closet = document.querySelectorAll(".close");

 for(const cls of closet){
    cls.addEventListener("click", function(){
        const contener = document.querySelector(".tab-contents")
	    contener.classList.remove("profilAnim");
        contener.classList.add("profilAnimRev");
    })
 }