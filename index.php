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
      <link rel="stylesheet" type="text/CSS" href="css/form.css">
      <link rel="icon" type="image/ICO" href="media/ico/cherubino_pant541.ico">
      <script src="js/theme/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>

      <style>
            h1, h2{
                  text-align: center !important;
            }
            .site-description span{
                  display: block;
            }
            div.pages div{
                  padding: 10px;
                  transition: 0.2s;
                  border-radius: 10px;
            }
            div.pages div:hover{
                  
                  background-color: var(--bgColor);
            }
            div.pages p,
            div.pages a.button-like{
                  display: inline-block;
            }
            .form-grid{
                  margin-bottom: 30px;
            }
            .form-grid-data-row > *:first-child {
                  flex-basis: 40%;
                  text-align: justify;
                  padding: 0px 50px;
                  height: 100%;
            }
            .form-grid-data-row > *:nth-child(2) {
                  background-color: var(--bgColor_light);
                  border-radius: 10px;
                  padding: 20px;
            }
      </style>
</head>
<body>
      <header>
            <h1>Repository degli Studenti</h1>
      </header>

      <!-- Barra di navigazione del sito -->
      <nav id="navbar">
            <div class="side-navbar-visualizer" onclick="sideNavbarToggle()">Menu</div>
            <a href="#" class="navbar-main-element current-page"><div><span>Home</span></div></a>
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
                        <a href="uploaddocument.php" class="navbar-dropdown-option">Upload</a>
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
      
      <h2>Benvenuto nella Repository degli Studenti</h2>

      <div class="form-grid">
            <div class="form-grid-data-row">
                  <p class="site-description">
                        <span>Benvenuto nella Repository degli Studenti, un sito web dedicato alla condivisione materiale di studio.</span><br>
                        <span>Esplora la vasta gamma di documenti e dispense caricati dagli studenti e cerca appunti per le materie pi&ugrave; impegnative.</span><br>
                        <span>Per usufruire del servizio dovrai creare un account personale, dove potrai gestire i tuoi documenti e caricarne di nuovi.</span><br>
                        <span>Scopri varie statistiche sull'utilizzo del sito, dai documenti pi&ugrave; scaricati ai corsi di laurea pi&ugrave; attivi.</span><br>
                        <span>Potrai inoltre scegliere il tuo tema preferito per personalizzare l'esperienza di navigazione. </span><br>
                        <span>Inizia subito a esplorare e a condividere conoscenze con la comunit&agrave;!</span><br>
                  </p>
                  <div class="pages">
                        <div>
                              <p>Una descrizione del sito</p><a href="manual.html" class="button-like">Manuale</a>
                        </div>
                        
                        <div>
                              <p>Cerchi appunti per una materia impegnativa?</p><a href="search.php" class="button-like">Cerca</a>
                        </div>
                        
                        <div>
                              <p>Vuoi condividere i tuoi appunti?</p><a href="uploaddocument.php" class="button-like">Upload</a>
                        </div>
                        
                        <div>
                              <p>Vuoi controllare i tuoi documenti?</p><a href="personal.php" class="button-like">Area personale</a>
                        </div>
                        
                        <div>
                              <p>Vuoi sapere quali sono le materie pi&ugrave; popolari?</p><a href="statistics.php" class="button-like">Statistiche</a>
                        </div>
                  </div>
            </div>
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
                  <img alt="logo della società" class="company-logo" id="footerUnipiLogo" src="media/ico/cherubino_black.ico">
            </div>
      </footer>
      
      <script src="js/navbar/navbarresizing.js"></script>
</body>
</html>