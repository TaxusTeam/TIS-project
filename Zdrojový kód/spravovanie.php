<?php
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
session_start();

?>

<!DOCTYPE HTML>

<html>
<?php
hlavicka("Spravovanie výkonu");
?>
<form action="" method="post" class="bootstrap-frm">
    <h1>Spravovanie výkonu
        <!-- <span>Please fill all the texts in the fields.</span> -->
    </h1> 
    <label>
        <span>Meno:</span>
        <input id="name" type="text" name="name" placeholder="Your Full Name" />
    </label>   
    <label>
        <span>&nbsp;</span> 
        <input type="button" class="button" value="Ulož" /> 
    </label>    
</form>

<?php
paticka();        
?>



</html>
