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
      <link rel="stylesheet" type="text/CSS" href="css/themes/dark.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
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

      <!-- retrievePersonalDocuments() -->
      <script src="js/document/retrieve/personal.js"></script>

      <!-- uploadDocument() -->
      <script src="js/document/update/upload.js"></script>

      <!-- deleteDocumet() -->
      <script src="js/document/update/delete.js"></script>

      <!-- changeOptionInToggleOptions() -->
      <script src="js/toggleElement.js"></script>
      
</head>
<body onload="retrieveDegrees()">
      <header>
            <h1>area personale</h1>
      </header>
      
      <nav>
            <a href="index.php" class="navbar-main-element"><div>Home</div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <a href="personal.php" class="navbar-main-element current-page"><div>Area personale</div></a>
                  <div class="navbar-dropdown-container" style="margin-top: 50px;">
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element"><div>Cerca</div></a>
            <a href="login.php" class="navbar-main-element"><div>Login</div></a>
            <a href="signup.php" class="navbar-main-element"><div>Registrati</div></a>
            <a href="manual.html" class="navbar-main-element"><div>Manuale</div></a>
            <a href="statistics.php" class="navbar-main-element"><div>Statistiche</div></a>
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

      <!-- Tipo di visualizzazione -->
      <section class="switch-option">
            <span>Scegli un metodo di visualizzazione</span>
            <div id="visualization-types-options-container" class="switch-option-container n2 option-1-selected">
                  <div onclick="changeVisualizationType(this, 1)" class="switch-option n2">BLOCCHI</div>
                  <div onclick="changeVisualizationType(this, 2)" class="switch-option n2">LISTA</div>
            </div>
      </section>
      
      <!-- Caricamento di un nuovo documento -->
      <section>
            <form method="post" enctype="multipart/form-data" style="border-width: 5px; border-color: red; border-style: solid;" onsubmit="uploadDocument(event)"><fieldset>
                  <legend>Carica un documento</legend>
                  <span>Titolo del documento</span>
                  <input name="title" type="text" required>
                  <br>
                  <span>Carica il tuo file:</span>
                  <input type="file" name="fileContent" required>
                  <br>
                  <span>Corso di studio</span>
                  <select id="degree_selector" name="degree_selector" onchange="retrieveSubjectByDegree()" required style="width:400px;">
                  </select>
                  <br>
                  <span>Materia</span>
                  <select id="subject_selector" name="subject_selector" type="text" list="subject" required style="width:400px;">
                  </select>
                  <br>  
                  <button type="submit">Carica</button>
                  <button type="reset">azzera i campi</button>
            </fieldset></form>
      </section>

      <section id="documentVisualizer">
            <button onclick="retrieveAndDisplayPersonalDocuments()">Carica i tuoi documenti</button>
      </section>

      <div class="page-index-container">
            <div class="page-index-element shifter" onclick="previousPage()">&#11207;</div>
            <div id="page-index-container" class="page-index-container"></div>
            <div class="page-index-element shifter" onclick="nextPage()">&#11208;</div>
      </div>

      <footer>
            footer
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

      let blockDimensionStandard = 8;

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
      }
            
      /* Tipo di visualizzazione dei documenti */

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
                        document.getElementById("documentVisualizer"),
                        VisualizationType, 
                        false
                  );
      }


      </script>
</body>
</html>