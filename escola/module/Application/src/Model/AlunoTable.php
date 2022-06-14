<?php
//Classe mapeadora de dados

namespace Application\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGatewayInterface;

Class AlunoTable{
    private TableGatewayInterface $tableGateway; //TableGateway é uma passagem,um caminho

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

    }

    public function gravar(Aluno $aluno)
    {
        $set = $aluno->toArray();
        if (empty($set['matricula'])){
            return $this->tableGateway
            ->insert($set);
        }
        return $this->tableGateway
        ->update($set,[
            'matricula' => $set['matricula']
        ]);  
    }

    public function listar(): ResultSet
    {
        return $this->tableGateway->select();
    }

    public function excluir($matricula)
    {
       return $this->tableGateway->delete(
           ['matricula' => $matricula]
       );     
    }

    public function buscarAluno($matricula)
    {
        $alunos = $this->tableGateway
        ->select([
            'matricula' => $matricula    
        ]);
        if ($alunos->count() > 0){
            return $alunos->current();
        }
        $aluno = new \StdClass();
        $aluno->matricula = 0;
        $aluno->nome = "";
        return $aluno;
    }


}