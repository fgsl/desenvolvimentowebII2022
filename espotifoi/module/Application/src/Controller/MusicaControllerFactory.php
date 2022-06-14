<?php
namespace Application\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\MusicaTable;
use Application\Model\ArtistaTable;

class MusicaControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $conexao = $container->get('conexao');
        
        $tableGateway = new TableGateway( 'musicas', $conexao );
        $musicaTable = new MusicaTable($tableGateway );

        $tableGateway = new TableGateway('artistas', $conexao  );
        $artistaTable = new ArtistaTable( $tableGateway);
       

        return new MusicaController($musicaTable, $artistaTable );     
    }    
}