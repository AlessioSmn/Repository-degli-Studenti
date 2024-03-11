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

      <section class="search-method">
            <span>Scegli un metodo di ricerca</span>
            <div id="search-method-options-container" class="search-method-options-container text">
                  <div onclick="displaySearchMode('subject')">MATERIA</div>
                  <div onclick="displaySearchMode('text')">TESTO</div>
            </div>
      </section>

      <section>
            <span>Scegli un metodo di ricerca:</span><br>
            <input type="radio" name="searchMode" id="sbSubject" onclick="displaySearchMode('subject')">
            <label for="sbSubject">per materia singola</label><br>

            <input type="radio" name="searchMode" id="sbTextString" onclick="displaySearchMode('text')" checked>
            <label for="sbTextString">per nome</label><br>
      </section>

      <!-- Ricerca per materia specifica -->
      <section id="searchBySubject" style="display:none;">
            <label id="AREA">Area:</label>
            <code>da inserire nel database, livello superiore a degreecourse</code>
            <br/>
                  
            <label for="degree_selector">Corso di studi:</label>
            <select id="degree_selector" name="degree_selector" onchange="retrieveSubjectByDegree()" required style="width:400px;">
            </select>
            <br/>

            <label for="subject_selector">Materia:</label>
            <select id="subject_selector" name="subject_selector" type="text" list="subject" required style="width:400px;">
            </select>
            <br/>
                  
            <!-- <button type="submit" onclick="showDocuments()">Cerca</button> -->
            <button type="submit" onclick="retrieveDocumentsBySubject()">Cerca</button>
      </section>

      <!-- Ricerca per nome della materia -->
      <section id="searchByTextString" style="display:block;">
            <form onsubmit="return false;">
                  <label for="mainText">Testo: </label>
                  <input id="mainText" name="mainText" type="text" placeholder="es: analisi" onkeydown="onTextEntered()">
                  <br>

                  <!-- <button onclick="searchDocumentsByTextString()">Cerca</button> -->
                  <button onclick="retrieveDocumentsByTextField()">Cerca</button>
                  <br>
                  <button id="subjectFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('subject')">Apri subject</button>
                  <button id="documentFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('document')">Apri doc</button>
                  <button id="userFieldsetOpen" type="button" onclick="OpenSearchNameFieldset('user')">Apri user</button>

                  <fieldset id="subjectFieldset" style="display:none;" disabled>
                        <legend>Materia</legend>
                        <label for="subName">Cerca per nome della materia</label>
                        <input id="subName" type="checkbox" onclick="subjectNameChanged()" checked>
                        <br>
                        <label for="minCFUcheck">Limite minimo di CFU: </label>
                        <input id="minCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('min')">
                        <div id="minCFUcontainer" style="display: none;">
                              <button onclick="checkBoxChanged(-1, 'min')">-</button>
                              <label id="minCFUvalue">6</label>
                              <button onclick="checkBoxChanged(+1, 'min')">+</button>
                        </div>
                        <br>
                        <label for="maxCFUcheck">Limite massimo di CFU: </label>
                        <input id="maxCFUcheck" type="checkbox" onchange="toggleLabelCFUvisibility('max')">
                        <div id="maxCFUcontainer" style="display: none;">
                              <button onclick="checkBoxChanged(-1, 'max')">-</button>
                              <label id="maxCFUvalue">12</label>
                              <button onclick="checkBoxChanged(+1, 'max')">+</button>
                        </div>
                        <button type="button" onclick="CloseSearchNameFieldset('subject')" class="closeFieldset">X</button>
                  </fieldset>
                  <fieldset id="documentFieldset" style="display:none;" disabled>
                        <legend>Documento</legend>
                        <label for="docTitle">Cerca per titolo del documento</label>
                        <input id="docTitle" type="checkbox" onclick="docTitleChanged()" checked>
                        <br>
                        <label for="docSubtitle">Cerca per sottotitolo del documento</label>
                        <input id="docSubtitle" type="checkbox" onclick="docSubtitleChanged()">
                        <button type="button" onclick="CloseSearchNameFieldset('document')" class="closeFieldset">X</button>
                  </fieldset>
                  <fieldset id="userFieldset" style="display:none;" disabled>
                        <legend>Autore</legend>
                        <label for="userName">Cerca per nome dell'autore</label>
                        <input id="userName" type="checkbox" onclick="userNameChanged()">
                        <br>
                        <label for="userMail">Cerca per mail dell'autore</label>
                        <input id="userMail" type="checkbox" onclick="userMailChanged()">
                        <button type="button" onclick="CloseSearchNameFieldset('user')" class="closeFieldset">X</button>
                  </fieldset>
            </form>
      </section>

      <section>
            <select id="documentOrder" onchange="changeFieldOrder()">
                  <option value="download">Numero di download</option>
                  <option value="doc">Titolo del documento</option>
                  <option value="sub">Nome della materia</option>
                  <option value="usrName">Nome dell'autore</option>
                  <option value="usrMail">Mail dell'autore</option>
                  <option value="up">Data di caricamento</option>
                  <option value="lastMod">Ultima modifica</option>
            </select>
            <button id="orderButton" onclick="flipOrder()" style="padding:0px; width:30px; height:30px; text-align:center; border-radius: 50%;">&#11205;</button>
      </section>
      <button onclick="reOrderDocuments('Download', true)">REORDER by download asc</button>
      <button onclick="reOrderDocuments('Download', false)">REORDER by download desc</button>
      <button onclick="TEST_RIORDINA_JS(1)">title, true</button>
      <button onclick="TEST_RIORDINA_JS(2)">title, false</button>
      <button onclick="TEST_RIORDINA_JS(3)">uploadDate, true</button>
      <button onclick="TEST_RIORDINA_JS(4)">uploadDate, false</button>
      <button onclick="TEST_RIORDINA_JS(5)">donwloads, true</button>
      <button onclick="TEST_RIORDINA_JS(6)">donwloads, false</button>
      <button onclick="TEST_RIORDINA_JS(7)">id, true</button>
      <button onclick="TEST_RIORDINA_JS(8)">id, false</button>
      <section id="documentVisualizer">
            <!-- -->
      </section>
      
      <div id="docPopupContainerMask" class="doc-popup-container-mask" onclick="closePopup()" ></div>
      <div id="docPopupContainer" class="doc-popup-container">
            <button onclick="closePopup()" class="doc-popup-close">&#11199;</button>
            <h1 id="docFrameTitle"></h1>
            <iframe id="docFrame" frameborder="0"></iframe>
      </div>
      
      <footer>footer</footer>

      <!-- Document class -->
      <!-- sortDocuments() -->
      <script src="js/document/document.js"></script>
      
      <!-- populateWithDocuments() -->
      <script src="js/document/display.js"></script>

      <!-- documentVisualizerBlock() -->
      <script src="js/document/visualize/blocks.js"></script>

      <!-- retrieveDocumentsBySubject() -->
      <script src="js/document/retrieve/bySubject.js"></script>

      <!-- retrieveDocumentsByTextField() -->
      <script src="js/document/retrieve/byText.js"></script>

      <script>
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
      </script>

      <!-- DEPRECATED -->
      <!-- <script src="js/searchFunctions/searchBySubject.js"></script> -->
      <!-- <script src="js/searchFunctions/searchByTextField.js"></script> -->
      <!-- <script src="js/searchFunctions/orderDocuments.js"></script> -->
      <!-- <script src="js/fillSubjectOptions.js"></script> -->
      <!-- <script src="js/documentContainer.js"></script> -->

      <script>
            let DOCUMENTS = [];
      </script>

      <script>

      let searchBySubject = document.getElementById("searchBySubject");
      let searchByText = document.getElementById("searchByTextString");
      let searchOptionsContainer = document.getElementById("search-method-options-container");
      /**
       * Funzione per alternare tra le due modalità di ricerca presenti
       * @param mode ['text' | 'subject']
       */
      function displaySearchMode(mode){
            searchBySubject.style.display = 'none';
            searchByText.style.display = 'none';
            switch (mode) {
                  case 'text':
                        searchOptionsContainer.classList.remove("subject");
                        searchOptionsContainer.classList.add("text");
                        document.getElementById("searchByTextString").style.display = 'block';
                        break;
                  case 'subject':
                        searchOptionsContainer.classList.remove("text");
                        searchOptionsContainer.classList.add("subject");
                        document.getElementById("searchBySubject").style.display = 'block';
                        break;
                  default:
                        break;
            }
      }
      function onTextEntered(){
            if (event.key === "Enter") {
                  retrieveDocumentsByTextField();
            }
      }
      function subjectNameChanged(){
            retrieveDocumentsByTextField();
      }
      function changeCFUvalue(step, id){
            // event.preventDefault();
            var value = parseInt(document.getElementById(id+"CFUvalue").innerHTML);
            var newValue = value + step;
            document.getElementById(id+"CFUvalue").innerHTML = newValue > 0 ? newValue : 0;
      }
      function checkBoxChanged(step, id){
            changeCFUvalue(step, id);
            retrieveDocumentsByTextField();
      }
      function toggleLabelCFUvisibility(id){
            var CFUcontainer = document.getElementById(id+"CFUcontainer");
            var vis = CFUcontainer.style.display;
            CFUcontainer.style.display = (vis == 'none') ? 'inline' : 'none';
            retrieveDocumentsByTextField();
      }

      function docTitleChanged(){
            // event.preventDefault();
            /*
            var docTitleControl = document.getElementById("docTitle");
            var docSubtitleControl = document.getElementById("docSubtitle");
            // impongo almeno una scelta tra titolo e sottotitolo
            if(docTitleControl.checked == false) {
                  docSubtitleControl.checked = true;
            }
            */
            retrieveDocumentsByTextField();
      }
      function docSubtitleChanged(){
            // event.preventDefault();
            /*
            var docTitleControl = document.getElementById("docTitle");
            var docSubtitleControl = document.getElementById("docSubtitle");
            // impongo almeno una scelta tra titolo e sottotitolo
            if(!docSubtitleControl.checked) {
                  docTitleControl.checked = true;
            }
            */
            retrieveDocumentsByTextField();
      }

      function userNameChanged(){
            retrieveDocumentsByTextField();
      }

      function userMailChanged(){
            retrieveDocumentsByTextField();
      }
      
      function OpenSearchNameFieldset(field){
            var fieldset = document.getElementById(field+"Fieldset");
            var openButton = document.getElementById(field+"FieldsetOpen");
            fieldset.disabled = false;
            fieldset.style.display = 'block';
            openButton.style.display = 'none';
      }
      function CloseSearchNameFieldset(field){
            var fieldset = document.getElementById(field+"Fieldset");
            var openButton = document.getElementById(field+"FieldsetOpen");
            fieldset.disabled = true;
            fieldset.style.display = 'none';
            openButton.style.display = 'inline';
      }
      var mode = document.getElementById("sbSubject");
      function changeFieldOrder(){
            if(mode.checked) retrieveDocumentsBySubject();
            else retrieveDocumentsByTextField();
      }
      var flipped = false;
      function flipOrder(){
            var orderButton = document.getElementById("orderButton");
            orderButton.innerHTML = flipped ? '&#11205;' : '&#11206;';
            flipped = !flipped;

            if(mode.checked) retrieveDocumentsBySubject();
            else retrieveDocumentsByTextField();
      }

      </script>
</body>
</html>