<?php 
$prevDir = isset($prevDir) ? "" : "../";
$pageName = isset($pageName) ? $pageName : null;
include 'loginControl.php';
 
include_once 'config/config.php';
include_once 'classes/DBconnect.php';
include_once 'utils/executePreparedStatement.php';

$connection = new DatabaseConnect();

// default selected option
echo "<option disabled selected style=\"font-style: italic;\"> -- AAAA seleziona un corso di studio --</option>";
$query = "SELECT id, name FROM degreecourse;";
// $result = mysqli_query($connection->getConnection(), $query);

$result = executePreparedStatement($query, $affectedRows);

if($result)
      while($row = mysqli_fetch_assoc($result))
            // fill the list with all degrees' options
            echo "<option value=\"".$row['id']."\">".$row['name']."</option>";

?>