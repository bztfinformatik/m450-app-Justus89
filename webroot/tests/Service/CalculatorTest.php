<?php

// Datei: webroot/tests/Service/CalculatorTest.php

// package test.service; (in Java entspricht dies der Verzeichnisstruktur)
// Auch wenn es diesen Pfad in PHP nicht gibt, so wie in Java, wird dies durch composer.json unter autoload deklatiert.
namespace Test\Service;

// import app.service.Calculator;
use App\Service\Calculator;
// import phpunit.framework.TestCase;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

// Unsere Klasse muss [Etwas]Test heissen
// und von PHPUnit\Framework\TestCase erben:
class CalculatorTest extends TestCase {
    // Unser Dataprovider (statische methode) liefert Test-Daten für
    // einzelne "Durchläufe":
    public static function cToFData(): array {
        // Wir liefern einen Array mit einzelnen Test-Datensätzen:
        return [
            // Jeder Test-Datensatz ist wiederum ein Array mit Funktions-Parametern:

            // Normale Werte
            ['celsius' => 0.0, 'fahrenheit' => 32.0],
            ['celsius' => 5.0, 'fahrenheit' => 41.0],
            ['celsius' => -40.0, 'fahrenheit' => -40.0],
            ['celsius' => 100.0, 'fahrenheit' => 212.0],
            // Grenzwerte
            ['celsius' => -273.15, 'fahrenheit' => -459.67], // absoluter Nullpunkt
            ['celsius' => 1000.0, 'fahrenheit' => 1832.0],  // großer Wert
            // Spezielle Dezimalwerte
            ['celsius' => 0.0001, 'fahrenheit' => 32.0],
        ];
    }

    public static function invalidCelsiusData(): array {
        return [
            [null],
            [''],
            ['20'],
            ['not a number'],
        ];
    }

    // Test mit DataProvider-Methode:
    // Input-Werte werden als Funktionsparameter übergeben.
	// Die Methode wird nun für jeden Test-Datensatz einzeln aufgerufen:
    #[DataProvider('cToFData')]
    public function testCToF(float $celsius, float $fahrenheit) {
        // Wir erstellen eine Instanz:
        $calc = new Calculator();
        // Normaler Testfall für gültige Werte
        $result = $calc->cToF($celsius);
        $this->assertIsFloat($result);
        // `assertEquals` mit Delta-Wert von 0.01 für Rundungsabweichungen
        $this->assertEquals($fahrenheit, $result, '');
    }

    #[DataProvider('invalidCelsiusData')]
    public function testCToFInvalidInput($celsius) {
        $this->expectException(\TypeError::class);
        $calc = new Calculator();
        $calc->cToF($celsius);
    }
}