<?php
require_once 'iRadovi.php';
require_once 'SimpleParser.php';

class DiplomskiRadovi implements iRadovi {
    private $naziv_rada;
    private $tekst_rada;
    private $link_rada;
    private $oib_tvrtke;
    private $conn;

    public function __construct($dbhost = "localhost", $dbname = "radovi", $user = "root", $pass = "root") {
        try {
            $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function create($data) {
        $this->naziv_rada = $data['naziv_rada'];
        $this->tekst_rada = $data['tekst_rada'];
        $this->link_rada = $data['link_rada'];
        $this->oib_tvrtke = $data['oib_tvrtke'];
    }

    public function save() {
        $stmt = $this->conn->prepare("INSERT INTO diplomski_radovi (naziv_rada, tekst_rada, link_rada, oib_tvrtke) VALUES (:naziv, :tekst, :link, :oib)");
        $stmt->execute([
            ':naziv' => $this->naziv_rada,
            ':tekst' => $this->tekst_rada,
            ':link'  => $this->link_rada,
            ':oib'   => $this->oib_tvrtke
        ]);
    }

    public function read() {
        $stmt = $this->conn->query("SELECT * FROM diplomski_radovi");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchPage($url) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!$html || $httpCode !== 200) {
            echo "cURL error: " . curl_error($ch) . " (HTTP $httpCode)\n";
            curl_close($ch);
            return false;
        }

        echo "Stranica dohvaćena (" . number_format(strlen($html)) . " bytes)\n";
        curl_close($ch);
        return $html;
    }

    public static function parseHtml($html) {
        // Pronađi sve article tagove
        $articles = SimpleParser::findArticles($html);

        if (empty($articles)) {
            echo "Nisu pronađeni <article> tagovi!\n";
            return [];
        }

        $results = [];

        foreach ($articles as $articleHtml) {
            $link = SimpleParser::findFirstLink($articleHtml);
            $oib = SimpleParser::findOIB($articleHtml);
            $naziv = SimpleParser::cleanText($link['text']);
            $href = $link['href'];

            if (empty($naziv) || empty($href)) {
                continue;
            }

            $results[] = [
                'naziv_rada' => $naziv,
                'tekst_rada' => '',
                'link_rada' => $href,
                'oib_tvrtke' => $oib
            ];
        }

        return $results;
    }

    /* Dohvati detalje rada */
    public static function fetchRadDetails($link) {
        echo "Dohvaćam detalje: $link\n";

        $html = self::fetchPage($link);
        if (!$html) return '';

        $tekst = SimpleParser::findFirstParagraph($html);
        $tekst = SimpleParser::cleanText($tekst);

        usleep(500000);

        return $tekst;
    }
}