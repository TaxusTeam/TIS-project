<?php

/*
* Trieda PRETEK ktoru pouzijeme na udrzovanie udajov o pretekoch.
*/
class PRETEKY
{
  public $ID;
  public $NAZOV;
  public $DATUM;
  public $DEADLINE;
  /**
  *Prida udaje objektu preteky do databazy
  */

    public function nacitaj($ID,$NAZOV,$DATUM,$DEADLINE){
        $this->ID = $ID;
        $this->NAZOV = $NAZOV;
        $this->DATUM = $DATUM;
        $this->DEADLINE = $DEADLINE;
    }

  public function pridaj_pretek($NAZOV, $DATUM, $DEADLINE){
   $db = napoj_db();

   $sql =<<<EOF
      INSERT INTO PRETEKY (
         NAZOV,DATUM,DEADLINE)
      VALUES ("$NAZOV", "$DATUM", "$DEADLINE");
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Records created successfully\n";
   }
   $db->close();
  }

/**
*upravy pretek v databaze podla aktualneho id objektu preteky
*/
  function uprav_pretek ($NAZOV, $DATUM, $DEADLINE){
  if(!$this->ID){
    return false;
  }
    $db = napoj_db();
    $sql =<<<EOF
       UPDATE PRETEKY set NAZOV = "$NAZOV" where ID="$this->ID";
       UPDATE PRETEKY set DATUM = "$DATUM" where ID="$this->ID";
       UPDATE PRETEKY set DEADLINE = "$DEADLINE" where ID="$this->ID";
EOF;
    $ret = $db->exec($sql);
    if(!$ret){
       echo $db->lastErrorMsg();
    } else {
       
    }
   $db->close();
  }

/**
*prihlasy pouzivatela na pretek
*/
static function odhlas_z_preteku($ID,$ID_pouz){
  $db = napoj_db();

   $sql =<<<EOF
      DELETE FROM PRIHLASENY WHERE (ID_POUZ = $ID_pouz) AND (ID_PRET=$ID);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Uspesne vymazane";
   }
   $db->close();
}

/**
*odhlasy pouzivatela na pretek
*/
static function prihlas_na_pretek($ID,$ID_pouz){
  $db = napoj_db();

    $sql =<<<EOF
      INSERT INTO PRIHLASENY (
         ID_POUZ,ID_PRET)
      VALUES ($ID_pouz,$ID);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
    } else {
      echo "uspesne pridane";
    }
    $db->close();
}


/**
*vrati zoznam pouzivatelov pruhlasenych na pretek s duplicitnym chipom
*/

public function vypis_prihlasenych_d_chip(){
    $db = napoj_db();
    $sql =<<<EOF
           CREATE TABLE temp
      (ID INTEGER NOT NULL,
      MENO              VARCHAR    NOT NULL,
      PRIEZVISKO        VARCHAR    NOT NULL,
      OS_I_C            VARCHAR,
      CHIP              INT,
      POZNAMKA          VARCHAR,
      USPECH            VARCHAR
      );
EOF;
$db->exec($sql);
$sql =<<<EOF
          INSERT INTO temp(ID, meno, priezvisko, OS_I_C, CHIP, POZNAMKA, USPECH) SELECT POUZIVATELIA.* FROM POUZIVATELIA INNER JOIN PRIHLASENY ON POUZIVATELIA.ID = PRIHLASENY.ID_POUZ  WHERE (PRIHLASENY.ID_PRET = $this->ID);
EOF;
$db->exec($sql);
$sql =<<<EOF
         SELECT temp.* FROM temp WHERE temp.CHIP in (SELECT temp.CHIP from temp GROUP BY temp.CHIP HAVING COUNT (temp.CHIP) > 1);
EOF;
$ret = $db->query($sql);
$sql =<<<EOF
         DROP TABLE TEMP;
EOF;
        
           
           


      
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        //echo "<b>".$row['ID'],$row['MENO'],$row['PRIEZVISKO'],$row['OS_I_C'],$row['CHIP'],$row['POZNAMKA']."</b><br>";
        echo "<tr>";
        echo '<td><input type="checkbox" name="incharge[]" value="'.$row['ID'].'"/></td>';
        echo "<td><font color='red'>".$row['ID']."</font></td>";
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='red'>".$row['MENO']."</font></a></td>";      //***********************
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='red'>".$row['PRIEZVISKO']."</font></a></td>";
        echo "<td><font color='red'>".$row['OS_I_C']."</font></td>";
        echo "<td><font color='red'>".$row['CHIP']."</font></td>";
        echo "<td><font color='red'>".$row['POZNAMKA']."</font></td>";
        echo "<td>
        <a href='uprav.php?id=".$row['ID']."&pr=".$_GET["id"]."'>Uprav</a></td></tr> ";

      }
      // echo "Operation done successfully"."<br>";   ///////////////////
       $db->exec($sql);   
       $db->close();
  }
