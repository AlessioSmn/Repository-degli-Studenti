// File contenente varie funzioni per la visualizzazione di un elenco di documenti

/**
 * Popola l'elemento di id "documentVisualizer" con i vari documenti
 * @param {Array[Document]} documents Array di documenti da visualizzare
 * @param {string} Type ['block' | 'compact'] Specifica il tipo di visualizzazione da impostare
 * @param {boolean} Public Specifica se i documenti devono essere mostrati per la pagina di ricerca pubblica o quella personale
 */
function populateWithDocuments(documents, Type, Ascending){
      
      // Container di tutti i documenti
      let mainContainer = document.getElementById("documentVisualizer");
      mainContainer.innerHTML = "";

      for(let doc of documents){
            let documentElement = doc.constructVisualizer(Type, Ascending);
            mainContainer.appendChild(documentElement);
      }
}

/**
 * Crea un elemento HTML (un div) contenente varie informazioni sul documento passato
 * @param {Document} doc Il documento da mostrare
 * @return {HTMLElement}
 */
function constructMainContainer(doc){
      let container = document.createElement("div");

      // Classe del container
      container.setAttribute("class", "mainContainer");
      
      // Titolo del documento
      var documentTitle = document.createElement("p");
      documentTitle.textContent = doc.title;
      documentTitle.setAttribute("class", "documentTitle");
      container.appendChild(documentTitle);

      // Data di upload
      var uploadInfo = document.createElement("p");
      uploadInfo.innerHTML = "Upload: " + italianDate(doc.uploadDate);
      uploadInfo.setAttribute("class", "dateInfo upload");
      // docInfo.appendChild(uploadInfo);
      // container.appendChild(docInfo);
      container.appendChild(uploadInfo);

      // Downloads
      var downloadCounter = document.createElement("p");
      downloadCounter.innerHTML = "&#8659; &#128229;" + doc.downloads;
      downloadCounter.setAttribute("class", "downloadCounter");
      container.appendChild(downloadCounter);

      return container;
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