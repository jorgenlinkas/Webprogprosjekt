<?php if(!$gjennomIndex) die("Access denied.");

echo "<h2>Kassen - bekreft din ordre</h2>";

echo "<p>Ordredato: ".now()."</p>";

echo "<p><strong>Faktura/leveringsadresse:</strong><br/>"
      .$kunde->getNavn()."<br/>"
      .$kunde->getAdresse()."<br/>"
      .$kunde->getPostnr()." ".$kunde->getPoststed()."</p>";

$ordrelinjer = $handlekurv->getHandlekurv();
if(count($ordrelinjer) == 0)
    echo "<p class=\"advarselmelding\">Ingen varer registrert i handlekurven</p>";
else
{
	if($_POST['bekreftordre']=="Bekreft ordre")
	{
	   $ordre=new Ordre(null,$kunde->getKNr());
	   $ordre->setOrdrelinjer($handlekurv->getBasicHandlekurv());
	   if($ordre->lagreOrdre())
	   {
	      $handlekurv->tomHandlekurv();
         echo "<p class=\"okmelding\">Din ordre er bekreftet mottatt av oss. Du vil motta din(e) vare(r) innen 2 �r.</p>";
		}
	   else
	      echo "<p class=\"feilmelding\">En feil oppsto ved utf�ring av ordre (NYO01)</p>";
	}
	else
	{
?>
    <table>
        <tr><th>Varenummer</th><th>Varenavn</th><th>Enhetspris</th><th>Antall</th><th>MVA</th><th>Totalpris</th></tr>
    <?php
    $totalsum;
    foreach ($ordrelinjer as $ordrelinje)
    {
            echo "<tr><td>".$ordrelinje[0]."</td><td>".$ordrelinje[1]."</td><td>".number_format($ordrelinje[2],2,',','.')."</td><td>".$ordrelinje[3]."</td><td>25&#37;</td><td>".number_format($ordrelinje[4],2,',','.')."</td></tr>";
            $totalsum+=$ordrelinje[4];
    }
    echo "<tr><td colspan=\"4\"></td><td><strong>Sum varer:</strong></td><td>".number_format($totalsum,2,',','.')."</td></tr>";
    echo "<tr><td colspan=\"4\"></td><td><strong>Frakt:</strong></td><td>120,00</td></tr>";
    echo "<tr><td colspan=\"4\"></td><td><strong>Herav MVA (25&#37;):</strong></td><td>".number_format((($totalsum+120)*0.2),2,',','.')."</td></tr>";
    echo "<tr><td colspan=\"4\"></td><td><strong>TOTALT:</strong></td><td>".number_format(($totalsum+120),2,',','.')."</td></tr>";
    ?>
    </table>
    <form action="index.php?side=kassen" method="POST"><input type="submit" name="bekreftordre" value="Bekreft ordre"></form>
<?php
	}
}
?>