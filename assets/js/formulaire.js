document.getElementById("bg_pic").addEventListener('change', readURL, true);
function readURL(){
   var file = document.getElementById("bg_pic").files[0];
   var reader = new FileReader();
   reader.onloadend = function(){
      document.getElementById('formulaire').style.backgroundImage = "url(" + reader.result + ")";
      document.getElementById('formulaire').style.backgroundSize = "auto";
      document.getElementById('formulaire2').style.backgroundColor = "#fff9";
   }
   if(file){
      reader.readAsDataURL(file);
    }else{
    }
}

document.getElementById("addSection").addEventListener('click', addSection, true);
document.getElementById("delSection").addEventListener('click', delSection, true);

function addSection() {
  var secti_max = document.getElementById("section_max").value;

}
