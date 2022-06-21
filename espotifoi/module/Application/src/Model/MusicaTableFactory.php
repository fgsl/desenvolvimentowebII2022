<?php
namespace Application\Model;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\MusicaTable;

class MusicaTableFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $conexao = $container->get('conexao');
        
        $tableGateway = new TableGateway( 'musicas', $conexao );
        return new MusicaTable($tableGateway );
    }    
}