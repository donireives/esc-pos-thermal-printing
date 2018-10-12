<?php


require __DIR__ . '/vendor/mike42/autoload.php';
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
$connector = new NetworkPrintConnector("192.168.0.68", 9100);
$printer = new Printer($connector);
$printer -> initialize();

$parkingCode = 'P-'.date("Ymd").'2342342';
$type = 'IN Car';
$date = date("Y/m/d H:i:s");


$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("Test Parking\n");
$printer -> selectPrintMode();
$printer -> text("Jl Moh Toha 136 Bandung");
$printer -> text("\n=======================================\n");
$printer -> feed();

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text($parkingCode."\n");
$printer -> text($type."\n");
$printer -> text($date."\n");
$printer->feed(2);

$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer->setBarcodeHeight(60);
$printer->setBarcodeWidth(2);
$printer->barcode("d-1111-xxx", Printer::BARCODE_CODE93);
$printer->feed();

$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("THIS TICKET MUST BE PRESENTED TO\n");
$printer -> text("THE ATTENDANT UPON LEAVING PARKING AREA \n");
$printer -> feed(2);

$printer -> cut();
$printer -> pulse();
$printer -> close();
