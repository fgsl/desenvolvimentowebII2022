<?php
namespace Application\Model;

class Aluno {
    public int    $matricula;
    public string $nome;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}