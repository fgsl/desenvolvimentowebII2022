<?php
namespace Application\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\AlunoTable;

class AlunoControllerFactory implements FactoryInterface{ 
    public function __invoke(
        ContainerInterface $container, 
        $requestedName,
        ?array $options = null)
    {
        $conexao = $container -> get('conexao');
        $tableGateway = new TableGateway(
            'alunos', //muda o nome da tabela
            $conexao 
        );
        $alunoTable = new AlunoTable(
            $tableGateway
        );
        return new AlunoController($alunoTable);
    }
}