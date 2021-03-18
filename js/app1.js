
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
			var printContents = document.querySelector(".drukuj").innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

}




 function SendMail()
  {
    html2canvas(document.querySelector('.drukuj').children[0]).then(function(canvas) {
        var img=canvas.toDataURL();
        $.ajax({
            type: "POST",
            url: "test.php",
            data: {zdj : img},
            success : function(response) {
                alert(response);
            },
            error : function(response) {
                alert(response);
            }
        });
       });
       



  }
  function Download()
  {
      const planLekcji = document.querySelector(".drukuj").children[0];
      planLekcji.classList.add("pobierz");
    html2canvas(document.querySelector('.drukuj')).then(function(canvas) {
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
