// Tiene traccia dell'apertura della navbar
let smallNavbarOpened = false;
let navbar = document.getElementById("navbar");

// Apre / chiude la navbar laterale
// nb: ha effetto solo con una piccola finestra
function sideNavbarToggle(){
      smallNavbarOpened = !smallNavbarOpened;
      if(smallNavbarOpened)
            navbar.classList.add("compact-visualizing");
      else
            navbar.classList.remove("compact-visualizing");
}