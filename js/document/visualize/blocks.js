/**
 * Crea un elemento HTML (un div) contenente varie informazioni sul documento per la zona personale.
 * Aggiunge le informazioni fondamentali per individuare il documento e alcuni bottoni di controllo per la modifica e cancellazione del documento.
 * Non viene posta l'informazione dell'autore e tutte le varie possibilità di visualizzazione presenti in documentVisualizerBlockPublic.
 * @param {Document} doc Il documento da mostrare
 * @return {HTMLElement}
 */
function documentVisualizerBlockPersonal(doc){
      let container = document.createElement("div");

      // Classe del container
      container.setAttribute("class", "doc-container");

      // Counter dei download
      container.setAttribute("data-doc-downloads", doc.downloads);
      
      // Titolo del documento
      container.appendChild(documentVisualizerBlock_title(doc.title));

      // Sottotitolo del documento
      if(doc.subtitle != null)
            container.appendChild(documentVisualizerBlock_subtitle(doc.subtitle));

      // Materia del documento
      container.appendChild(documentVisualizerBlock_subject(doc.subject));

      // Corso di laurea del documento
      container.appendChild(documentVisualizerBlock_degree(doc.degree));

      // Numero di download del documento
      container.appendChild(documentVisualizerBlock_downloads(doc.downloads));

      // Data di upload del documento
      container.appendChild(documentVisualizerBlock_uploadDate(doc.uploadDate));

      // Data di modifica del documento
      container.appendChild(documentVisualizerBlock_modifiedDate(doc.lastModifiedDate));

      // Bottone per la cancellazione
      container.appendChild(documentVisualizerBlock_deleteButton(doc.id, doc.extension));

      return container;
}

/**
 * Crea un elemento HTML (un div) contenente varie informazioni sul documento per la ricerca pubblica.
 * Aggiunge le informazioni fondamentali per individuare il documento e alcuni bottoni per il download, l'apertura in una nuova scheda e l'apertura in un iframe.
 * Non viene posta la possibilità di cancellazione del documento come in documentVisualizerBlockPersonal.
 * @param {Document} doc Il documento da mostrare
 * @return {HTMLElement}
 */
function documentVisualizerBlockPublic(doc){
      let container = document.createElement("div");

      // Classe del container
      container.classList.add("doc-container");
      
      // Titolo del documento
      container.appendChild(documentVisualizerBlock_title(doc.title));

      // Sottotitolo del documento
      if(doc.subtitle != null)
            container.appendChild(documentVisualizerBlock_subtitle(doc.subtitle));

      // Autore del documento
      container.appendChild(documentVisualizerBlock_owner(doc.author));

      // Materia del documento
      container.appendChild(documentVisualizerBlock_subject(doc.subject));

      // Corso di laurea del documento
      container.appendChild(documentVisualizerBlock_degree(doc.degree));

      // Bottone per il download
      container.appendChild(documentVisualizerBlock_downloadButton(doc.id, doc.extension, doc.title));

      // Bottone per l'apertura in nuova pagina
      container.appendChild(documentVisualizerBlock_openNewPageButton(doc.id, doc.extension, doc.title));
      container.appendChild(documentVisualizerBlock_openPopupButton(doc.id, doc.extension, doc.title));

      // Numero di download del documento
      container.appendChild(documentVisualizerBlock_downloads(doc.downloads));

      // Data di upload del documento
      container.appendChild(documentVisualizerBlock_uploadDate(doc.uploadDate));

      // Data di modifica del documento
      container.appendChild(documentVisualizerBlock_modifiedDate(doc.lastModifiedDate));

      return container;
}

