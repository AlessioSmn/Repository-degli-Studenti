
// Works only with a (select) element with id = degree_selector
var degree_selector = document.getElementById("degree_selector");

/** 
 * @description Executes a fetch request to server to get all subjects relative to the selected degree
 */
function showSubjects(){
      var degreeID = degree_selector.selectedIndex;
      var degreeName = degree_selector.options[degree_selector.selectedIndex].innerHTML;

      // Effettua una richiesta fetch al server PHP per ottenere i dati dal database
      fetch('php/subject/retrieveByDegree.php?selectedDegreeIndex=' + degreeID)
      .then(response => response.json())
      .then(data => fillSubjectOptions(document.getElementById("subject_selector"), data, degreeName))
      .catch(error => console.error('Errore nella richiesta fetch: ' + error));
}
degree_selector.addEventListener("change", showSubjects);