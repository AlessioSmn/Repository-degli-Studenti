/**
 * Effettua l'upload di un documento, ricavando i dati dal form del chiamante
 * @param {*} event 
 */
function uploadDocument(event) {
      event.preventDefault();
      
      let uploadForm = new FormData(event.target);

      // Controllo che sia stata impostata una materia
      let subject_selector = document.getElementById("subject_selector");
      if(Number(subject_selector.selectedIndex) <= 0) return false;

      let fetchBodyOptions = new FormData();

      // Ricavo tutti i campi necessari per la richiesta
      fetchBodyOptions.append("title", uploadForm.get('title'));
      fetchBodyOptions.append("fileContent", uploadForm.get('fileContent'));
      fetchBodyOptions.append("subjectId", subject_selector.value);
      let fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };
      
      // Richiesta al file php
      fetch('php/document/manage/uploadDocument.php', fetchOptions)
      .then(response => response.json())
      .then(data => {
            // Upload avvenuto con successo
            if(data[0]){
                  window.location.href = "personal.php";
            }

            // errore nell'upload
            else{
                  let uploadError = document.getElementById("uploadError");
                  uploadError.innerText = data[1] != null ? data[1] : "Errore nell'upload del documento";
                  uploadError.style.display = "block";
            }
      })
      .catch(error => {
            console.error("Errore nell'upload del file: ", error);
            let uploadError = document.getElementById("uploadError");
            uploadError.innerText = "Errore nell'upload del documento";
            uploadError.style.display = "block";
      });
      
}