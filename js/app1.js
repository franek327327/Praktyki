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
// Drukowanie planu
function printDiv()
{
            console.log("print");
			var printContents = document.querySelector(".drukuj").innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

}




 function SendMail()
  {
    html2canvas(document.getElementById('conas')).then(function(canvas) {
        var img=canvas.toDataURL();
        $.ajax({
            type: "POST",
            url: "test.php",
            data: {zdj : img},
            success : function(response) {
                console.log(response);
            },
            error : function(response) {
                console.log(response);
            }
        });
       });
       



  }
  function Download()
  {
    html2canvas(document.getElementById('conas')).then(function(canvas) {
        SaveAs(canvas.toDataURL(), 'plan lekcji.png');
        });
  }

  function SaveAs(url, filename) {

    var link = document.createElement('a');

    if (typeof link.download == 'string') {

        link.href = url;
        link.download = filename;

        //Firefox wymaga by element znajdował się w body
        document.body.appendChild(link);

        //Symuluje kliknięcie
        link.click();

        //Usunięcie elemenetu po wykonaniu
        document.body.removeChild(link);

    } else {

        window.open(url);

    }
}
