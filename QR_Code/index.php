<?php
 
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create('Life is too short to be generating QR codes')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo


// Create generic label
$label = Label::create('Label')
    ->setTextColor(new Color(255, 0, 0));


$result = $writer->write($qrCode , null, $label);

// Validate the result
$writer->validateResult($result, 'Life is too short to be generating QR codes');

$result->saveToFile(__DIR__.'/qrcode.png');

// Or output it directly to the browser
header('Content-Type: '.$result->getMimeType());
echo $result->getString();

