<?php
/**
 * Classe contenente delle query per ricavare varie statistiche sul database
 */
class StatisticQuery{
      // NB inner join sulla tabella target perchè si vogliono evitare gli elementi senza record
      //    esempio: molte materie sarebbero a zero
      
      /**
       * Corsi di laurea ordinati per numero di download effettuati maggiore
       */
      const DegreesMostDownload = 
            " SELECT
                  degreecourse.id as ID, 
                  degreecourse.name as Name, 
                  if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
                  INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
            GROUP BY degreecourse.id
            ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, degreecourse.name; ";
      
      /**
       * Corsi di laurea ordinati per numero di upload di documenti maggiore
       */
      const DegreesMostActive =
            " SELECT 
                  degreecourse.id as ID, 
                  degreecourse.name as Name,
                  count(*) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
                  INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
            GROUP BY degreecourse.id
            ORDER BY count(*) DESC, degreecourse.name; ";
      
      /**
       * Materie ordinate per numero di download effettuati maggiore
       */
      const SubjectsAllMostDownload = 
            " SELECT 
                  subject.id as ID, 
                  subject.name as Name,
                  if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
            GROUP BY subject.id
            ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, subject.name; ";
      
      /**
       * Materie ordinate per numero di upload di documenti maggiore
       */
      const SubjectsAllMostActive = 
            " SELECT 
                  subject.id as ID, 
                  subject.name as Name,
                  count(*) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
                  INNER JOIN subject ON document.subject = subject.id 
            GROUP BY subject.id
            ORDER BY count(*) DESC, subject.name; ";

      /**
       * Utenti ordinati per numero di download effettuati maggiore
       */
      const UsersMostDownload = 
            " SELECT 
                  user.id as ID, 
                  user.name as Name,
                  if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
            GROUP BY user.id
            ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, user.name; ";

      /**
       * Utenti ordinati per numero di upload di documenti maggiore
       */
      const UsersMostActive = 
            " SELECT 
                  user.id as ID, 
                  user.name as Name,
                  count(*) as Value
            FROM document 
                  INNER JOIN user ON document.owner = user.id 
            GROUP BY user.id
            ORDER BY count(*) DESC, user.name; ";
}