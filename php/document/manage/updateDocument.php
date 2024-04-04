<?php 

// Se la sessione non è già attiva la faccio partire
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

$projectDir = "../../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

$id = $_POST['id'];
$oldExtension = $_POST['oldExtension'];
$newTitle = $_POST['newTitle'];
$newSubitle = ($_POST['newSubtitle'] == "") ? NULL : $_POST['newSubtitle'];
$newExtension;

// Controlla se il file è stato cambiato
$fileChanged = isset($_FILES['newFile']);

if($fileChanged){
      $newFile = $_FILES['newFile'];
      $newExtension = pathinfo($newFile["name"], PATHINFO_EXTENSION);
      if($newExtension != null) $newExtension = "." . $newExtension;
}
else{
      $newExtension = $oldExtension;
}

// Faccio l'update del documento
$sqlStatement = " UPDATE document
            SET 
                  title = ?, 
                  subtitle = ?, 
                  extension = ? 
            WHERE id = ? AND owner = ?;";

$parameterType = "sssii";

$parameters = array(
      $newTitle, 
      $newSubitle, 
      $newExtension, 
      $id,                    // Document Id
      $_SESSION['user_id']    // Owner id -> ossia l'id dell'utente loggato
);

// Eseguo lo statement per la modifica del record
executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterType, 
      $parameters);

// Se c'è stato un errore ritorno false
if($affectedRows <= 0){
      echo json_encode(false);
      return;
}
if($fileChanged){
      // Directory dove sono salvati i documenti
      $docsDirectory = $projectDir . "docs/";

      // Individuo il file da eliminare
      $oldFile = $docsDirectory . $id . $oldExtension;

      // Se il file esiste lo elimino
      if(file_exists($oldFile))
            unlink($oldFile);

      // Al suo posto (con il suo stesso id) carico il nuovo file
      $newFilePath = $docsDirectory . $id . $newExtension;
      
      // Salvo il nuovo file
      if(move_uploaded_file($newFile["tmp_name"], $newFilePath))
            echo json_encode(true);

      else
            echo json_encode(false);
}
else{
      echo json_encode(true);
}

?>