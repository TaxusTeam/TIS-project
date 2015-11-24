<?php
session_start();
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');

$po = new POUZIVATELIA();
$po = POUZIVATELIA::vrat_pouzivatela($_GET["id"]);


if(isset($_POST['posli3'])){
  vymaz_obrazok($_GET['id']);
  pridaj_obrazok($_GET['id']);

}
if(isset($_POST['vymaz'])){

  vymaz_obrazok($_GET['id']);

}

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
    <?php echo "<h1>Upraviť údaje používateľa -  ".$po->meno." ".$po->priezvisko."</h1>"; ?>
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
  
  
<section id="uprav"><div id="profil">
<div id="foto">
  <form method="post" enctype="multipart/form-data">
<?php zobraz_obrazok($_GET['id']); ?>

</form>
</div>
</div>



  
<?php 
$zobraz_form = true;

if (isset ($_POST['posli2']) )  { 
  $po->vymaz_pouzivatela($_GET['id']);
  //unset($po);
  
  ?>
  
  <?php
  echo '<p class="chyba">Vymazane!</p>';
  $zobraz_form = false;  
}

if ((isset ($_POST['posli'])) && 
    
    isset ($_POST['meno'])  || 
    isset ($_POST['priezvisko']) || 
    isset ($_POST['oscislo']) ||
    isset ($_POST['cip']) || 
    isset ($_POST['poznamka']) ||
    isset ($_POST['uspech']))  { 

  $po->uprav_pouzivatela ($_POST['meno'], $_POST['priezvisko'], $_POST['oscislo'], $_POST['cip'], $_POST['poznamka'], $_POST['uspech']);
echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
 
  unset($po);
  $po = new POUZIVATELIA();
  $po = POUZIVATELIA::vrat_pouzivatela($_GET["id"]);
  ?>
  
  <?php

    
} 

if ($zobraz_form) {
?>
<div id="f">
	<form method="post" enctype="multipart/form-data">
    <table>
    <tr>
		    <td><label for="meno">Meno</label></td>
		    <td><input type="text" name="meno" id="meno" size="30" value="<?php echo $po->meno; ?>"></td>
		</tr>
    <tr>
        <td><label for="priezvisko">Priezvisko</label></td>
		    <td><input type="text" name="priezvisko" id="priezvisko" size="30" value="<?php echo $po->priezvisko; ?>"></td>
		</tr>
    <tr>
		    <td><label for="oscislo">Osobné číslo</label> </td>
		    <td><input type="text" name="oscislo" id="oscislo" size="30" value="<?php echo $po->os_i_c; ?>"> </td>
		</tr>
    <tr>
        <td><label for="cip">Čip</label> </td>
		    <td><input type="text" name="cip" id="cip" size="30" value="<?php echo $po->chip; ?>"></td>
		</tr>
    <tr>
        <td><label for="poznamka">Poznámka</label></td>
		    <td><input type="text" name="poznamka" id="poznamka" size="30" value="<?php echo $po->poznamka; ?>"> </td>
		</tr>
    <tr>
       <td> <label for="uspech">Úspechy</label> </td>
       <td> <textarea cols="27" rows="5" name="uspech" id="uspech"><?php echo $po->uspech; ?></textarea></td>
	     	
		</tr>	
  </table>
  
	  <p id="buttons">
      <input type="submit" name="posli" value="Upraviť"> 
      <input type="submit" name="posli2" value="Vymazať" onclick="alert('Urcite?');"> 
     
		</p>
      
  </form>
</div>
<?php } ?> 
</section> 
  
  
</body>



</html>