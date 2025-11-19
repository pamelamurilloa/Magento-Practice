<?php
echo "<h1>Debug Info</h1>";
echo "<b>MAGE_RUN_CODE:</b> " . ($_SERVER['MAGE_RUN_CODE'] ?? 'NOT SET') . "<br>";
echo "<b>MAGE_RUN_TYPE:</b> " . ($_SERVER['MAGE_RUN_TYPE'] ?? 'NOT SET') . "<br>";
echo "<b>HTTP_HOST:</b> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "<b>SERVER_NAME:</b> " . $_SERVER['SERVER_NAME'] . "<br>";