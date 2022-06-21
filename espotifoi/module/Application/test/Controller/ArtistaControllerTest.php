<?php

declare(strict_types=1);

namespace ApplicationTest\Controller;

use Application\Controller\ArtistaController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\ArtistaTable;
use Application\Model\ArtistaTableFactory;

class ArtistaControllerTest extends AbstractHttpControllerTestCase
{
    private ArtistaTable $artistaTable; 

    public function setUp(): void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $container = $this->getApplication()->getServiceManager();
        $factory = new ArtistaTableFactory();
        $this->artistaTable = $factory($container, __CLASS__);
    }

    public function testIndexActionCanBeAccessed(): void
    {
        $this->dispatch('/artistas', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(ArtistaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('ArtistaController');
        $this->assertMatchedRouteName('artistas');
    }

    public function testEditarActionCanBeAccessed(): void
    {
        $this->dispatch('/artistas/editar', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(ArtistaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('ArtistaController');
        $this->assertMatchedRouteName('artistas');
    }
    
    public function testGravarActionCanBeAccessed(): void
    {
        $_POST = [
            'nome' => 'Urtigão'
        ];
        $this->dispatch('/artistas/gravar', 'POST',$_POST);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(ArtistaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('ArtistaController');
        $this->assertMatchedRouteName('artistas');
    }      

    public function testExcluirActionCanBeAccessed(): void
    {
        $artista = $this->artistaTable->buscarArtistaPorNome('Urtigão');
        $this->dispatch('/artistas/excluir/' . $artista->codigo, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(ArtistaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('ArtistaController');
        $this->assertMatchedRouteName('artistas');
        $artista = $this->artistaTable->buscarArtistaPorNome('Urtigão');
        $this->assertEquals(0,$artista->codigo);
    }          
}
