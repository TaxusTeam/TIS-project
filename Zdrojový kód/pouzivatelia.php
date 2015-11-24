<?php



class POUZIVATELIA
{  
  public $id;
  public $meno;
  public $prezvisko;
  public $os_i_c;
  public $chip;
  public $poznamka;
  public $uspech;

  function __construct(){


  }

  function nacitaj($id, $meno,$prezvisko,$os_i_c,$chip,$poznamka,$uspech){
    $this->id = $id;
    $this->meno = $meno;   ///////////////////
    $this->priezvisko = $prezvisko;
    $this->os_i_c = $os_i_c;
    $this->chip = $chip;
    $this->poznamka = $poznamka;
    $this->uspech = $uspech;
  }

  function pridaj_pouzivatela($meno,$prezvisko,$os_i_c,$chip,$poznamka,$uspech){

    $db = napoj_db();

   $sql =<<<EOF
      INSERT INTO POUZIVATELIA (
         MENO,PRIEZVISKO,OS_I_C,CHIP,POZNAMKA,USPECH)
      VALUES ("$meno", "$prezvisko", "$os_i_c", "$chip", "$poznamka","$uspech");
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      //echo "Records created successfully\n";
   }
   $db->close();

  }


  static function vrat_pouzivatela($ID){
    $db = napoj_db();
    $sql =<<<EOF
       SELECT * FROM POUZIVATELIA WHERE ID = $ID;
EOF;
    $ret = $db->query($sql);
    if(!$ret){
      echo $db->lastErrorMsg();
      
      return false;
   } else {
      //echo "Records got successfully\n";
      
      while($row = $ret->fetchArray(SQLITE3_ASSOC)){
        $p = new self();
        $p->nacitaj($row['ID'], $row['MENO'], $row['PRIEZVISKO'], $row['OS_I_C'], $row['CHIP'], $row['POZNAMKA'], $row['USPECH']);
        return $p;
      }
      $db->close();
   }
   
    
  }
  
  




static function vypis_zoznam_admin(){
    $db = napoj_db();

   $sql =<<<EOF
      SELECT * from POUZIVATELIA;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      /*echo "ID = ". $row['ID'] ."<br>";
      echo "MENO = ". $row['MENO'] ."<br>";
      echo "PRIEZVISKO = ". $row['PRIEZVISKO'] ."<br>";
      echo "OS_I_C =  ".$row['OS_I_C'] ."<br>";
      echo "CHIP =  ".$row['CHIP'] ."<br>";
      echo "POZNAMKA =  ".$row['POZNAMKA'] ."<br><br>";   */
      
      echo "<tr>";
        //echo '<td><input type="checkbox" name="person" value="'. $row['ID'].'"></td>';
        echo '<td><input type="checkbox" name="incharge[]" value="'.$row['ID'].'"/></td>';
        echo "<td>".$row['ID']."</td>";
        echo "<td><a href='profil.php?id=".$row['ID']."'><font color='black'>".$row['MENO']."</font></a></td>";
        echo "<td><a href='profil.php?id=".$row['ID']."'><font color='black'>".$row['PRIEZVISKO']."</font></a></td>";
        echo "<td>".$row['OS_I_C']."</td>";
        echo "<td>".$row['CHIP']."</td>";
        echo "<td>".$row['POZNAMKA']."</td>";
        //echo "<td><input type=\"checkbox\" name=\"".$row['ID']."\" value=\"".$row['ID']."\"></td></tr>";
        echo "<td>
        <a href='uprav.php?id=".$row['ID']."'>Uprav</a></td>";
        echo "<td>
        <a href='platba.php?id=".$row['ID']."'>Platby</a></td></tr> ";

        
   }
   //echo "Operation done successfully"."<br>";
   $db->close();

  }

static function vymaz_pouzivatela($ID){
  $db = napoj_db();
    $sql =<<<EOF
       DELETE FROM POUZIVATELIA WHERE ID = $ID;
       DELETE FROM PRIHLASENY WHERE ID_POUZ = $ID;
EOF;
    $ret = $db->exec($sql);
    if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      //echo "Records removed successfully\n";
   }
   $db->close();
  

}

function uprav_pouzivatela ($MENO, $PRIEZVISKO, $OS_I_C, $CHIP, $POZNAMKA, $uspech){
    $db = napoj_db();
    $sql =<<<EOF
       UPDATE POUZIVATELIA set MENO = "$MENO" where ID="$this->id";
       UPDATE POUZIVATELIA set PRIEZVISKO = "$PRIEZVISKO" where ID="$this->id";
       UPDATE POUZIVATELIA set OS_I_C = "$OS_I_C" where ID="$this->id";
       UPDATE POUZIVATELIA set CHIP = "$CHIP" where ID="$this->id";
       UPDATE POUZIVATELIA set POZNAMKA = "$POZNAMKA" where ID="$this->id";
       UPDATE POUZIVATELIA set USPECH = "$uspech" where ID="$this->id";
EOF;
    $ret = $db->exec($sql);
    if(!$ret){
       echo $db->lastErrorMsg();
    } else {
       //echo $db->changes(), " Record updated successfully\n";
    }
   $db->close();
  }








}
 ?>