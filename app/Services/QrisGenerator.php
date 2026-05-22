<?php

namespace App\Services;

class QrisGenerator
{
    public static function generate(string $merchantName, string $merchantCity, int $amount, string $reference): string
    {
        $payload = '';
        $payload .= self::element('00', '01');
        $payload .= self::element('01', '12');
        $payload .= self::element('26', self::element('00', 'ID.CO.QRIS') . self::element('01', $reference));
        $payload .= self::element('52', '0000');
        $payload .= self::element('53', '360');
        $payload .= self::element('54', number_format($amount, 0, '.', ''));
        $payload .= self::element('58', 'ID');
        $payload .= self::element('59', strtoupper(substr($merchantName, 0, 25)));
        $payload .= self::element('60', strtoupper(substr($merchantCity, 0, 15)));
        $payload .= self::element('62', self::element('05', $reference));

        $payloadWithCrc = $payload . '63' . '04';
        $crc = self::crc16($payloadWithCrc);

        return $payloadWithCrc . strtoupper($crc);
    }

    private static function element(string $id, string $value): string
    {
        return str_pad($id, 2, '0', STR_PAD_LEFT) . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
    }

    private static function crc16(string $data): string
    {
        $crc = 0xFFFF;
        $dataLength = strlen($data);

        for ($i = 0; $i < $dataLength; $i++) {
            $crc ^= ord($data[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc <<= 1;
                }
                $crc &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
