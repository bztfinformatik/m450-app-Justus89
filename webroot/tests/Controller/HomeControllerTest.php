<?php
namespace Test\Controller;

use App\Controller\HomeController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

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

    // Test für den Fall ohne PLZ, Datum und Zeit
    public function testGetInputParamsWithMissingZipDateAndTime() {
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
            'mode' => 'historic', // Standardwert, da 'mode' nicht gesetzt ist
            'zip' => '8500',
            'date' => null,
            'time' => null
        ], $params);
    }




    // Basis-Test für die getInputParams-Methode
    public function testGetInputParamsWithValidData() {
        $controller = new HomeController();

        // Stub des ServerRequestInterface erstellen
        $reqStub = $this->createStub(ServerRequestInterface::class);

        // Rückgabewert der Methode `getQueryParams` konfigurieren
        $reqStub->method('getQueryParams')
                ->willReturn(['mode' => 'actual', 'zip' => '8500', 'date' => '2023-04-15', 'time' => '14:00']);

        // Aufruf der zu testenden Methode
        $result = $controller->getInputParams($reqStub);

        // Erwartetes Ergebnis überprüfen
        $this->assertEquals([
            'mode' => 'actual',
            'zip' => '8500',
            'date' => '2023-04-15',
            'time' => '14:00',
            'timestamp' => '2023-04-15 14:00:00',
        ], $result);
    }

    // Negative Tests für ungültige Eingabewerte
    public function testGetInputParamsWithInvalidDate() {
        $controller = new HomeController();
        $reqStub = $this->createStub(ServerRequestInterface::class);

        $reqStub->method('getQueryParams')
                ->willReturn(['mode' => 'historic', 'zip' => '8500', 'date' => 'ungültiges Datum', 'time' => '14:00']);

        $result = $controller->getInputParams($reqStub);

        $this->assertEquals([
            'mode' => 'historic',
            'zip' => '8500',
            'date' => 'ungültiges Datum',
            'time' => '14:00',
            'timestamp' => null, // sollte null zurückgeben bei ungültigem Datum
        ], $result);
    }

    // Test für fehlende Parameter mithilfe eines DataProviders
    /**
     * @dataProvider dataProviderForGetInputParams
     */
    public function testGetInputParamsWithDifferentInputs($queryParams, $expected) {
        $controller = new HomeController();
        $reqStub = $this->createStub(ServerRequestInterface::class);
        $reqStub->method('getQueryParams')->willReturn($queryParams);

        $result = $controller->getInputParams($reqStub);

        $this->assertEquals($expected, $result);
    }

    public static function dataProviderForGetInputParams() {
        return [
            // Testfall: alle Parameter korrekt
            [['mode' => 'historic', 'zip' => '8500', 'date' => '2023-04-15', 'time' => '12:00'],
                ['mode' => 'historic', 'zip' => '8500', 'date' => '2023-04-15', 'time' => '12:00', 'timestamp' => '2023-04-15 12:00:00']],
            
            // Testfall: Fehlende `date` und `time`
            [['mode' => 'historic', 'zip' => '8500'],
                ['mode' => 'historic', 'zip' => '8500', 'date' => null, 'time' => null, 'timestamp' => null]],
            
            // Testfall: `mode` nicht gesetzt (Standardwert prüfen)
            [['zip' => '8500', 'date' => '2023-04-15', 'time' => '12:00'],
                ['mode' => 'historic', 'zip' => '8500', 'date' => '2023-04-15', 'time' => '12:00', 'timestamp' => '2023-04-15 12:00:00']],
            
            // Testfall: Ungültiges `date`
            [['mode' => 'actual', 'zip' => '8500', 'date' => 'ungültig', 'time' => '14:00'],
                ['mode' => 'actual', 'zip' => '8500', 'date' => 'ungültig', 'time' => '14:00', 'timestamp' => null]],
        ];
    }
}
