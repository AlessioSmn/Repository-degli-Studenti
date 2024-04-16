<?php 
$prevDir = "";
$pageName = "uploaddocument.php";
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

      <!-- uploadDocument() -->
      <script src="js/document/update/upload.js"></script>
      
      <style>
            .upload-section{
                  margin: 30px 70px;
            }
      </style>
</head>
<body onload="retrieveDegrees()">
      <header>
            <h1>Upload</h1>
      </header>

      <!-- Barra di navigazione del sito -->
      <nav id="navbar">
            <div class="side-navbar-visualizer" onclick="sideNavbarToggle()">Menu</div>
            <a href="index.php" class="navbar-main-element"><div><span>Home</span></div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Accesso</span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" href="login.php">Login</a>
                        <a class="navbar-dropdown-option" href="signup.php">Registrati</a>
                        <a class="navbar-dropdown-option" onclick="logout()">Logout</a>
                  </div>
            </div>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Area personale</span>
                  <div class="navbar-dropdown-container">
                        <a href="personal.php" class="navbar-dropdown-option">Documenti</a>
                        <a href="#" class="navbar-dropdown-option current-page">Upload</a>
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element"><div><span>Cerca</span></div></a>
            <a href="statistics.php" class="navbar-main-element"><div><span>Statistiche</span></div></a>
            <a href="manual.html" class="navbar-main-element"><div><span>Manuale</span></div></a>
            <div class="navbar-main-element floating" onclick="logout()"><span>Logout</span></div>
            <div class="navbar-main-element navbar-dropdown-main floating">
                  <span>Tema</span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" onclick="setTheme('dark')">Scuro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('grey')">Grigio</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('light')">Chiaro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('pantone')">Pantone</a>
                        <a class="navbar-dropdown-option" onclick="setTheme(CUSTOM_THEME)">Custom</a>
                  </div>
            </div>
      </nav>

      <div class="page-description">
            <h3>Carica un nuovo documento</h3>
      </div>
      
      <!-- Caricamento di un nuovo documento -->
      <div class="upload-section">
            <form method="post" onsubmit="uploadDocument(event)" class="form-grid">
                  <div class="form-grid-data-row">
                        <label for="title">Titolo del documento</label>
                        <input id="title" name="title" type="text" required>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="titleError">
                        Inserisci un titolo
                  </div>
                  <div class="form-grid-data-row">
                        <label for="subtitle">Sottotitolo del documento</label>
                        <input id="subtitle" name="subtitle" type="text">
                  </div>
                  <div class="form-grid-data-row">
                        <label for="degree_selector">Corso di studio</label>
                        <!-- 
                              NOTA WARNING
                              Generato errore: 'A select element with a required attribute, and without a multiple attribute, and without a size attribute whose value is greater than 1, must have a child option element.'
                              in quanto attualmente vuoto, ma sia questo che il <select> per le materie vengono popolati dinamicamente
                        -->
                        <select id="degree_selector" name="degree_selector" onchange="retrieveSubjectByDegree()" required>
                        </select>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="degreeError">
                        Seleziona un corso di studi
                  </div>
                  <div class="form-grid-data-row">
                        <label for="subject_selector">Materia</label>
                        <select id="subject_selector" name="subject_selector" required disabled>
                        </select>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="subjectError">
                        Seleziona una materia
                  </div>
                  <div class="form-grid-data-row">
                        <label for="fileContent">Carica il tuo file</label>
                        <input type="file" id="fileContent" name="fileContent" onchange="alertExtension()" required>
                        <button id="showFileInfo" type="button" class="show-password" onclick="toggleFileInfoVisibility()"></button>
                  </div>
                  <div id="fileExtensionInfo" class="form-grid-bottom-rows input-description input-info right-side" style="display: none;">
                        <p>
                              <span>Estensioni meglio supportate:</span>
                              <ul>
                                    <li>pdf</li>
                                    <li>txt</li>
                                    <li>js</li>
                                    <li>html</li>
                                    <li>css</li>
                              </ul>
                        </p>
                        <p>
                              <span>Supporto limitato:</span>
                              <ul>
                                    <li>doc</li>
                                    <li>docx</li>
                                    <li>ppt</li>
                                    <li>pttx</li>
                              </ul>
                        </p>
                        <p>
                              <span>Rischio di corruzione del documento:</span>
                              <ul>
                                    <li>png</li>
                                    <li>jpg</li>
                                    <li>jpeg</li>
                                    <li>gif</li>
                              </ul>
                        </p>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="fileError">
                        Carica un file
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error" id="uploadError">
                        Errore del caricamento di un nuovo documento
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="submit" class="central important" onclick="displayErrors()">Carica</button>
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="reset" class="central">Azzera i campi</button>
                  </div>
            </form>
      </div>

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
                  <img alt="logo della società" class="company-logo" id="footerUnipiLogo" src="media/.ico/cherubino_black.ico">
            </div>
      </footer>

      <!-- Document class -->
      <!-- sortDocuments() -->
      <script src="js/document/document.js"></script>
      
      <!-- sideNavbarToggle() -->
      <script src="js/navbar/navbarresizing.js"></script>

      <script>
      
      const showFileInfoButton = document.getElementById("showFileInfo");
      const fileExtensionInfo = document.getElementById("fileExtensionInfo");
      function toggleFileInfoVisibility(){
            let currentVis = fileExtensionInfo.style.display;
            if(currentVis == "block"){
                  fileExtensionInfo.style.display = "none";
                  showFileInfoButton.style.backgroundImage = 'url(media/.png/hide.png)';
            }
            else{
                  fileExtensionInfo.style.display = "block";
                  showFileInfoButton.style.backgroundImage = 'url(media/.png/show.png)';
            }
      }

      const errorExtensions = ["jpg", "png", "jpeg", "gif"];
      function alertExtension(){
            // Ricavo l'estensione del file appena carictao
            let uploadedFile = document.getElementById("fileContent").files[0];
            let extension = uploadedFile.name.split('.').pop();
            window.alert(extension);

            // Controllo che non sia in quelle che danno errori
            for(let ext of errorExtensions)

                  // in tal caso mostro all'utente l'avviso
                  if(ext == extension){
                        fileExtensionInfo.style.display = "block";
                        showFileInfoButton.style.backgroundImage = 'url(media/.png/show.png)';
                        return;
                  }

      }
            
      function displayErrors(){
            let titleInput = document.querySelector('input[name="title"]');
            let titleError = document.getElementById("titleError");
            if(!titleInput.checkValidity()) titleError.style.display = 'block';
            else titleError.style.display = 'none';

            let degreeInput = document.querySelector('select[name="degree_selector"]');
            let degreeError = document.getElementById("degreeError");
            if(degreeInput.selectedIndex === 0) degreeError.style.display = 'block';
            else degreeError.style.display = 'none';

            let subjectInput = document.querySelector('select[name="subject_selector"]');
            let subjectError = document.getElementById("subjectError");
            if(subjectInput.selectedIndex === 0) subjectError.style.display = 'block';
            else subjectError.style.display = 'none';

            let fileInput = document.querySelector('input[name="fileContent"]');
            let fileError = document.getElementById("fileError");
            if(!fileInput.checkValidity()) fileError.style.display = 'block';
            else fileError.style.display = 'none';
      }
      </script>
</body>
</html>