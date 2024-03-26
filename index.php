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
            }, { passive: true });
      </script>
</head>
<body>
      <header>
            <p>Biblioteca UniPi</p>
            <p>Raccolta di appunti degli studenti per gli studenti</p>
            <p>proprio quella</p>
            <img src="media/.svg/logo_white.svg" alt="logo UniPi">
      </header>

      <!-- Barra di navigazione del sito -->
      <nav>
            <a href="#" class="navbar-main-element current-page"><div><span>Home</span></div></a>
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
                        <a href="personal.php" class="navbar-dropdown-option">Area personale</a>
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
                        <a class="navbar-dropdown-option" onclick="setTheme('custom')">Neon</a>
                  </div>
            </div>
      </nav>
      
      <section>
            <h1>Benvenuto nella Repository degli Studenti</h1>
            <p>
                  Benvenuto nella Repository degli Studenti, un sito web dedicato alla condivisione materiale di studio.<br/>
                  Esplora la vasta gamma di documenti e dispense caricati dagli studenti e cerca appunti per le materie pi&ugrave; impegnative. <br/>
                  Per usufruire del servizio dovrai creare un account personale, dove potrai gestire i tuoi documenti e caricarne di nuovi.<br/>
                  Scopri varie statistiche sull'utilizzo del sito, dai documenti pi&ugrave; scaricati ai corsi di laurea pi&ugrave; attivi.<br/>
                  Potrai inoltre scegliere il tuo tema preferito per personalizzare l'esperienza di navigazione. <br/>
                  Inizia subito a esplorare e a condividere conoscenze con la comunit&agrave;!<br/>
            </p>
            <p>Una descrizione del sito</p><a href="manual.html"><button>Manuale</button></a>
            <p>Cerchi appunti per una materia ostica?</p><a href="search.php"><button>Cerca</button></a>
            <p>Vuoi condividere i tuoi appunti?</p><a href="personal.php"><button>Area personale</button></a>
            <p>Vuoi controllare i tuoi documenti?</p><a href="personal.php"><button>Area personale</button></a>
            <p>Vuoi sapere quali sono le materie pi&ugrave; popolare?</p><a href="statistics.php"><button>Statistiche</button></a>
      </section>

      <footer>
            Alessio Simoncini
            Progetto per il corso di Progettazione WEB [080II]
            <hr>
            CdS Ingegneria Informatica - Dipartimento di Ingegneria dell'informazione
            Scuola di Ingegneria UNIPI
            Universit&agrave; di Pisa
            Lungarno Pacinotti 43
            56126 Pisa
      </footer>
</body>
</html>