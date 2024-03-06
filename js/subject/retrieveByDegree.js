
/**
 * Effettua una richiesta al server e ricava tutte le ,aterie di un dato corso di laurea, poi le mostra popolando varie opzioni
 */
function retrieveSubjectByDegree(){
      // Ricavo il corso selezionato 
      let degree_selector = document.getElementById("degree_selector");
      let selectedDegreeOption = degree_selector.options[degree_selector.selectedIndex];
      // Id e nome
      let degreeId = selectedDegreeOption.value;
      let degreeName = selectedDegreeOption.innerText;

      // Effettua una richiesta fetch al server PHP per ottenere i dati dal database
      fetch('php/subject/retrieveByDegree.php?selectedDegreeIndex=' + degreeId)
      .then(response => response.json())
      .then(data => {
            if(data !== null) 
                  fillSubjectOptions(document.getElementById("subject_selector"), data, degreeName)
      })
      .catch(error => console.error('Errore nella richiesta fetch: ' + error));
}