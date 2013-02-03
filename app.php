<?php

require_once __DIR__.'/vendor/autoload.php';

if (file_exists('app.ini')) {
    $config = parse_ini_file("app.ini");
} else {
    $config = array();
}

$entityUri = isset($config['entity_uri']) ? $config['entity_uri'] : 'https://tent.tent.is';

$clientFactory = new Depot\Api\Client\ClientFactory;
$client = $clientFactory->create();

try {
    $server = $client->discover($entityUri);
} catch (Exception $e)
{
    include "templates/error.php";
}

include "templates/index.php";

