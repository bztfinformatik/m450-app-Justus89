<?php

// Datei: webroot/src/Service/Calculator.php

namespace App\Service;

class Calculator {
    // Wandelt (einen oder mehrere) Celsius-Wert(e) in Fahrenheit um
    // Der Datentyp der Variable $celsius ist ein float oder(|) ein array
    public function cToF(float|array $celsius): float|array {
        // TODO: Celsius to Fahrenheit!
        if (is_float($celsius)) {
            return floatval($celsius * 9 / 5 + 32);
        }
        // Ein Array von Werten wird konvertiert und als Array zurückgegeben
        return array_map(fn($c) => floatval($c * 9 / 5 + 32), $celsius);
    }
}