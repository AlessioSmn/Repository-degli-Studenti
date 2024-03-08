/**
 * Costruisce un elemento div per la visualizzazione dei documenti
 * @param {bool} DML Mostra i bottoni per il controllo del documento
 * @param {int} id Identificatore (primary key) del documento
 * @param {string} extension Estensione del documento
 * @param {string} title Titolo del documento
 * @param {string} author Autore del documento
 * @param {string} subject Materia del documento
 * @param {string} degree Corso di studio del documento
 * @param {int} downloads Numero di download del documento
 * @param {Date} lastModifiedDate Numero di download del documento
 * @param {Date} uploadDate Numero di download del documento
 * @param {string} subtitle |Optional - Sottotitolo del documento
 * @returns {HTMLElement} div che contiene tutti gli elementi del documento
 */
function constructDocs(DML, id, extension, title, author, subject, degree, downloads, lastModifiedDate, uploadDate, subtitle = null){
      var newDiv = document.createElement("div");

      // newDiv.textContent = title + ((subtitle === null) ? "" : (" - " + subtitle))+ " di " + author + " - " + subject + " di " + degree;
      newDiv.setAttribute("class", "mainContainer");

      // set attributes
      newDiv.setAttribute("data-doc-title",         title);
      newDiv.setAttribute("data-doc-subtitle",      subtitle);
      newDiv.setAttribute("data-doc-subject",       subject);
      newDiv.setAttribute("data-doc-degree",        degree);
      newDiv.setAttribute("data-doc-author",        author);
      newDiv.setAttribute("data-doc-download",      downloads);
      newDiv.setAttribute("data-doc-upload",        uploadDate);
      newDiv.setAttribute("data-doc-update",        lastModifiedDate);

      // Titolo del documento
      var docTitle = document.createElement("h5");
      docTitle.textContent = title;
      docTitle.setAttribute("class", "documentTitle");
      newDiv.appendChild(docTitle);

      // Sottotitolo del documento se presente
      if(!(subtitle === null)){
            var docSubtitleDivider = document.createElement("label");
            docSubtitleDivider.textContent = " - ";
            docSubtitleDivider.setAttribute("class", "documentSubtitleDivider");
            newDiv.appendChild(docSubtitleDivider);

            var docSubtitle = document.createElement("h6");
            docSubtitle.textContent = subtitle;
            docSubtitle.setAttribute("class", "documentSubtitle");
            newDiv.appendChild(docSubtitle);
      }
      
      // Autore del documento
      var authorLabel = document.createElement("label");
      // authorLabel.innerHTML = "autore: ";
      authorLabel.setAttribute("class", "documentAuthor");
      var authorLabelItalic = document.createElement("i");
      authorLabelItalic.textContent = author;
      authorLabel.appendChild(authorLabelItalic);
      newDiv.appendChild(authorLabel);

      // Materia
      var subjectLabel = document.createElement("label");
      subjectLabel.innerHTML = subject + " - ";
      subjectLabel.setAttribute("class", "documentSubject");
      newDiv.appendChild(subjectLabel);

      // Corso di studi
      var degreeLabel = document.createElement("label");
      degreeLabel.innerHTML = degree;
      degreeLabel.setAttribute("class", "documentDegree");
      newDiv.appendChild(degreeLabel);
      newDiv.appendChild(document.createElement("br"));

      // Bottone per l'apertura in un'altra pagina
      var openButton = document.createElement("button");
      openButton.innerHTML = "Apri il documento";
      openButton.onclick = function(){
            var doc = ('php/document/manage/downloadDocument.php?id='+id+'&ext='+extension+"&title="+title+"&mode=0");
            window.open(doc, "_blank");
      }
      newDiv.appendChild(openButton);
      newDiv.appendChild(document.createElement("br"));

      // Bottone per il download
      var downloadButton = document.createElement("button");
      downloadButton.textContent = "Scarica";
      downloadButton.onclick = function(){
            var doc = ('php/document/manage/downloadDocument.php?id='+id+'&ext='+extension+"&title="+title+"&mode=1");

            let newDownloads = Number(newDiv.getAttribute("data-doc-download")) + 1;
            newDiv.setAttribute("data-doc-download", newDownloads);

            let downloadCounter = docInfo.querySelector('.downloadCounter');
            downloadCounter.innerHTML = "&#8659; &#128229; " + newDownloads;

            window.open(doc, "_blank");
      }
      newDiv.appendChild(downloadButton);
      newDiv.appendChild(document.createElement("br"));
      
      if(DML) constructDocsPersonal(newDiv, id, extension);

      else constructDocsSearch(newDiv, id, extension);

      var docInfo = document.createElement("p");
      var downloadCounter = document.createElement("span");
      downloadCounter.innerHTML = "&#8659; &#128229;" + downloads;
      downloadCounter.setAttribute("class", "downloadCounter");
      docInfo.appendChild(downloadCounter);
      docInfo.appendChild(document.createElement("br"));

      var lastMod = document.createElement("span");
      lastMod.innerHTML = "Last mod: " + italianDate(lastModifiedDate);
      lastMod.setAttribute("class", "dateInfo update");
      docInfo.appendChild(lastMod);
      docInfo.appendChild(document.createElement("br"));

      var upl = document.createElement("span");
      upl.innerHTML = "Upload: " + italianDate(uploadDate);
      upl.setAttribute("class", "dateInfo upload");
      docInfo.appendChild(upl);
      newDiv.appendChild(docInfo);

      return newDiv;
}

