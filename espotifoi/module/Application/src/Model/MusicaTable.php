<?php
namespace Application\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class MusicaTable {
    private TableGatewayInterface $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function gravar(Musica $musica)
    {
        $set = $musica->toArray();
         
        if (empty($set['codigo'])) {
        return $this->tableGateway->insert($set);
    }

      return $this->tableGateway ->update($set,['codigo' => $set['codigo']]);  

   }

   public function listar($codigoArtista = null): ResultSet
    {
        $select = new Select($this->tableGateway->getTable());
        $select->join('artistas','musicas.codigo_artista = artistas.codigo',['artista' => 'nome']); 
        if ($codigoArtista !== null){
            $select->where(['codigo_artista' => $codigoArtista]);
        }
        $musicas = $this->tableGateway->selectWith($select);
        return $musicas;
    } 

    public function excluir($codigo)
    {
       return $this->tableGateway->delete(['codigo' => $codigo]


       );     
    }

    public function buscarMusica($codigo)
    {
        $musicas = $this->tableGateway->select(['codigo' => $codigo ]);
        
        if ($musicas->count() > 0){

            return $musicas->current();

        }

        $musica = new \StdClass();
        $musica->codigo = 0;
        $musica->nome = "";
        $musica->codigo_artista = 0;
        return $musica;
    }



    
}