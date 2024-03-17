
// Riferimenti agli elementi che controllano i parametri di ricerca

var subjectNameTextField = document.getElementById("mainText");
// Controlli e valori sui CFU della materia
// NB: in PHP va bene anche il campo text vuoto, si troveranno tutte le materie
// NB: si lascia all'utente il buon senso di mettere minCFU <= maxCFU, 
//          in caso contrario banalmente non ci saranno risultati
var subjectNameControl = document.getElementById("subName");
var subjectMinCFUvalue = document.getElementById("minCFUvalue");
var subjectMaxCFUvalue = document.getElementById("maxCFUvalue");
var subjectMinCFUcontrol = document.getElementById("minCFUcheck");
var subjectMaxCFUcontrol = document.getElementById("maxCFUcheck");

// Controlli sul nome del documento
// NB: in PHP si ammette sia Titolo e Sottotitolo nulli
var documentTitleControl = document.getElementById("docTitle");
var documentSubtitleControl = document.getElementById("docSubtitle");

// Controlli sul proprietario del documento
var userNameControl = document.getElementById("userName");
var userMailControl = document.getElementById("userMail");

/**
 * Effettua una fetch per ricavare tutti i documenti che rispettano i criteri di ricerca
 */
function retrieveDocumentsByTextField(){
      let fetchArguments = prepareFetchArgumentsText();
      
      return fetch('php/document/retrieval/byText.php?' + fetchArguments)
      .then(response => response.json())
      .then(data => {

            // Array vuoto di documenti
            let documents = [];

            // Creo l'array di document utilizzando la classe apposita
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
      .catch(error => {
            console.error('Errore nella richiesta fetch: ' + error);
            return false;
      });
}

/**
 * Funzione di utilità per preparare gli argomenti da passare alla richiesta PHP
 */
function prepareFetchArgumentsText(){
      // array per contenere tutti i parametri di ricerca da passare alla fetch
      let argsArray = [];

      // Testo
      let text = subjectNameTextField.value;
      // Si rimuovono spazi iniziali
      text = text.trim();
      // Sostituzione di tutti gli spazi( anche multipli) con % per la ricerca LIKE in SQL
      text = text.replace(/ +/g, '%');
      // ricerca si fa solo sui lowercase per evitare problemi
      text = text.toLowerCase();

      argsArray.push(["text", text]);

      // Materia
      if(subjectNameControl.checked)
            argsArray.push(["subName", 1]);
      let minCFU = parseInt(subjectMinCFUvalue.innerHTML);
      let maxCFU = parseInt(subjectMaxCFUvalue.innerHTML);
      if(subjectMinCFUcontrol.checked)
            argsArray.push(["minCFU", minCFU]);
      if(subjectMaxCFUcontrol.checked)
            argsArray.push(["maxCFU", maxCFU]);

      // Documento
      if(documentTitleControl.checked)
            argsArray.push(["docTitle", 1]);
      if(documentSubtitleControl.checked)
            argsArray.push(["docSubtitle", 1]);

      // Proprietario
      if(userNameControl.checked)
            argsArray.push(["userName", 1]);
      if(userMailControl.checked)
            argsArray.push(["userMail", 1]);

      // https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams/URLSearchParams
      return new URLSearchParams(argsArray).toString();
}
