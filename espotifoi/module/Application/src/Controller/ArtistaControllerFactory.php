<?php
namespace Application\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\ArtistaTable;
use Application\Model\MusicaTable;
use Laminas\Db\ResultSet\ResultSet;
use Application\Model\Musica;

class ArtistaControllerFactory implements FactoryInterface {
    
    public function __invoke( ContainerInterface $container,$requestedName,?array $options = null)
    {
        $conexao = $container->get('conexao');

        $tableGateway = new TableGateway('artistas', $conexao  );
        $artistaTable = new ArtistaTable( $tableGateway);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Musica());
        $tableGateway = new TableGateway( 'musicas', $conexao, null, $resultSet);
        $musicaTable = new MusicaTable($tableGateway);        

        return new ArtistaController($artistaTable, $musicaTable);        
    }
}