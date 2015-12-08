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
    <h1>Spravovanie výkonu</h1> 
    <label>
        <span>Spravovať výkon súťažiaceho:</span><select name="selection">
        
        <!-- SEM PRIDAT FUNKCIU NA NACITANIE SUTAZIACICH Z DB -->
        <?php
        echo $_GET["id"];
        echo "serus";
        $arr = get_prihlaseni_pouz_na_preteky($_GET["id"]);
        show_option_values($arr);
        ?>
        
        
        
        </select>
    </label>    
    <label>
        <span>&nbsp;</span> 
        <input type="button" class="button" value="Spravuj" /> 
    </label>    
</form>

<?php
paticka();        
?>



</html>

<?php
// === PHP Functions ===

function show_option_values($array){
    foreach($array as $value){
        echo '<option value="'.$value.'">'.$value.'</option>';
    }
}

function get_prihlaseni_pouz_na_preteky($id_preteku){
    $db = napoj_db();
    
    $sql =<<<EOF
      SELECT
        PRIEZVISKO, MENO FROM PRIHLASENY
        JOIN POUZIVATELIA ON PRIHLASENY.ID_POUZ = POUZIVATELIA.ID
        WHERE PRIHLASENY.ID_PRET = "$id_preteku";
EOF;
    
    $ret = $db->query($sql);
    

    $ret = $db->exec($sql);
    
    if(!$ret){
       echo $db->lastErrorMsg();
       $db->close();
       return;
    } else {
       $db->close();
       return $ret;
    }
    return;
}
?>
