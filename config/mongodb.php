<?php
require_once __DIR__ . '/../vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$scoreCollection = $mongoClient->esportify->scores;
?>
