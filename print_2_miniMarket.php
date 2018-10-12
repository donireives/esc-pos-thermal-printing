<?php

/*
    when I write this code, I'm too lazy to make spaces logic. 
    Normally add some spaces depending on the number of words.
    a little messy in printing area :v

                                                doni_was_here
*/

require __DIR__ . '/vendor/mike42/autoload.php';
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
$connector = new NetworkPrintConnector("192.168.0.68", 9100);
$printer = new Printer($connector);
$printer -> initialize();

$date = date("D j M Y H:i");
$adminName='Aaaa';
$invoiceCode='INV-001';
$cash=200000;
$noncash=0;
$dataTransaction = array(
    0 => array(
        'name'=>'Kertas A4',
        'qty'=>1,
        'price'=>50000
    ),
    1 => array(
        'name'=>'Kertas F4',
        'qty'=>1,
        'price'=>52000
    ),
    2 => array(
        'name'=>'Ballpoint AA',
        'qty'=>2,
        'price'=>3500
    ),
);
$totalTransaction=0;
$ppnItem=0;


$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("Test Market\n");
$printer -> selectPrintMode();
$printer -> setUnderline(1);
$printer -> text("Jl Moh Toha 136 Bandung\n");
$printer -> setUnderline(0);
$printer -> text($date.'/'.$adminName.'/'.$invoiceCode);
$printer -> text("\n=======================================\n");
$printer -> feed();

foreach ($dataTransaction as $value){
	$printer -> setJustification(Printer::JUSTIFY_RIGHT);
	$printer -> text($value['name']." .......... ");
	$printer -> text("  ".$value['qty']."  ");
	$printer -> text(number_format($value['price'],0,'',',')."\n");
	$totalTransaction+=$value['price']*$value['qty'];
	$ppnItem+=10/100*$value['price']*$value['qty'];
}
$printer -> feed();

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text("SubTotal : Rp. ".number_format($totalTransaction,0,'',',')."\n");
$printer -> text("PPN : Rp. ".number_format($ppnItem,0,',','')."\n");
$printer -> text("----------------------------- \n");
$printer -> text("Total : Rp. ".number_format($totalTransaction+$ppnItem,0,'',',')."\n");
$printer -> setEmphasis(false);
$printer -> text("Cash : Rp. ".number_format($cash,0,'',',')."\n");
$printer -> text("Non-cash : Rp. ".number_format($noncash,0,'',',')."\n");
$printer -> text("Change : Rp. ".number_format(($cash+$noncash)-($totalTransaction+$ppnItem),0,'',',')."\n");
$printer -> feed();

$printer -> feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("customer service SMS 01111111111 \n");
$printer -> text("Call 123456 - Mail test@example.com \n");
$printer -> feed(2);

$printer -> cut();
$printer -> pulse();
$printer -> close();
