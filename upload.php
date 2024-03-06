<?php
$prevDir = "";
$pageName = "search.php";
include "php/logControl/loginControl.php";

include 'config/config.php';
$connection = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);
if (mysqli_connect_errno()) {
      // echo "Connessione con MySQL fallita: " . mysqli_connect_error();
      exit();
}
else{
      // echo "Connection open: ".DB_host." - ".DB_user.": ".DB_name."; port:".DB_port;
}
$documentFolder = 'docs/';

// Handle file upload
if (isset($_FILES['fileContent'])) {
      // Chosen title
      $documentTitle = $_POST['title'];
      $documentTitle = $connection->real_escape_string($documentTitle);

      // Selected Subject Id
      $subjectId = $_POST['subject_selector'];
      echo $subjectId . "<br>";

      // Owner is logged user
      $loggedUserId = -1;

      // file extension
      $docExtension = pathinfo($_FILES["fileContent"]["name"], PATHINFO_EXTENSION);
      if($docExtension != null){
            $docExtension = '.'.$docExtension;
      }
  
      // Insert query
      $query = "  INSERT INTO document (title, subject, owner, extension) 
                  VALUES ('$documentTitle', $subjectId, '$loggedUserId', '$docExtension');";

      if ($connection->query($query) === TRUE) {
            echo "PDF file uploaded successfully.";
            $newDocRowId = $connection->insert_id;

            // Save file in docs/
            $finalPath = $documentFolder . $newDocRowId . $docExtension;
            if (move_uploaded_file($_FILES["fileContent"]["tmp_name"], $finalPath)) {
                  echo "The file " . $finalPath . " has been uploaded.";
            } else {
                  echo "Sorry, there was an error uploading your file.";
            }
      } else {
            // echo "Error: " . $query . "<br>" . $connection->error;
            echo "Error:" . $connection->error;
      }
} else {
      echo "Error uploading the PDF file, \$_FILES['fileContent'] not set";
}
  
// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
      <title>Repository studenti</title>
      <link rel="stylesheet" type="text/CSS" href="css/themes/dark.css" id="theme">
      <link rel="stylesheet" type="text/CSS" href="css/themes.css">
      <link rel="stylesheet" type="text/CSS" href="css/general.css">
      <link rel="stylesheet" type="text/CSS" href="css/header.css">
      <link rel="stylesheet" type="text/CSS" href="css/navbar.css">
      <link rel="stylesheet" type="text/CSS" href="css/footer.css">
      <link rel="icon" type="image/ICO" href="media/.ico/cherubino_pant541.ico">
      <script src="js/themeControl.js"></script>
      <script src="js/logControl/logout.js"></script>
</head>
<body>
<body>
      <header>
            <h1>PAGINA TEST</h1>
      </header>
      
      <nav>
            <a href="index.php" class="navbarElement"><div>Home</div></a>
            <a href="personal.php" class="navbarElement currentPage"><div>Area personale</div></a>
            <a href="search.php" class="navbarElement"><div>Cerca</div></a>
            <a href="login.php" class="navbarElement"><div>Login</div></a>
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
      </article>
      <footer>footer</footer>
</body>
</html>