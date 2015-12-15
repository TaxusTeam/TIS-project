<?php
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
session_start();

?>

<!DOCTYPE HTML>

<html>
<?php
hlavicka("Tabuľka výkonov");
if(isset($_POST["vymaz"])){
    if(vymaz_vykon($_POST["ID_VYKON"])){
        echo "<h4 align='center'>Výkon vymazaný</h4>";
    }
}
vypis_vykony($_GET["id"]);

paticka();
?>



</html>

<?php
// === PHP Functions ===
function vypis_vykony($id_pouzivatela){
    $db = napoj_db();

    if($db){
        $sql =<<<EOF
      SELECT
        * FROM VYKON
        JOIN POUZIVATELIA ON VYKON.ID_LOG = POUZIVATELIA.ID
        JOIN PRETEKY ON VYKON.ID_PRET = PRETEKY.ID
        WHERE ID_LOG = "$id_pouzivatela"
        ORDER BY DATUM ASC;
EOF;

        $ret = $db->query($sql);
        ?>
        <div>
        <table style="width:100%;">
            <tr>
                <td class="prvy">Dátum</td>
                <td class="prvy">Názov</td>
                <td class="prvy">Miesto</td>
                <td class="prvy">Víťaz</td>
                <td class="prvy">Víťazný čas</td>
                <td class="prvy">Môj čas</td>
                <td class="prvy">Vzdialenosť</td>
                <td class="prvy">Ideálna vzdialenosť</td>
                <td class="prvy">Rýchlosť</td>
                <td class="prvy">Prevýšenie</td>
                <td class="prvy">Odchýlka</td>
                <td class="prvy">Prirážka</td>
                <td class="prvy">Hodnotenie</td>
                <td></td>
                <td></td>
            </tr>
            <?php
        while($row = $ret->fetchArray(SQLITE3_ASSOC)){
            echo "<tr>";
            echo "<td>".$row["DATUM"]."</td>";
            echo "<td>".$row["NAZOV"]."</td>";
            echo "<td>".$row["MIESTO"]."</td>";
            echo "<td>".$row["VITAZ"]."</td>";
            echo "<td>".$row["VITAZ_CAS"]."</td>";
            echo "<td>".$row["MOJ_CAS"]."</td>";
            echo "<td>".$row["VZDIALENOST"]."</td>";
            echo "<td>".$row["IDEAL_VZDIALENOST"]."</td>";
            echo "<td>".$row["RYCHLOST"]."</td>";
            echo "<td>".$row["PREVYSENIE"]."</td>";
            echo "<td>".$row["ODCHYLKA"]."</td>";
            echo "<td>".$row["PRIRAZKA"]."</td>";
            echo "<td>".$row["HODNOTENIE"]."</td>";
            echo "<td><a href='uprav_vykon.php?id=".$row["ID_VYKON"]."'>Uprav</a></td>";
            echo "<td><form method='post'><input type='hidden' name='ID_VYKON' value='".$row["ID_VYKON"]."'><input type='submit' name='vymaz' value='Vymaž'></form></td>";

            echo "</tr>";
        }
            ?>
        </table>
        </div><?php
        $db->close();
        return;
    } else {
        $db->close();
        return 0;
    }
}

function vymaz_vykon($id_vykon){
    $db = napoj_db();

    if ($db) {
        $sql = <<<EOF
          DELETE FROM VYKON WHERE VYKON.ID_VYKON = "$id_vykon";
EOF;

        $ret = $db->exec($sql);
        return $ret;
    }
    return 0;
}
?>
