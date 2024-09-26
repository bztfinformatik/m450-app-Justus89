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
}