<?php
if (isset($_GET['DEBUG_TEST'])) {
    header('Content-Type: text/plain');
    echo "1. HOST HEADER (From Browser/Varnish): " . ($_SERVER['HTTP_HOST'] ?? 'Empty') . "\n";
    echo "2. SERVER_NAME (From Nginx): " . ($_SERVER['SERVER_NAME'] ?? 'Empty') . "\n";
    echo "3. MAGE_RUN_CODE (Target Website): " . ($_SERVER['MAGE_RUN_CODE'] ?? 'NOT SET') . "\n";
    echo "4. MAGE_RUN_TYPE: " . ($_SERVER['MAGE_RUN_TYPE'] ?? 'NOT SET') . "\n";
    exit(); // Stop Magento from loading
}
/**
 * Public alias for the application entry point
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\Framework\App\Bootstrap;

try {
    require __DIR__ . '/../app/bootstrap.php';
} catch (\Exception $e) {
    echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
        <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
        Autoload error</h3>
    </div>
    <p>{$e->getMessage()}</p>
</div>
HTML;
    http_response_code(500);
    exit(1);
}

$bootstrap = Bootstrap::create(BP, $_SERVER);
/** @var \Magento\Framework\App\Http $app */
$app = $bootstrap->createApplication(\Magento\Framework\App\Http::class);
$bootstrap->run($app);
