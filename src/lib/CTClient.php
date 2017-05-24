<?php
/**
 * CTClient, a client implementing the CertiTrade API library in PHP
 *
 * This client demonstrates the nessecary functions to quickly get a shop up
 * and running against the CertiTrade Merchant API library.
 *
 * @copyright Copyright (c) 2013-2014, CertiTrade AB
 * @package CertiTrade Merchant API library
 */

require_once './CTServer.php';

// these needs to be set
$merchantId = 30094;
$apiKey = 'J3CW7JH3RMLXBVSBUXKLBLNPT8RJB3R8R1RUQLC7';

// Create a new CTServer instance given a Merchant id, an API key and an optional testing flag.
try {
    $ct_server = new CertiTrade\CTServer($merchantId, $apiKey, true); // Third arg = 'true' gets you a test server, remove for production
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}