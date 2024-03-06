<?php 

// Se incluso in un file impedisce l'accesso allo stesso se l'utente non ha effettuato il login

// Ricavo la sessione attiva
if(session_status() != PHP_SESSION_ACTIVE)
      session_start();

// echo $prevDir;

// Se l'utente ha fatto il login ok
if(!isset($_SESSION['logged']) || !($_SESSION['logged'] == true)){

      // Memorizzo la pagina di provenienza in sessione
      // in questa maniera se l'utente si logga correttamente viene riportato alla pagina precedente
      // nb: se la pagina precedente è di nuovo login porto comunque alla home, altriemtni lutente può confondersi
      // e pensare che il login non è andato a buon fine
      $previousDir = isset($prevDir) ? $prevDir : "../";
      $_SESSION['previousPage'] = (isset($pageName) && $pageName != 'login.php') ? $pageName : "index.php";

      // Redirigo verso la pagina di login
      header("location:" . $previousDir . "login.php", true, 302);
}

?>