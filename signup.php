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
      <link rel="stylesheet" type="text/CSS" href="css/formError.css">
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
            <a href="signup.php" class="navbarElement currentPage"><div>Registrati</div></a>
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
            <form id="signUpForm" name="signUpForm" method="post" action="signupValidation.php" onsubmit="return validateForm()">
            <fieldset><legend>Informazioni personali</legend>
                  Nome: 
                  <input 
                        required 
                        type="text" 
                        name="name" 
                        pattern="[A-Za-z ']*" 
                        placeholder="Es: Mario" 
                        title="Inserisci il tuo nome: solo caratteri [A-Z] e [a-z] ammessi">
                  <br>
                  
                  Cognome:
                  <input 
                        required 
                        type="text" 
                        name="surname" 
                        pattern="[A-Za-z ']*" 
                        placeholder="Es: Rossi" 
                        title="Inserisci il tuo cognome: solo caratteri [A-Z] e [a-z] ammessi">
                  <br>
                  
                  <!-- Generic pattern:               "[A-Za-z0-9.]+@[a-z]+\.[a-z]{2,}$" -->
                  <!-- @studenti.unipi.it pattern:    "[A-Za-z0-9.]+@studenti.unipi.it" -->
                  <!--
                        pattern="[A-Za-z0-9.]+@studenti.unipi.it" 
                  -->
                  Mail istituzionale: 
                  <input 
                        required 
                        type="mail" 
                        name="email" 
                        pattern="[A-Za-z0-9.]+@studenti.unipi.it" 
                        placeholder="Es: m.rossi1@studenti.unipi.it" 
                        title="Inserisci la tua mail istituzionale, nella forma [name]@studenti.unipi.it">
                  <br>
                  <label for="email">Inserisci la tua mail istituzionale (Es: m.rossi1@studenti.unipi.it)</label>
            </fieldset>
            <fieldset><legend>Registrazione</legend>
                        <!-- 
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[\(\)\[\]\{\}\.,:;\-_\+\*!£\$%&/=\?'\^\|\\]).{8,}" 
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[\(\)\[\]\{\}\.,:;\-_\+\*!£\$%&/=\?'\^\|\\]).{8,}"
                        -->
                  Password:
                  <input 
                        id="pwd1"
                        required
                        type="password" 
                        name="password"
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}"
                        placeholder="password"
                        title="inserisci una password sicura: deve essere costituita da minimo 8 caratteri ed includere almeno un numero, una lettera maiuscola, una lettera minuscola e un carattere speciale">
                  <button type="button" onmousedown="showPassword('pwd1')" onmouseup="hidePassword('pwd1')" onmouseleave="hidePassword('pwd1')">-eye-</button>
                  <br>
                  Ripeti Password:
                  <input 
                        id="pwd2"
                        required
                        type="password" 
                        name="passwordRepeat"
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}"
                        placeholder="password"
                        title="Ripeti la password">
                  <button type="button" onmousedown="showPassword('pwd2')" onmouseup="hidePassword('pwd2')" onmouseleave="hidePassword('pwd2')">-eye-</button>
                  <br>
            </fieldset>
            <button type="submit">Registrati</button>
            <button type="reset">Azzera i campi</button>
            </form>
      </article>
      <footer>footer</footer>
      <script>
      function validateForm(){
            let pwd1 = document.forms["signUpForm"]["password"].value;
            let pwd2 = document.forms["signUpForm"]["passwordRepeat"].value;
            if (pwd1 != pwd2) {
                  alert("Name must be filled out");
                  return false;
            }
      }
      function showPassword(id){
            var pwd = document.getElementById(id);
            pwd.type = 'text';
      }
      function hidePassword(id){
            var pwd = document.getElementById(id);
            pwd.type = 'password';
      }

      let regexPwdDigitCheck = "(?=.*[0-9])";
      let regexPwdLowerCheck = "(?=.*[A-Z])";
      let regexPwdUpperCheck = "(?=.*[a-z])";
      let regexPwdBrackets = "\\(\\)\\[\\]\\{\\}";
      let regexPwdPunctation = "\\.,:;\\-_\\+\\*";
      let regexPwdOthers = "!£\\$%&/=\\?'\\^\\|\\" + "\\";
      let regexPwdSpecials = "(?=.*[" + regexPwdBrackets + regexPwdPunctation + regexPwdOthers + "])";
      let regexPwdPatternRequired = regexPwdDigitCheck + regexPwdLowerCheck + regexPwdUpperCheck + regexPwdSpecials;
      let regexPwdMinumumLength = ".{8,}";
      document.getElementById("pwd1").pattern = regexPwdPatternRequired + regexPwdMinumumLength;
      document.getElementById("pwd2").pattern = regexPwdPatternRequired + regexPwdMinumumLength;
      </script>
</body>
</html>