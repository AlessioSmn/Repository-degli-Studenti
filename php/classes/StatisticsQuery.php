<?php
/**
 * Classe contenente delle query per ricavare varie statistiche sul database
 */
class StatisticQuery{
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
       * Nota: Mostra solo gli utenti che hanno caricato almeno un documento
       */
      const UsersAllInfo = 
            " SELECT 
                  U.id as ID, 
                  U.email as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM document D
                  INNER JOIN user U ON D.owner = U.id 
            GROUP BY U.id; ";

      /**
       * Informazioni sul numero di Upload e di Download dei propri documenti per tutti gli utenti, relativo ad un dato corso di laurea
       * Nota: Mostra solo gli utenti che hanno caricato almeno un documento
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
            GROUP BY U.id; ";

      /**
       * Informazioni sul numero di Upload e di Download dei propri documenti per tutti gli utenti, relativo ad una data materia
       * Nota: Mostra solo gli utenti che hanno caricato almeno un documento
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
            GROUP BY U.id; ";

      /**
       * Informazioni sul numero di Upload e di Download per tutte le materie
       * Nota: Mostra solo le materie con almeno un documento caricato
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
            GROUP BY D.subject; ";

      /**
       * Informazioni sul numero di Upload e di Download per le materie di un dato cosro di studi
       * Nota: Mostra tutte le materie del corso di studi, anche se senza alcun documento
       */
      const SubjectDegreeInfo = 
            " SELECT 
                  S.id as ID, 
                  S.name as Name, 
                  count(*) as Uploads, 
                  if(sum(D.downloadCounter) is null, 0, sum(D.downloadCounter)) as Downloads 
            FROM subject S
            -- FROM document D
            --       INNER JOIN subject S ON D.subject = S.id 
                  INNER JOIN degreecourse DC ON S.degreecourse = DC.id 
                  LEFT OUTER JOIN document D on S.id = D.subject 
            WHERE DC.id = ? 
            GROUP BY S.id; ";

      /**
       * Informazioni sul numero di Upload e di Download per i corsi di studi
       * Nota: Mostra solo i corsi di studi con almeno un documento caricato
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
            GROUP BY DC.id; ";

}