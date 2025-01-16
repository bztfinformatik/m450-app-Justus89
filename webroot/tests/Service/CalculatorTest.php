<?php

// Datei: webroot/tests/Service/CalculatorTest.php

namespace Test\Service;

use App\Service\Calculator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CalculatorTest extends TestCase {
    // Dataprovider für Celsius zu Fahrenheit
    public static function cToFData(): array {
        return [
            ['celsius' => 0.0, 'fahrenheit' => 32.0],
            ['celsius' => 5.0, 'fahrenheit' => 41.0],
            ['celsius' => -40.0, 'fahrenheit' => -40.0],
            ['celsius' => 100.0, 'fahrenheit' => 212.0],
            ['celsius' => -273.15, 'fahrenheit' => -459.67],
            ['celsius' => 1000.0, 'fahrenheit' => 1832.0],
            ['celsius' => 0.0001, 'fahrenheit' => 32.0],
            [
                'celsius' => [0, (0 - 32) * 5 / 9, -273.15],
                'fahrenheit' => [32.0, 0.0, -459.67]
            ],
        ];
    }

    // Dataprovider für ungültige Eingaben
    public static function invalidCelsiusData(): array {
        return [
            [null],
            [''],
            ['not a number'],
        ];
    }

    // Test für Celsius zu Fahrenheit Konversion
    #[DataProvider('cToFData')]
    public function testCToF($celsius, $fahrenheit) {
        $calc = new Calculator();
        $result = $calc->cToF($celsius);

        if (is_array($celsius)) {
            $this->assertIsArray($result);
            $this->assertEquals($fahrenheit, $result, 'Fehler bei Array-Konvertierung');
        } else {
            $this->assertIsFloat($result);
            $this->assertEquals($fahrenheit, $result, 'Fehler bei Einzelwert-Konvertierung');
        }
    }

    // Test für ungültige Eingaben (Celsius)
    #[DataProvider('invalidCelsiusData')]
    public function testCToFInvalidInput($celsius) {
        $this->expectException(\TypeError::class);
        $calc = new Calculator();
        $calc->cToF($celsius);
    }

    // DataProvider für calcAverage
    public static function calcAverageProvider(): array {
        return [
            [
                [
                    ["temp" => 22.19], 
                    ["temp" => 24.65], 
                    ["temp" => 24.44]
                ],
                ["temp" => 23.43]
            ],
            [
                [
                    ["temp" => 0],
                    ["temp" => 0],
                    ["temp" => 0]
                ],
                ["temp" => 0]
            ],
        ];
    }

    // Test für calcAverage
    #[DataProvider('calcAverageProvider')]
    public function testCalcAverage($input, $expected) {
        $calc = new Calculator();
        $ret = $calc->calcAverage($input);
        $this->assertEquals($expected, $ret);
    }

    // Einfacher Test für calcAverage mit leeren Eingaben
    public function testCalcAverageSimple() {
        $calc = new Calculator();
        $ret = $calc->calcAverage([]);
        $exp = ["temp" => 0.0];  // Beispiel-Erwartung für leere Eingabe
        $this->assertEquals($exp, $ret);
    }
}
