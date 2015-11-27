<?php


/*
* Trieda PLATBY ktoru pouzijeme na udrzovanie udajov o PLATBACH.
*/

CLASS PLATBY{
  public $ID;
  public $ID_POUZ;
  public $DATUM;
  public $SUMA;



  public function nacitaj($ID,$ID_POUZ,$DATUM,$SUMA){
        $this->ID = $ID;
        $this->ID_POUZ = $ID_POUZ;
        $this->DATUM = $DATUM;
        $this->SUMA = $SUMA;
    }

  public function pridaj_platbu($ID_POUZ, $DATUM, $SUMA){
   $db = napoj_db();
   $SUMA2 = htmlentities($SUMA, ENT_QUOTES, 'UTF-8');
   $sql =<<<EOF
      INSERT INTO PLATBY (
         ID_POUZ,DATUM,SUMA)
      VALUES ("$ID_POUZ", "$DATUM", "$SUMA2");
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Records created successfully\n";
   }
   $db->close();
  }

  static function vrat_platbu ($ID){
    $db = napoj_db();
      $sql =<<<EOF
         SELECT * from PLATBY WHERE ID=$ID;
EOF;

      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        $pom = new PLATBY();
        $pom->nacitaj($ID,$row['ID_POUZ'],$row['DATUM'],$row['SUMA']);
       }
       echo "Operation done successfully"."<br>";
       $db->close();
       return $pom;
  }


    function uprav_platbu ($ID_POUZ, $DATUM, $SUMA){
  if(!$this->ID){
    return false;
  }
    $db = napoj_db();
    $sql =<<<EOF
       UPDATE PLATBY set ID_POUZ = "$ID_POUZ" where ID="$this->ID";
       UPDATE PLATBY set DATUM = "$DATUM" where ID="$this->ID";
       UPDATE PLATBY set SUMA = "$SUMA" where ID="$this->ID";
EOF;
    $ret = $db->exec($sql);
    if(!$ret){
       echo $db->lastErrorMsg();
    } else {
       echo $db->changes(), " Record updated successfully\n";
    }
   $db->close();
  }


  /**
*vymaze platbu z DB podla id objektu PLATBY
*/
  static function vymaz_platbu($ID){
    $db = napoj_db();
    $sql =<<<EOF
       DELETE FROM PLATBY WHERE ID = $ID;
EOF;
     $ret = $db->exec($sql);
    if(!$ret){
       echo $db->lastErrorMsg();
    } else {
       echo $db->changes(), " Record removed successfully\n";
    }
   $db->close();
    
  }

/**
*Vrati zoznam platieb 
*/
static function vypis_zoznam($idd){
  
   $db = napoj_db();

   $sql =<<<EOF
      SELECT * from POUZIVATELIA INNER JOIN PLATBY ON PLATBY.ID_POUZ = POUZIVATELIA.ID;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
     
     if ($idd == $row['ID_POUZ']){
       echo '<tr><td><input type="radio" name="incharge[]" value="'.$row['ID'].'"/></td>';
       echo '<td>'.$row['ID'].'</td><td>'.$row['MENO'] ."</td><td>" .$row['PRIEZVISKO'] ."</td><td>" .$row['ID_POUZ']."</td><td>".$row['DATUM']."</td><td>".$row['SUMA']."</td></tr>";  
     } 
   }
   //echo "Operation done successfully"."<br>";
   $db->close();
}

}

 ?>