<?php
session_start();
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');

$po = new POUZIVATELIA();
$po = POUZIVATELIA::vrat_pouzivatela($_GET["id"]);

?>
<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

      
	<title>Registracny system</title>
  <link rel="stylesheet" href="styl/styly.css">  
      
</head>

<body>
  <header>
    <?php echo "<h1>Platby - ".$po->meno." ".$po->priezvisko."</h1>"; ?>
  </header>
  
  <nav><?php
    if (isset ($_GET["pr"])) {  
      echo "<a href='pretek.php?id=". $_GET["pr"] ."'>Späť</a>";
    }
    else {
      echo "<a href='zoznam_pouzivatelov.php'>Späť</a>";
    }  
    ?>
  </nav> 
  
<section>
 
<div id="tab_platby">  
    <form method="post">
      <h2>Zoznam platieb</h2>
      <table border="1" style="width:100%">
          <tr>
            <td class="prvy"></td>
            <td class="prvy">ID platby</td>
            <td class="prvy">Meno</td>
            <td class="prvy">Priezvisko</td> 
            <td class="prvy">ID</td>
            <td class="prvy">Dátum</td>
            <td class="prvy">Suma</td>
          </tr>
          
             <?php
      $pl = new PLATBY();
      PLATBY::vypis_zoznam($_GET["id"]);
      //unset($pl);
      ?>
          
      </table>
      <p>
        <input name="novy" type="submit" id="novy" value="Nová platba">
        <!--<input name="edit" type="submit" id="edit" value="Upravit platbu"> -->
        <input name="del" type="submit" id="del" value="Vymazať platbu"> 
      </p>
      
    </form>
    <br><br> <br> <br>  
</div>


    <br>
<?php 

$zobraz_form = false;



if ((isset($_POST['del']) && (isset($_POST['incharge'])) ))
{
    // PHP throws a fit if we try to loop a non-array
    if(is_array($_POST['incharge']))
    {
         foreach($_POST['incharge'] as $val)     // id platby
         {
            PLATBY::vymaz_platbu($val);
            //echo $val . '<br />';
            //echo $val."<br>";
            echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
            
        }
    }
}

if (isset($_POST['novy'])) 
{
    
    
         
  $zobraz_form = true;
            
  //echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
            
      
    
}
/*$pom = 0;
if ((isset($_POST['edit']) && (isset($_POST['incharge'])) ))
{
    // PHP throws a fit if we try to loop a non-array
    if(is_array($_POST['incharge']))
    {
         foreach($_POST['incharge'] as $val)     // id platby
         {
            //PLATBY::vymaz_platbu($val);
            
            $pom = $val;
            $zobraz_form = true;
            //echo $pom . '<br />';
            
            //echo $val."<br>";
            //echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
            
        }
    }
}*/
?> 

<?php

if ((isset($_POST['posli'])) &&
    (isset ($_POST['kedy'])  || 
    isset ($_POST['kolko']) )) {
    
     $pl->pridaj_platbu($_GET['id'],$_POST['kedy'],$_POST['kolko']);
     echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
    }
    
if (isset($_POST['cancel'])) {
  $zobraz_form = false;
}
    
    
if ($zobraz_form) {
  
?>
<div id="novy_pouzivatel">
	<form method="post" enctype="multipart/form-data">
  <h2>Pridať platbu</h2>
	<table>
    <tr>
		  <td><label for="kedy">Dátum:</label></td>
		  <td><input type="text" name="kedy" id="datetimepicker" size="30" value="<?php echo $pl->DATUM; ?>"></td>
		</tr>
    <tr>
      <td><label for="kolko">Suma:</label> </td>
		  <td><input type="text" name="kolko" id="kolko" size="30" value="<?php echo $pl->SUMA; ?>"></td>
		</tr>
  </table>
		           
	  	<p id="buttons">
        <input type="submit" name="posli" value="Pridaj">
        <input type="submit" name="cancel" value="Koniec">
        <?php } ?>
		  </p>
        
  </form>
</div>

  </section>
  
  <br>
  <footer>
    <div id="footer">TIS - projekt 2014, Registracny system pre sportovy klub</div>
  </footer>  
  <script src="js/jquery.js"></script>
  <script src="js/jquery.datetimepicker.js"></script>
  <script>
  $('#datetimepicker').datetimepicker({
  dayOfWeekStart : 1,
  format:'d-m-Y H:i',
  lang:'sk',
  showAnim: "show"
  });


  </script> 
  
  </body>
  </html>