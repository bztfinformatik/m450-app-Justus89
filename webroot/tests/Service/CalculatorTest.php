<?php

// Datei: webroot/tests/Service/CalculatorTest.php

// package test.service; (in Java entspricht dies der Verzeichnisstruktur)
// Auch wenn es diesen Pfad in PHP nicht gibt, so wie in Java, wird dies durch composer.json unter autoload deklatiert.
namespace Test\Service;

// import app.service.Calculator;
use App\Service\Calculator;
// import phpunit.framework.TestCase;
use PHPUnit\Framework\TestCase;

// Unsere Klasse muss [Etwas]Test heissen
// und von PHPUnit\Framework\TestCase erben:
class CalculatorTest extends TestCase {

    // erster Test: Funktioniert 0° celsius?
    // der Methodenname muss mit "test" beginnen:
    public function testCToF() {
        // Wir erstellen eine Instanz:
        $calc = new Calculator();

        // wir fragen nach 0°C:
        $result = $calc->cToF(0);

        // erhalten wir eine Float-Antwort?
        $this->assertIsFloat($result);
        // ... und stimmt sie auch?
        $this->assertSame(32.0, $result);
    }
    
    public function testCToFArray() {
        $calc = new Calculator();
        $result = $calc->cToF([0, 100]);

        $this->assertIsArray($result);
        $this->assertSame([32.0, 212.0], $result);
    }

      // Test für negative Werte und Grenzfälle
      public function testCToFNegativeValues() {
        $calc = new Calculator();
        $this->assertSame(-40.0, $calc->cToF(-40));
        $this->assertSame(14.0, $calc->cToF(-10));
    }

    // Test für hohe Werte
    public function testCToFHighValues() {
        $calc = new Calculator();
        $result = $calc->cToF(1000);  // ein hoher Celsius-Wert
        $this->assertEquals(1832.0, $result);
    }

    // Test für leeres Array
    public function testCToFEmptyArray() {
        $calc = new Calculator();
        $result = $calc->cToF([]);
        $this->assertIsArray($result);
        $this->assertSame([], $result);
    }

    // Test für ungültige Eingaben
    public function testCToFInvalidInput() {
        $calc = new Calculator();

        // Prüfen, dass eine Exception bei ungültigen Eingaben geworfen wird
        $this->expectException(\TypeError::class);
        $calc->cToF("string"); // ungültiger Typ
    }

    // Test für Nullwerte (null)
    public function testCToFNullValue() {
        $calc = new Calculator();
        
        // Da `null` kein gültiger Typ für diesen Parameter ist, sollte eine TypeError-Exception ausgelöst werden
        $this->expectException(\TypeError::class);
        $calc->cToF(null);
    }
}