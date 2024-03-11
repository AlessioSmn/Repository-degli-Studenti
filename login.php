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
      <script src="js/logControl/login.js"></script>
</head>
<body>
      <header>
            <p>Biblioteca UniPi</p>
            <p>Raccolta di appunti degli studenti per gli studenti</p>
            <p>proprio quella</p>
            <img src="media/.svg/logo_white.svg" alt="logo UniPi">
      </header>

      <nav>
            <a href="index.php" class="navbar-main-element"><div>Home</div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <a href="personal.php" class="navbar-main-element"><div>Area personale</div></a>
                  <div class="navbar-dropdown-container" style="margin-top: 50px;">
                        <a href="customize.html" class="navbar-dropdown-option">Tema custom</a>
                  </div>
            </div>
            <a href="search.php" class="navbar-main-element"><div>Cerca</div></a>
            <a href="login.php" class="navbar-main-element current-page"><div>Login</div></a>
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

      <article>
            <div style="border: 5px; border-color: red; border-style:dotted; padding: 10px; width: 20%;">
                  <h4 style="color: red">DEBUGGING ONLY</h4>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('a.dallebandenere')">fill1</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('b.rossi1')">fill2</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('b.rossi2')">fill3</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('c.verdi10')">fill4</button>
                  <button onclick="DEBUG_ONLY_fillLoginAdminData('d.bianchi19')">fill5</button>
            </div>

            <form name="loginForm" onsubmit="login(event)">
                  Mail istituzionale: 
                  <input type="mail" name="email" placeholder="Es: m.rossi1@studenti.unipi.it" required><br>
                  Password: 
                  <input type="password" name="password" required placeholder="password"><br>
                  <button type="submit" id="submitLoginForm">Login</button>
                  <button type="reset">Azzera i campi</button>
            </form>
            <p id="loginInfo"></p>
      </article>
      <footer>footer</footer>
      <script>
             
      function DEBUG_ONLY_fillLoginAdminData(mail){
            document.querySelector('input[name="email"]').value = mail+"@studenti.unipi.it";
            document.querySelector('input[name="password"]').value = "rootAdmin1.";
      }
      </script>
</body>
</html>