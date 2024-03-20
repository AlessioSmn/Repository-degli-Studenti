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
      <link rel="stylesheet" type="text/CSS" href="css/themes/dark.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
      <link rel="stylesheet" type="text/CSS" href="css/statistics.css">
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">
      <script src="js/theme/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>
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
            <a href="search.php" class="navbar-main-element"><div>Cerca</div></a>
            <a href="login.php" class="navbar-main-element"><div>Login</div></a>
            <a href="signup.php" class="navbar-main-element"><div>Registrati</div></a>
            <a href="manual.html" class="navbar-main-element"><div>Manuale</div></a>
            <a href="statistics.php" class="navbar-main-element current-page"><div>Statistiche</div></a>
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

      <!-- Selezione del campo di ordinamento -->
      <section id="selection-order" class="selection order background-half-1">
            <div class="order-option" onclick="changeOrder(1)">Download</div>
            <div class="order-option" onclick="changeOrder(2)">Upload</div>
      </section>

      <!-- Selezione del target -->
      <section id="selection-target" class="selection target background-third-3">
            <div class="target-option" onclick="changeTarget(1)">Corso di laurea</div>
            <div class="target-option" onclick="changeTarget(2)">Materie</div>
            <div class="target-option" onclick="changeTarget(3)">Utenti</div>
      </section>

      <!-- Selezione del gruppo -->
      <section id="selection-group" class="selection group background-third-1">
            <div class="group-option" onclick="changeGroup(1)">Tutti</div>
            <div class="group-option" onclick="changeGroup(2)">Per un dato corso di laurea</div>
            <div class="group-option" onclick="changeGroup(3)">Per una data materia</div>
      </section>

      <!-- Selezione corso di laurea di selezione -->
      <section id="selection-degree" class="selection" style="display:none">
            <select id="degree_selector" onchange="degreeSelected()">
            </select>
      </section>

      <!-- Selezione della materia di selezione -->
      <section id="selection-subject" class="selection" style="display:none">
            <select id="subject_selector" onchange="subjectSelected()">
            </select>
      </section>

      <section id="graphContainer" class="graph-container">
            <!-- graph -->
      </section>
      
      <footer>
            footer
      </footer>

      <script src="js/stats/statistics.js"></script>

      <!-- retrieveDegrees() -->
      <script src="js/degree/retrieve.js"></script>

      <!-- retrieveSubjectByDegree() -->
      <script src="js/subject/retrieveByDegree.js"></script>

      <script>

            const statsController = new Statistics(document.getElementById("graphContainer"));

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
             */
            function changeTarget(Position){
                  if(Position == Target)
                        return;

                  // Rimuovo la vecchia classe
                  selectionTarget.classList.remove("background-third-" + Target);

                  // Imposto il nuovo target
                  Target = Position;

                  // Aggiungo la nuova classe
                  selectionTarget.classList.add("background-third-" + Target);

                  // Se metto una tra Subject e Degree non posso più selezionare tutti i gruppi presenti
                  // Per come ho ordinato i target ed i gruppi un target X (indice) può essere raggruppato
                  // solo per gruppi con indice Y <= X
                  // Quindi i gruppi rimanenti avranno width = ( 100 / X ) %
                  let groupOptions = Array.from(selectionGroup.children);
                  let partedWidth = (100 / Position) + '%';

                  // Imposto i primi X elementi con partedWidth
                  for(let i = 1; i <= Position; i++){
                        let option = groupOptions[i - 1];
                        option.style.width = partedWidth;
                  } 
                  
                  // Imposto i rimanenti con width = 0
                  for(let i = Position + 1; i <= 3; i++){
                        let option = groupOptions[i - 1];
                        option.style.width = '0';
                  }

                  // Reimposto anche la classe css del group
                  removeBackgroundClass(selectionGroup);

                  // Per avere la classe css corretta
                  let bgDivision;
                  switch(Position){
                        case 1: bgDivision = 'full'; break;
                        case 2: bgDivision = 'half'; break;
                        case 3: bgDivision = 'third'; break;
                  }
                  
                  // Se l'indice di gruppo va oltre position lo resetto a 1
                  if(Group > Position)
                        Group = 1;

                  if(Target < 3)
                        selectionSubject.style.display = 'none';

                  if(Target < 2)
                        selectionDegree.style.display = 'none';

                  // Imposto lo stile della selezione del gruppo
                  selectionGroup.classList.add("background-" + bgDivision + "-" + Group);

                  // Richiedo le statistiche
                  statsController.retrieveStatistics(getTargetString(), getGroupString());
            }

            /* 
             * Cambia il gruppo del target 
             */
            function changeGroup(Position){
                  if(Position == Group)
                        return;

                  // Rimuovo la vecchia classe
                  removeBackgroundClass(selectionGroup);

                  // Imposto il nuovo gruppo
                  Group = Position;

                  // Per avere la classe css corretta
                  let bgDivision;
                  switch(Target){
                        case 1: bgDivision = 'full'; break;
                        case 2: bgDivision = 'half'; break;
                        case 3: bgDivision = 'third'; break;
                  }
                  
                  // Aggiungo la nuova classe
                  selectionGroup.classList.add("background-" + bgDivision + "-" + Group);

                  // A seconda del gruppo faccio cose diverse
                  switch(Group){

                        // All -> posso direttamente richiedere le statistiche
                        case 1: {
                              selectionDegree.style.display = 'none';
                              selectionSubject.style.display = 'none';
                              statsController.retrieveStatistics(getTargetString(), getGroupString());
                              return;
                        }

                        // Degree -> mostro solo la selezione delle materie
                        case 2: {
                              selectionDegree.style.display = 'block';
                              selectionSubject.style.display = 'none';
                              return;
                        }

                        // Degree -> mostro entrambe le selezioni
                        case 3: {
                              selectionDegree.style.display = 'block';
                              selectionSubject.style.display = 'block';
                              return;
                        }
                  }
                  
            }

            /* 
             * Cambia l'ordinamento del grafico tra Downloads e Uploads 
             */
            function changeOrder(Position){
                  if(Position == Order)
                        return;

                  // Rimuovo la vecchia classe
                  selectionOrder.classList.remove("background-half-" + Order);

                  // Imposto il nuovo ordine
                  Order = Position;

                  // Aggiungo la nuova classe
                  selectionOrder.classList.add("background-half-" + Order);

                  // Riordino il grafico
                  statsController.changeOrder(Order == 1);
            }

            function getTargetString(){
                  switch(Target){
                        case 1: return 'Degree';
                        case 2: return 'Subject';
                        case 3: return 'User';
                  }
                  return '';
            }
            function getGroupString(){
                  switch(Group){
                        case 1: return 'All';
                        case 2: return 'Degree';
                        case 3: return 'Subject';
                  }
                  return '';
            }

            function removeBackgroundClass(Element){
                  // Elenco delle classi
                  let classes = Element.classList;

                  // lo scorro
                  for(let cssClass of classes)

                        // Se inizia con background la rimuovo
                        if (cssClass.startsWith('background-'))

                              Element.classList.remove(cssClass);
            }

            function degreeSelected(){
                  // Se il group selezionato è 2 (solo corso di studi) richiedo le statistiche
                  if(Group == 2)
                        statsController.retrieveStatistics(
                              getTargetString(), 
                              getGroupString(), 
                              degree_selector.value
                        );

                  // Altirmenti mostro le materie del corso
                  else
                        retrieveSubjectByDegree();
            }

            function subjectSelected(){
                  statsController.retrieveStatistics(
                        getTargetString(), 
                        getGroupString(),
                        subject_selector.value
                  );
            }
      </script>
</body>
</html>