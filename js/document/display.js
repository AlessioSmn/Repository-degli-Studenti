// File contenente varie funzioni per la visualizzazione di un elenco di documenti

/**
 * Popola l'elemento di id "documentVisualizer" con i vari documenti
 * @param {Array[Document]} documents Array di documenti da visualizzare
 * @param {string} Type ['block' | 'compact'] Specifica il tipo di visualizzazione da impostare
 * @param {boolean} Public Specifica se i documenti devono essere mostrati per la pagina di ricerca pubblica o quella personale
 */
function populateWithDocuments(documents, Type, Public){
      
      // Container di tutti i documenti
      let mainContainer = document.getElementById("documentVisualizer");
      mainContainer.innerHTML = "";

      for(let doc of documents){
            let documentElement = doc.constructVisualizer(Type, Public);
            mainContainer.appendChild(documentElement);
      }
}

function italianDate(DataIn){
      DataOut = "";
      let day = DataIn.getDate().toString().padStart(2, '0');
      DataOut += day + " ";

      let month = DataIn.getMonth();
      DataOut += getMonthName(month) + " ";

      let year = DataIn.getFullYear().toString();
      DataOut += year;

      return DataOut;
}

function getMonthName(monthNumber){
      switch(monthNumber){
            case 0: return "Gen";
            case 1: return "Feb";
            case 2: return "Mar";
            case 3: return "Apr";
            case 4: return "Mag";
            case 5: return "Giu";
            case 6: return "Lug";
            case 7: return "Ago";
            case 8: return "Set";
            case 9: return "Ott";
            case 10: return "Nov";
            case 11: return "Dic";
            default: return "---";
      }
}

function TEST_RIORDINA_JS(num){
      switch(num){
            case 1:sortDocuments(DOCUMENTS, 'title', true);break;
            case 2:sortDocuments(DOCUMENTS, 'title', false);break;
            case 3:sortDocuments(DOCUMENTS, 'uploadDate', true);break;
            case 4:sortDocuments(DOCUMENTS, 'uploadDate', false);break;
            case 5:sortDocuments(DOCUMENTS, 'downloads', true);break;
            case 6:sortDocuments(DOCUMENTS, 'downloads', false);break;
            case 7:sortDocuments(DOCUMENTS, 'id', true);break;
            case 8:sortDocuments(DOCUMENTS, 'id', false);break;
      }
      
      populateWithDocuments(DOCUMENTS);
}