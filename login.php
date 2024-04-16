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
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">
      <script src="js/theme/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>
      <script src="js/logControl/login.js"></script>
      <style>
            body{
                  background-color: var(--bgColor_dark);
            }
      </style>
</head>
<body>
      <header>
            <h1>Login</h1>
      </header>

      <!-- Barra di navigazione del sito -->
      <nav id="navbar">
            <div class="side-navbar-visualizer" onclick="sideNavbarToggle()">Menu</div>
            <a href="index.php" class="navbar-main-element"><div><span>Home</span></div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Accesso</span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option current-page" href="#">Login</a>
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

      <div class="main-log-container">
            <form name="loginForm" onsubmit="login(event)" class="form-grid">
                  <div class="form-grid-data-row">
                        <label for="email">Mail istituzionale</label>
                        <input type="email" id="email" name="email" placeholder="Es: m.rossi1@studenti.unipi.it" required>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="emailError">
                        Inserisci una mail
                  </div>
                  <div class="form-grid-data-row">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <button id="showPwd" type="button" onmousedown="showPassword()" onmouseup="hidePassword()" onmouseleave="hidePassword()" class="show-password"></button>
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error right-side" id="passwordError">
                        Inserisci una password
                  </div>
                  <div class="form-grid-bottom-rows input-description input-error" id="loginError">
                        Email e/o password errati
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="submit" id="submitLoginForm" class="central important" onclick="displayErrors()">Login</button>
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="reset" class="central">Azzera i campi</button>
                  </div>
                  <div class="form-grid-data-row">
                        <label>Non hai un account?</label>
                        <a href="signup.php" class="button-like">Registrati</a>
                  </div>
            </form>
            <p id="loginInfo"></p>
      
      </div>
      

      
      <div style="border: 5px; border-color: red; border-style:dotted; padding: 00px; width: 90%;">
                  <h4 style="color: red; display: inline;">DEBUGGING ONLY</h4>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('a.dallebandenere')">fill1</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('b.rossi1')">fill2</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('b.rossi2')">fill3</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('c.verdi10')">fill4</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('vasco')">vasco</button>
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
      
      <script src="js/navbar/navbarresizing.js"></script>
            
      <script>
      const pwdInputElement = document.querySelector('input[name="password"]');
      const hideShowPassword = document.getElementById('showPwd');
      function showPassword(){
            // Mostro la password
            pwdInputElement.type = 'text';

            // E cambio l'immagine del bottone
            hideShowPassword.style.backgroundImage = 'url(media/.png/show.png)';

      }
      function hidePassword(id){
            // Nascondo la password
            pwdInputElement.type = 'password';

            // E cambio l'immagine del bottone
            hideShowPassword.style.backgroundImage = 'url(media/.png/hide.png)';
      }
             
      function displayErrors(){
            let emailInput = document.querySelector('input[name="email"]');
            let emailError = document.getElementById("emailError");
            if(!emailInput.checkValidity()) emailError.style.display = 'block';
            else emailError.style.display = 'none';

            let password1Input = document.querySelector('input[name="password"]');
            let password1Error = document.getElementById("passwordError");
            if(!password1Input.checkValidity()) password1Error.style.display = 'block';
            else password1Error.style.display = 'none';
      }

      function DEBUG_ONLY_fillLoginAdminData(mail){
            document.querySelector('input[name="email"]').value = mail+"@studenti.unipi.it";
            if(mail == 'vasco')document.querySelector('input[name="password"]').value = "qwertyQ1.";
            else document.querySelector('input[name="password"]').value = "rootAdmin1.";
      }
      </script>
</body>
</html>