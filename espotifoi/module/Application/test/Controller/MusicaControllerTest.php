<?php

declare(strict_types=1);

namespace ApplicationTest\Controller;

use Application\Controller\MusicaController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\ArtistaTableFactory;
use Application\Model\MusicaTableFactory;
use Application\Model\ArtistaTable;
use Application\Model\MusicaTable;

class MusicaControllerTest extends AbstractHttpControllerTestCase
{
    private ArtistaTable $artistaTable;
    private MusicaTable $musicaTable;

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
        $factory = new MusicaTableFactory();
        $this->musicaTable = $factory($container, __CLASS__);
    }

    public function testIndexActionCanBeAccessed(): void
    {
        $this->dispatch('/musicas', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(MusicaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('MusicaController');
        $this->assertMatchedRouteName('musicas');
    }

    public function testEditarActionCanBeAccessed(): void
    {
        $this->dispatch('/musicas/editar', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(MusicaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('MusicaController');
        $this->assertMatchedRouteName('musicas');
    }
    
    public function testGravarActionCanBeAccessed(): void
    {
        $_POST = [
            'nome' => 'Urtigão'
        ];
        $this->dispatch('/artistas/gravar', 'POST',$_POST);
        $artista = $this->artistaTable->buscarArtistaPorNome('Urtigão');
        $_POST = [
            'nome' => 'Dispois a gente compra',
            'codigo_artista' => $artista->codigo
        ];        
        $this->dispatch('/musicas/gravar', 'POST',$_POST);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(MusicaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('MusicaController');
        $this->assertMatchedRouteName('musicas');
    }      

    public function testExcluirActionCanBeAccessed(): void
    {
        $musica = $this->musicaTable->buscarMusicaPorNome('Dispois a gente compra');
        $this->dispatch('/musicas/excluir/' . $musica->codigo, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('application');
        $this->assertControllerName(MusicaController::class); // as specified in router's controller name alias
        $this->assertControllerClass('MusicaController');
        $this->assertMatchedRouteName('musicas');
        $this->assertEquals(0,$musica->codigo);
        $this->dispatch('/artistas/excluir/' . $musica->codigo_artista, 'GET');

    }       
}
