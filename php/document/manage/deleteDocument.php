<?php 

$projectDir = "../../../";
// Controllo che sia effettuato il login
$prevDir = $projectDir; // fino a /progetto
include_once $projectDir.'php/logControl/loginControl.php';

include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// Elimino il documento secondo il suo id
$sqlStatement = "DELETE FROM document WHERE id = ?;";
$parameterType = "i"; // intero

// Eseguo lo statement
executePreparedStatement(
      $sqlStatement, 
      $affectedRows, 
      $parameterType, 
      array($_GET['id']));

if($affectedRows > 0){

      // Individuo il file da eliminare
      $filePath = $projectDir . 'docs/' . $_GET['id'] . $_GET['ext'];

      // Se il file esiste lo elimino
      if(file_exists($filePath)){
            unlink($filePath);
            echo json_encode(true);
      }
      else{
            echo json_encode(false);
      }
}
else{
      echo json_encode(false);
}

?>