
var degree_selector = document.getElementById("degree_selector");
function showSubjects(){
      // Ricavo il corso selezionato 
      let selectedDegreeOption = degree_selector.options[degree_selector.selectedIndex];
      let degreeId = selectedDegreeOption.value;
      let degreeName = selectedDegreeOption.innerText;

      // Effettua una richiesta fetch al server PHP per ottenere i dati dal database
      fetch('php/subject/retrieveByDegree.php?selectedDegreeIndex=' + degreeId)
      .then(response => response.json())
      .then(data => {if(data !== null) fillSubjectOptions(document.getElementById("subject_selector"), data, degreeName)})
      .catch(error => console.error('Errore nella richiesta fetch: ' + error));
}
degree_selector.addEventListener("change", showSubjects);

function showDocuments(){
      var subjectID = subject_selector.options[subject_selector.selectedIndex].value;
      let subjectName = subject_selector.options[subject_selector.selectedIndex].innerHTML;
      var degreeID = degree_selector.selectedIndex;
      let degreeName = degree_selector.options[degree_selector.selectedIndex].innerHTML;
      
      if(degreeID == 0 || subjectID == 0)
            return;

      let documentVisualizer = document.getElementById("documentVisualizer");
      documentVisualizer.innerHTML = "";
      // Effettua una richiesta fetch al server PHP per ottenere i dati dal database
      // fetch('php/retrieveDocumentsBySubject.php?' + preparefetchargs(subjectID))
      fetch('php/document/retrieval/bySubject.php?' + preparefetchargs(subjectID))
      .then(response => response.json())
      .then(data => {
            
            DOCUMENTS = [];

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
                  DOCUMENTS.push(doc);
            }
            populateWithDocuments(DOCUMENTS);
/*
            // Non stampo i documenti se il result set è vuoto
            if(data !== null) data.forEach(function(queryRow){ 
                  var newDiv = constructDocs(
                        false,
                        queryRow['id'], 
                        queryRow['extension'], 
                        queryRow['title'], 
                        queryRow['owner'], 
                        subjectName, 
                        degreeName, 
                        queryRow['downloads'], 
                        new Date(queryRow['lastModifiedDate']), 
                        new Date(queryRow['uploadDate']), 
                        queryRow['subtitle']);
                  documentVisualizer.appendChild(newDiv);
            })
            */
      })
      .catch(error => {
            console.error('Errore nella richiesta fetch: ' + error);
      });
}
function preparefetchargs(sub){
      // array per contenere tutti i parametri di ricerca da passare alla fetch
      var argsArray = [];

      // Id della materia
      argsArray.push(["selectedSubjectId", sub]);

      // Order
      argsArray.push(['orderField', documentOrder.value]);
      argsArray.push(['asc', flipped ? "ASC" : "DESC"]);

      return new URLSearchParams(argsArray).toString();
}


                  /*
            if(data !== null){
                  fillSubjectOptions(data);
                  // default selected first choice
                  let defaultSubjectOption = document.createElement("option");
                  defaultSubjectOption.disabled = true;
                  defaultSubjectOption.selected = true;
                  defaultSubjectOption.style.fontStyle = "italic";
                  defaultSubjectOption.innerHTML = " -- seleziona una materia -- ";
                  subjectSelector.appendChild(defaultSubjectOption);
                  
                  let currentYear = -1;
                  let optionGroup;
                  data.forEach(function(queryRow){ 
                        console.log(queryRow);
                        let year = queryRow['year'];

                        // separate subject in to years (<optgroups>)
                        if(currentYear != year){
                              currentYear = year;
                              // close optgroup and add it to the subject selector
                              if(optionGroup)
                                    subjectSelector.appendChild(optionGroup);
                              // Open new optgroup
                              optionGroup = document.createElement("optgroup");
                              optionGroup.label = "Anno " + year;
                              console.debug("New optgroup: " + optionGroup.label);
                        }
            
                        let subjectOption = document.createElement("option");
                        subjectOption.value = queryRow['id'];
                        subjectOption.innerHTML = queryRow['name'];
                        optionGroup.appendChild(subjectOption);
                  })
                  subjectSelector.appendChild(optionGroup);
            }
            else{
                  // default no options
                  let subjectOption = document.createElement("option");
                  subjectOption.disabled = true;
                  subjectOption.selected = true;
                  subjectOption.style.fontStyle = "italic";
                  subjectOption.innerHTML = " -- nessuna materia in " + degreeName + " -- ";
                  subjectSelector.appendChild(subjectOption);
            }
      })
                  */