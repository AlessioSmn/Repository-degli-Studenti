<?php

// Se la sessione non è già attiva la faccio partire
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

$projectDir = "../../";

// File di configurazione per la connessione con il DB
include_once $projectDir.'config/config.php';
include_once $projectDir.'php/utils/executePreparedStatement.php';

// Salvo la pagina perchè distruggo la sessione
$previousPage = isset($_SESSION['previousPage']) ? $_SESSION['previousPage'] : 'index.php';

// Quando viene effettuato il login si elimina la sessione corrente
session_unset();
session_destroy();

// Prendo l'indirizzo di mail inserito (POST)
$email = $_POST['email'];
$password = $_POST['password'];


// Controllo che l'accesso sia consentito
if(!loginValidation($email, $password)){
      echo json_encode([false, "Credenziali di accesso errate"]);
      exit();
}
 
// Creo ed inizializzo le variabili di sessione
fillNewSession($email);

// Echo la pagina precedente per la ridirezione
echo json_encode([true, $previousPage]);

/**
 * Funzione che permette di connettersi al database e controllare la correttezza delle credenziali di accesso
 * @param $email L'email inserita
 * @param $password La password inserita
 */
function loginValidation($email, $password, $printInfo = false){
      $sqlStatement = "SELECT password FROM user WHERE email = ?";
      $parameterTypes = "s"; // Stringa
      // TODO Sanitize input
      $parameters = array($email);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );

      // Se c'è un errore nel prepared statement
      // oppure se non è stato trovato l'utente
      if($result == false || $affectedRows != 1)
            return false;

      // Ricavo l'unico record presente
      $row = mysqli_fetch_assoc($result);

      // verifico il match con la password inserita
      if(password_verify($password, $row['password']))
            return true;

      return false;
}

function fillNewSession($email){
      $sqlStatement = "SELECT id, name, surname FROM user WHERE email = ?";
      $parameterTypes = "s";
      $parameters = array($email);

      $result = executePreparedStatement(
            $sqlStatement,
            $affectedRows,
            $parameterTypes,
            $parameters
      );

      // check that there's ony row
      if($affectedRows != 1)
            return;

      $row = mysqli_fetch_assoc($result);

      if(session_status() != PHP_SESSION_ACTIVE)
            session_start();

      $_SESSION['logged'] = 1;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_surname'] = $row['surname'];
}

?>