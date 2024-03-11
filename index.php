<?php 
$prevDir = "";
$pageName = "index.php";
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
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">
      <script src="js/theme/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>

      <script>
            window.addEventListener('scroll', function() {
                  const scroll = window.scrollY;
                  document.querySelector('header').style.backgroundPositionY = -0.5 * scroll + 'px';
            });
      </script>
</head>
<body>
      <header>
            <p>Biblioteca UniPi</p>
            <p>Raccolta di appunti degli studenti per gli studenti</p>
            <p>proprio quella</p>
            <img src="media/.svg/logo_white.svg" alt="logo UniPi">
      </header>

      <nav>
            <a href="index.php" class="navbar-main-element current-page"><div>&#x2302; &#x1F3E0; Home</div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <a href="personal.php" class="navbar-main-element"><div>&#128193; Area personale</div></a>
                  <div class="navbar-dropdown-container" style="margin-top: 50px;">
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element"><div>&#x1F50E; &#xFE0E; Cerca</div></a>
            <a href="login.php" class="navbar-main-element"><div>&#9094; Login</div></a>
            <a href="signup.php" class="navbar-main-element"><div>Registrati</div></a>
            <a href="manual.html" class="navbar-main-element"><div>&#128214; Manuale</div></a>
            <a href="documentation.php" class="navbar-main-element"><div>&#128202; Doc-</div></a>
            <div class="navbar-main-element navbar-dropdown-main floating">
                  &#127912; <span>Tema<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" onclick="setTheme('dark')">Scuro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('grey')">Grigio</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('light')">Chiaro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('pantone')">Pantone</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('custom')">Neon</a>
                  </div>
            </div>
            <div class="navbar-main-element floating" onclick="logout()"><span>&#11199; &#9211;</span> Logout</div>
      </nav>
      
      <section>
            <h1>Benvenuto nella Repository degli Studenti</h1>
            <p>
                  Benvenuto nella Repository degli Studenti, un sito web dedicato alla condivisione materiale di studio.<br/>
                  Esplora la vasta gamma di documenti e dispense caricati dagli studenti e cerca appunti per le materie più impegnative. <br/>
                  Per usufruire del servizio dovrai creare un account personale, dove potrai gestire i tuoi documenti e caricarne di nuovi.<br/>
                  Scopri varie statistiche sull'utilizzo del sito, dai documenti più scaricati ai corsi di laurea più attivi.<br/>
                  Potrai inoltre scegliere il tuo tema preferito per personalizzare l'esperienza di navigazione. <br/>
                  Inizia subito a esplorare e a condividere conoscenze con la comunità!<br/>
            </p>
            <p>Una descrizione del sito</p><a href="manual.html"><button>Manuale</button></a>
            <p>Cerchi appunti per una materia ostica?</p><a href="search.php"><button>Cerca</button></a>
            <p>Vuoi condividere i tuoi appunti?</p><a href="personal.php"><button>Area personale</button></a>
            <p>Vuoi controllare i tuoi documenti?</p><a href="personal.php"><button>Area personale</button></a>
            <p>Vuoi controllare i tuoi documenti?</p><a href="documentation.php"><button>Statistiche</button></a>
      </section>

      <footer>
            Alessio Simoncini
            Progetto per il corso di Progettazione WEB [080II]
            <hr>
            CdS Ingegneria Informatica - Dipartimento di Ingegneria dell'informazione
            Scuola di Ingegneria UNIPI
            Università di Pisa
            Lungarno Pacinotti 43
            56126 Pisa
      </footer>
</body>
</html>