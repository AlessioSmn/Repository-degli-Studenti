<?php
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';

include_once '../config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';
?>

<option disabled selected style="font-style: italic;"> -- seleziona una materia --</option>
<?php
if(isset($_POST["degreecourse_selector"])){
      $sqlStatement = "  SELECT id, name 
                  FROM subject 
                  WHERE degreecourse = ?;";
      $type = "i";
      $dc = $_POST["degreecourse_selector"];
      $result = executePreparedStatement($sqlStatement, $a, $type, array($dc));
      if($result)
            while($row = mysqli_fetch_assoc($result))
                  echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
}
?>