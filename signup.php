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
      <script src="js/logControl/signup.js"></script>
</head>
<body>
      <header>
            <h1>Registrazione</h1>
      </header>

      <!-- Barra di navigazione del sito -->
      <nav>
            <a href="index.php" class="navbar-main-element"><div><span>Home</span></div></a>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Accesso<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" href="login.php">Login</a>
                        <a class="navbar-dropdown-option current-page" href="#">Registrati</a>
                        <a class="navbar-dropdown-option" onclick="logout()">Logout</a>
                  </div>
            </div>
            <div class="navbar-main-element navbar-dropdown-main">
                  <span>Area personale<span>
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
                  <span>Tema<span>
                  <div class="navbar-dropdown-container">
                        <a class="navbar-dropdown-option" onclick="setTheme('dark')">Scuro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('grey')">Grigio</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('light')">Chiaro</a>
                        <a class="navbar-dropdown-option" onclick="setTheme('pantone')">Pantone</a>
                        <a class="navbar-dropdown-option" onclick="setTheme(CUSTOM_THEME)">Custom</a>
                  </div>
            </div>
      </nav>

      <section class="main-log-container">
            <form name="signUpForm" onsubmit="signup(event)" class="form-grid">
                  <fieldset>
                        <legend>Informazioni personali</legend>
                        <div class="form-grid-data-row">
                              <label for="name">Nome</label>
                              <input 
                                    required
                                    type="text" 
                                    name="name" 
                                    pattern="[A-Za-z ']*" 
                                    placeholder="Es: Mario" 
                                    title="Inserisci il tuo nome: solo caratteri [A-Z] e [a-z] ammessi">
                        </div>
                        <div class="form-grid-bottom-rows input-error-description right-side" id="nameError">
                              Inserisci un nome
                        </div>
                        <div class="form-grid-data-row">
                              <label for="surname">Cognome</label>
                              <input 
                                    required
                                    type="text" 
                                    name="surname" 
                                    pattern="[A-Za-z ']*" 
                                    placeholder="Es: Rossi" 
                                    title="Inserisci il tuo cognome: solo caratteri [A-Z] e [a-z] ammessi">
                        </div>
                        <div class="form-grid-bottom-rows input-error-description right-side" id="surnameError">
                              Inserisci un cognome
                        </div>
                  
                  <!-- Generic pattern:               "[A-Za-z0-9.]+@[a-z]+\.[a-z]{2,}$" -->
                  <!-- @studenti.unipi.it pattern:    "[A-Za-z0-9.]+@studenti.unipi.it" -->
                  <!--
                        pattern="[A-Za-z0-9.]+@studenti.unipi.it" 
                  -->
                        <div class="form-grid-data-row">
                              <label for="email">Mail istituzionale</label>
                              <input 
                                    required
                                    type="mail" 
                                    name="email" 
                                    pattern="[A-Za-z0-9.]+@studenti.unipi.it" 
                                    placeholder="Es: m.rossi1@studenti.unipi.it" 
                                    title="Inserisci la tua mail istituzionale, nella forma [name]@studenti.unipi.it">
                        </div>
                        <div class="form-grid-bottom-rows input-error-description right-side" id="emailError">
                              Inserisci indirizzo mail valido
                        </div>
                  </fieldset>
                  <fieldset>
                        <legend>Registrazione</legend>
                        <!-- 
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[\(\)\[\]\{\}\.,:;\-_\+\*!£\$%&/=\?'\^\|\\]).{8,}" 
                        pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[\(\)\[\]\{\}\.,:;\-_\+\*!£\$%&/=\?'\^\|\\]).{8,}"
                        -->
                        <div class="form-grid-data-row">
                              <label for="password">Password</label>
                              <input 
                                    id="pwd1"
                                    required
                                    type="password" 
                                    name="password"
                                    placeholder="La tua password"
                                    title="inserisci una password sicura: deve essere costituita da minimo 8 caratteri ed includere almeno un numero, una lettera maiuscola, una lettera minuscola e un carattere speciale">
                              <button id="showpwd1" type="button" onmousedown="showPassword('pwd1')" onmouseup="hidePassword('pwd1')" onmouseleave="hidePassword('pwd1')" class="show-password"></button>
                        </div>
                        <div class="form-grid-bottom-rows input-error-description right-side" id="password1Error">
                              <p>
                              Inserisci una password valida costituita da:
                              <ul>
                                    <li>Minimo 8 caratteri</li>
                                    <li>Almeno un numero</li>
                                    <li>Almeno una lettera minuscola</li>
                                    <li>Almeno una lettera maiuscola</li>
                                    <li>Almeno un carattere speciale</li>
                              </ul>
                              </p>
                        </div>
                        <div class="form-grid-data-row">
                              <label for="passwordRepeat">Ripeti la password</label>
                              <input 
                                    id="pwd2"
                                    required
                                    type="password" 
                                    name="passwordRepeat"
                                    placeholder="La tua password"
                                    title="Ripeti la password">
                              <button id="showpwd2" type="button" onmousedown="showPassword('pwd2')" onmouseup="hidePassword('pwd2')" onmouseleave="hidePassword('pwd2')" class="show-password"></button>
                        </div>
                        <div class="form-grid-bottom-rows input-error-description right-side" id="password2Error">
                              Le due password non coincidono
                        </div>
                  </fieldset>
                  <div class="form-grid-bottom-rows input-error-description" id="signupError">
                        
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="submit" class="central important" onclick="displayErrors()">Registrati</button>
                  </div>
                  <div class="form-grid-bottom-rows">
                        <button type="reset" class="central">Azzera i campi</button>
                  </div>
                  <div class="form-grid-data-row">
                        <label>Hai gi&agrave; un account?</label>
                        <a href="login.php" class="button-like">Accedi</a>
                  </div>
            </form>
      </section>

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
                  <img class="company-logo" id="footerUnipiLogo" src="media/.ico/cherubino_black.ico">
            </div>
      </footer>

      <script>
      function showPassword(id){
            // <a href="https://www.flaticon.com/free-icons/password" title="password icons">Password icons created by th studio - Flaticon</a>
            // <a href="https://www.flaticon.com/free-icons/password" title="password icons">Password icons created by th studio - Flaticon</a>

            // Mostro la password
            const pwdInputElement = document.getElementById(id);
            pwdInputElement.type = 'text';

            // E cambio l'immagine del bottone
            const hideShowPassword = document.getElementById('show' + id);
            hideShowPassword.style.backgroundImage = 'url(media/.png/show.png)';

      }
      function hidePassword(id){
            // Nascondo la password
            const pwdInputElement = document.getElementById(id);
            pwdInputElement.type = 'password';

            // E cambio l'immagine del bottone
            const hideShowPassword = document.getElementById('show' + id);
            hideShowPassword.style.backgroundImage = 'url(media/.png/hide.png)';
      }
      
      function displayErrors(){
            // Recupera le informazioni inserite
            let nameInput = document.querySelector('input[name="name"]');
            let nameError = document.getElementById("nameError");
            if(!nameInput.checkValidity()) nameError.style.display = 'block';
            else nameError.style.display = 'none';

            let surnameInput = document.querySelector('input[name="surname"]');
            let surnameError = document.getElementById("surnameError");
            if(!surnameInput.checkValidity()) surnameError.style.display = 'block';
            else surnameError.style.display = 'none';

            let emailInput = document.querySelector('input[name="email"]');
            let emailError = document.getElementById("emailError");
            if(!emailInput.checkValidity()) emailError.style.display = 'block';
            else emailError.style.display = 'none';

            let password1Input = document.querySelector('input[name="password"]');
            let password1Error = document.getElementById("password1Error");
            if(!password1Input.checkValidity()) password1Error.style.display = 'block';
            else password1Error.style.display = 'none';

            let password2Input = document.querySelector('input[name="passwordRepeat"]');
            let password2Error = document.getElementById("password2Error");
            if(password2Input.value != password1Input.value) password2Error.style.display = 'block';
            else password2Error.style.display = 'none';
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