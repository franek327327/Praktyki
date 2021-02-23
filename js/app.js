const buttonLogowanie = document.querySelector(".log-btn");
const logowanie = document.querySelector(".log");
const rejestracja = document.querySelector(".reg");
const buttonRejestracja = document.querySelector(".reg-btn");

buttonLogowanie.addEventListener("click", function() {

    logowanie.style.display = "block";
	logowanie.classList.add("logAnim");
	logowanie.classList.remove("logRev");
	rejestracja.classList.remove("regAnim");
	rejestracja.classList.add("regRev");
	

    if (rejestracja.style.display == "block") 
	{
        rejestracja.style.display = "none";
    }

});
buttonRejestracja.addEventListener("click", function() {

	src="index.php";
	console.log(ileBld);
	
	

    rejestracja.style.display = "block";
	logowanie.classList.add("logRev");
	logowanie.classList.remove(".logAnim");
	rejestracja.classList.remove("regRev");
	rejestracja.classList.add("regAnim");

    if (logowanie.style.display == "block") 
	{
        logowanie.style.display = "none";
    }

});

// Podgląd hasła
const hasloBtn = document.querySelectorAll(".zobaczHaslo");




for (const btn of hasloBtn) {
    const hasloHref = btn.getAttribute("href");
    const haslo = document.querySelector(hasloHref);

    function show() {
        haslo.setAttribute("type", "text");
    }

    function hide() {
        haslo.setAttribute("type", "password");
    }

    document.addEventListener("DOMContentLoaded", () => {
        btn.addEventListener("mousedown", show);
        btn.addEventListener("mouseup", hide);
    });
}
