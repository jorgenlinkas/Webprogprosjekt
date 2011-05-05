<?php
if(!$gjennomIndex) die("Access denied.");
$kategori = $_REQUEST['kat'];
$katnavn;

switch ($kategori)
{
    case 0: $katnavn = "Alle kategorier";
            break;
    case 1: $katnavn = "Speilreflekskamera";
            break;
    case 2: $katnavn = "Superzoomkamera";
            break;
    case 3: $katnavn = "Kompaktkamera";
            break;
    case 4: $katnavn = "Undervannskamera";
            break;
    case 5: $katnavn = "Objektiv";
            break;
    case 6: $katnavn = "Tilbeh&oslash;r";
            break;
}

echo "<h2>".$katnavn."</h2>";

$vare = new Vare();
$vareliste = $vare->getVarer($kategori);

if(count($vareliste) == 0)
    echo "<p>Det finnes ingen varer i denne kategorien.</p>";
else
    foreach ($vareliste as $varer)
    {
        $bildeurl = $varer[0];
        $vnr = $varer[1];
        $varenavn = substr($varer[2], 0, 50);
        $beskrivelse = substr($varer[3], 0, 300);
        $pris = number_format($varer[4],2,',','.');

        if(!is_file($bildeurl))
           $bildeurl = "images/standardbilde.jpg";
        echo "<div class='varelinje'><span class='varebilde'><img src='$bildeurl' alt='$vnr' /></span>
                <span class='varetekst'>
                <h3><a href='index.php?side=vareinfo&amp;vnr=".$vnr."'>".$varenavn."</a></h3>
                <p>$beskrivelse</p>
                </span>
                <span class='pris'><p>$pris</p>
                <form class='leggtilvare' action='' method='post' >
                    <input type='hidden' name='vnr' value='$vnr' />
                    <input type='text' name='antall' value='1' />
                    <input type='submit' name='leggihandlekurv' value='Legg til' />
                </form>
                </span>
                </div>";
       echo "<hr/>";
    }

    if(isset($_POST['leggihandlekurv']))
    {

    }
?>

