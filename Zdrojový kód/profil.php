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
<?php zobraz_obrazok($_GET['id']);

 
 ?>
</form>
</div>
<div id="obsah">
<?php 
$po = new POUZIVATELIA();
  $po = POUZIVATELIA::vrat_pouzivatela($_GET["id"]);
echo $po->meno; 
echo" ";
echo $po->priezvisko;
echo"<br>";
echo $po->uspech;

unset($po);

?>
</div>
</div>
  

  



</section> 
<?php 

}
unset($po);
?>
  
</body>



</html>