/**
*vrati zoznam pouzivatelov pruhlasenych na pretek s unikatnym chipom
*/
public function vypis_prihlasenych_u_chip(){
    $db = napoj_db();
    $sql =<<<EOF
           CREATE TABLE temp
      (ID INTEGER NOT NULL,
      MENO              VARCHAR    NOT NULL,
      PRIEZVISKO        VARCHAR    NOT NULL,
      OS_I_C            VARCHAR,
      CHIP              INT,
      POZNAMKA          VARCHAR,
      USPECH            VARCHAR
      );
EOF;
$db->exec($sql);
$sql =<<<EOF
          INSERT INTO temp(ID, meno, priezvisko, OS_I_C, CHIP, POZNAMKA, USPECH) SELECT POUZIVATELIA.* FROM POUZIVATELIA INNER
           JOIN PRIHLASENY ON POUZIVATELIA.ID = PRIHLASENY.ID_POUZ  WHERE (PRIHLASENY.ID_PRET = $this->ID);
EOF;
$db->exec($sql);
$sql =<<<EOF
         SELECT temp.* FROM temp WHERE temp.CHIP in (SELECT temp.CHIP from temp GROUP BY temp.CHIP HAVING COUNT (temp.CHIP) = 1);
EOF;
$ret = $db->query($sql);
$sql =<<<EOF
         DROP TABLE TEMP;
EOF;

    
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        //echo $row['ID'],$row['MENO'],$row['PRIEZVISKO'],$row['OS_I_C'],$row['CHIP'],$row['POZNAMKA']."<br>";
        echo "<tr>";
        echo '<td><input type="checkbox" name="incharge[]" value="'.$row['ID'].'"/></td>';
        echo "<td>".$row['ID']."</td>";
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='black'>".$row['MENO']."</font></a></td>";
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='black'>".$row['PRIEZVISKO']."</font></a></td>";
        echo "<td>".$row['OS_I_C']."</td>";
        echo "<td>".$row['CHIP']."</td>";
        echo "<td>".$row['POZNAMKA']."</td>";
        echo "<td>
        <a href='uprav.php?id=".$row['ID']."&pr=".$_GET["id"]."'>Uprav</a></td></tr> ";

      }
       // echo "Operation done successfully"."<br>";      ////////////////////////////
       $db->exec($sql);
       $db->close();
  }

/**
*vrati zoznam neprihlasenych
*/

