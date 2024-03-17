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
      <link rel="stylesheet" type="text/CSS" href="css/themes/dark.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
      <link rel="stylesheet" type="text/CSS" href="css/search.css">
      <link rel="stylesheet" type="text/CSS" href="css/pageindex.css">
      <link rel="stylesheet" type="text/CSS" href="css/document_block.css">
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">

      <!-- setTheme() -->
      <script src="js/theme/themeControl.js"></script>

      <!-- logout() -->
      <script src="js/logControl/logout.js"></script>

      <!-- retrieveDegrees() -->
      <script src="js/degree/retrieve.js"></script>

      <!-- retrieveSubjectByDegree() -->
      <script src="js/subject/retrieveByDegree.js"></script>

</head>
<body onload="retrieveDegrees()">

      <header>
            <h1>Titolo</h1>
      </header>
      
      <!-- Barra di navigazione del sito -->
      <nav>
            <a href="index.php" class="navbar-main-element"><div>Home</div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <a href="personal.php" class="navbar-main-element"><div>Area personale</div></a>
                  <div class="navbar-dropdown-container" style="margin-top: 50px;">
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element current-page"><div>Cerca</div></a>
            <a href="login.php" class="navbar-main-element"><div>Login</div></a>
            <a href="signup.php" class="navbar-main-element"><div>Registrati</div></a>
            <a href="manual.html" class="navbar-main-element"><div>Manuale</div></a>
            <a href="documentation.php" class="navbar-main-element"><div>Doc-</div></a>
            <div class="navbar-main-element navbar-dropdown-main floating">
                  <span>Tema<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" onclick="setTheme('dark')">Scuro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('grey')">Grigio</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('light')">Chiaro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('pantone')">Pantone</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('custom')">Neon</a>
                  </div>
            </div>
            <div class="navbar-main-element floating" onclick="logout()"><span>&#11199;</span> Logout</div>
      </nav>

      <!-- Metodo di ricerca -->
      <section class="search-method-selection">
            <span>Scegli un metodo di ricerca</span>
            <div id="search-method-options-container" class="search-method-selection-options-container text">
                  <div onclick="displaySearchMode('subject')">MATERIA</div>
                  <div onclick="displaySearchMode('text')">TESTO</div>
            </div>
      </section>

      <!-- Ricerca per materia specifica -->
      <section id="searchBySubject" style="display:none;" class="search-method">

            <label for="degree_selector">Corso di studi:</label>
            <select id="degree_selector" name="degree_selector" onchange="retrieveSubjectByDegree()" required style="width:400px;">
            </select>
            <br/>

            <label for="subject_selector">Materia:</label>
            <select id="subject_selector" name="subject_selector" type="text" list="subject" required style="width:400px;">
            </select>
            <br/>
                  
            <button type="submit" onclick="mainSearch('subject')">Cerca</button>
      </section>

      <!-- Ricerca per nome della materia -->
      <section id="searchByTextString" style="display:block;" class="search-method">
            <form onsubmit="return false;">
                  <label for="mainText">Testo: </label>
                  <input id="mainText" name="mainText" type="text" placeholder="es: analisi" onkeydown="onTextEntered(event)">
                  <br>
                  <!-- 

                  <button id="subjectFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('subject')">Apri subject</button>
                  <button id="documentFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('document')">Apri doc</button>
                  <button id="userFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('user')">Apri user</button>

                  <fieldset id="subjectFieldset" style="display:none;" disabled>
                        <legend>Materia</legend>
                        <button type="button" onclick="CloseSearchNameFieldset('subject')" class="closeFieldset">X</button>
                  </fieldset>
                  <fieldset id="documentFieldset" style="display:none;" disabled>
                        <legend>Documento</legend>
                        <button type="button" onclick="CloseSearchNameFieldset('document')" class="closeFieldset">X</button>
                  </fieldset>
                  <fieldset id="userFieldset" style="display:none;" disabled>
                        <legend>Autore</legend>
                        <button type="button" onclick="CloseSearchNameFieldset('user')" class="closeFieldset">X</button>
                  </fieldset>

                  -->

                  <!-- Vincoli sulla materia -->
                  <label for="subName">Cerca per nome della materia</label>
                  <input id="subName" type="checkbox" checked>
                  <br>
                  <label for="minCFUcheck">Imponi un limite minimo di CFU: </label>
                  <input id="minCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('min')">
                  <div id="minCFUcontainer" style="display: none;">
                        <button onclick="changeCFUvalue(-1, 'min')">-</button>
                        <label id="minCFUvalue">6</label>
                        <button onclick="changeCFUvalue(+1, 'min')">+</button>
                  </div>
                  <br>
                  <label for="maxCFUcheck">Imponi un limite massimo di CFU: </label>
                  <input id="maxCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('max')">
                  <div id="maxCFUcontainer" style="display: none;">
                        <button onclick="changeCFUvalue(-1, 'max')">-</button>
                        <label id="maxCFUvalue">12</label>
                        <button onclick="changeCFUvalue(+1, 'max')">+</button>
                  </div>

                  <!-- Vincoli sull'autore -->
                  <label for="userName">Cerca per nome dell'autore</label>
                  <input id="userName" type="checkbox">
                  <br>
                  <label for="userMail">Cerca per mail dell'autore</label>
                  <input id="userMail" type="checkbox">

                  <!-- Vincoli sul documento -->
                  <label for="docTitle">Cerca per titolo del documento</label>
                  <input id="docTitle" type="checkbox" checked>
                  <br>
                  <label for="docSubtitle">Cerca per sottotitolo del documento</label>
                  <input id="docSubtitle" type="checkbox">
                  
                  <br>
                  <button onclick="mainSearch('text')">Cerca</button>
            </form>
      </section>

      <!-- Ordinamento dei risultati -->
      <section class="search-order">
            <select id="documentOrderingField" onchange="changeFieldOrder()">
                  <option value="downloads">Numero di download</option>
                  <option value="title">Titolo del documento</option>
                  <option value="subject">Nome della materia</option>
                  <option value="degree">Nome del corso di laurea</option>
                  <option value="author">Mail dell'autore</option>
                  <option value="uploadDate">Data di caricamento</option>
                  <option value="lastModifiedDate">Ultima modifica</option>
            </select>
            <button id="documentOrderAscending" onclick="flipOrder()" class="flip-order">&#11206;</button>
      </section>

      <!-- Visualizzazione dei documenti -->
      <section id="documentVisualizer">
            <!-- -->
      </section>

      <!-- Indici di pagina -->
      <section class="page-index-container">
            <div class="page-index-element shifter" onclick="previousPage()">&#11207;</div>
            <div id="page-index-container" class="page-index-container"></div>
            <div class="page-index-element shifter" onclick="nextPage()">&#11208;</div>
      </section>
      
      <!-- Maschera e container per la visualizzazione in popup -->
      <section>
            <div id="docPopupContainerMask" class="doc-popup-container-mask" onclick="closePopup()" ></div>
            <div id="docPopupContainer" class="doc-popup-container">
                  <button onclick="closePopup()" class="doc-popup-close">&#11199;</button>
                  <h1 id="docFrameTitle"></h1>
                  <iframe id="docFrame" frameborder="0"></iframe>
            </div>
      </section>
      
      <footer>footer</footer>

      <!-- Document class -->
      <!-- sortDocuments() -->
      <script src="js/document/document.js"></script>
      
      <!-- populateWithDocuments() -->
      <script src="js/document/display.js"></script>

      <!-- retrieveDocumentsBySubject() -->
      <script src="js/document/retrieve/bySubject.js"></script>

      <!-- retrieveDocumentsByTextField() -->
      <script src="js/document/retrieve/byText.js"></script>

      <!-- PageHandler class -->
      <!-- visualizePreviousBlock() -->
      <!-- visualizeNextBlock() -->
      <script src="js/document/visualize/pageHandling.js"></script>

      <script>
      

      /* Metodo di ricerca */

      let searchBySubject = document.getElementById("searchBySubject");
      let searchByText = document.getElementById("searchByTextString");
      let searchOptionsContainer = document.getElementById("search-method-options-container");
      /**
       * Funzione per alternare tra le due modalità di ricerca presenti
       * @param mode ['text' | 'subject']
       */
      function displaySearchMode(mode){
            switch (mode) {
                  case 'text':
                        searchOptionsContainer.classList.remove("subject");
                        searchOptionsContainer.classList.add("text");
                        searchBySubject.style.display = 'none';
                        searchByText.style.display = 'block';
                        break;
                  case 'subject':
                        searchOptionsContainer.classList.remove("text");
                        searchOptionsContainer.classList.add("subject");
                        searchBySubject.style.display = 'block';
                        searchByText.style.display = 'none';
                        break;
                  default:
                        break;
            }
      }


      /* Ricerca dei documenti */

      // Array dei documenti attualmente visualizzati
      let DOCUMENTS = [];
      let DOC_SLICE = [];

      let blockDimensionStandard = 10;

      let pageHandler = new PageHandler(document.getElementById("page-index-container"));

      let orderingField = document.getElementById("documentOrderingField");
      let orderingAscending = document.getElementById("documentOrderAscending");
      let ascendingOrder = true;

      /**
       * Effettua la ricerca dei documenti, li ordina secondo l'ordinamento scelto e mostra solo il primo blocco
       * @param {string} method Il metodo di ricerca utlizzato [text | subject]
       */
      function mainSearch(method) {
            // 1) Effettuo la richiesta dei documenti
            switch(method){
                  case 'text':
                        retrieveDocumentsByTextField().then(docs => {
                              if (docs === false || docs.length == 0){
                                    document.getElementById("documentVisualizer").innerText = "Nessun risultato :(";
                                    document.getElementById("page-index-container").innerText = "";
                                    return;
                              }
                              
                              DOCUMENTS = docs;

                              // 2) Ordino l'array dei documenti
                              mainOrdering();

                              // 3) Mostro solo il primo blocco
                              mainFirstVisualization();
                        });
                        break;

                  case 'subject':
                        retrieveDocumentsBySubject().then(docs => {
                              if (docs === false || docs.length == 0){
                                    document.getElementById("documentVisualizer").innerText = "Nessun risultato :(";
                                    document.getElementById("page-index-container").innerText = "";
                                    return;
                              }
                              
                              DOCUMENTS = docs;

                              // 2) Ordino l'array dei documenti
                              mainOrdering();

                              // 3) Mostro solo il primo blocco
                              mainFirstVisualization();
                        });
                        break;

                  // se il metodo non è riconsciuto non faccio niente
                  default:
                        return;
            }
      }

      function onTextEntered(event){
            if (event.key === "Enter") {
                  mainSearch('text');
            }
      }

      
      /* Ordinamento dei documenti */
      
      /**
       * Funzione per l'ordinamento dell'array di documenti DOCUMENTS
       */
      function mainOrdering(){
            // Nel caso dell'ordinamento per downloads (e altri campi numerici, ma è l'unico) credo sia più intuitivo invertira il senso dell'ordinamento
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
      }
      function flipOrder(){
            orderingAscending.innerHTML = ascendingOrder ? '&#11205;' : '&#11206;';
            ascendingOrder = !ascendingOrder;

           // 0) I documenti sono già presenti in DOCUMENTS

            // 1) Riordino l'array dei documenti
            mainOrdering();

            // 2) Mostro il nuovo primo blocco
            mainFirstVisualization();
      }

      
      /* Scorrimento tra le pagine */

      /**
       * Funzione per il popolamento di una parte dei documenti, visualizzando la prima pagina
       */
      function mainFirstVisualization(){
            DOC_SLICE = pageHandler.firstVisualization(DOCUMENTS, blockDimensionStandard);
            if(DOC_SLICE === false)
                  return;

            populateWithDocuments(
                  DOC_SLICE,        // Lista di documenti
                  'block',          // Tipo di visualizzazione ['block' | 'compact' ]
                  true              // Pubblico o privato [true -> public, false -> personal]
            );
      }
      function nextPage(){
            DOC_SLICE = pageHandler.visualizeNextBlock();
            if(DOC_SLICE === false)
                  return;
            populateWithDocuments(DOC_SLICE, 'block', true);
      }
      function previousPage(){
            DOC_SLICE = pageHandler.visualizePreviousBlock();
            if(DOC_SLICE === false)
                  return;
            populateWithDocuments(DOC_SLICE, 'block', true);
      }

      
      /* Popup per la visualizzazione in pagina dei documenti */
      
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
      
      
      /* Vincoli di ricerca per CFU */

      function changeCFUvalue(step, id){
            let value = parseInt(document.getElementById(id + "CFUvalue").innerHTML);
            let newValue = value + step;
            document.getElementById(id + "CFUvalue").innerHTML = newValue > 0 ? newValue : 0;
      }

      function toggleLabelCFUvisibility(id){
            let CFUcontainer = document.getElementById(id + "CFUcontainer");
            let vis = CFUcontainer.style.display;
            CFUcontainer.style.display = (vis == 'none') ? 'inline' : 'none';
      }

      </script>
</body>
</html>