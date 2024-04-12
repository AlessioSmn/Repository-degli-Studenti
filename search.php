<?php 
$prevDir = "";
$pageName = "search.php";
include "php/logControl/loginControl.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
      <meta charset="utf-8">
      <title>Repository studenti</title>
      <link rel="stylesheet" type="text/CSS" href="css/themes/light.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
      <link rel="stylesheet" type="text/CSS" href="css/search.css">
      <link rel="stylesheet" type="text/CSS" href="css/form.css">
      <link rel="stylesheet" type="text/CSS" href="css/pageindex.css">
      <link rel="stylesheet" type="text/CSS" href="css/toggle_element.css">
      <link rel="stylesheet" type="text/CSS" href="css/document_general.css">
      <link rel="stylesheet" type="text/CSS" href="css/document_block.css">
      <link rel="stylesheet" type="text/CSS" href="css/document_compact.css">
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">

      <!-- setTheme() -->
      <script src="js/theme/themeControl.js"></script>

      <!-- logout() -->
      <script src="js/logControl/logout.js"></script>

      <!-- retrieveDegrees() -->
      <script src="js/degree/retrieve.js"></script>

      <!-- retrieveSubjectByDegree() -->
      <script src="js/subject/retrieveByDegree.js"></script>

      <!-- changeOptionInToggleOptions() -->
      <script src="js/toggleElement.js"></script>

