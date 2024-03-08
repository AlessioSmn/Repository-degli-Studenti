<?php 
$prevDir = "";
$pageName = "documentation.php";
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
      
      <nav>
            <a href="index.php" class="navbarElement"><div>Home</div></a>
            <a href="personal.php" class="navbarElement"><div>Area personale</div></a>
            <a href="search.php" class="navbarElement"><div>Cerca</div></a>
            <a href="login.php" class="navbarElement"><div>Login</div></a>
            <a href="signup.php" class="navbarElement"><div>Registrati</div></a>
            <a href="manual.html" class="navbarElement"><div>Manuale</div></a>
            <a href="documentation.php" class="navbarElement currentPage"><div>Doc-</div></a>
            <div class="navbarElement navbarDropDown">
                  Tema
                  <div class="themeOptionsContainer">
                        <a class="themeOption" onclick="setTheme('dark')">Scuro</a>
                        <a class="themeOption" onclick="setTheme('grey')">Grigio</a>
                        <a class="themeOption" onclick="setTheme('light')">Chiaro</a>
                        <a class="themeOption" onclick="setTheme('pantone')">Pantone</a>
                        <a class="themeOption" onclick="setTheme('custom')">Neon</a>
                  </div>
            </div>
            <div class="navbarElement logoutElement" onclick="logout()"><span>&#11199;</span> Logout</div>
      </nav>
            Grafici con i corsi di laurea più visualizzati
            Grafici con le materie più visualizzate
            Grafici con gli utenti più attivi (più documenti)
            Grafici con gli utenti più popolari (più documenti)
            Grafici con gli utenti più attivi per corso di laurea
            Grafici con gli utenti più attivi per materie
      </article>
      <h3>Cambia PHP e ritorna ID|nome|downloads|uploads</h3>
      <h4>Fai doppia drop down list: una per tabella target, una per active/download</h4>
      <h4>Fai fetch solo al cambio di tabella, tra (downloads|uploads) riordina tutto in JS</h4>
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

            <div id="graphContainer" class="graphContainer">
                  <!-- graph -->
            </div>
      </section>
      <footer>footer</footer>
      <script src="js/stats/getDegreesStats.js"></script>
</body>
</html>