<?php
session_start();
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');
$zobraz_form = false;
if (isset ($_POST['novy'])){
    $zobraz_form = true;
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
    <h1>Admin</h1>
  </header>

  <nav>
    <a href="zoznam_pouzivatelov.php">Zoznam všetkých používateľov a evidencia platieb</a>
  </nav>


<div id="zoz_pretekov_uzivatel">
  <h2>Zoznam pretekov<h2>
    <table border="1" style="width:100%">
      <tr>
        <td class="prvy">Názov pretekov</td>
        <td class="prvy">Dátum konania</td> 
        <td class="prvy">Deadline prihlásenia</td>
        <td class="prvy"> </td>
      </tr>
      
      <?php PRETEKY::vypis_zoznam_admin(); ?>
      
     </table>
     <form class="nove_preteky" method="post">
       <p id="button1">
         <input name="novy" type="submit" id="novy" value="Nové preteky"> 
       </p>
     </form>
</div>
      
<br> 



<section id="uprav_preteky">
<?php
$zobraz_form = false;

if (isset($_POST['novy'])){
  $zobraz_form = true;  

}
if (isset($_POST['end'])){
  $zobraz_form = false;  
}


if ( (isset ($_POST['posli'])) && 

    isset ($_POST['nazov']) && 
    isset ($_POST['datum']) &&
    isset ($_POST['deadline']) )  { 
    
 
 
  $p = new PRETEKY();
  $p->pridaj_pretek($_POST['nazov'],$_POST['datum'],$_POST['deadline']);
  echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
  unset($p);
  

  ?>
  
  <?php
  echo '<p class="chyba">Upravene!</p>';  
} 

if ($zobraz_form) {
?>
	<form method="post" enctype="multipart/form-data">
	 <table>
		<tr>
      <td><label for="nazov">Názov pretekov</label></td>
		  <td><input type="text" name="nazov" id="nazov" size="30" value="<?php echo ""; ?>"> </td>
		</tr>
    <tr>
		  <td><label for="datum">Dátum konania</label>  </td>
		  <td><input type="text" name="datum" id="datetimepicker1" size="30" value="<?php echo ""; ?>"></td>
		</tr>
    <tr>
      <td><label for="deadline">Deadline prihlásenia</label>    </td>
		  <td><input type="text" name="deadline" id="datetimepicker2" size="30" value="<?php echo ""; ?>"> </td>
		</tr>
	 </table>
   
   <p id="buttons">
   <input type="submit" name="posli" value="Pridaj">
   <input type="submit" name="end" value="Koniec">
   <br><br>
   </p>
  </form>
  <?php 
  } 
  ?>
	
</section>  
  
  
  <br>
  <footer>
    <div id="footer">TIS - projekt 2014, Registračný systém pre športový klub</div>
  </footer>  
<script src="js/jquery.js"></script>
  <script src="js/jquery.datetimepicker.js"></script>
  <script>
  $('#datetimepicker1').datetimepicker({
  dayOfWeekStart : 1,
  format:'d-m-Y H:i',
  lang:'sk'
  });


  </script>  
  <script>
  $('#datetimepicker2').datetimepicker({
  dayOfWeekStart : 1,
  format:'d-m-Y H:i',
  lang:'sk',
  showAnim: "show"
  });


  </script> 
</body>



</html>