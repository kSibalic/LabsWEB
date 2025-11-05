<?php

$xml = simplexml_load_file('LV2.xml') or die("Error while loading XML file");

echo "<h1>Popis osoba</h1>";

foreach ($xml->record as $osoba) {
    echo "<div style='border:1px solid #ccc; margin:10px; padding:10px; width:300px;'>";
    echo "<img src='{$osoba->slika}' alt='picture goes here' style='float:right;'>";
    echo "<h3>{$osoba->ime} {$osoba->prezime}</h3>";
    echo "<p><b>Email:</b> {$osoba->email}</p>";
    echo "<p>{$osoba->zivotopis}</p>";
    echo "</div>";
}
?>