/**
 * Appende bottoni di modifica e cancellazione del documento
 * @param {HTMLElement} Container Elemento che contiene tutti gli elementi del documento
 * @param {int} id Identificatore (primary key) del documento
 * @param {string} extension Estensione del documento
 * @param {string} title Titolo del documento
 * @returns Appende bottoni di modifica e cancellazione del documento
 */
function constructDocsPersonal(Container, id, extension){
      // Bottone per la modifica del file
      var modifyButton = document.createElement("button");
      modifyButton.textContent = "Modifica il documento";
      Container.appendChild(modifyButton);
      Container.appendChild(document.createElement("br"));

      // Bottone per l'eliminazione del file
      var deleteButton = document.createElement("button");
      deleteButton.textContent = "Cancella il documento";
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
                  }
                  window.alert(data);
            })
            .catch(error => console.error("Errore: " + error));
      }
      Container.appendChild(deleteButton);
      Container.appendChild(document.createElement("br"));

      return Container;
}

/**
 * Appende bottoni di modifica e cancellazione del documento
 * @param {HTMLElement} Container Elemento che contiene tutti gli elementi del documento
 * @param {int} id Identificatore (primary key) del documento
 * @param {string} extension Estensione del documento
 * @returns Appende bottoni di modifica e cancellazione del documento
 */
function constructDocsSearch(Container, id, extension, title){
      // iframe per la visualizzazione del documento nella pagina
      var iframe = document.createElement("iframe");
      iframe.src="about:blank";
      iframe.setAttribute('id', 'frame_'+id);
      iframe.setAttribute('class', 'iframeDoc');
      iframe.style.height='0px';
      Container.appendChild(iframe);

      // immagine della freccia che ruota
      var visualizeButtonImage = document.createElement("img");
      visualizeButtonImage.setAttribute('class', 'visualizeButtonImage')
      visualizeButtonImage.src = "media/.png/arrow_white.png";
      visualizeButtonImage.style.transform = 'rotate(90deg)';

      // Span per il testo del bottone
      var visualizeButtonText = document.createElement("span");
      visualizeButtonText.textContent = "Mostra il PDF in frame";

      // bottone per la visualizzazione del frame
      var visualizeButton = document.createElement("button");
      visualizeButton.onclick = function(){
            if (iframe.style.height == '0px'){
                  iframe.style.height = '250px';
                  iframe.src="php/document/manage/downloadDocument.php?id="+id+"&ext="+extension+"&title="+title+"#zoom=50";
                  visualizeButtonText.textContent = "Nascondi il frame";
                  visualizeButtonImage.style.transform = 'rotate(0deg)';
            }
            else{
                  iframe.style.height = '0px';
                  iframe.src="about:blank";
                  visualizeButtonText.textContent = "Mostra il PDF in frame";
                  visualizeButtonImage.style.transform = 'rotate(90deg)';
            }
      }
      // immagine per il bottone
      visualizeButton.appendChild(visualizeButtonImage);
      visualizeButton.appendChild(visualizeButtonText);
      Container.appendChild(visualizeButton);
      Container.appendChild(document.createElement("br"));

      // div di valutazione
      var starContainer = document.createElement("div");
      starContainer.setAttribute('class', 'starContainer');

      for(let i = 5; i >= 1; i--){
            var star = document.createElement("button");
            star.setAttribute('class', 'star star'+i.toString());
            // star.setAttribute('class', 'star');
            star.innerHTML = '&#10025;';
            starContainer.appendChild(star);
      }
      Container.appendChild(starContainer);
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
            case 0: return "gen";
            case 1: return "feb";
            case 2: return "mar";
            case 3: return "apr";
            case 4: return "mag";
            case 5: return "giu";
            case 6: return "lug";
            case 7: return "ago";
            case 8: return "set";
            case 9: return "ott";
            case 10: return "nov";
            case 11: return "dic";
            default: return "---";
      }
}