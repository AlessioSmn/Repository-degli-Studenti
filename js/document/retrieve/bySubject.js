
/**
 * Effettua una fetch per ricavare tutti i documenti che rispettano i criteri di ricerca
 * @return {Promise<Document[]>} Ritrona un array di documenti (array di oggetti della classe Document)
 */
function retrieveDocumentsBySubject(){
      // Ricavo le informazioni della materia selezionata
      const subjectSelector = document.getElementById("subject_selector");
      const subjectId = subjectSelector.options[subjectSelector.selectedIndex].value;
      const subjectName = subjectSelector.options[subjectSelector.selectedIndex].innerHTML;

      // Ricavo le informazioni del croso selezionato (solo a scopo di controllo e informativo, nnon è necessario per la richiesta php)
      const degreeSelector = document.getElementById("degree_selector");
      const degreeId = degreeSelector.options[degreeSelector.selectedIndex].value;
      const degreeName = degreeSelector.options[degreeSelector.selectedIndex].innerHTML;
      
      // Controllo che sia stata selezionata correttamente una materia
      if(degreeId == 0 || subjectId == 0)
            return;

      let fetchArguments = prepareFetchArgumentsSubject(subjectId);

      // Effettua una richiesta fetch al server PHP per ottenere i dati dal database
      return fetch('php/document/retrieval/bySubject.php?' + fetchArguments)
      .then(response => response.json())
      .then(data => {
            
            // Pulisco la lista di documenti
            let documents = [];

            // Creo l'array di document utilizzando la classe apposita
            for(let row of data){
                  let doc = new Document(
                        row['id'],
                        row['title'],
                        row['subtitle'],
                        row['extension'],
                        row['owner'],
                        subjectName,
                        degreeName,
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
      .catch(error => {
            console.error('Errore nella richiesta fetch: ' + error);
            return false;
      });
}

/**
 * Funzione di utilità per preparare gli argomenti da passare alla richiesta PHP
 * @param {string} subject 
 */
function prepareFetchArgumentsSubject(subject){
      // array per contenere tutti i parametri di ricerca da passare alla fetch
      let argsArray = [];

      // Id della materia
      argsArray.push(["selectedSubjectId", subject]);

      return new URLSearchParams(argsArray).toString();
}