<?php
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
session_start();

?>

<!DOCTYPE HTML>

<html>
<?php
hlavicka("Prihlásenie administrátora");
?>
<form method="post">
    <div id="prihlasenieAdministratora">
        <h2>Prihlásenie administrátora<h2>
        <table style="width:100%;">  
          <tr>
            <td><label for="heslo">Heslo:</label></td>
            <td><input type=password name="heslo" id="heslo"></td>
          </tr>
            <?php
                if(isset($_POST["heslo"])){
                    ?>
            <tr>
                <td></td>
                <td class="upozornenie">Ľutujeme, zadali ste zlé heslo</td>
            </tr>
                    <?php
                }
            ?>
          <tr>
            <td></td>
            <td><input type=submit name="prihlas" id="prihlas" value="Prihlásiť"></td>
          </tr>
        </table> 
    </div>
</form>
<?php
paticka();        
?>



</html>
