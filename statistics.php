<?php 
$prevDir = "";
$pageName = "statistics.php";
include "php/logControl/loginControl.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
      <title>Progetto PWEB</title>
      <link rel="stylesheet" type="text/CSS" href="css/themes/light.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
      <link rel="stylesheet" type="text/CSS" href="css/form.css">
      <link rel="stylesheet" type="text/CSS" href="css/statistics.css">
      <link rel="stylesheet" type="text/CSS" href="css/toggle_element.css">
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">
      <script src="js/theme/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>
      <style>
            .form-grid-data-row{
                  margin-top: 20px;
                  height: 50px;
            }
            .form-grid-data-row > *:nth-child(2) {
                  height: 100%;
            }
      </style>
</head>
<body onload="pageLoad()">
      <header>
            <h1>Statistiche</h1>
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
            <a href="search.php" class="navbar-main-element"><div><span>Cerca</span></div></a>
            <a href="#" class="navbar-main-element current-page"><div><span>Statistiche</span></div></a>
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

      <!-- Scelta del grafico da mostrare -->
      <section class="form-grid graph-options">

            <!-- Selezione del campo di ordinamento -->
            <div class="form-grid-data-row">
                  <label for="selection-order">Campo di ordinamento</label>
                  <div id="selection-order" name="selection-order" class="switch-option-container n2 option-1-selected">
                        <div class="switch-option n2" onclick="changeOrder(this, 1)">Download</div>
                        <div class="switch-option n2" onclick="changeOrder(this, 2)">Upload</div>
                  </div>
            </div>

            <!-- Selezione del target -->
            <div class="form-grid-data-row">
                  <label for="selection-target">Soggetto del grafico</label>
                  <div id="selection-target" name="selection-target" class="switch-option-container n3 option-3-selected">
                        <div class="switch-option n3" onclick="changeTarget(this, 1)">Corso di laurea</div>
                        <div class="switch-option n3" onclick="changeTarget(this, 2)">Materie</div>
                        <div class="switch-option n3" onclick="changeTarget(this, 3)">Utenti</div>
                  </div>
            </div>

            <!-- Selezione del gruppo -->
            <div class="form-grid-data-row">
                  <label for="selection-group">Raggruppamento</label>
                  <div id="selection-group" name="selection-group" class="switch-option-container n3 option-1-selected">
                        <div class="switch-option n3" onclick="changeGroup(this, 1)">Tutti</div>
                        <div class="switch-option n3" onclick="changeGroup(this, 2)">Per un dato corso di laurea</div>
                        <div class="switch-option n3" onclick="changeGroup(this, 3)">Per una data materia</div>
                  </div>
            </div>

            <!-- Selezione corso di laurea di selezione -->
            <div id="selection-degree" class="form-grid-data-row" style="display:none">
                  <label for="selection-degree">Corso di studi</label>
                  <div name="selection-degree" class="switch-option-container">
                        <select id="degree_selector" onchange="degreeSelected()" class="fill">
                        </select>
                  </div>
            </div>

            <!-- Selezione della materia di selezione -->
            <div id="selection-subject" class="form-grid-data-row" style="display:none">
                  <label for="selection-subject">Materia</label>
                  <div name="selection-subject" class="switch-option-container">
                        <select id="subject_selector" onchange="subjectSelected()" class="fill">
                        </select>
                  </div>
            </div>
      </section>

      <section id="graphContainer" class="graph-container">
            <!-- graph -->
      </section>

      <!-- Sezione precaricata con un'immagine da mostrare quando non ci sono risultati -->
      <section id="no-result" class="no-result">
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
                  <img class="company-logo" id="footerUnipiLogo" src="media/.ico/cherubino_white.ico">
            </div>
      </footer>

      <script src="js/stats/statistics.js"></script>

      <!-- retrieveDegrees() -->
      <script src="js/degree/retrieve.js"></script>

      <!-- retrieveSubjectByDegree() -->
      <script src="js/subject/retrieveByDegree.js"></script>

      <!-- changeOptionInToggleOptions() -->
      <script src="js/toggleElement.js"></script>

      <script>

            const statsController = new Statistics(document.getElementById("graphContainer"), document.getElementById("no-result"));

            let Target = 3;
            let Group = 1;
            let Order = 1;

            const selectionTarget = document.getElementById("selection-target");
            const selectionGroup = document.getElementById("selection-group");
            const selectionOrder = document.getElementById("selection-order");

            const selectionDegree = document.getElementById("selection-degree");
            const degree_selector = document.getElementById("degree_selector");
            const selectionSubject = document.getElementById("selection-subject");
            const subject_selector = document.getElementById("subject_selector");

            /* 
             * Cambia il target del grafico 
             * @param {HTMLElement} CallerElement Elenento chiamante
             * @param {Number} TargetSelected Target selezionato (1, 2, ...)
             */
            function changeTarget(CallerElement, TargetSelected){
                  if(TargetSelected == Target)
                        return;

                  // Imposto il nuovo target
                  Target = TargetSelected;

                  // Aggiorno la classe CSS per lo sfondo
                  changeOptionInToggleOptions(CallerElement, TargetSelected - 1);

                  // Se metto una tra Subject e Degree non posso più selezionare tutti i gruppi presenti
                  // Per come ho ordinato i target ed i gruppi un target X (indice) può essere raggruppato
                  // solo per gruppi con indice Y <= X
                  // Quindi i gruppi rimanenti avranno width = ( 100 / X ) %
                  let groupOptions = Array.from(selectionGroup.children);
                  let partedWidth = (100 / Target) + '%';

                  // Imposto i primi X elementi con partedWidth
                  for(let i = 1; i <= Target; i++){
                        let option = groupOptions[i - 1];
                        option.style.width = partedWidth;
                  } 
                  
                  // Imposto i rimanenti con width = 0
                  for(let i = Target + 1; i <= 3; i++){
                        let option = groupOptions[i - 1];
                        option.style.width = '0';
                  }

                  // Cancello la classe che indica il numero di opzioni ( n[Numero] ), la scambio con la nuova
                  let classes = selectionGroup.classList;
                  for(let cssClass of classes) 
                        if (cssClass.match(/^n\d+$/))
                              selectionGroup.classList.replace(cssClass, 'n' + Target);
                              
                  // Se l'indice di gruppo va oltre TargetSelected lo resetto a 1
                  if(Group > Target){
                        Group = 1;                  
                        let classes = selectionGroup.classList;
                        for(let cssClass of classes) 
                              if (cssClass.match(/^option-\d+-selected$/))
                                    selectionGroup.classList.replace(cssClass, 'option-' + Group + '-selected');
                  }

                  // Se target < 3 (ossia non è utenti, evito la selezione per materia)
                  if(Target < 3)
                        selectionSubject.style.display = 'none';

                  // Se target < 3 (ossia è corsi, evito anche la selezione per materie)
                  if(Target < 2)
                        selectionDegree.style.display = 'none';

                  // Aggiusto la classe css anche del gruppo

                  // Richiedo le statistiche
                  retrieveStatisticsByCurrentSettings();
            }

            /* 
             * Cambia il gruppo del target
             * @param {HTMLElement} CallerElement Elenento chiamante
             * @param {Number} SelectedGroup Gruppo selezionato (1, 2, ...) 
             */
            function changeGroup(CallerElement, SelectedGroup){
                  if(SelectedGroup == Group)
                        return;

                  // Imposto il nuovo gruppo
                  Group = SelectedGroup;

                  // Aggiorno la classe CSS
                  changeOptionInToggleOptions(CallerElement, SelectedGroup - 1);

                  // A seconda del gruppo faccio cose diverse
                  switch(Group){

                        // All -> posso direttamente richiedere le statistiche
                        case 1: {
                              selectionDegree.style.display = 'none';
                              degree_selector.selectedIndex = 0;
                              selectionSubject.style.display = 'none';
                              subject_selector.selectedIndex = 0;
                              subject_selector.disabled = true;
                              retrieveStatisticsByCurrentSettings();
                              return;
                        }

                        // Degree -> mostro solo la selezione delle materie
                        case 2: {
                              selectionDegree.style.display = 'flex';
                              selectionSubject.style.display = 'none';
                              subject_selector.selectedIndex = 0;
                              return;
                        }

                        // Degree -> mostro entrambe le selezioni
                        case 3: {
                              selectionDegree.style.display = 'flex';
                              selectionSubject.style.display = 'flex';
                              return;
                        }
                  }
                  
            }

            /* 
             * Cambia l'ordinamento del grafico tra Downloads e Uploads 
             * @param {HTMLElement} CallerElement Elenento chiamante
             * @param {Number} OrderSelected Ordine selezionato (1, 2, ...)
             */
            function changeOrder(CallerElement, SelectedOrder){
                  if(SelectedOrder == Order)
                        return;

                  // Imposto il nuovo ordine
                  Order = SelectedOrder;

                  // Aggiorno la classe CSS
                  changeOptionInToggleOptions(CallerElement, SelectedOrder - 1);

                  // Riordino il grafico
                  statsController.changeOrder(Order == 1);
            }

            /**
             * Ottiene le statistiche scelte utlizzando la classe Statistics,
             * in base ai parametri Target e Group
             */
            function retrieveStatisticsByCurrentSettings(){
                  statsController.retrieveStatistics(
                              getTargetString(), 
                              getGroupString(), 
                              getGroupId(),
                        );
            }
            /**
             * Restituisce il corretto parametro Target da passare alla funzione Statistics::retrieveStatistics(),
             * in base alla variabile globale Target
             */
            function getTargetString(){
                  switch(Target){
                        case 1: return 'Degree';
                        case 2: return 'Subject';
                        case 3: return 'User';
                  }
                  return '';
            }
            /**
             * Restituisce il corretto parametro Group da passare alla funzione Statistics::retrieveStatistics(),
             * in base alla variabile globale Group
             */
            function getGroupString(){
                  switch(Group){
                        case 1: return 'All';
                        case 2: return 'Degree';
                        case 3: return 'Subject';
                  }
                  return '';
            }
            /**
             * Restituisce il corretto parametro GroupId da passare alla funzione Statistics::retrieveStatistics(),
             * in base alla variabile globale Group
             */
            function getGroupId(){
                  switch(Group){
                        case 1: return null;
                        case 2: return degree_selector.value;
                        case 3: return subject_selector.value;
                  }
                  return null;
            }

            /**
             * Rimuove ogni classe CSS dall'elemento Element il cui nome inizi per 'background-'
             */
            function removeBackgroundClass(Element){
                  // Elenco delle classi
                  let classes = Element.classList;

                  // lo scorro
                  for(let cssClass of classes)

                        // Se inizia con background la rimuovo
                        if (cssClass.startsWith('background-'))

                              Element.classList.remove(cssClass);
            }

            /**
             * Funzione chiamata quando viene modificata il corso di laurea selezionato
             */
            function degreeSelected(){

                  // Richiedo le materie in ogni caso per averle già mostrare nel caso
                  // in cui l'utente scelga poi il reggruppamento per materia
                  retrieveSubjectByDegree();

                  // Se il group selezionato è 2 (solo corso di studi) richiedo le statistiche
                  if(Group == 2)
                        retrieveStatisticsByCurrentSettings();
            }

            /**
             * Funzione chiamata quando viene modificata la materia selezionata
             */
            function subjectSelected(){
                  retrieveStatisticsByCurrentSettings();
            }

            function pageLoad(){

                  // Carico i corsi di laurea
                  retrieveDegrees();

                  // Carico di default la statistica degli utenti con più download
                  retrieveStatisticsByCurrentSettings();
            }
      </script>
</body>
</html>