/**
 * Ritorna un bottone per la cancellazione del documento
 * @param {Number} id L'id del documento
 * @param {string} extension Il tipo del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_deleteButton(id, extension){
      var deleteButton = document.createElement("button");
      deleteButton.textContent = "Elimina il documento";
      deleteButton.classList.add("doc-deleteButton");
      deleteButton.onclick = function(){
            fetch('php/document/manage/deleteDocument.php?id='+id+'&ext='+extension)
            .then(response => response.json())
            .then(data => {
                  if(data === true){
                        window.alert("File eliminato correttamente!");
                        location.reload();
                  }
                  else{
                        window.alert("Errore nell'eliminazione del file");
                        // In questo caso data potrebbe fornire ulteriori informazioni sul problema
                  }
            })
            .catch(error => console.error("Errore: " + error));
      }
      return deleteButton;
}

/**
 * Ritorna un bottone per il download del documento
 * @param {Number} id L'id del documento
 * @param {string} extension Il tipo del documento
 * @param {string} title Il titolo del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_downloadButton(id, extension, title){
      var downloadButton = document.createElement("button");
      downloadButton.textContent = "Scarica";
      downloadButton.onclick = function(){
            let documentUrl = 'php/document/manage/downloadDocument.php?id='+id+'&ext='+extension+"&title="+title+"&mode=1";
            window.open(documentUrl, "_blank");
      }
      return downloadButton;
}

/**
 * Ritorna un bottone per l'apertura in nuova pagina del documento
 * @param {Number} id L'id del documento
 * @param {string} extension Il tipo del documento
 * @param {string} title Il titolo del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_openNewPageButton(id, extension, title){
      var openButton = document.createElement("button");
      openButton.textContent = "Apri il documento";
      openButton.onclick = function(){
            let documentUrl = 'php/document/manage/downloadDocument.php?id='+id+'&ext='+extension+"&title="+title+"&mode=0";
            window.open(documentUrl, "_blank");
      }
      return openButton;
}

/**
 * Ritorna un bottone per l'apertura di un iframe del documento
 * @param {Number} id L'id del documento
 * @param {string} extension Il tipo del documento
 * @param {string} title Il titolo del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_openPopupButton(id, extension, title){
      var popupButton = document.createElement("button");
      popupButton.textContent = "Apri in frame";
      popupButton.onclick = function(){
            // Mostro il popup e la maschera sottostante (mettendo display:block)
            let popupContainer = document.getElementById("docPopupContainer");
            let mask = document.getElementById("docPopupContainerMask");
            popupContainer.classList.add("active");
            mask.classList.add("active");

            let iframe = document.getElementById("docFrame");
            iframe.src = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + extension + "&title=" + title + "&mode=0";

            let frameTitle = document.getElementById("docFrameTitle");
            frameTitle.innerText = title;
      }
      return popupButton;
}

/**
 * Ritorna un elemento HTML stilizzato contenente il titolo del documento
 * @param {string} title Il titolo del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_title(title){
      var titleElement = document.createElement("p");
      titleElement.textContent = title;
      titleElement.classList.add("doc-title");
      return titleElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente il sottotitolo del documento
 * @param {string} subtitle Il sottotitolo del documento
 * @return {HTMLElement|null}
 */
function documentVisualizerBlock_subtitle(subtitle){
      if(subtitle == null)
            return;

      var subtitleElement = document.createElement("p");
      subtitleElement.textContent = subtitle;
      subtitleElement.classList.add("doc-subtitle");
      return subtitleElement;
} 

/**
 * Ritorna un elemento HTML stilizzato contenente l'autore del documento
 * @param {string} owner L'autore del documento 
 * @return {HTMLElement}
 */
function documentVisualizerBlock_owner(owner){
      var ownerElement = document.createElement("p");
      ownerElement.textContent = owner;
      ownerElement.classList.add("doc-owner");
      return ownerElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente la materia del documento
 * @param {string} subject La materia del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_subject(subject){
      var subjectElement = document.createElement("p");
      subjectElement.textContent = subject;
      subjectElement.classList.add("doc-subject");
      return subjectElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente il corso di laurea del documento
 * @param {string} degree Il corso di laurea del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_degree(degree){
      var degreeElement = document.createElement("p");
      degreeElement.textContent = degree;
      degreeElement.classList.add("doc-degree");
      return degreeElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente il numero di download del documento
 * @param {Number} downloads Il numero di download del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_downloads(downloads){
      var downloadsElement = document.createElement("p");
      downloadsElement.textContent = downloads;
      downloadsElement.classList.add("doc-downloads");
      return downloadsElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente la data di upload del documento
 * @param {Date} uploadDate La data di upload del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_uploadDate(uploadDate){
      var uploadElement = document.createElement("p");
      uploadElement.textContent = uploadDate;
      uploadElement.classList.add("doc-dateinfo");
      return uploadElement;
}

/**
 * Ritorna un elemento HTML stilizzato contenente la data dell'ultima modifica del documento
 * @param {Date} modified La data di modifica del documento
 * @return {HTMLElement}
 */
function documentVisualizerBlock_modifiedDate(modifiedDate){
      var modifiedElement = document.createElement("p");
      modifiedElement.textContent = modifiedDate;
      modifiedElement.classList.add("doc-dateinfo");
      return modifiedElement;
}
  