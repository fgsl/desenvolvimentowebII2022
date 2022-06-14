<?php
namespace Application\Model;

use Laminas\Db\Sql\Predicate\In;

class Musica {
    public int $codigo;
    public string $nome;
    public int $codigo_artista;

    public function exchangeArray($data)
    {
        $this->codigo = $data['codigo'];
        $this->nome = $data['nome'];
        $this->codigo_artista = $data['codigo_artista'];
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}