/*
window.onload = (event) => {
      // fetch('php/retrievePersonalDocuments.php')
      fetch('php/document/retrieval/personal.php')
      .then(response => response.json())
      .then(data => {
            // Non stampo i documenti se il result set è vuoto
            if(data !== null) data.forEach(function(queryRow){ 
                  // console.log(queryRow);
                  var newDiv = constructDocs(
                        true,
                        queryRow['id'], 
                        queryRow['extension'], 
                        queryRow['title'], 
                        queryRow['owner'], 
                        queryRow['subjectName'], 
                        queryRow['degreeName'], 
                        queryRow['downloads'], 
                        new Date(queryRow['lastModifiedDate']), 
                        new Date(queryRow['uploadDate']), 
                        queryRow['subtitle']);
                  documentVisualizer.appendChild(newDiv);
            })
      })
      .catch(error =>{
            console.error('Errore nella richiesta fetch: ' + error.statusText)
            console.error('Messaggio di errore: ' + error.message);
      });
}
*/

function retrievePersonalDocuments(callingElement){
      // ELimino il bottone che ha lancito la funzione
      let parent = callingElement.parentNode;
      parent.removeChild(callingElement);

      fetch('php/document/retrieval/personal.php')
      .then(response => response.json())
      .then(data => {
            // Non stampo i documenti se il result set è vuoto
            if(data !== null) data.forEach(function(queryRow){ 
                  // console.log(queryRow);
                  var newDiv = constructDocs(
                        true,
                        queryRow['id'], 
                        queryRow['extension'], 
                        queryRow['title'], 
                        queryRow['owner'], 
                        queryRow['subjectName'], 
                        queryRow['degreeName'], 
                        queryRow['downloads'], 
                        new Date(queryRow['lastModifiedDate']), 
                        new Date(queryRow['uploadDate']), 
                        queryRow['subtitle']);
                  documentVisualizer.appendChild(newDiv);
            })
      })
      .catch(error =>{
            console.error('Errore nella richiesta fetch: ' + error.statusText)
            console.error('Messaggio di errore: ' + error.message);
      });
}