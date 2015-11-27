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
<?php
   
    if($po){?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script src="thumbnailviewer.js" type="text/javascript"></script>
      
	<title>Registracny system</title>
  <link rel="stylesheet" href="styl/styly.css">  
  <link rel="stylesheet" href="thumbnailviewer.css"> 
      
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
  if(isset($_SESSION['admin'])&&$_SESSION['admin']==1){
    echo '<meta http-equiv="refresh" content="0; URL=admin.php">';
  }else{
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
  }
  //unset($po);
  
  ?>
  
  <?php
  echo '<p class="chyba">Vymazane!</p>';
  $zobraz_form = false;  
}

if ((isset ($_POST['posli'])) && 
    
    over ($_POST['meno'])  &&
    over ($_POST['priezvisko']) )  { 

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
      <?php if(isset($_POST['meno']) && !over($_POST['meno'])){echo'<tr><td><font color="red">Nevyplnili ste meno!</font></td></tr>';} ?>
    <tr>
		    <td><label for="meno">Meno</label></td>
		    <td><input type="text" name="meno" id="meno" size="30" value="<?php if(isset($_POST['meno'])){echo $_POST['meno'];}else{echo $po->meno;} ?>"></td>
		</tr>
    <?php if(isset($_POST['priezvisko']) && !over($_POST['priezvisko'])){echo'<tr><td><font color="red">Nevyplnili ste priezvisko!</font></td></tr>';} ?>
    <tr>
        <td><label for="priezvisko">Priezvisko</label></td>
		    <td><input type="text" name="priezvisko" id="priezvisko" size="30" value="<?php if(isset($_POST['priezvisko'])){echo $_POST['priezvisko'];}else{echo $po->priezvisko;} ?>"></td>
		</tr>
    <tr>
		    <td><label for="oscislo">Osobné číslo</label> </td>
		    <td><input type="text" name="oscislo" id="oscislo" size="30" value="<?php if(isset($_POST['oscislo'])){echo $_POST['oscislo'];}else{echo $po->os_i_c;} ?>"> </td>
		</tr>
    <tr>
        <td><label for="cip">Čip</label> </td>
		    <td><input type="text" name="cip" id="cip" size="30" value="<?php if(isset($_POST['cip'])){echo $_POST['cip'];}else{echo $po->chip;} ?>"></td>
		</tr>
    <tr>
        <td><label for="poznamka">Poznámka</label></td>
		    <td><input type="text" name="poznamka" id="poznamka" size="30" value="<?php if(isset($_POST['poznamka'])){echo $_POST['poznamka'];}else{echo $po->poznamka;} ?>"> </td>
		</tr>
    <tr>
       <td> <label for="uspech">Úspechy</label> </td>
       <td> <textarea cols="27" rows="5" name="uspech" id="uspech"><?php if(isset($_POST['uspech'])){echo $_POST['uspech'];}else{echo $po->uspech;} ?></textarea></td>
	     	
		</tr>	
  </table>
  
	  <p id="buttons">
      <input type="submit" name="posli" value="Upraviť"> 
      <input type="submit" name="posli2" value="Vymazať" onclick="return confirm('Naozaj chcete vymazať používateľa?');"> 
     
		</p>
      
  </form>
</div>
<?php } 
}
unset($pt);
?> 
</section> 
  
  
</body>



</html>