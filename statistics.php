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
<body>
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

      <!-- Selezione del grafico -->
      <section>
            Seleziona la statistica che vuoi visualizzare
            <div class="statistics-option-conatiner">
                  <div class="statistics-option-conatiner" value=""> Utenti con più download</div>
            </div>
      </section>
      <p>
            Corsi di laurea più attivi (più documenti caricati)
            Corsi di laurea più popolari (più download)
            Grafici con le materie più visualizzate
            Utenti più attivi (più documenti caricati)
            Utenti più popolari (più download)
            Utenti più attivi per corso di laurea
            Utenti più attivi per materie
      </p>
<!--
      <section>
            <input type="radio" name="graphMode" value="deg" id="deg" onclick="getDegreesStats('deg')">
            <label for="deg">corsi di laurea più visualizzati</label><br>

            <input type="radio" name="graphMode" value="subAll" id="subAll" onclick="getDegreesStats('subAll')">
            <label for="subAll">materie più visualizzate</label><br>

            <input type="radio" name="graphMode" value="subDeg" id="subDeg" onclick="getDegreesStats('subDeg')">
            <label for="subDeg">materie più visualizzate per corso di laurea</label><br>

            <input type="radio" name="graphMode" value="usrAct" id="usrAct" onclick="getDegreesStats('usrAct')">
            <label for="usrAct">utenti più attivi</label><br>

            <input type="radio" name="graphMode" value="usrDow" id="usrDow" onclick="getDegreesStats('usrDow')">
            <label for="usrDow">utenti più popolari</label><br>
      </section>
-->

      <section>
            <input type="radio" name="graphMode" value="deg" id="DegreeAll" onclick="statsController.retrieveStatistics('Degree', 'All')">
            <label for="DegreeAll">Corsi di laurea (All)</label><br>

            <input type="radio" name="graphMode" value="subAll" id="SubjectAll" onclick="statsController.retrieveStatistics('Subject', 'All')">
            <label for="SubjectAll">Materie (All)</label><br>

            <input type="radio" name="graphMode" value="usrAct" id="UserAll" onclick="statsController.retrieveStatistics('User', 'All')">
            <label for="UserAll">Utenti (All)</label><br>
      </section>

      <section>
            <input type="radio" name="orderingField" id="orderByDownloads" onclick="statsController.changeOrder(true)" checked>
            <label for="orderByDownloads">Dowloads</label><br>

            <input type="radio" name="orderingField" id="orderByUploads" onclick="statsController.changeOrder(false)">
            <label for="orderByUploads">Uploads</label><br>
      </section>

      <div id="graphContainer" class="graph-container">
            <!-- graph -->
      </div>
      
      <footer>footer</footer>

      <!-- getDegreesStats() -->
      <script src="js/stats/getDegreesStats.js"></script>

      <script src="js/stats/statistics.js"></script>

      <script>
            const statsController = new Statistics(document.getElementById("graphContainer"));
      </script>
</body>
</html>