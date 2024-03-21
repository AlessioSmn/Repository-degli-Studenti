
function deleteDocument(DocumentId, DocumentExtension){
      
      // Chiamata di fecth alla funzione php per la cancellazione del documento
      fetch('php/document/manage/deleteDocument.php?id=' + DocumentId + '&ext=' + DocumentExtension)

      // deserializzo la risposta
      .then(response => response.json())

      // Mostro l'esito
      .then(data => {
            if(data === true){
                  window.alert("File eliminato correttamente!");
                  location.reload();
            }
            else{
                  window.alert("Errore nell'eliminazione del file");
                  // In questo caso data potrebbe fornire ulteriori informazioni sul problema
            }
      })

      .catch(error => console.error("Errore: " + error));
}