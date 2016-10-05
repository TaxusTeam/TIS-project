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


if(isset($_POST["uloz"]) && isset($_POST["ID_LOG"])){
    echo "<a href='tabulka_vykonov.php?id=".$_POST["ID_LOG"]."'><h4 align='center'>".vloz_vykon()."</h4></a>";
}
?>
<form method=POST>
    <div class="spravaVykonu">
        <h2>Spravovanie výkonu:</h2>
        <table style="width:100%;">
            <tr>
                <td class="table-left"><label>Meno súťažiaceho:</label></td>
                <td class="table-right"><?php prihlaseni_pouz_na_preteky($_GET["id"]);?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Preteky:</label></td>
                <td class="table-right"><?php nazov_a_datum_pretekov($_GET["id"], "nazov");?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Dátum:</label></td>
                <td class="table-right"><?php nazov_a_datum_pretekov($_GET["id"], "datum");?></td>
            </tr>
            <tr>
                <td class="table-left"><label>Miesto:</label></td>
                <td class="table-right"><input type="text" name="MIESTO" id="MIESTO" ></td>
            </tr>
            <tr>
                <td class="table-left"><label>Víťaz:</label></td>
                <td class="table-right"><input type="text" name="VITAZ" id="VITAZ"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Čas víťaza:</label></td>
                <td class="table-right"><input type="text" name="VITAZ_CAS" id="VITAZ_CAS"></td>
            </tr>
            <tr>
                <td class="table-left"<label>Môj čas:</label></td>
                <td class="table-right"><input type="text" name="MOJ_CAS" id="MOJ_CAS"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Nabehaná vzdialenosť v km:</label></td>
                <td class="table-right"><input type="text" name="VZDIALENOST" id="VZDIALENOST"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Ideálna vzdialenosť v km:</label></td>
                <td class="table-right"><input type="text" name="IDEAL_VZDIALENOST" id="IDEAL_VZDIALENOST"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Rýchlosť min/km:</label></td>
                <td class="table-right"><input type="text" name="RYCHLOST" id="RYCHLOST"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Prevýšenie m/km:</label></td>
                <td class="table-right"><input type="text" name="PREVYSENIE" id="PREVYSENIE"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Odchýlka nabehané/ideálne mínus 1(%):</label></td>
                <td class="table-right"><input type="text" name="ODCHYLKA" id="ODCHYLKA"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Prirážka % v závislosti od kopcov a rýchlosti:</label></td>
                <td class="table-right"><input type="text" name="PRIRAZKA" id="PRIRAZKA"></td>
            </tr>
            <tr>
                <td class="table-left"><label>Hodnotiace kritérium %:</label></td>
                <td class="table-right"><input type="text" name="HODNOTENIE" id="HODNOTENIE"></td>
            </tr>
            <tr>
                <td class="table-left"></td>
                <td class="table-right"><input type=submit name="uloz" id="uloz" value="Ulož" /></td>
            </tr>
        </table>
    </div>
</form>
    <br><br><br>

<?php
paticka();        
?>



</html>

<?php
// === PHP Functions ===
function prihlaseni_pouz_na_preteky($id_preteku){
    $db = napoj_db();
    
    if($db){
        $sql =<<<EOF
      SELECT
        ID_POUZ, PRIEZVISKO, MENO FROM PRIHLASENY
        JOIN POUZIVATELIA ON PRIHLASENY.ID_POUZ = POUZIVATELIA.ID
        LEFT JOIN VYKON ON PRIHLASENY.ID_POUZ = VYKON.ID_LOG
        AND PRIHLASENY.ID_PRET = VYKON.ID_PRET
        WHERE PRIHLASENY.ID_PRET = "$id_preteku"
        AND ID_VYKON IS NULL;
EOF;

        $ret = $db->query($sql);
        echo "<select name='ID_LOG'>";
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

function vloz_vykon(){
    $db = napoj_db();


    if($db){
        $ID_PRET = $_GET['id'];
        $ID_LOG = $_POST["ID_LOG"];

        $MIESTO = $_POST["MIESTO"];
        $VITAZ = $_POST["VITAZ"];
        $VITAZ_CAS = $_POST["VITAZ_CAS"];
        $MOJ_CAS = $_POST["MOJ_CAS"];
        $VZDIALENOST = $_POST["VZDIALENOST"];
        $IDEAL_VZDIALENOST = $_POST["IDEAL_VZDIALENOST"];
        $RYCHLOST = $_POST["RYCHLOST"];
        $PREVYSENIE = $_POST["PREVYSENIE"];
        $ODCHYLKA = $_POST["ODCHYLKA"];
        $PRIRAZKA = $_POST["PRIRAZKA"];
        $HODNOTENIE = $_POST["HODNOTENIE"];
        //echo $db->lastErrorMsg();
        $sql =<<<EOF
      INSERT INTO `VYKON`
      (`ID_PRET`,`ID_LOG`,`MIESTO`,`VITAZ`,`VITAZ_CAS`,`MOJ_CAS`,`VZDIALENOST`,
      `IDEAL_VZDIALENOST`,`RYCHLOST`,`PREVYSENIE`,`ODCHYLKA`,`PRIRAZKA`,`HODNOTENIE`)
      VALUES ("$ID_PRET","$ID_LOG","$MIESTO","$VITAZ","$VITAZ_CAS",
      "$MOJ_CAS","$VZDIALENOST","$IDEAL_VZDIALENOST","$RYCHLOST",
      "$PREVYSENIE","$ODCHYLKA","$PRIRAZKA","$HODNOTENIE");

EOF;



        $ret = $db->exec($sql);
        $db->close();
        if($ret){
            return "Výkon úspešne pridaný (zobraz)";
        }
        return "Nastala chyba";
    } else {
        $db->close();
        return "Nastal problém s databázou";
    }
    return "Nastal problém";
}

function nazov_a_datum_pretekov($id_preteku, $typ){
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
