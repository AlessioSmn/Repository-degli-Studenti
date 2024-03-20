<?php

/**
 * Funzione di utilità per processare query / DML statements. Richiede che sia stato precedentemente incluso un file con le variabili di configurazione per la connessione al database
 * @param string $sqlStatement Query / DML statement che si vuole eseguire 
 * @param int $affectedRows Reference. Memorizza il numero di record modificati / restituiti
 * @param string $parameterTypes Optional. Default = null. Stringa dei tipi dei parametri della query
 * @param array $parameterValue Optional. Default = null. Array di parametri della query
 * @param array $lastInsertedId Optional. Default = null. Reference. Se lo statement è insert o update salva il valore dell'id
 * @return mysqli_result|boolean|string[]
 */
function executePreparedStatement($sqlStatement, &$affectedRows, $parameterTypes = null, $parameterValue = null, &$lastInsertedId = null){
      // Connessione con il database, secondo i paramteri specificati in config/config.php
      $connection = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);

      // perparo lo statement
      // Questo unito alla bind permette di evitare sql injections
      $statement = $connection->prepare($sqlStatement);
      $affectedRows = -2;

      // Se lo statement non è stato preparato correttamente
      if(!$statement){
            mysqli_close($connection);
            return false;
      }

      // Eseguo la bind di tutti i parametri se sono presenti
      if(!is_null($parameterTypes) && !is_null($parameterValue) && !empty($parameterTypes) && !empty($parameterValue))
            variableBindParam($statement, $parameterTypes, $parameterValue);

      // errore in esecuzione
      if(!$statement->execute()){
            mysqli_close($connection);
            return false;
      }

      // Ricavo il result set
      $result = $statement->get_result();
      
      // Imposto il numero di righe modificate / ritornate ricavadolo dalle opportune funzioni
      // (Se lo statement è una query richiede mysqli_num_rows, se è un'operazione di DMl richiede getConnection)
      $affectedRows = max(mysqli_affected_rows($connection), $result ? mysqli_num_rows($result) : 0);

      // Ricavo l'ultimo id inserito
      $lastInsertedId = mysqli_insert_id($connection);

      mysqli_close($connection);

      // Restituisco il result set
      return $result;
}

/**
 * Permette di chiamare la funzione bind_param() con un numero variabile di parametri
 * @param string $stm Statement che dovrà contenere le variabili
 * @param string $parameterTypes Stringa con i tipi dei parametri
 * @param array $parameters Array contenente i parametri da passare alla funzione bind_param
 */
function variableBindParam(&$stm, $parameterTypes, array &$parameters){
      /*
            bind_param(types, par1, par2, ..., parN);
            // Il primo argomento dev'essere una stringa con i tipi di tutti i parametri, in ordine
            // I successivi N argomenti sono i paramteri
      */

      // Primo argomento della bind_param: unica stringa con i tipi in ordine
      $argsArray = array($parameterTypes);

      // Restanti N argomenti: i vari parametri
      foreach ($parameters as &$param) {
            $argsArray[] = &$param;
      }

      // Chiamo la bind_param() con un numero variabile di paramteri grazie a call_user_func_array
      call_user_func_array(array(&$stm, 'bind_param'), $argsArray);
}
?>
