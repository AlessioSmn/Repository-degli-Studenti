/**
 * Effettua l'upload di un documento, ricavando i dati dal form del chiamante
 * @param {*} event 
 */
function uploadDocument(event) {
      event.preventDefault();
      
      let uploadForm = new FormData(event.target);
      let fetchBodyOptions = new FormData();

      // Ricavo tutti i campi necessari per la richiesta
      fetchBodyOptions.append("title", uploadForm.get('title'));
      fetchBodyOptions.append("fileContent", uploadForm.get('fileContent'));
      let subject_selector = document.getElementById("subject_selector");
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
                  window.alert("Documento caricato con successo");
                  window.location.href = "personal.php";
            }

            // errore nell'upload
            else{
                  window.alert("Errore nell'upload del documento");
            }
      })
      .catch(error => console.error("Errore nell'upload del file: ", error));
      
}