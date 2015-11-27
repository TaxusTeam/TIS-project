<?php
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');

$po = new POUZIVATELIA();
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
    <h1>Admin - Zoznam všetkých používateľov</h1>
  </header> 

  <nav>
  <a href="admin.php">Späť</a>     
  </nav>
  
<section id="vsetci_pouzivatelia"> 
  <form method="post">
    <h2>Zoznam používateľov</h2>
    <table border="1">
      <tr> 
        <td class="prvy"></td>
        <td class="prvy">ID</td>
        <td class="prvy">Meno</td> 
        <td class="prvy">Priezvisko</td>
        <td class="prvy">Osobné číslo</td>
        <td class="prvy">Čip</td>
        <td class="prvy">Poznámka</td>
        <td class="prvy">Akcia</td>
        <td class="prvy">Platby</td>
      </tr>
        <?php
        $po->vypis_zoznam_admin();
        ?>
    </table> 

    
   <p> 
    <input name="del" type="submit" id="del" onclick="return confirm('Naozaj chcete vymazať používateľa?');" value="Vymazať používateľa"> <!-- aj v admine kde su vsetci pouzivatelia-->
    <input name="novy" type="submit" id="novy" value="Nový používateľ"> <!-- aj v admine kde su vsetci pouzivatelia-->
   </p>
  </form>
  
  <br>  <br><br><br>
    
</section>  

<section>
<?php 

if (isset($_POST['del']))
{
    // PHP throws a fit if we try to loop a non-array
    if(is_array($_POST['incharge']))
    {
         foreach($_POST['incharge'] as $val)
         {
            //echo $val . '<br />';
            $po = new POUZIVATELIA();
            $po->vymaz_pouzivatela($val);
            unset($po);
            echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
        }
    }
}


$zobraz_form = false;

$po = new POUZIVATELIA();

if (isset ($_POST['novy'])){
    $zobraz_form = true;
}

if (isset ($_POST['stop'])){
    $zobraz_form = false;
}


if ((isset ($_POST['posli'])) && 
    
    (isset ($_POST['meno'])  && 
    isset ($_POST['priezvisko']) && 
    isset ($_POST['oscislo']) &&
    isset ($_POST['cip']) && 
    isset ($_POST['poznamka'])) )  { 


 $zobraz_form = false;
   $po->pridaj_pouzivatela ($_POST['meno'], $_POST['priezvisko'], $_POST['oscislo'], $_POST['cip'], $_POST['poznamka'], $_POST['uspech']);
  
  unset($po);
  
  ?>
  
  <?php
  echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
  echo '<p class="chyba">Pridane!</p>';  
}





//$zobraz_form =true;
if ($zobraz_form) {
?>

<div  id="novy_pouzivatel">
	<form method="post" enctype="multipart/form-data">
    <h2>Nový používateľ</h2>
		<table>
    <tr>
		    <td><label for="meno">Meno</label></td>
		    <td><input type="text" name="meno" id="meno" size="30" value="<?php echo ""; ?>"></td>
		</tr>
    <tr>
        <td><label for="priezvisko">Priezvisko</label></td>
		    <td><input type="text" name="priezvisko" id="priezvisko" size="30" value="<?php echo ""; ?>"></td>
		</tr>
    <tr>
		    <td><label for="oscislo">Osobne číslo</label></td>
		    <td><input type="text" name="oscislo" id="oscislo" size="30" value="<?php echo ""; ?>"></td>
		</tr>
    <tr>
        <td><label for="cip">Čip</label></td>
		    <td><input type="text" name="cip" id="cip" size="30" value="<?php echo""; ?>"></td>
		</tr>
    <tr>
        <td><label for="poznamka">Poznámka</label></td>
		    <td><input type="text" name="poznamka" id="poznamka" size="30" value="<?php echo""; ?>"></td>
		</tr>
    <tr>
        <td><label for="uspech">Úspechy</label></td>
		    <td> <textarea cols="27" rows="5" name="uspech" id="uspech"></textarea></td>
		</tr>
  </table>  
    <!--text area-->
		
	  <p id="buttons">
      <input type="submit" name="posli" value="Pridaj používateľa">
      <input type="submit" name="stop" value="Koniec">
     
		</p>  
  </form>
</div>
<?php } ?>	
</section>
  
  
  
  <br>
  <footer>
    <div id="footer">TIS - projekt 2014, Registracny system pre sportovy klub</div>
  </footer>  

</body>



</html>
