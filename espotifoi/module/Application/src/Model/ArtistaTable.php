<?php
namespace Application\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGatewayInterface;


class ArtistaTable {

    private TableGatewayInterface $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function gravar(Artista $artista)
    {
        $set = $artista->toArray();
        if (empty($set['codigo'])){
        return $this->tableGateway->insert($set);
        }
        return $this->tableGateway ->update($set,['codigo' => $set['codigo']]);  
    }

    public function listar(): ResultSet
    {
        return $this->tableGateway->select();     
    }

    public function excluir($codigo)
    {
       return $this->tableGateway->delete(['codigo' => $codigo] );   
    }

    public function buscarArtista($codigo)
    {
        $artistas = $this->tableGateway->select([ 'codigo' => $codigo]);
       
        if ($artistas->count() > 0){
            return $artistas->current();
        }

        $artista = new \StdClass();
        $artista->codigo = 0;
        $artista->nome="";
        return $artista;
    }

    public function buscarArtistaPorNome($nome)
    {
        $artistas = $this->tableGateway->select([ 'nome' => $nome]);
       
        if ($artistas->count() > 0){
            return $artistas->current();
        }

        $artista = new \StdClass();
        $artista->codigo = 0;
        $artista->nome="";
        return $artista;
    }    



}