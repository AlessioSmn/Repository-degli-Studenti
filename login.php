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
      <script src="js/themeControl.js"></script>
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
            <a href="index.php" class="navbarElement"><div>Home</div></a>
            <a href="personal.php" class="navbarElement"><div>Area personale</div></a>
            <a href="search.php" class="navbarElement"><div>Cerca</div></a>
            <a href="login.php" class="navbarElement currentPage"><div>Login</div></a>
            <a href="signup.php" class="navbarElement"><div>Registrati</div></a>
            <a href="manual.html" class="navbarElement"><div>Manuale</div></a>
            <a href="documentation.php" class="navbarElement"><div>Doc-</div></a>
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