public function vypis_neprihlasenych(){
    $db = napoj_db();
    $sql =<<<EOF
           CREATE TABLE temp
      (ID INTEGER NOT NULL,
      MENO              VARCHAR    NOT NULL,
      PRIEZVISKO        VARCHAR    NOT NULL,
      OS_I_C            VARCHAR,
      CHIP              INT,
      POZNAMKA          VARCHAR,
      USPECH            VARCHAR
      );
EOF;
$db->exec($sql);
    $sql =<<<EOF
        INSERT INTO temp(ID, meno, priezvisko, OS_I_C, CHIP, POZNAMKA, USPECH) SELECT POUZIVATELIA.* FROM POUZIVATELIA LEFT OUTER JOIN PRIHLASENY ON PRIHLASENY.ID_POUZ = POUZIVATELIA.ID 
        WHERE PRIHLASENY.ID is null
        OR (PRIHLASENY.ID_PRET <> $this->ID AND PRIHLASENY.ID_POUZ NOT IN 
          (SELECT PRIHLASENY.ID_POUZ FROM PRIHLASENY WHERE ID_PRET = $this->ID));
           
           
EOF;
$db->exec($sql);
$sql =<<<EOF
         SELECT temp.* FROM temp WHERE temp.ID GROUP BY temp.ID;
EOF;
$ret = $db->query($sql);

$sql =<<<EOF
         DROP TABLE TEMP;
EOF;

      
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        
        echo "<tr>";
        echo '<td><input type="checkbox" name="incharge[]" value="'.$row['ID'].'"/></td>';
        echo "<td>".$row['ID']."</td>";                                                
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='black'>".$row['MENO']."</font></a></td>";
        echo "<td><a href='profil.php?id=".$row['ID']."&pr=".$_GET["id"]."'><font color='black'>".$row['PRIEZVISKO']."</font></a></td>";
        echo "<td>".$row['OS_I_C']."</td>";
        echo "<td>".$row['CHIP']."</td>";
        echo "<td>".$row['POZNAMKA']."</td>";
        echo "<td>
        <a href='uprav.php?id=".$row['ID']."&pr=".$_GET["id"]."'>Uprav</a></td></tr> ";

      }
      // echo "Operation done successfully"."<br>";       ////////////////////////
      $db->exec($sql);
       $db->close();
}



/**
*nastavy parametre preteku podla zvoleneho id
*/
  static function vrat_pretek ($ID){
    $db = napoj_db();
      $sql =<<<EOF
         SELECT * from Preteky WHERE ID=$ID;
EOF;

      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
        $pom = new PRETEKY();
        $pom->nacitaj($ID,$row['NAZOV'],$row['DATUM'],$row['DEADLINE']);
       }
       // echo "Operation done successfully"."<br>";    //////////////
       $db->close();
       return $pom;
  }

/**
*vymaze pretek z DB podla id objektu PRETEKY
*/
  static function vymaz_pretek($ID){
    $db = napoj_db();
    $sql =<<<EOF
       DELETE FROM PRETEKY WHERE ID = $ID;
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
*Vrati zoznam zoznam pretekov 
*/
static function vypis_zoznam(){
  
   $db = napoj_db();

   $sql =<<<EOF
      SELECT * from Preteky ORDER BY ID DESC;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
    echo "<tr><td><a href='pretek.php?id=".$row['ID']."'>".$row['NAZOV']."</a></td>";
    echo "<td>".$row['DATUM']."</td>";
    echo "<td>".$row['DEADLINE']."</td>";
    //echo "<td><a href='uprav_preteky.php?id=".$row['ID']."'>Uprav</a></td>";
    echo "<tr>";
    
    
   }
   //echo "Operation done successfully"."<br>";   ////////////////////////////////
   $db->close();
}


static function vypis_zoznam_admin(){
  
   $db = napoj_db();

   $sql =<<<EOF
      SELECT * from Preteky ORDER BY ID DESC;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
    echo "<tr><td><a href='pretek.php?id=".$row['ID']."&ad=1'>".$row['NAZOV']."</a></td>";
    echo "<td>".$row['DATUM']."</td>";
    echo "<td>".$row['DEADLINE']."</td>";
    echo "<td><a href='uprav_preteky.php?id=".$row['ID']."'>Uprav</a></td>";
    echo "<tr>";
    
    
   }
   //echo "Operation done successfully"."<br>";   ////////////////////////////////
   $db->close();
}




}
 ?>