<?php
namespace Test\Controller;

use App\Controller\HomeController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;

class HomeControllerTest extends TestCase {
    // Test für einen gültigen Request mit allen Parametern
    public function testGetInputParamsWithAllParameters() {
        // Erstellen eines Fake-Requests mit Query-Parametern
        $request = (new ServerRequest('GET', '/weather'))
            ->withQueryParams(['mode' => 'historic', 'zip' => '8500', 'date' => '2024-01-01', 'time' => '12:00']);
        $controller = new HomeController();

        // Aufrufen der zu testenden Methode
        $params = $controller->getInputParams($request);

        // Überprüfen der Rückgabe
        $this->assertEquals([
            'mode' => 'historic',
            'zip' => '8500',
            'date' => '2024-01-01',
            'time' => '12:00'
        ], $params);
    }

    // Test für den Fall ohne Datum und Uhrzeit
    public function testGetInputParamsWithMissingDateAndTime() {
        $request = (new ServerRequest('GET', '/weather'))
            ->withQueryParams(['mode' => 'actual', 'zip' => '8500']);
        $controller = new HomeController();

        $params = $controller->getInputParams($request);

        $this->assertEquals([
            'mode' => 'actual',
            'zip' => '8500',
            'date' => null,
            'time' => null
        ], $params);
    }

    // Test für den Fall ohne PLZ
    public function testGetInputParamsWithMissingZip() {
        $request = (new ServerRequest('GET', '/weather'))
            ->withQueryParams(['mode' => 'historic']);
        $controller = new HomeController();

        $params = $controller->getInputParams($request);

        $this->assertEquals([
            'mode' => 'historic',
            'zip' => null,
            'date' => null,
            'time' => null
        ], $params);
    }

    // Test für den Standardmodus 'historic' (wenn mode nicht gesetzt ist)
    public function testGetInputParamsWithNoMode() {
        $request = (new ServerRequest('GET', '/weather'))
            ->withQueryParams(['zip' => '8500']);
        $controller = new HomeController();

        $params = $controller->getInputParams($request);

        $this->assertEquals([
            'mode' => 'historic',
            'zip' => '8500',
            'date' => null,
            'time' => null
        ], $params);
    }
}
