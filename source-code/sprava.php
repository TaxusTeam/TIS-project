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

if(!isset($_POST["uloz"])){
?>
<form method="post">
    <div class="spravaVykonu">
        <h2>Spravovanie výkonu:</h2>
        <table style="width:100%;">
            <tr>
                <td class="table-left"><label>Meno súťažiaceho:</label></td>
                <td class="table-right"><?php prihlaseni_pouz_na_preteky(2);//prihlaseni_pouz_na_preteky($_GET["id"]);?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Preteky:</label></td>
                <td class="table-right"><?php nazov_pretekov(2, "nazov");//prihlaseni_pouz_na_preteky($_GET["id"]);?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Dátum:</label></td>
                <td class="table-right"><?php nazov_pretekov(2, "datum");//prihlaseni_pouz_na_preteky($_GET["id"]);?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Miesto:</label></td>
                <td class="table-right"><input type="text" name="miesto" id="miesto"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Víťaz a jeho čas:</label></td>
                <td class="table-right"><input type="text" name="vitaz" id="vitaz"></td>
            </tr>
            <tr>
                <td class="table-left"<label>Môj čas:</label></td>
                <td class="table-right"><input type="text" name="moj_cas" id="moj_cas"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Nabehaná vzdialenosť v km:</label></td>
                <td class="table-right"><input type="text" name="nabehane" id="nabehane"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Ideálna vzdialenosť v km:</label></td>
                <td class="table-right"><input type="text" name="ideal" id="ideal"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Rýchlosť min/km:</label></td>
                <td class="table-right"><input type="text" name="rychlost" id="rychlost"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Prevýšenie m/km:</label></td>
                <td class="table-right"><input type="text" name="prevysenie" id="prevysenie"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Odchýlka nabehané/ideálne mínus 1(%):</label></td>
                <td class="table-right"><input type="text" name="odchylka" id="odchylka"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Prirážka % v závislosti od kopcov a rýchlosti:</label></td>
                <td class="table-right"><input type="text" name="prirazka" id="prirazka"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Hodnotiace kritérium %:</label></td>
                <td class="table-right"><input type="text" name="kriterium" id="kriterium"></td>
            </tr>
            <tr>
                <td class="table-left"></td>
                <td class="table-right"><input type=submit name="uloz" id="uloz" value="Ulož"></td>
            </tr>
        </table>
    </div>
</form>
    <br><br><br>

<?php
}
paticka();        
?>



</html>

<?php
// === PHP Functions ===
function prihlaseni_pouz_na_preteky($id_preteku){
    $db = napoj_db();

    
    if($db){
       //echo $db->lastErrorMsg();
        $sql =<<<EOF
      SELECT
        ID_POUZ, PRIEZVISKO, MENO FROM PRIHLASENY
        JOIN POUZIVATELIA ON PRIHLASENY.ID_POUZ = POUZIVATELIA.ID
        WHERE PRIHLASENY.ID_PRET = "$id_preteku";
EOF;

        $ret = $db->query($sql);
        echo "<select>";
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            echo '<option value="'.$row["ID_POUZ"].'">'.$row["MENO"]." ".$row["PRIEZVISKO"].'</option>';
        }
        echo "</select>";
        $db->close();
    } else {
        $db->close();
        return;
    }
    return;
}

function nazov_pretekov($id_preteku, $typ){
    $db = napoj_db();


    if($db){
        //echo $db->lastErrorMsg();
        $sql =<<<EOF
      SELECT
        NAZOV, DATUM FROM PRETEKY
        WHERE ID = "$id_preteku";
EOF;

        $ret = $db->query($sql);
        $row = $ret->fetchArray(SQLITE3_ASSOC);
        if($typ == "nazov"){
            echo '<input type="hidden" name="'.$typ.'" id="'.$typ.'" value="'.$id_preteku.'">'.$row["NAZOV"];
        }
        elseif($typ == "datum"){
            echo '<input type="hidden" name="'.$typ.'" id="'.$typ.'" value="'.$id_preteku.'">'.$row["DATUM"];
        }

        $db->close();
    } else {
        $db->close();
        return;
    }
    return;
}
?>
