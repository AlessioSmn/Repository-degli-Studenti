

/**
 * Effettua la modifica di un documento
 * @param {*} event
 */
function modifyDocument(event){
      event.preventDefault();

      const updateForm = new FormData(event.target);
      const fetchBodyOptions = new FormData();

      // Controllo che l'utente abbia cambiato qualcosa
      const newTitle = updateForm.get('title');
      const oldTitle = updateForm.get('docOldTitle');
      const newSubtitle = updateForm.get('subtitle');
      const oldSubtitle = updateForm.get('docOldSubtitle');
      const newFile = updateForm.get('newfile');
      const fileUpdated = document.getElementById("newFileInput").files.length > 0;

      if(newTitle == oldTitle
      && newSubtitle == oldSubtitle
      && !fileUpdated){
            window.alert("Non hai effettuato nessuna modifica");
            return;
      }

      // Ricavo tutti i campi necessari per la richiesta
      fetchBodyOptions.append("newTitle", newTitle);
      fetchBodyOptions.append("newSubtitle", newSubtitle);
      fetchBodyOptions.append("id", updateForm.get('docId'));
      fetchBodyOptions.append("oldExtension", updateForm.get('docExtension'));
      if(fileUpdated) fetchBodyOptions.append("newFile", newFile);
      let fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };

      // Chiamata di fecth alla funzione php per la modifica  del documento
      fetch('php/document/manage/updateDocument.php', fetchOptions)

      // deserializzo la risposta
      .then(response => response.json())

      // Mostro l'esito
      .then(data => {
            if(data === true){
                  location.reload();
            }
            else{
                  window.alert("Errore nella modifica del file");
            }
      })
      .catch(error => console.error("Errore: " + error));

}
