<?php


require __DIR__ . '/vendor/mike42/autoload.php';
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
$connector = new NetworkPrintConnector("192.168.0.68", 9100);
$printer = new Printer($connector);
$printer -> initialize();

$logo = EscposImage::load("assets/logo.png", false);

$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> graphics($logo);
$printer -> feed(2);

$printer -> cut();
$printer -> pulse();
$printer -> close();
