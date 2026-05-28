<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class QrCodeRenderer
{
    public static function generateDataUri(string $data, int $size = 300): string
    {
        try {
            $qrCode = new QrCode(
                $data,
                new Encoding('UTF-8'),
                ErrorCorrectionLevel::High,
                $size,
                10,
                RoundBlockSizeMode::Margin,
            );

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $pngData = $result->getString();
            return 'data:image/png;base64,' . base64_encode($pngData);
        } catch (\Exception $e) {
            return '';
        }
    }
}
