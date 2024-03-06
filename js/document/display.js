// File contenente varie funzioni per la visualizzazione di un elenco di documenti

/**
 * Popola l'elemento di id "documentVisualizer" con i vari documenti
 * @param {Array[Document]} documents Array di documenti da visualizzare
 */
function populateWithDocuments(documents){
      
      // Container di tutti i documenti
      let mainContainer = document.getElementById("documentVisualizer");
      mainContainer.innerHTML = "";

      for(let doc of documents){
            let documentElement = constructMainContainer(doc);
            mainContainer.appendChild(documentElement);
      }
}

/**
 * Crea un elemento HTML (un div) contenente varie informazioni sul documento passato
 * @param {Document} doc Il documento da mostrare
 * @returns {HTMLElement}
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
      console.log(DOCUMENTS.length);  
      
      populateWithDocuments(DOCUMENTS);
}