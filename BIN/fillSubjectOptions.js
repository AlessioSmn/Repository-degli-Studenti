/**
 * Popola il <select> con la lista di opzioni passata, premettendo una opzione non selezionambile
 * @param {HTMLElement} subjectContainer tag select da popolare con le varie materie
 * @param {} subjects Array di materie, costituite da tre campi: [id | name | year]
 * @param {string} degreeName nome del corso di studio dal quale sono state prese le materie
 */
 function fillSubjectOptions(subjectContainer, subjects, degreeName){

      // Cancello le opzioni presenti in precedenza
      subjectContainer.innerHTML = null;

      if(subjects !== null && subjects.length > 0){

            // Primo elemento non selezionabile
            let disabledOption = document.createElement("option");
            disabledOption.selected = true;
            disabledOption.disabled = true;
            disabledOption.innerText = " -- seleziona una materia -- ";
            disabledOption.style.fontStyle = "italic";
            subjectContainer.appendChild(disabledOption);
      
            // Scorro su tutte le maerie, tenendo traccia dell'anno corrente
            let currentYear = -1;
            let optionGroup;

            for(let subject of subjects){ 

                  // Ricavo l'anno della materia
                  let year = subject['year'];

                  // Divido le matierie in optgroup a seconda dell'annp
                  if(currentYear != year){
                        currentYear = year;
                        
                        // Se l'optgroup è definito (ne è già stato creato uno) lo chiudo
                        if(optionGroup)
                              subjectContainer.appendChild(optionGroup);

                        // Apro un nuovo optgroup
                        optionGroup = document.createElement("optgroup");
                        optionGroup.label = "Anno " + year;
                  }

                  // Option per la materia
                  let subjectOption = document.createElement("option");

                  // Vaalore dell'option (l'id nel database)
                  subjectOption.value = subject['id'];

                  // Testo della materia
                  subjectOption.innerHTML = subject['name'];

                  // La aggiungo all'optgroup
                  optionGroup.appendChild(subjectOption);
            }

            // Appendo l'ultimo optgroup
            subjectContainer.appendChild(optionGroup);
      }

      // Se non ci sono materie
      else{
            let disabledOption = document.createElement("option");
            disabledOption.selected = true;
            disabledOption.disabled = true;
            disabledOption.innerText = " -- nessuna materia in " + degreeName + " -- ";
            disabledOption.style.fontStyle = "italic";
            subjectContainer.appendChild(disabledOption);
      }
}