</head>
<body onload="retrieveDegrees()">

      <header>
            <h1>Ricerca</h1>
      </header>

      <!-- Barra di navigazione del sito -->
      <nav>
            <a href="index.php" class="navbar-main-element"><div><span>Home</span></div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Accesso<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" href="login.php">Login</a>
                        <a class="navbar-dropdown-option" href="signup.php">Registrati</a>
                        <a class="navbar-dropdown-option" onclick="logout()">Logout</a>
                  </div>
            </div>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Area personale<span>
                  <div class="navbar-dropdown-container">
                        <a href="personal.php" class="navbar-dropdown-option">Documenti</a>
                        <a href="uploaddocument.php" class="navbar-dropdown-option">Upload</a>
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="#" class="navbar-main-element current-page"><div><span>Cerca</span></div></a>
            <a href="statistics.php" class="navbar-main-element"><div><span>Statistiche</span></div></a>
            <a href="manual.html" class="navbar-main-element"><div><span>Manuale</span></div></a>
            <div class="navbar-main-element floating" onclick="logout()"><span>Logout</span></div>
            <div class="navbar-main-element navbar-dropdown-main floating">
                  <span>Tema<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" onclick="setTheme('dark')">Scuro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('grey')">Grigio</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('light')">Chiaro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('pantone')">Pantone</a>
                        <a class="navbar-dropdown-option" onclick="setTheme(CUSTOM_THEME)">Custom</a>
                  </div>
            </div>
      </nav>

      <section class="search-options">

            <div class="left-side-options">

                  <!-- Metodo di ricerca -->
                  <div>
                        <label>Scegli un metodo di ricerca</label>
                        <div id="search-method-options-container" class="switch-option-container n2 option-2-selected">
                              <div onclick="displaySearchMode(this, 1)" class="switch-option n2">MATERIA</div>
                              <div onclick="displaySearchMode(this, 2)" class="switch-option n2">TESTO</div>
                        </div>
                  </div>
            </div>

            <!-- Ricerca per materia specifica -->
            <div id="searchBySubject" style="display:none;" class="search-method form-grid">
                  <div class="form-grid-data-row">
                        <label for="degree_selector">Corso di studio:</label>
                        <select id="degree_selector" name="degree_selector" onchange="retrieveSubjectByDegree()" required> </select>
                  </div>
                  <div class="form-grid-data-row">
                        <label for="subject_selector">Materia:</label>
                        <select id="subject_selector" name="subject_selector" required disabled></select>
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button onclick="mainSearch('subject')" class="important">Cerca</button>
                  </div>
            </div>

            <!-- Ricerca per nome della materia -->
            <div id="searchByTextString" style="display:block;" class="search-method">
                  <div class="form-grid-data-row">
                        <label for="mainText">Testo: </label>
                        <input id="mainText" name="mainText" type="text" placeholder="es: analisi" onkeydown="onTextEntered(event)" style="width: 50%; height: 50px; flex: none;">
                  </div>

                  <label>Campi di ricerca</label>
                  <div class="match-options">
                        <!-- Vincoli sulla materia -->
                        <fieldset>
                              <legend>Materia</legend>
                              <div class="form-grid-data-row">
                                    <input id="subName" type="checkbox" checked>
                                    <label for="subName">Cerca per nome della materia</label>
                              </div>
                              <div class="form-grid-data-row">
                                    <input id="degName" type="checkbox">
                                    <label for="degName">Cerca per nome del corso di studio</label>
                              </div>
                        </fieldset>

                        <!-- Vincoli sull'autore -->
                        <fieldset>
                              <legend>Autore</legend>
                              <div class="form-grid-data-row">
                                    <input id="userName" type="checkbox">
                                    <label for="userName">Cerca per nome dell'autore</label>
                              </div>
                              <div class="form-grid-data-row">
                                    <input id="userMail" type="checkbox">
                                    <label for="userMail">Cerca per mail dell'autore</label>
                              </div>
                        </fieldset>

                        <!-- Vincoli sul documento -->
                        <fieldset>
                              <legend>Documento</legend>
                              <div class="form-grid-data-row">
                                    <input id="docTitle" type="checkbox" checked>
                                    <label for="docTitle">Cerca per titolo del documento</label>
                              </div>
                              <div class="form-grid-data-row">
                                    <input id="docSubtitle" type="checkbox">
                                    <label for="docSubtitle">Cerca per sottotitolo del documento</label>
                              </div>
                        </fieldset>

                        <!-- Vincoli sui CFU -->
                        <fieldset>
                              <legend>CFU</legend>
                              <div class="form-grid-data-row">
                                    <input id="minCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('min')">
                                    <label for="minCFUcheck">Imponi un limite minimo di CFU: </label>
                              </div>
                              <div id="minCFUcontainer" class="form-grid-data-row" style="display: none;">
                                    <label>Limite:</label>
                                    <div class="cfu-filter">
                                          <button onclick="changeCFUvalue(-1, 'min')">-</button>
                                          <label id="minCFUvalue">6</label>
                                          <button onclick="changeCFUvalue(+1, 'min')">+</button>
                                    </div>
                              </div>
                              <div class="form-grid-data-row">
                                    <input id="maxCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('max')">
                                    <label for="maxCFUcheck">Imponi un limite massimo di CFU: </label>
                              </div>
                              <div id="maxCFUcontainer" class="form-grid-data-row" style="display: none;">
                                    <label>Limite</label>
                                    <div class="cfu-filter">
                                          <button onclick="changeCFUvalue(-1, 'max')">-</button>
                                          <label id="maxCFUvalue">12</label>
                                          <button onclick="changeCFUvalue(+1, 'max')">+</button>
                                    </div>
                              </div>
                        </fieldset>
                  </div>

                  <div class="form-grid-bottom-rows">
                        <button onclick="mainSearch('text')" class="important">Cerca</button>
                  </div>

            </div>
      </section>

      <section class="search-results">

            <div class="left-side-options">

                  <!-- Tipo di visualizzazione -->
                  <div id="visualizationMode">
                        <label>Metodo di visualizzazione</label>
                        <div id="visualization-types-options-container" class="switch-option-container n2 option-1-selected">
                              <div onclick="changeVisualizationType(this, 1)" class="switch-option n2"><img src="media/.png/blocco.png"></div>
                              <div onclick="changeVisualizationType(this, 2)" class="switch-option n2"><img src="media/.png/lista.png"></div>
                        </div>
                  </div>

                  <!-- Ordinamento dei risultati -->
                  <label>Campo di ordinamento</label>
                  <select id="documentOrderingField" onchange="changeFieldOrder()">
                        <option value="downloads">Numero di download</option>
                        <option value="title">Titolo del documento</option>
                        <option value="subject">Nome della materia</option>
                        <option value="degree">Nome del corso di laurea</option>
                        <option value="author">Mail dell'autore</option>
                        <option value="uploadDate">Data di caricamento</option>
                        <option value="lastModifiedDate">Ultima modifica</option>
                  </select>

                  <label>Ordine dei documenti</label>
                  <button id="documentOrderAscending" onclick="flipOrder()" class="flip-order">Decrescente &#11206;</button>
                  

                  <!-- Estensione del documento -->
                  <fieldset>
                        <legend>Estensione</legend>
                        <div name="docExtention" id="docExtentionFilter">
                        </div>
                  </fieldset>
                  <button onclick="filterAndDisplayDocuments()"></button>
            </div>
            <div>
                  <!-- Visualizzazione dei documenti -->
                  <section id="documentVisualizer">
                        <!-- -->
                  </section>

                  <!-- Sezione precaricata con un'immagine da mostrare quando non ci sono risultati -->
                  <div id="no-result" class="no-result">
                  </div>

                  <!-- Indici di pagina -->
                  <div id="page-index-section" class="page-index-container" style="display:none;">
                        <div class="page-index-element shifter" onclick="previousPage()">&#11207;</div>
                        <div id="page-index-container" class="page-index-container"></div>
                        <div class="page-index-element shifter" onclick="nextPage()">&#11208;</div>
                  </div>
            </div>
      </section>

      <!-- Maschera e container per la visualizzazione in popup -->
      <section class="popup-section">
            <div id="docPopupContainerMask" class="doc-popup-container-mask" onclick="closePopup()" ></div>
            <div id="docPopupContainer" class="doc-popup-container search">
                  <button onclick="closePopup()" class="doc-popup-close">&#11199;</button>
                  <h1 id="docFrameTitle"></h1>
                  <iframe id="docFrame" frameborder="0"></iframe>
            </div>
      </section>
      
      <footer>
            <div class="left-section">
                  <span>Autore</span> <span>Alessio Simoncini</span><br>
                  <span>Materia</span> <span>Progettazione WEB</span><br>
                  <span>Codice</span> <span>080II</span>
                  <hr>
                  <span>Corso di studio</span> <span>CdS Ingegneria Informatica</span><br>
                  <span>Dipartimento</span> <span>Dipartimento di Ingegneria dell'informazione</span><br>
                  <span>Scuola</span> <span>Scuola di Ingegneria</span><br>
                  <span>Universit&agrave;</span> <span>Universit&agrave; di Pisa</span><br>
                  <span>Indirizzo</span> <address>Lungarno Pacinotti 43, 56126 Pisa</address>
            </div>
            <div class="right-section">
                  <img class="company-logo" id="footerUnipiLogo" src="media/.ico/cherubino_black.ico">
            </div>
      </footer>

      <!-- Document class -->
      <!-- sortDocuments() -->
      <script src="js/document/document.js"></script>
      
      <!-- retrieveDocumentsBySubject() -->
      <script src="js/document/retrieve/bySubject.js"></script>

      <!-- retrieveDocumentsByTextField() -->
      <script src="js/document/retrieve/byText.js"></script>

      <!-- PageHandler class -->
      <!-- visualizePreviousBlock() -->
      <!-- visualizeNextBlock() -->
      <script src="js/document/pageSubdivision/pageHandling.js"></script>

      <script>

      const documentVisualizer = document.getElementById("documentVisualizer");

      // *******************************
      // *** Metodo di ricerca
      // *******************************

      const searchBySubject = document.getElementById("searchBySubject");
      const searchByText = document.getElementById("searchByTextString");
      const searchOptionsContainer = document.getElementById("search-method-options-container");
      const extensionFilter = document.getElementById("docExtentionFilter");
      /**
       * Funzione per alternare tra le due modalità di ricerca presenti
       * @param {HTMLElement} CallerElement Elenento chiamante
       * @param {Number} SelectedMode 
       */
      function displaySearchMode(CallerElement, SelectedMode){
            
            // Cambio lo sfondo
            changeOptionInToggleOptions(CallerElement, SelectedMode - 1);

            switch (SelectedMode) {
                  case 1:
                        searchBySubject.style.display = 'block';
                        searchByText.style.display = 'none';
                        break;
                  case 2:
                        searchBySubject.style.display = 'none';
                        searchByText.style.display = 'block';
                        break;
                  default:
                        break;
            }
      }
      // Array di documenti ricavati dal server
      let DOCUMENTS = [];

      // Array di documenti filtrati secondo estensione
      let DOC_FILTERED = [];

      // Array dei documenti attualmente visualizzati
      let DOC_SLICE = [];


      let blockDimensionStandard = 12;

      let pageHandler = new PageHandler(document.getElementById("page-index-container"));

      const orderingField = document.getElementById("documentOrderingField");
      const orderingAscending = document.getElementById("documentOrderAscending");
      let ascendingOrder = true;

      const noResultSection = document.getElementById("no-result");

      // *******************************
      // *** Ricerca dei documenti
      // *******************************

      /**
       * Effettua la ricerca dei documenti, li ordina secondo l'ordinamento scelto e mostra solo il primo blocco
       * @param {string} method Il metodo di ricerca utlizzato [text | subject]
       */
      function mainSearch(method) {
            // 1) Effettuo la richiesta dei documenti
            switch(method){
                  case 'text':
                        retrieveDocumentsByTextField().then(docs => PROCESS_DOCUMENTS(docs));
                        break;

                  case 'subject':
                        retrieveDocumentsBySubject().then(docs => PROCESS_DOCUMENTS(docs));
                        break;

                  // se il metodo non è riconsciuto non faccio niente
                  default:
                        return;
            }
      }

      function PROCESS_DOCUMENTS(Documents){
            
            // Se non ci sono risultati
            if (Documents === false || Documents.length == 0){

                  // Comunico che non ci sono risultati
                  documentVisualizer.innerText = "Nessun risultato :(";

                  // Aggiungo un'immagine per far vedere che non ci sono risultati
                  noResultSection.style.display = "block";

                  // Nascondo l'indice di pagina
                  document.getElementById("page-index-section").style.display = "none";

                  // Azzero tutti gli array di documenti
                  DOCUMENTS = [];
                  DOC_FILTERED = [];
                  DOC_SLICE = [];

                  return;
            }
                     
            // Inzializzo l'array di documenti filtrato come tutti i documenti
            DOC_FILTERED = DOCUMENTS = Documents;
            
            // Torno a mostrare l'indice di pagina in maniera normale
            document.getElementById("page-index-section").removeAttribute("style");
            noResultSection.style.display = "none";

            // Popolo il select con le estensioni disponibili, tutte selezionate
            displayAllExtensions();

            // 2) Ordino l'array dei documenti
            mainOrdering();

            // 3) Mostro solo il primo blocco
            mainFirstVisualization();

            // 4) Scorro la pagina fino ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }

      function displayAllExtensions(){
            // Ricavo le estensioni di tutti i documenti ricercati
            let extentions = getAllExtensions(DOCUMENTS);

            // Pulisco l'eventuale lista di estensioni già presente
            extensionFilter.innerHTML = "";

            // Per ogni estensione creo label e checkbox
            for(let extention of extentions){
                  // Label
                  let extensionLabel = document.createElement("label");
                  extensionLabel.innerText = extention == '' ? "-" : extention;
                  extensionLabel.for = "_" + extention;
                  extensionFilter.appendChild(extensionLabel);

                  // Checkbox
                  let extentionCheckbox = document.createElement("input");
                  extentionCheckbox.type = "checkbox";
                  extentionCheckbox.value = extention;
                  extentionCheckbox.name = "_" + extention;
                  extentionCheckbox.checked = true;
                  extentionCheckbox.onchange = filterAndDisplayDocuments;
                  extensionFilter.appendChild(extentionCheckbox);
            }
      }

      function onTextEntered(event){
            if (event.key === "Enter") {
                  mainSearch('text');
            }
      }

      // *******************************
      // *** Filtro dei documenti
      // *******************************

      function filterAndDisplayDocuments(){
            // Creo un array con tutte le estensioni selezionate
            let options = Array.from(extensionFilter.querySelectorAll("input"));
            let chosenExtensions = [];
            for(let option of options)
                  if(option.checked)
                        chosenExtensions.push(option.value);

            // Filtro i documenti secondo le estensioni scelte
            DOC_FILTERED = filterDocuments(DOCUMENTS, chosenExtensions);

            // Mostro il nuovo primo blocco
            mainFirstVisualization();

            // Scorro la pagina fino ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }
      
      
      // *******************************
      // *** Ordinamento dei documenti
      // *******************************
      
      /**
       * Funzione per l'ordinamento dell'array di documenti DOCUMENTS
       */
      function mainOrdering(){
            // Nel caso dell'ordinamento per downloads (e altri campi numerici, ma è l'unico) credo sia più intuitivo invertire il senso dell'ordinamento
            let order = orderingField.value != 'downloads' ? ascendingOrder : !ascendingOrder;
            sortDocuments(
                  DOCUMENTS, 
                  orderingField.value, 
                  order
            );
      }
      function changeFieldOrder(){
            // 0) I documenti sono già presenti in DOCUMENTS

            // 1) Riordino l'array dei documenti
            mainOrdering();

            // 2) Mostro il nuovo primo blocco
            mainFirstVisualization();

            // 3) Scorro la pagina fino ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }
      function flipOrder(){
            orderingAscending.innerHTML = ascendingOrder ? 'Crescente &#11205;' : ' Decrescente &#11206;';
            ascendingOrder = !ascendingOrder;

           // 0) I documenti sono già presenti in DOCUMENTS

            // 1) Inverto l'array dei documenti
            DOC_FILTERED.reverse();

            // 2) Mostro il nuovo primo blocco
            mainFirstVisualization();

            // 3) Scorro la pagina fino ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }

      // *******************************
      // *** Tipo di visualizzazione dei documenti
      // *******************************

      const VISUALIZATION_BLOCK     = 'block';
      const VISUALIZATION_COMPACT   = 'compact';
      let VisualizationType = VISUALIZATION_BLOCK;
      let visualizationTypeContainer = document.getElementById("visualization-types-options-container");
      /*
      * Cambia il tipo di visualizzazione dei documenti
      * @param {HTMLElement} CallerElement Elenento chiamante
      * @param {Number} SelectedType 
      */
      function changeVisualizationType(CallerElement, SelectedType){
            // Per capire se l'utente ha effettivamente cambiato visualizzazione o ha nuovamente cliccato su quella corrente
            let visualizationChanged = false;
            
            // Cambio lo sfondo
            changeOptionInToggleOptions(CallerElement, SelectedType - 1);

            switch(SelectedType){
                  case 1:
                        
                        // Controllo se è stata cambiata visualizzaizone
                        if(VisualizationType != VISUALIZATION_BLOCK) visualizationChanged = true;
                        
                        // Imposto la variabile che comanda la visualizzazione
                        VisualizationType = VISUALIZATION_BLOCK;
                        break;
                  
                  case 2:
                        
                        // Controllo se è stata cambiata visualizzaizone
                        if(VisualizationType != VISUALIZATION_COMPACT) visualizationChanged = true;
                        
                        // Imposto la variabile che comanda la visualizzazione
                        VisualizationType = VISUALIZATION_COMPACT;
                        break;
                  
                  default:
                        break;
            }

            // Se l'utente ha cambiato visualizzazione e stava visualizzando dei documenti li mostro secondo il nuovo tipo di visualizzazione
            if(visualizationChanged && DOC_SLICE.length > 0)
            
                  visualizeDocuments(
                        DOC_SLICE, 
                        documentVisualizer,
                        VisualizationType, 
                        true
                  );
      }

      
      // *******************************
      // *** Scorrimento tra le pagine
      // *******************************

      /**
       * Funzione per il popolamento di una parte dei documenti, visualizzando la prima pagina
       */
      function mainFirstVisualization(){
            DOC_SLICE = pageHandler.firstVisualization(DOC_FILTERED, blockDimensionStandard);
            if(DOC_SLICE === false)
                  return;

            visualizeDocuments(
                  DOC_SLICE, 
                  documentVisualizer,
                  VisualizationType, 
                  true
            );
      }
      function nextPage(){
            DOC_SLICE = pageHandler.visualizeNextBlock();
            if(DOC_SLICE === false)
                  return;
            
            visualizeDocuments(
                  DOC_SLICE, 
                  documentVisualizer,
                  VisualizationType, 
                  true
            );

            // Riporto la pagina in cima ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }
      function previousPage(){
            DOC_SLICE = pageHandler.visualizePreviousBlock();
            if(DOC_SLICE === false)
                  return;
            
            visualizeDocuments(
                  DOC_SLICE, 
                  documentVisualizer,
                  VisualizationType, 
                  true
            );

            // Riporto la pagina in cima ai documenti
            const documentVisualization = document.getElementById('visualizationMode');
            window.scrollTo({
                  top: documentVisualization.offsetTop - 60,
                  behavior: 'smooth'
            });
      }

      /* Possibilità di scorrere le pagine utilizzando le frecce */
      document.addEventListener('keydown', function(event){
            switch(event.key){
                  case 'ArrowLeft': 
                        previousPage(); 
                        break;
                  case 'ArrowRight':
                        nextPage(); 
                        break;
            }
      });

      
      // *******************************
      // *** Popup per la visualizzazione in pagina dei documenti
      // *******************************
      
      function closePopup() {

            // Disattivo il popup e la maschera sottostante (la classe css che mette display:block)
            let popupContainer = document.getElementById("docPopupContainer");
            let mask = document.getElementById("docPopupContainerMask");
            popupContainer.classList.remove("active");
            mask.classList.remove("active");

            // Rimuovo il documento dal frame
            let iframe = document.getElementById("docFrame");
            iframe.src = "";
            
            let frameTitle = document.getElementById("docFrameTitle");
            frameTitle.innerText = "";
      }
      
      
      // *******************************
      // *** Vincoli di ricerca per CFU
      // *******************************

      function changeCFUvalue(step, id){
            let value = parseInt(document.getElementById(id + "CFUvalue").innerHTML);
            let newValue = value + step;
            document.getElementById(id + "CFUvalue").innerHTML = newValue > 0 ? newValue : 0;
      }

      function toggleLabelCFUvisibility(id){
            let CFUcontainer = document.getElementById(id + "CFUcontainer");
            let vis = CFUcontainer.style.display;
            CFUcontainer.style.display = (vis == 'none') ? 'flex' : 'none';
      }

      </script>
</body>
</html>