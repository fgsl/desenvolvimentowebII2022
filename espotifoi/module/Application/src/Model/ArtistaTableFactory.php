<?php
namespace Application\Model;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\ArtistaTable;
use Laminas\Db\ResultSet\ResultSet;

class ArtistaTableFactory implements FactoryInterface {
    
    public function __invoke( ContainerInterface $container,$requestedName,?array $options = null)
    {
        $conexao = $container->get('conexao');

        $tableGateway = new TableGateway('artistas', $conexao  );
        return new ArtistaTable( $tableGateway);
    }
}