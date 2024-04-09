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
            container.classList.add("doc-block-container");
            
            // Titolo del documento
            container.appendChild(this.documentVisualizerBlock_title());

            // Sottotitolo del documento
            if(this.subtitle != null)
                  container.appendChild(this.documentVisualizerBlock_subtitle());

            // Autore del documento
            if(Public)
                  container.appendChild(this.documentVisualizer_standardElement(this.author, "Autore", "doc-block-owner"));

            // Materia del documento
            container.appendChild(this.documentVisualizer_standardElement(this.subject, "Materia", "doc-block-subject"));

            // Corso di laurea del documento
            container.appendChild(this.documentVisualizer_standardElement(this.degree, "Corso di studi", "doc-block-degree"));

            // Bottone per il download
            container.appendChild(this.documentVisualizer_downloadButton());

            // Bottone per l'apertura in nuova pagina
            container.appendChild(this.documentVisualizer_openNewPageButton());
            
            // Bottone per l'apertura in un popup
            if(Public)
                  container.appendChild(this.documentVisualizer_openPopupButton());

            if(!Public){
                  // Bottone per la modifica del documento
                  container.appendChild(this.documentVisualizer_updateButton());

                  // Bottone per l'eliminazione del documento
                  container.appendChild(this.documentVisualizer_deleteButton());
            }

            // Numero di download del documento
            container.appendChild(this.documentVisualizer_standardElement(this.extension, "Estensione", "doc-block-extension"));

            // Numero di download del documento
            container.appendChild(this.documentVisualizer_standardElement(this.downloads, "Downloads", "doc-block-downloads"));

            // Data di upload del documento
            container.appendChild(this.documentVisualizer_standardElement(italianDate(this.uploadDate), "Data di creazione", "doc-block-dateinfo"));

            // Data di modifica del documento
            container.appendChild(this.documentVisualizer_standardElement(italianDate(this.lastModifiedDate), "Data ultima modifica", "doc-block-dateinfo"));

            return container;
      }

      constructVisualizerCompact(Public){
            
            // Container principale del documento
            let container = document.createElement("div");

            container.setAttribute("data-open", JSON.stringify(false));

            // Container di tutte le informazioni visualizzate solo al click sul documento
            let additionalInfoContainer = document.createElement("div");
            additionalInfoContainer.classList.add("additional-info-container");

            // Visualizzazione delle informazioni aggiuntive sul click, e successiva chiusura
            container.onclick = function(){
                  if(JSON.parse(container.getAttribute("data-open"))){
                        container.classList.remove('vizualizing');
                        container.setAttribute("data-open", JSON.stringify(false));
                  }
                  else{
                        container.classList.add('vizualizing');
                        container.setAttribute("data-open", JSON.stringify(true));
                  }
            }

            // Classe del container
            container.classList.add("doc-compact-container");
            
            // Estensione del documento
            if(Public)
                  container.appendChild(this.documentVisualizerCompact_extension_title());

            // Titolo del documento
            container.appendChild(this.documentVisualizerCompact_title());
      
            // Sottotitolo del documento
            if(this.subtitle != null)
                  container.appendChild(this.documentVisualizerCompact_subtitle());

            if(Public){

                  // Autore del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.author, "Autore", "doc-compact-owner"));

                  // Materia del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.subject, "Materia", "doc-compact-subject"));

                  // Corso di laurea del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.degree, "Corso di studio", "doc-compact-degree"));


                  // Bottone per il download
                  additionalInfoContainer.appendChild(this.documentVisualizer_downloadButton());

                  // Bottone per l'apertura in nuova pagina
                  additionalInfoContainer.appendChild(this.documentVisualizer_openNewPageButton());
                  
                  // Bottone per l'apertura in un popup
                  additionalInfoContainer.appendChild(this.documentVisualizer_openPopupButton());


                  // Numero di download del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.downloads, "Downloads", "doc-compact-downloads"));

                  // Data di upload del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(italianDate(this.uploadDate), "Data di creazione", "doc-compact-dateinfo"));

                  // Data di modifica del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(italianDate(this.lastModifiedDate), "Data ultima modifica", "doc-compact-dateinfo"));
                  
            }

            else {

                  // Materia del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.subject, "Materia", "doc-compact-subject"));

                  // Corso di laurea del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.degree, "Corso di studio", "doc-compact-degree"));
                  
                  // Estensione del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.extension, "Estensione", "doc-compact-extension"));


                  // Data di upload del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(italianDate(this.uploadDate), "Data di creazione", "doc-compact-dateinfo"));

                  // Data di modifica del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(italianDate(this.lastModifiedDate), "Data ultima modifica", "doc-compact-dateinfo"));
                  
                  // Bottone per l'eliminazione del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_deleteButton());


                  // Numero di download del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_standardElement(this.downloads, "Downloads", "doc-compact-downloads"));

                  // Bottone per l'apertura in nuova pagina
                  additionalInfoContainer.appendChild(this.documentVisualizer_openNewPageButton());

                  // Bottone per la modifica del documento
                  additionalInfoContainer.appendChild(this.documentVisualizer_updateButton());
            }

            container.appendChild(additionalInfoContainer);

            return container;
      }


      /**
       * Crea un conatiner con una breve descrizione del contenuto e il contenuto / dati in sè
       * @param {String} Content Il contenuto da mostrare
       * @param {String} Info Una breve descrizione del contenuto
       * @param {String} cssClass Class css da applicare al container
       * @return {HTMLElement} Ritorna il container
       */
      documentVisualizer_standardElement(Content, Info, cssClass){
            // Container
            const elementContainer = document.createElement("p");
            elementContainer.classList.add(cssClass);

            // Informazione sul contenuto 
            if(Info.length > 0){
                  const elementInfo = document.createElement("span");
                  elementInfo.textContent = Info + ' ';
                  elementContainer.appendChild(elementInfo);
            }

            // Contenuto
            const elementContent = document.createElement("span");
            elementContent.textContent = Content;
            elementContainer.appendChild(elementContent);

            return elementContainer;
      }
            
      /**
       * Ritorna un bottone per la cancellazione del documento
       * @return {HTMLElement}
       */
      documentVisualizer_deleteButton(){
            let id = this.id;
            let ext = this.extension;
            let deleteButtonContainer = document.createElement("div");
            let deleteButton = document.createElement("button");
            deleteButton.textContent = "Elimina il documento";
            deleteButton.classList.add("doc-delete-button");
            deleteButton.onclick = function() {
                  let completeDelete = window.confirm("Vuoi eliminare questo documento?");
                  if(completeDelete)
                        deleteDocument(id, ext);
            };
            deleteButtonContainer.appendChild(deleteButton);
            return deleteButtonContainer;
      }
            
      /**
       * Ritorna un bottone per la modifica del documento
       * @return {HTMLElement}
       */
      documentVisualizer_updateButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let subtitle = this.subtitle;
            let updateButtonContainer = document.createElement("div");
            let updateButton = document.createElement("button");
            updateButton.textContent = "Modifica il documento";
            updateButton.classList.add("doc-update-button");
            updateButton.onclick = function() {
                  const updateForm = document.getElementById("updateForm");
                  
                  // Imposto i campi ai valori attuali
                  const titleInput = updateForm.querySelector("input[name='title']");
                  const oldTitleInput = updateForm.querySelector("input[name='docOldTitle']");
                  const subtitleInput = updateForm.querySelector("input[name='subtitle']");
                  const oldSubtitleInput = updateForm.querySelector("input[name='docOldSubtitle']");
                  const docId = updateForm.querySelector("input[name='docId']");
                  const docExtension = updateForm.querySelector("input[name='docExtension']");
                  titleInput.value = oldTitleInput.value = title;
                  subtitleInput.value = oldSubtitleInput.value = subtitle;
                  docId.value = id;
                  docExtension.value = ext;

                  // Titilo del documento come titolo della pagina di popup
                  const frameTitle = document.getElementById("docFrameTitle");
                  frameTitle.innerText = title;

                  // Mostro il popup e la maschera sottostante (mettendo display:block)
                  let popupContainer = document.getElementById("docPopupContainer");
                  let mask = document.getElementById("docPopupContainerMask");
                  popupContainer.classList.add("active");
                  mask.classList.add("active");

                  // Mostro il documento
                  const iframeOld = document.getElementById("docFrameOld");
                  iframeOld.src = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title + "&mode=0";

            };
            updateButtonContainer.appendChild(updateButton);
            return updateButtonContainer;
      }

      /**
       * Ritorna un bottone per il download del documento
       * @return {HTMLElement}
       */
      documentVisualizer_downloadButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let downloadButtonContainer = document.createElement("div");
            let downloadButton = document.createElement("button");
            downloadButton.textContent = "Scarica";
            downloadButton.onclick = function(){
                  let documentUrl = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title + "&mode=1";
                  window.open(documentUrl, "_blank");
            }
            downloadButtonContainer.appendChild(downloadButton);
            return downloadButtonContainer;
      }

      /**
       * Ritorna un bottone per l'apertura in nuova pagina del documento
       * @return {HTMLElement}
       */
      documentVisualizer_openNewPageButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let openButtonContainer = document.createElement("div");
            let openButton = document.createElement("button");
            openButton.textContent = "Apri il documento";
            openButton.onclick = function(){
                  let documentUrl = 'php/document/manage/downloadDocument.php?id=' + id + '&ext=' + ext + "&title=" + title+ "&mode=0";
                  window.open(documentUrl, "_blank");
            }
            openButtonContainer.appendChild(openButton);
            return openButtonContainer;
      }

      /**
       * Ritorna un bottone per l'apertura di un iframe del documento
       * @return {HTMLElement}
       */
      documentVisualizer_openPopupButton(){
            let id = this.id;
            let ext = this.extension;
            let title = this.title;
            let popupButtonContainer = document.createElement("div");
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
            popupButtonContainer.appendChild(popupButton);
            return popupButtonContainer;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il titolo del documento
       * @return {HTMLElement}
       */
      documentVisualizerBlock_title(){
            let titleElement = document.createElement("p");
            titleElement.textContent = this.title;
            titleElement.classList.add("doc-block-title");
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
            subtitleElement.classList.add("doc-block-subtitle");
            return subtitleElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il titolo del documento
       * @return {HTMLElement}
       */
      documentVisualizerCompact_title(){
            let titleElement = document.createElement("p");
            titleElement.textContent = this.title;
            titleElement.classList.add("doc-compact-title");
            return titleElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente il sottotitolo del documento
       * @return {HTMLElement|null}
       */
      documentVisualizerCompact_subtitle(){
            if(this.subtitle == null)
                  return;

            let subtitleElement = document.createElement("div");

            let elementContent = document.createElement("span");
            elementContent.innerText = this.subtitle;
            subtitleElement.appendChild(elementContent);

            subtitleElement.classList.add("doc-compact-subtitle");
            return subtitleElement;
      }

      /**
       * Ritorna un elemento HTML stilizzato contenente l'estensione del documento
       * @return {HTMLElement}
       */
      documentVisualizerCompact_extension_title(){
            let extensionElement = document.createElement("div");

            let elementContent = document.createElement("span");
            elementContent.innerText = this.extension;
            extensionElement.appendChild(elementContent);

            extensionElement.classList.add("doc-compact-extension-title");
            return extensionElement;
      }
}

/**
 * Funzione che ordina un array di documenti (documents) secondo un campo passato come parametro
 * @param {Array<Document>} documents Array di documenti
 * @param {Array<String>} field Campo secondo il quale ordinare l'array
 * @param {boolean} ascending Specifica se l'rdine dev'essere crescente (true) o decrescente (false)
 * @returns {null} Riordina l'array documents passato per riferimento
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

/**
 * Filtra l'array di Documenti secondo le estensioni inclusi nell'array
 * @param {Array<Document>} Documents Array di documenti
 * @param {Array<String>} Filters Array di estensioni
 * @returns {Array<Document>} Ritorna l'array di documenti filtrato
 */
function filterDocuments(Documents, Filters){
      let docFiltered = [];

      // Scorro tutti i documenti
      for(let doc of Documents){

            // Scorro tutte le estensioni
            for(let filter of Filters){

                  // Se il documento ha una estensione tra quelle selezionate
                  if(doc.extension == filter){
                        docFiltered.push(doc);
                        break;
                  }
            }
      }

      return docFiltered;
}

/**
 * Dato un array di documenti restituisce tutte le estensioni che compaiono
 * @param {Array<Document>} Documents Array di documenti
 * @returns {Array<String>} Ritorna un array di estensioni
 */
function getAllExtensions(Documents){
      // Set di estensioni per non avere duplicati
      let extensions = new Set();

      // Scorro tutti i documenti e aggiungo le loro estensioni
      for(let doc of Documents)
            extensions.add(doc.extension);

      // Ritorno l'array di estensioni senza duplicati
      console.log(Array.from(extensions));
      return Array.from(extensions);
}

/**
 * Popola l'elemento container con l'array di documenti passato
 * @param {Array[Document]} Documents L'array di documenti da visualizzazre
 * @param {HTMLElement} Container L'elemento che verrà popolato con i vari documenti
 * @param {String} Type Il tipo di visualizzazione da impostare [ 'block' | 'compact' ]
 * @param {boolean} Public Indica se i documenti sono mostrati per la pagina di ricerca pubblica o per quella personale
 */
function visualizeDocuments(Documents, Container, Type, Public){

      // Pulisco il container da eventuali elementi precedenti
      Container.innerHTML = "";

      // Itero sull'array di documenti
      for(let doc of Documents)

            // Costruisco un elemento per ogni documento e lo appendo al container
            Container.appendChild(doc.constructVisualizer(Type, Public));
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
            case 0: return "Gennaio";
            case 1: return "Febbraio";
            case 2: return "Marzo";
            case 3: return "Aprile";
            case 4: return "Maggio";
            case 5: return "Giugno";
            case 6: return "Luglio";
            case 7: return "Agosto";
            case 8: return "Settembre";
            case 9: return "Ottobre";
            case 10: return "Novembre";
            case 11: return "Dicembre";
            default: return "---";
      }
}
