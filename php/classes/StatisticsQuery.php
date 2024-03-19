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


      /**
       * Dato un'entità della quale si vogliono reperire le informazioni di upload e download (Utenti, materia o corso di laurea),
       * eventualmente relativi a un sottoinsieme (tutti, per una data materia, per un dato corso di laurea), 
       * restituisce il corretto statement MySQL per reperire le informazioni
       * @param string $Target L'entità della quale si vogliono reperire le informazioni di upload e download  ['User' | 'Subject' | 'Degree' ]
       * @param string $Group Sottoinsieme da considerare [ 'All' | 'Degree' | 'Subject' ]
       * @return string Ritorna una query MySQL (come stringa) per ricavare le informazioni dal database
       */
      static function GetStatisticQuery($Target, $Group = "All"){
            switch($Target){
                  case "User": switch($Group){
                        case "All":       return StatisticQuery::UsersAllInfo;
                        case "Degree":    return StatisticQuery::UsersDegreeInfo;
                        case "Subject":   return StatisticQuery::UsersSubjectInfo;
                        default: return null;
                  }

                  case "Subject": switch($Group){
                        case "All":       return StatisticQuery::SubjectAllInfo;
                        case "Degree":    return StatisticQuery::SubjectDegreeInfo;
                        default: return null;
                  }

                  case "Degree": switch($Group){
                        case "All":       return StatisticQuery::DegreeAllInfo;
                        default: return null;
                  }
                  
                  default: return null;
            }
      }



      /**
       * Informazioni sul numero di Upload e di Download dei propri documenti per tutti gli utenti
       */
      const UsersAllInfo = 
            " SELECT 
                  U.id as ID, 
                  U.email as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN user U ON D.owner = U.id 
            GROUP BY U.id ";

      /**
       * Informazioni sul numero di Upload e di Download dei propri documenti per tutti gli utenti, relativo ad una data materia
       */
      const UsersSubjectInfo = 
            " SELECT 
                  U.id as ID, 
                  U.email as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN user U ON D.owner = U.id 
            WHERE D.subject = ? 
            GROUP BY U.id ";

      /**
       * Informazioni sul numero di Upload e di Download dei propri documenti per tutti gli utenti, relativo ad un dato corso di laurea
       */
      const UsersDegreeInfo = 
            " SELECT 
                  U.id as ID, 
                  U.email as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN user U ON D.owner = U.id 
                  INNER JOIN subject S ON D.subject = S.id
            WHERE S.degreecourse = ? 
            GROUP BY U.id ";

      /**
       * Informazioni sul numero di Upload e di Download per tutte le materie
       */
      const SubjectAllInfo = 
            " SELECT 
                  S.id as ID, 
                  concat(S.name, ' (', DC.name, ')') as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN subject S ON D.subject = S.id 
                  INNER JOIN degreecourse DC ON S.degreecourse = DC.id 
            GROUP BY D.subject ";

      /**
       * Informazioni sul numero di Upload e di Download per le materie di un dato cosro di studi
       */
      const SubjectDegreeInfo = 
            " SELECT 
                  S.id as ID, 
                  S.name as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN subject S ON D.subject = S.id 
                  INNER JOIN degreecourse DC ON S.degreecourse = DC.id 
            WHERE DC.id = ? 
            GROUP BY D.subject ";

      /**
       * Informazioni sul numero di Upload e di Download per i corsi di studi
       */
      const DegreeAllInfo = 
            " SELECT 
                  DC.id as ID, 
                  DC.name as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN subject S ON D.subject = S.id 
                  INNER JOIN degreecourse DC ON S.degreecourse = DC.id 
            GROUP BY DC.id ";

}