<?php
session_start();
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');
if(isset($_POST['export'])){
  vypis_db();?>
  <meta http-equiv="refresh" content="0;URL=zoznam.txt" />
  <?php
}
?>

<html>

<head>
<script type="text/javascript" src="sorter/jquery-latest.js"></script>
<script type="text/javascript" src="sorter/jquery.tablesorter.js"></script>
<script type="text/javascript">
  $(document).ready(function()
  {
    $("#myTable").tablesorter();
  }
);
  </script>
<script type="text/javascript">
  $(document).ready(function()
  {
    $("#myTable2").tablesorter();
  }
);
  </script>


	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">     
  
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />  -->
      
	<title>Registracny system</title>
  <link rel="stylesheet" href="styl/styly.css">  
  <link rel="stylesheet" href="sorter/themes/blue/style.css"> 
  <!--<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 480px)" href="styl/styly2.css" />   -->
      


</head>




<body>

<section> 

  <header><?php
    $pr = new PRETEKY();
    $pr=PRETEKY::vrat_pretek($_GET["id"]);
     echo "<h1>" . $pr->NAZOV . "</h1>";	
    unset($pr);
    ?>
  </header> 
  
  <nav>
    <?php
    
    if($_SESSION['admin'] ==1 ){

      echo "<a href='admin.php'>Späť</a><br>";
    }
    else {
      echo "<a href='index.php'>Späť</a>";
    }
    ?>
  </nav>
    

    <?php
    // vypis detailu preteku
    $pr = new PRETEKY();
    $pr=PRETEKY::vrat_pretek($_GET["id"]); ?>
    
    <form method="post">  

      <div id="upozornenie"> 
     <table class="u" border="1">
        <tr><td style="font-weight:bold;">Upozornenie<td><tr>
        <tr><td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean et est a dui semper facilisis. Pellentesque placerat elit a nunc. Nullam tortor odio, rutrum quis, egestas ut, posuere sed, felis. Vestibulum placerat feugiat nisl. Suspendisse lacinia, odio non feugiat vestibulum, sem erat blandit metus, ac nonummy magna odio pharetra felis. Vivamus vehicula velit non metus faucibus auctor. Nam sed augue. Donec orci. Cras eget diam et dolor dapibus sollicitudin. In lacinia, tellus vitae laoreet ultrices, lectus ligula dictum dui, eget condimentum velit dui vitae ante. Nulla nonummy augue nec pede. Pellentesque ut nulla. Donec at libero. Pellentesque at nisl ac nisi fermentum viverra. Praesent odio. Phasellus tincidunt diam ut ipsum. Donec eget est.<td><tr>
     </table>
  <div>


  <div id="prihlaseny">
     <h2>Prihlásený používatelia</h2>
    <table id="myTable" class="tablesorter" border="1" style="width:100%">
      <thead>
      <tr>
        <th class="prvy"></th>
        <th class="prvy">ID</th>
        <th class="prvy">Meno</th> 
        <th class="prvy">Priezvisko</th>
        <th class="prvy">Osobné číslo</th>
        <th class="prvy">Čip</th>
        <th class="prvy">Poznámka</th>
        <th class="prvy"></th>
      </tr>
      </thead>
      <tbody>
        <?php
        $pr->vypis_prihlasenych_d_chip();
        $pr->vypis_prihlasenych_u_chip();
        ?>  
        </tbody>
    </table>
    
    <p><input name="odhlas" type="submit" id="odhlas" value="Odhlásiť z pretekov"></p> <br> 
    <?php if($_SESSION['admin'] ==1 ){ ?>
    <p><input name="export" type="submit" id="export" value="Export do súboru"></p>
  <?php }?> 
    <br> <br>   <br>
  </div> 
    
    <!--</form>-->

    <!--<form method="post">-->
  <div id="odhlaseny">
  <h2>Neprihlásený používatelia</h2>
    <table  id="myTable2" class="tablesorter" border="1" style="width:100%">
      <thead>
      <tr>
        
        <th class="prvy"></th>
        <th class="prvy">ID</th>
        <th class="prvy">Meno</th> 
        <th class="prvy">Priezvisko</th>
        <th class="prvy">Osobné číslo</th>
        <th class="prvy">Čip</th>
        <th class="prvy">Poznámka</th>
        <th class="prvy"></th>

      </tr>
      </thead>
      <tbody>
        <?php
        $pr->vypis_neprihlasenych();
        ?>
      </tbody>
    </table>
    
    <p>
        <input name="prihlas" type="submit" id="prihlas" value="Prihlásiť na preteky">
        <?php 
        if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
            ?> <input name="del" type="submit" id="del" value="Vymazať používateľa"> <!-- aj v admine kde su vsetci pouzivatelia--> <?php
        }
        ?>
        
    </p>
    <!--</form> -->

    <!--<form method="post">     -->
  <p>
    <input name="novy" type="submit" id="novy" value="Nový používateľ"> <!-- aj v admine kde su vsetci pouzivatelia-->   
  </p>  <br><br><br>
</div>


</form>   

    <?php    
    unset($pr);
    ?>


<?php 
    
    

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

if (isset($_POST['prihlas']))
{
    // PHP throws a fit if we try to loop a non-array
    if(is_array($_POST['incharge']))
    {
         foreach($_POST['incharge'] as $val)
         {
            //echo $val . '<br />';
            PRETEKY::prihlas_na_pretek($_GET["id"], $val);
            echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
        }
    }
}

  
if (isset($_POST['odhlas']))
{
    // PHP throws a fit if we try to loop a non-array
    if(is_array($_POST['incharge']))
    {
         foreach($_POST['incharge'] as $val)
         {
            //echo $val . '<br />';
            PRETEKY::odhlas_z_preteku($_GET["id"], $val);
            echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
        }
    }
}

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
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////  
  
  
  
    
    
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
   $po->pridaj_pouzivatela ($_POST['meno'], $_POST['priezvisko'], $_POST['oscislo'], $_POST['cip'], $_POST['poznamka'],$_POST['uspech']);

  unset($po);
  
  ?>
  
  <?php
  echo '<p class="chyba">Pridane!</p>';
  echo '<META HTTP-EQUIV="refresh" CONTENT="0">';  
}



if ($zobraz_form) {
?>

<div  id="novy_pouzivatel">
	<form border="1" method="post" enctype="multipart/form-data">
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
     <?php } ?>
		</p>  
  </form>
</div>

	
</section>
  
  
  
  <br>
  <footer>
    <div id="footer">TIS - projekt 2014, Registracny system pre sportovy klub</div>
  </footer>  
  
  
</body>


</html>