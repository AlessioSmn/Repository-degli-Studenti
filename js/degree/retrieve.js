/**
 * Interroga il database e ricava tutti corsi di laurea presenti
 * @returns Ritorna tutti i corsi di laurea presenti come array, ogni riga costituita dall'ID del corso e dal nome
 */
function retrieveDegrees(){
      let selectElement = document.getElementById("degree_selector");
      fetch('php/degree/retrieveAll.php')
      .then(response => response.json())
      .then(data => { 
            fillSelectWithDegrees(selectElement, data);
      })
      .catch(error => console.log(error));
}

/**
 * Popola il <select> con la lista di opzioni passata, premettendo una opzione non selezionambile
 * @param selectElement Elemento HTML di tupo select da popolare (verrà prima svuotato)
 * @param options Array di elementi da mostrare come opzioni
 */
function fillSelectWithDegrees(selectElement, degrees){

      // Svuoto selectElement
      selectElement.innerHTML = "";

      // Primo elemento non selezionabile
      let disabledOption = document.createElement("option");
      disabledOption.selected = true;
      disabledOption.disabled = true;
      disabledOption.innerText = "-- seleziona un corso di studio --";
      disabledOption.style.fontStyle = "italic";
      selectElement.appendChild(disabledOption);

      // Aggiungo tutti gli altri elementi
      for(let degree of degrees){
            let option = document.createElement("option");

            // Imposto valore (ossia ID)
            option.value = degree["id"];

            // Imposto il testo (nome del corso)
            option.innerText = degree["name"];

            selectElement.appendChild(option);
      }
}