// On récupère le bouton de chargement
const btnCharger = document.getElementById("chargerPochette");
btnCharger.addEventListener("click", lanceParcourir, false);

// On récupère le champ d'upload
const fileupload = document.getElementById("imageFile");
fileupload.addEventListener("change", afficheImage, false);
// On répuère le champ img qui affiche l'image
const imageAffiche = document.getElementById("imageAffichee")

function lanceParcourir() {
    fileupload.click();
}

function afficheImage(){
    const imageCharge = this.files[0];
    const ulrImageCharge = URL.createObjectURL(imageCharge);
    imageAffiche.setAttribute("src", ulrImageCharge);
}