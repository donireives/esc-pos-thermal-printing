<?php


require __DIR__ . '/vendor/mike42/autoload.php';
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
$connector = new NetworkPrintConnector("192.168.0.68", 9100);
$printer = new Printer($connector);
$printer -> initialize();

$type = 'KMZ';
$date = date("Y/m/d H:i:s");
$from = 'Bandung';
$to = 'Cimahi';
$type = 'KMZ';
$price = 300000;
$ticketNo = 'KMZWAY87AA';

$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("Test Metro\n");
$printer -> selectPrintMode();
$printer -> feed(2);

$printer -> setJustification(Printer::JUSTIFY_CENTER);
// title($printer, "QR code demo\n");
$testStr = "Testing 123";
$printer -> qrCode($testStr, Printer::QR_ECLEVEL_L, 10);
$printer -> text("\n");
$printer -> feed();
$printer->feed();

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Date Time :".$date."\n");
$printer -> text("Type :".$type."\n");
$printer -> text("From :".$from."\n");
$printer -> text("To :".$to."\n");
$printer -> text("Price : Rp. ".number_format($price,0,'',',')."\n");
$printer->feed(2);


$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("=========================== \n");
$printer -> text("Ticket No:".$ticketNo." \n");
$printer -> text("=========================== \n\n");

$printer -> text("ENJOY YOUR JOURNEY \n");
$printer -> feed(2);

$printer -> cut();
$printer -> pulse();
$printer -> close();
