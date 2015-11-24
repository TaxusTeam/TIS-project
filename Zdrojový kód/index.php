<?php
include('funkcie.php');
include('pouzivatelia.php');
include('preteky.php');
include('platby.php');
session_start();
$_SESSION['admin'] = 0;
/*
$p = new PRETEKY('KOKOT','06/06/1899','06/26/1982 00:00:00');
$p->pridaj_pretek();
$p->nastav_id(1);
$p->uprav_pretek('KOKOT','06/06/1899','06/26/1982 00:00:00');
PRETEKY::vymaz_pretek(4);
*/
// Treba si len upravit tuto funkciu alebo sa nou inspirovat na vypis
//PRETEKY::vypis_zoznam();  //!!!!!!!!!!!!!
//Vytvor_tab_pouz();
//$pouz = new POUZIVATELIA();
//$pouz->pridaj_pouzivatela("kyndl", "burger", "chachara", "423524", "bufbufbuf");

/*
PRETEKY::prihlas_na_pretek(900,5000);
POUZIVATELIA::vymaz_pouzivatela(2);
POUZIVATELIA::vypis_zoznam();

//detail preteku
$pr = new PRETEKY();
$pr=PRETEKY::vrat_pretek(4);
$pr->vypis_prihlasenych_d_chip();
$pr->vypis_prihlasenych_u_chip();
//$pr->vypis_neprihlasenych();
unset($pr);
///

$pl = new PLATBY();
$pl = PLATBY::vrat_platbu(3);
$pl->uprav_platbu(1,'07/12/1999',60);
PLATBY::vypis_zoznam();
PLATBY::vymaz_platbu(6);
PLATBY::vypis_zoznam();
/*
$pl->pridaj_platbu(2,'06/26/1982',300);
$pl->pridaj_platbu(4,'06/26/1982',300);
$pl->pridaj_platbu(5,'06/26/1982',300);
$pl->pridaj_platbu(6,'06/26/1982',300);*/
/*
PRETEKY::prihlas_na_pretek(4,3);
PRETEKY::prihlas_na_pretek(4,2);
PRETEKY::prihlas_na_pretek(3,1);
PRETEKY::prihlas_na_pretek(5,1);
PRETEKY::prihlas_na_pretek(4,1);
PRETEKY::prihlas_na_pretek(2,3);*/
/*$po = new POUZIVATELIA();
$po = POUZIVATELIA::vrat_pouzivatela(3);
$po->uprav_pouzivatela("buffy", "kelemen", "5", "4", "3");
$po->pridaj_uspech("dobehol som do obchodu");
$po->vypis_uspechy();
POUZIVATELIA::uprav_uspech(3, "bukvica");
POUZIVATELIA::vymaz_uspech(1);

$po->vypis_uspechy();
unset($po);*/
//POUZIVATELIA::vypis_zoznam();
//Vytvor_tab_uspech();


?>

<!DOCTYPE HTML>

<html>
<?php
hlavicka("Športový klub");
?>

<div id="zoz_pretekov_uzivatel">
    <h2>Zoznam pretekov<h2>
    <table border="1" style="width:100%;">  
      <tr>
        <td class="prvy">Názov pretekov</td>
        <td class="prvy">Dátum konania</td> 
        <td class="prvy">Deadline prihlásenia</td>
      </tr>
      <?php PRETEKY::vypis_zoznam(); ?>       
    </table> 
</div>
<?php
paticka();        
?>



</html>
