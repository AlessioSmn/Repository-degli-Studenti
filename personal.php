<?php 
$prevDir = "";
$pageName = "personal.php";
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
      <link rel="stylesheet" type="text/CSS" href="css/pageindex.css">
      <link rel="stylesheet" type="text/CSS" href="css/form.css">
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

      <!-- retrievePersonalDocuments() -->
      <script src="js/document/retrieve/personal.js"></script>

      <!-- deleteDocumet() -->
      <script src="js/document/update/delete.js"></script>

      <!-- modifyDocument() -->
      <script src="js/document/update/modify.js"></script>

      <!-- changeOptionInToggleOptions() -->
      <script src="js/toggleElement.js"></script>
      
</head>
<body onload="retrieveAndDisplayPersonalDocuments()">
      <header>
            <h1>Area personale</h1>
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
                        <a href="#" class="navbar-dropdown-option current-page">Documenti</a>
                        <a href="uploaddocument.php" class="navbar-dropdown-option">Upload</a>
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element"><div><span>Cerca</span></div></a>
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

      <!-- Tipo di visualizzazione -->
      <section id="visualizationMode">
            <span>Scegli un metodo di visualizzazione</span>
            <div id="visualization-types-options-container" class="switch-option-container n2 option-2-selected">
                  <div onclick="changeVisualizationType(this, 1)" class="switch-option n2"><img src="media/.png/blocco.png"></div>
                  <div onclick="changeVisualizationType(this, 2)" class="switch-option n2"><img src="media/.png/lista.png"></div>
            </div>
      </section>

      <!-- Visualizzazione dei documenti -->
      <section id="documentVisualizer">
            <!-- documenti -->
      </section>

      <!-- Indici di pagina -->
      <div class="page-index-container">
            <div class="page-index-element shifter" onclick="previousPage()">&#11207;</div>
            <div id="page-index-container" class="page-index-container"></div>
            <div class="page-index-element shifter" onclick="nextPage()">&#11208;</div>
      </div>
      
      <!-- Maschera e container per la visualizzazione in popup -->
      <section class="popup-section">
            <!-- Aggiungo la closePopup() anche alla maschera così che si possa chiudere il popup premendo sullo sfondo oscurato -->
            <div id="docPopupContainerMask" class="doc-popup-container-mask" onclick="closePopup()" ></div>
            <div id="docPopupContainer" class="doc-popup-container personal">
                  <button onclick="closePopup()" class="doc-popup-close">&#11199;</button>
                  <h1 id="docFrameTitle"></h1>
                  <form id="updateForm" method="post" enctype="multipart/form-data" onsubmit="modifyDocument(event)">
                        <div><span>Titolo</span><input name="title" type="text" placeholder="" required/></div>
                        <div><span>Sottotitolo</span><input name="subtitle" type="text" placeholder=""/></div>
                        <div><span>Nuovo file</span><input name="newfile" type="file" onchange="visualizeNewDocumentUploaded(this)" id="newFileInput"/></div>
                        <input type="hidden" name="docId">
                        <input type="hidden" name="docExtension">
                        <input type="hidden" name="docOldTitle">
                        <input type="hidden" name="docOldSubtitle">
                        <button type="reset">Reset</button>
                        <button type="submit">Submit</button>
                  </form>
                  <iframe id="docFrameOld" frameborder="0"></iframe>
                  <iframe id="docFrameNew" frameborder="0"></iframe>
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

      <!-- PageHandler class -->
      <!-- visualizePreviousBlock() -->
      <!-- visualizeNextBlock() -->
      <script src="js/document/pageSubdivision/pageHandling.js"></script>

      <script>

      // Array dei documenti attualmente visualizzati
      let DOCUMENTS = [];
      let DOC_SLICE = [];

      let blockDimensionStandard = 16;

      let pageHandler = new PageHandler(document.getElementById("page-index-container"));

      function retrieveAndDisplayPersonalDocuments(){
            retrievePersonalDocuments().then(docs => {
                  if (docs === false)
                        return;

                  DOCUMENTS = docs;

                  // 2) Ordino l'array dei documenti
                  sortDocuments(DOCUMENTS, 'downloads', false);

                  // 3) Mostro solo il primo blocco
                  DOC_SLICE = pageHandler.firstVisualization(DOCUMENTS, blockDimensionStandard);

                  visualizeDocuments(
                        DOC_SLICE, 
                        document.getElementById("documentVisualizer"),
                        VisualizationType, 
                        false
                  );
            });
      }
      

      function nextPage(){
            DOC_SLICE = pageHandler.visualizeNextBlock();
            if(DOC_SLICE === false)
                  return;

            visualizeDocuments(
                  DOC_SLICE, 
                  document.getElementById("documentVisualizer"),
                  VisualizationType, 
                  false
            );

            // Riporto l'utente in cima alla lista di documenti
            const documentVisualization = document.getElementById('visualizationMode');
            documentVisualization.scrollIntoView({ behavior: 'smooth', block: 'start'  });
      }
      function previousPage(){
            DOC_SLICE = pageHandler.visualizePreviousBlock();
            if(DOC_SLICE === false)
                  return;
            
            visualizeDocuments(
                  DOC_SLICE, 
                  document.getElementById("documentVisualizer"),
                  VisualizationType, 
                  false
            );

            // Riporto l'utente in cima alla lista di documenti
            const documentVisualization = document.getElementById('visualizationMode');
            documentVisualization.scrollIntoView({ behavior: 'smooth', block: 'start'  });
      }
            
      /* Tipo di visualizzazione dei documenti */

      const VISUALIZATION_BLOCK     = 'block';
      const VISUALIZATION_COMPACT   = 'compact';
      const visualizationTypeContainer = document.getElementById("visualization-types-options-container");
      let VisualizationType = VISUALIZATION_COMPACT; // di default inizio con quella compatta
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
                        document.getElementById("documentVisualizer"),
                        VisualizationType, 
                        false
                  );
      }

      
      /* Popup per la visualizzazione in pagina dei documenti */
      
      function closePopup() {

            // Disattivo il popup e la maschera sottostante (la classe css che mette display:block)
            let popupContainer = document.getElementById("docPopupContainer");
            let mask = document.getElementById("docPopupContainerMask");
            popupContainer.classList.remove("active");
            mask.classList.remove("active");

            // Rimuovo il documento dal frame
            let iframeOld = document.getElementById("docFrameOld");
            iframeOld.src = "";
            let iframeNew = document.getElementById("docFrameNew");
            iframeNew.src = "";

            let frameTitle = document.getElementById("docFrameTitle");
            frameTitle.innerText = "";
      }

      function visualizeNewDocumentUploaded(input){
            /*
            let file = input.files[0];
            let reader = new FileReader();
            let iframe = document.getElementById('docFrameNew');

            reader.onload = function(event) {
                  iframe.src = event.target.result;
            };

            reader.readAsDataURL(file);
            */
      }

      </script>
</body>
</html>