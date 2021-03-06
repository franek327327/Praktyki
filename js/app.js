const buttonLogowanie = document.querySelector(".log-btn");
const logowanie = document.querySelector(".log");
const rejestracja = document.querySelector(".reg");
const buttonRejestracja = document.querySelector(".reg-btn");


buttonLogowanie.addEventListener("click", function() {

    logowanie.style.display = "block";
	logowanie.classList.add("logAnim");
	rejestracja.classList.remove("regAnim");
	

    if (rejestracja.style.display == "block") 
	{
        rejestracja.style.display = "none";
    }

});
buttonRejestracja.addEventListener("click", function() {
	
    rejestracja.style.display = "block";
	logowanie.classList.remove(".logAnim");
	rejestracja.classList.add("regAnim");

    if (logowanie.style.display == "block") 
	{
        logowanie.style.display = "none";
    }

});


