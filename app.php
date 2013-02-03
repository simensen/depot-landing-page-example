<?php

require_once __DIR__.'/vendor/autoload.php';

$config = parse_ini_file("app.ini");

$entityUri = isset($config['entity_uri']) ? $config['entity_uri'] : 'https://depot.tent.is';

$clientFactory = new Depot\Api\Client\ClientFactory;
$client = $clientFactory->create();

try {
    $server = $client->discover($entityUri);
} catch (Exception $e)
{
    include "templates/error.php";
}

include "templates/index.php";

