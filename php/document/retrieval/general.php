<?php

/**
 * Esegue un'interrogazione con il database per ricavare i documenti secondo le specifiche della query passata come parametro
 * @param $query La query da eseguire, con parametri
 * @param $parameters Array di valori da inserire come paramteri
 * @param $parameterTypes Stringa costituita da un carattere per parametro che ne identifica il tipo
 * @return array Restituisce un array (eventualmente vuoto) di record 
 */
function retrieveDocuments($query, $parameters, $parameterTypes){

      // Eseguo la query

      $result = executePreparedStatement(
            $query, 
            $affectedRows, 
            $parameterTypes,
            $parameters
      );

      // Restituisco il risultato come array di record

      $resultArray = array();

      if ($affectedRows > 0) {
            while($row = $result->fetch_assoc()) {
                  $resultArray[] = $row;
            }
      }

      return $resultArray;
}
?>