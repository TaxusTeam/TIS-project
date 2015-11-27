<?php
class KATEGORIE{
  function vypis_kategorie_admin(){
    $db = napoj_db();

    $sql =<<<EOF
      SELECT * from Kategorie ORDER BY ID DESC;
    EOF;

    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      echo "<tr><td>".$row['nazov']."</td>";
      echo "<td><a href='uprav_kategoriu.php?id=".$row['id_kategoria']."'>Uprav</a></td>";
      echo "<tr>";
    }
   $db->close();
  }
}
?>