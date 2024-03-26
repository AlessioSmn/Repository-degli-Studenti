

/**
 * Effettua la modifica di un documento
 * @param {*} event
 */
function modifyDocument(event){
      event.preventDefault();

      let updateForm = new FormData(event.target);
      let fetchBodyOptions = new FormData();

      // Ricavo tutti i campi necessari per la richiesta
      fetchBodyOptions.append("newTitle", updateForm.get('title'));
      fetchBodyOptions.append("newSubtitle", updateForm.get('subtitle'));
      fetchBodyOptions.append("newFile", updateForm.get('newfile'));
      fetchBodyOptions.append("id", updateForm.get('docId'));
      fetchBodyOptions.append("oldExtension", updateForm.get('docExtension'));
      let fetchOptions = {
            method: "POST",
            body: fetchBodyOptions,
      };

      // Chiamata di fecth alla funzione php per la modifica  del documento
      fetch('php/document/manage/updateDocument.php', fetchOptions)

      // deserializzo la risposta
      .then(response => response.text())

      // Mostro l'esito
      .then(data => {
            console.log(data);
            /*
            if(data === true){
                  location.reload();
            }
            else{
                  window.alert("Errore nella modifica del file");
            }
            */
      })
      .catch(error => console.error("Errore: " + error));

}
