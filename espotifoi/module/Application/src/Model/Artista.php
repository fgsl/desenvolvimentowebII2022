<?php
namespace Application\Model;

class Artista {
    public int $codigo;
    public string $nome;
 

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}