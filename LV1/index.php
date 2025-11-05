<?php
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

require_once 'DiplomskiRadovi.php';

$baseUrl = "https://stup.ferit.hr/index.php/zavrsni-radovi/page/";
$diplomski = new DiplomskiRadovi();

// Brojač spremljenih radova
$totalSaved = 0;

// Dohvaćanje stranica
for ($i = 2; $i <= 6; $i++) {
    $url = $baseUrl . $i;
    echo "Stranica $i od 5\n";
    echo "URL: $url\n";

    $html = DiplomskiRadovi::fetchPage($url);

    if ($html === false) {
        echo "Stranica $i preskočena zbog greške\n\n";
        sleep(2);
        continue;
    }

    $radovi = DiplomskiRadovi::parseHtml($html);

    if (empty($radovi)) {
        echo "Nisu pronađeni radovi na stranici $i\n\n";
        continue;
    }

    foreach ($radovi as $index => $r) {
        try {
            $obj = new DiplomskiRadovi();
            $obj->create($r);
            $obj->save();
            $totalSaved++;

            if ($index < 3) {
                echo "  ✓ {$r['naziv_rada']}\n";
            }

        } catch (PDOException $e) {
            // Ignoriraj duplicate key errors
            if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                echo "  ⚠️  Greška: " . $e->getMessage() . "\n";
            }
        }
    }
    echo "Stranica $i završena! (Ukupno: $totalSaved radova)\n\n";

    // Delay
    if ($i < 6) {
        sleep(2);
    }
}
echo "Ukupno spremljeno: $totalSaved radova\n\n";

// Prikaži prvih 10 radova
$saved = $diplomski->read();
echo "Primjer prvih 10 radova:\n";

foreach (array_slice($saved, 0, 10) as $idx => $r) {
    $num = $idx + 1;
    echo "$num. {$r['naziv_rada']}\n";
    echo "Link: {$r['link_rada']}\n";
    if (!empty($r['oib_tvrtke'])) {
        echo "OIB: {$r['oib_tvrtke']}\n";
    }
    echo "\n";
}