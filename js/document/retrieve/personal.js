
/**
 * Effettua una fetch per ricavare tutti i documenti dell'utente loggato (identifcatore ricavato direttamente in php)
 * @return {Promise<Document[]>} Ritrona un array di documenti (array di oggetti della classe Document)
 */
function retrievePersonalDocuments(){

      return fetch('php/document/retrieval/personal.php')
      .then(response => response.json())
      .then(data => {

            // Riferimento al container di tutti i documenti
            let mainContainer = document.getElementById("documentVisualizer");
            mainContainer.innerHTML = "";

            // Pulisco l'array di documenti
            let documents = [];

            for(let row of data){
                  let doc = new Document(
                        row['id'],
                        row['title'],
                        row['subtitle'],
                        row['extension'],
                        row['owner'],
                        row['subjectName'],
                        row['degreeName'],
                        row['downloads'],
                        new Date(row['lastModifiedDate']), 
                        new Date(row['uploadDate']), 
                  );

                  // Aggiungo il documento alla lista di documenti
                  documents.push(doc);
            }

            // Ritorno l'array di documenti
            return documents;
      })
      .catch(error => console.error(error.message));
}