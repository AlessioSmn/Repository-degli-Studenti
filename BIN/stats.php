<?php

define("sqlStatement_Degrees", 
                  " SELECT 
                        degreecourse.id as ID, 
                        degreecourse.name as Name,
                        if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
                  FROM document 
                        INNER JOIN user ON document.owner = user.id 
                        INNER JOIN subject ON document.subject = subject.id 
                        RIGHT OUTER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
                  GROUP BY degreecourse.id
                  ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, degreecourse.name; ");

define("sqlStatement_SubjectDegree", 
                  " SELECT 
                        subject.id as ID, 
                        subject.name as Name,
                        if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
                  FROM document 
                        INNER JOIN user ON document.owner = user.id 
                        INNER JOIN subject ON document.subject = subject.id 
                        INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
                  WHERE subject.degreecourse = ?
                  GROUP BY subject.id
                  ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, subject.name; ");

define("sqlStatement_SubjectAll", 
                  " SELECT 
                        subject.id as ID, 
                        subject.name as Name,
                        if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
                  FROM document 
                        INNER JOIN user ON document.owner = user.id 
                        INNER JOIN subject ON document.subject = subject.id 
                        INNER JOIN degreecourse ON subject.degreecourse = degreecourse.id 
                  GROUP BY subject.id
                  ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, subject.name; ");

define("sqlStatement_UserDownload", 
                  " SELECT 
                        user.id as ID, 
                        user.name as Name,
                        if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) as Value
                  FROM document 
                        INNER JOIN user ON document.owner = user.id 
                  GROUP BY user.id
                  ORDER BY if(sum(document.downloadCounter) is null, 0, sum(document.downloadCounter)) DESC, user.name; ");

define("sqlStatement_UserActive", 
                  " SELECT 
                        user.id as ID, 
                        user.name as Name,
                        count(*) as Value
                  FROM document 
                        INNER JOIN user ON document.owner = user.id 
                  GROUP BY user.id
                  ORDER BY count(*) DESC, user.name; ");
                  
function getInfo(&$sqlStatement, &$parameterTypes, &$parameters, $index, $par = null){
      switch($index){
            case "USRACT":
                  $sqlStatement = constant("sqlStatement_UserActive");
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            case "USRDOW":
                  $sqlStatement = constant("sqlStatement_UserDownload");
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            case "SUBALL":
                  $sqlStatement = constant("sqlStatement_SubjectAll");
                  $parameterTypes = "";
                  $parameters = array();
                  return;
            case "SUBDEG":
                  $sqlStatement = constant("sqlStatement_SubjectDegree");
                  $parameterTypes = "i";
                  $parameters = array($par);
                  return;
            default:
            case "DEG":
                  $sqlStatement = constant("sqlStatement_Degrees");
                  $parameterTypes = "";
                  $parameters = array();
                  return;
      }
}
?>