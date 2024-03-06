

function retrievePersonalDocuments(callingElement){
      // ELimino il bottone che ha lancito la funzione
      let parent = callingElement.parentNode;
      parent.removeChild(callingElement);

      fetch('php/document/retrieval/personal.php')
      .then(response => response.json())
      .then(data => {

            // Pulisco l'array di documenti
            DOCUMENTS = [];

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
                  DOCUMENTS.push(doc);
            }
            populateWithDocuments(DOCUMENTS);
      })
      .catch(error =>{
            console.error(error.message);
      });
}