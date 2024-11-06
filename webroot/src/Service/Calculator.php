<?php

// Datei: webroot/src/Service/Calculator.php

namespace App\Service;

class Calculator {
    // Wandelt (einen oder mehrere) Celsius-Wert(e) in Fahrenheit um
    // Der Datentyp der Variable $celsius ist ein float oder(|) ein array
    public function cToF(float|array $celsius): float|array {
        // TODO: Celsius to Fahrenheit!

        if (is_array($celsius)) {
            // Überprüfe, ob alle Elemente im Array numerisch sind
            foreach ($celsius as $value) {
                if (!(is_int($value) || is_float($value))) {
                    throw new \TypeError("Invalid input: All elements in the array must be number.");
                }
            }
            // Ein Array von Werten wird konvertiert und als Array zurückgegeben
            return array_map(fn($c) => round($c * 9 / 5 + 32, 2), $celsius);
        }
        // Überprüfen, ob der Input numerisch ist (float oder integer)
        if (!(is_int($celsius) || is_float($celsius))) {
            throw new \TypeError("Invalid input: Celsius must be a number.");
        }
        // Wenn der Input gültig ist, erfolgt die Umrechnung und Rückgabe
        return round($celsius * 9 / 5 + 32, 2); // Rundet das Ergebnis auf 2 Dezimalstellen

    }
}