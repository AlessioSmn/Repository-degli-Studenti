/**
 * Classe usata per memorizzare un documento
 * @param {int} id Identificatore numerico (usato nel database)
 * @param {string} title Titolo del documento
 * @param {string} subtitle Sottotitolo del documento se presente
 * @param {string} extension Estensione del file del documento
 * @param {string} author Autore del documento (Nome)
 * @param {string} subject Materia del documento
 * @param {string} degree Corso di studi del documento
 * @param {string} downloads Numero di download
 * @param {Date} lastModifiedDate Data dell'ultima modifica
 * @param {Date} uploadDate Data di upload del file
 */
class Document{
      constructor(
            id, 
            title,
            subtitle,
            extension,
            author,
            subject,
            degree,
            downloads,
            lastModifiedDate,
            uploadDate
      ){
            this.id = id;
            this.title = title;
            this.subtitle = subtitle;
            this.extension = extension;
            this.author = author;
            this.subject = subject;
            this.degree = degree;
            this.downloads = downloads;
            this.lastModifiedDate = lastModifiedDate;
            this.uploadDate = uploadDate;
      }

      /**
       * Costrusce un elemento HTML per la visualizzazione del documento
       * @param {string} Type ['block' | 'compact'] Specifica il tipo di visualizzazione da impostare
       * @param {boolean} Public Specifica se i documenti devono essere mostrati per la pagina di ricerca pubblica o quella personale
       * @return {HTMLElement} 
      */
      constructVisualizer(Type, Public){
            switch(Type){
                  case 'block':
                        return this.constructVisualizerBlock(Public);
                  case 'compact':
                        return this.constructVisualizerCompact(Public);
                  default:
                        return;
            }
      }

      constructVisualizerBlock(Public){
            
            let container = document.createElement("div");

            // Classe del container
            container.classList.add("doc-container");
            
            // Titolo del documento
            container.appendChild(this.documentVisualizerBlock_title());

            // Sottotitolo del documento
            if(this.subtitle != null)
                  container.appendChild(this.documentVisualizerBlock_subtitle());

            // Autore del documento
            if(Public)
                  container.appendChild(this.documentVisualizerBlock_owner());

            // Materia del documento
            container.appendChild(this.documentVisualizerBlock_subject());

            // Corso di laurea del documento
            container.appendChild(this.documentVisualizerBlock_degree());

            // Bottone per il download
            container.appendChild(this.documentVisualizerBlock_downloadButton());

            // Bottone per l'apertura in nuova pagina
            container.appendChild(this.documentVisualizerBlock_openNewPageButton());
            
            // Bottone per l'apertura in un popup
            if(Public)
                  container.appendChild(this.documentVisualizerBlock_openPopupButton());

            // Bottone per l'eliminazione del documento
            if(!Public)
                  container.appendChild(this.documentVisualizerBlock_deleteButton());

            // Numero di download del documento
            container.appendChild(this.documentVisualizerBlock_downloads());

            // Data di upload del documento
            container.appendChild(this.documentVisualizerBlock_uploadDate());

            // Data di modifica del documento
            container.appendChild(this.documentVisualizerBlock_modifiedDate());

            return container;
      }

      constructVisualizerCompact(Public){
            let container = document.createElement("div");
            container.classList.add("doc-container");
            container.innerText = this.title;
            return container;
      }

            
      /**
       * Ritorna un bottone per la cancellazione del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_deleteButton(){
            let id = this.id;
            let ext = this.extension;
            let deleteButton = document.createElement("button");
            deleteButton.textContent = "Elimina il documento";
            deleteButton.classList.add("doc-deleteButton");
            deleteButton.onclick = function(){
                  fetch('php/document/manage/deleteDocument.php?id=' + id + '&ext=' + ext)
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
       * @return {HTMLElement}
       */
      documentVisualizerBlock_downloadButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let downloadButton = document.createElement("button");
            downloadButton.textContent = "Scarica";
            downloadButton.onclick = function(){
                  let documentUrl = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title + "&mode=1";
                  window.open(documentUrl, "_blank");
            }
            return downloadButton;
      }

      /**
       * Ritorna un bottone per l'apertura in nuova pagina del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_openNewPageButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let openButton = document.createElement("button");
            openButton.textContent = "Apri il documento";
            openButton.onclick = function(){
                  let documentUrl = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title+ "&mode=0";
                  window.open(documentUrl, "_blank");
            }
            return openButton;
      }

      /**
       * Ritorna un bottone per l'apertura di un iframe del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_openPopupButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let popupButton = document.createElement("button");
            popupButton.textContent = "Apri in frame";
            popupButton.onclick = function(){
                  // Mostro il popup e la maschera sottostante (mettendo display:block)
                  let popupContainer = document.getElementById("docPopupContainer");
                  let mask = document.getElementById("docPopupContainerMask");
                  popupContainer.classList.add("active");
                  mask.classList.add("active");

                  let iframe = document.getElementById("docFrame");
                  iframe.src = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title + "&mode=0";

                  let frameTitle = document.getElementById("docFrameTitle");
                  frameTitle.innerText = title;
            }
            return popupButton;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il titolo del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_title(){
            let titleElement = document.createElement("p");
            titleElement.textContent = this.title;
            titleElement.classList.add("doc-title");
            return titleElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il sottotitolo del documento
       * @return {HTMLElement|null}
       */
      documentVisualizerBlock_subtitle(){
            if(this.subtitle == null)
                  return;

            let subtitleElement = document.createElement("p");
            subtitleElement.textContent = this.subtitle;
            subtitleElement.classList.add("doc-subtitle");
            return subtitleElement;
      } 

      /**
       * Ritorna un elemento HTML stilizzato contenente l'autore del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_owner(){
            let ownerElement = document.createElement("p");
            ownerElement.textContent = this.author;
            ownerElement.classList.add("doc-owner");
            return ownerElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente la materia del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_subject(){
            let subjectElement = document.createElement("p");
            subjectElement.textContent = this.subject;
            subjectElement.classList.add("doc-subject");
            return subjectElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il corso di laurea del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_degree(){
            let degreeElement = document.createElement("p");
            degreeElement.textContent = this.degree;
            degreeElement.classList.add("doc-degree");
            return degreeElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il numero di download del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_downloads(){
            let downloadsElement = document.createElement("p");
            downloadsElement.textContent = this.downloads;
            downloadsElement.classList.add("doc-downloads");
            return downloadsElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente la data di upload del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_uploadDate(){
            let uploadElement = document.createElement("p");
            uploadElement.textContent = this.uploadDate;
            uploadElement.classList.add("doc-dateinfo");
            return uploadElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente la data dell'ultima modifica del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_modifiedDate(){
            let modifiedElement = document.createElement("p");
            modifiedElement.textContent = this.lastModifiedDate;
            modifiedElement.classList.add("doc-dateinfo");
            return modifiedElement;
      }
      
}

/**
 * Funzione che ordina un array di documenti (documents) secondo un campo passato come parametro
 * @param {Array} documents Array di documenti
 * @param {string} field Campo secondo il quale ordinare l'array
 * @param {boolean} ascending Specifica se l'rdine dev'essere crescente (true) o decrescente (false)
 * @return {null} Riordina l'array documents passato per riferimento
 */
function sortDocuments(documents, field, ascending){

      documents.sort((a, b) => {

            // Se i campi hanno lo stesso valore ritorna 0
            if(a[field] == b[field])
                  return 0;

            // Sort deve ritornare -1 se a dev'essere precedente a b
            if(ascending)
                  return a[field] < b[field] ? -1 : 1;
            
            else
                  return a[field] > b[field] ? -1 : 1;

      });
}