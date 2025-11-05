<?php
$encryption_key = 'tajni_kljuc_1234567890abcdef';
$cipher = 'aes-256-cbc';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $content = file_get_contents($file['tmp_name']);

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    $encrypted = openssl_encrypt($content, $cipher, $encryption_key, 0, $iv);

    $encryptedFile = 'uploads/' . $file['name'] . '.enc';
    file_put_contents($encryptedFile, base64_encode($iv . $encrypted));

    echo "Datoteka uspješno kriptirana i spremljena";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit">Kriptiraj</button>
</form>
