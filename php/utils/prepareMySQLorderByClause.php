<?php

/**
 * Crea il vincolo MySQL per l'ordinamento del result set della query
 * @param $orderField Campo sul quale basare l'ordinamento
 * @param $order Determina se ordinare in maniera crescente (ASC) o decrescente (DESC)
 */
function prepareMySQLorderByClause($orderField, $order){
      $orderByKeyword = " ORDER BY ";

      // In questa maniera evito keyword errate per l'ordinamento
      $order = ($order == "ASC" ? "ASC" : "DESC");

      return $orderByKeyword . orderField($orderField) . " ". $order . "; ";
}

function orderField($orderField){
      switch($orderField){
            case 'usrName': 
                  return 'user.name';
            case 'usrMail': 
                  return 'user.email';
            case 'sub': 
                  return 'subject.name';
            case 'doc': 
                  return 'document.title';
            case 'up':
                  return 'document.uploadDate';
            case 'lastMod':
                  return 'document.lastModified';
            case 'download':
            default:
                  return 'document.downloadCounter';
      }
}
?>