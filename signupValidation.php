<?php

#region Input validation

// Password
// test if the two password input are equal
// if not, redirect to signup.php
if (isset($_POST['password']) && isset($_POST['passwordRepeat'])){
      if($_POST['password'] !== $_POST['passwordRepeat']){
            header('Location: signup.php', true, 301);
            exit();
      }
}
else exit();
#endregion

include 'config/config.php';
$connection = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);
if (mysqli_connect_errno()) {
      echo "Connessione con MySQL fallita: " . mysqli_connect_error();
      exit();
}
else{
      echo "Connection open: ".DB_host." - ".DB_user.": ".DB_name."; port:".DB_port;
}
$query = "insert into user(name, surname, email, password) values(?, ?, ?, ?);";
$stm = mysqli_prepare($connection, $query);
if($stm == false){
      echo "Error in the prepared statement: " . mysqli_error($connection);
      exit();
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
mysqli_stmt_bind_param($stm, 'ssss', $name, $surname, $email, $password);

if (mysqli_stmt_execute($stm)) {
      echo "Insert successful!";
      echo "Affected rows: " . mysqli_affected_rows($connection);
      
      if(isset($_SESSION['logged'])) 
            session_destroy();
      
      if(session_status() != PHP_SESSION_ACTIVE)
            session_start();
      $_SESSION['logged'] = 1;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_name'] = $name;
      $_SESSION['user_surname'] = $surname;    
} 
else {
      echo "Error executing prepared statement: " . mysqli_error($connection);
}

mysqli_stmt_close($stm);

echo "affected rows: ".mysqli_affected_rows($connection);

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
            <p>Grazie per esserti registrato!<p>
            <a href="search.php">Cerca appunti</a>


            <?php
            // TODO 
            echo "<div style=\"border: 2px; border-style:dotted; padding: 10px;\"><p style=\"color: red; font-size:30;\">REMOVE THIS CODE; DEBUGGING ONLY </p>";
// Query to get all of the selected degree's subjects
// include 'config/config.php';
$conn = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}
$query = "SELECT * FROM user";
$result = $conn->query($query);

if (mysqli_affected_rows($conn) > 0) {
    // display all subjects as options to choose from
    while($row = $result->fetch_assoc()) {
        echo "<p> ". $row['id'] ." - " . $row['name'] . " - " . $row['password'] . "</p>";
    }
} else {
    echo "<p>Nessun utente</p>";
}

$conn->close();
echo "</div>";
            ?>
      </article>
      <footer>footer</footer>
</body>
</html>