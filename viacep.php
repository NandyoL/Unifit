<?php
if (isset($_GET['cep'])) {
    $cep = preg_replace('/\D/', '', $_GET['cep']);
    $url = "https://viacep.com.br/ws/$cep/json/";
    $response = @file_get_contents($url);
    if ($response) {
        header('Content-Type: application/json');
        echo $response;
    }
}
?>
