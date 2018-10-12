<?php
/* Call this file 'hello-world.php' */
require __DIR__ . '/vendor/mike42/autoload.php';

// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\Printer;
// $connector = new FilePrintConnector("php://stdout");
// $printer = new Printer($connector);
// $printer -> text("Hello World!\n");
// $printer -> cut();
// $printer -> close();

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
$connector = new NetworkPrintConnector("192.168.0.68", 9100);
$printer = new Printer($connector);
$printer -> initialize();

$printer -> text("Hello World\n");
$printer -> text("==========================\n");
$printer -> text("Doni Was Here!\n");
$printer -> cut();
$printer -> close();