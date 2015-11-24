<?php
session_start();
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');

$po = new PRETEKY();
$po = PRETEKY::vrat_pretek($_GET["id"]);

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
    <?php echo "<h1>Upraviť preteky ".$po->ID." - ".$po->NAZOV."</h1>"; ?>
  </header>
  
  <nav>
  <a href="admin.php">Späť</a>
  </nav>  
  
<section id="uprav_preteky">
<?php

$zobraz_form = true; 

if ( (isset ($_POST['posli'])) && 

    isset ($_POST['nazov']) || 
    isset ($_POST['datum']) ||
    isset ($_POST['deadline']) )  { 
    
  //$po->uprav_pretek ($_POST['meno'], $_POST['priezvisko'], $_POST['oscislo'], $_POST['cip'], $_POST['poznamka']);
 
  $po->uprav_pretek($_POST['nazov'], $_POST['datum'], $_POST['deadline']);  
  unset($po);?>
  <meta http-equiv="refresh" content="0;URL=admin.php" />
  <?php
  $po = new PRETEKY();
  $po = PRETEKY::vrat_pretek($_GET["id"]);
  

  ?>
  
  <?php
   
} 
if (isset($_POST['zmaz']) ){
  $zobraz_form = false;
  $po = new PRETEKY();
  PRETEKY::vymaz_pretek($_GET['id']);
  unset($po);  
  echo '<p class="chyba">Vymazane!</p>';
  echo '<meta http-equiv="refresh" content="0; URL=admin.php">'; 
   
}

if ($zobraz_form) {
?>
	<form method="post" enctype="multipart/form-data">
	 <table>
		<tr>
      <td><label for="nazov">Názov pretekov</label></td>
		  <td><input type="text" name="nazov" id="nazov" size="30" value="<?php echo $po->NAZOV; ?>"> </td>
		</tr>
    <tr>
		  <td><label for="datum">Dátum konania</label>  </td>
		  <td><input type="text" name="datum" id="datetimepicker" size="30" value="<?php echo $po->DATUM; ?>"></td>
		</tr>
    <tr>
      <td><label for="deadline">Deadline prihlásenia</label>    </td>
		  <td><input type="text" name="deadline" id="datetimepicker1" size="30" value="<?php echo $po->DEADLINE; ?>"> </td>
		</tr>
	 </table>
   
   <p id="buttons">
   <input type="submit" name="posli" value="Uprav">
   <input type="submit" name="zmaz" value="Vymaž">
   </p>
  </form>
  
  <?php } ?>
	
</section> 
  
<br>
<footer>
  <div id="footer">TIS - projekt 2014, Registračný systém pre športový klub</div>
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
  <script>
  $('#datetimepicker1').datetimepicker({
  dayOfWeekStart : 1,
  format:'d-m-Y H:i',
  lang:'sk',
  showAnim: "show"
  });


  </script>  
  
</body>



</html>