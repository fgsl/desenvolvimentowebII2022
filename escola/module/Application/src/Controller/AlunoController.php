<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\AlunoTable;
use Application\Model\Aluno;

class AlunoController extends AbstractActionController
{

    private AlunoTable $alunoTable;

    public function __construct(AlunoTable $alunoTable)
    {
        $this->alunoTable = $alunoTable;
    }

    public function indexAction()
    {
        $alunos = $this -> alunoTable
        ->listar();
        return new ViewModel([
            'alunos' => $alunos
        ]);
    }

    public function editarAction()
    {
        $matricula = $this->params('matricula');
        
        $aluno = $this->alunoTable->
        buscarAluno($matricula);

        return new ViewModel([
            'aluno' => $aluno
        ]);
    }

    public function gravarAction()
    {
        $matricula = $this->getRequest()->getPost('matricula');
        $nome = $this->getRequest()->getPost('nome');
        $aluno = new Aluno();
        $aluno->matricula = (int) $matricula;
        $aluno->nome = $nome;
        $this->alunoTable->gravar($aluno);
        return $this->redirect()->toRoute('alunos'); 
    }

    public function excluirAction()
    {
        $matricula = $this->params('matricula');
        $this->alunoTable->excluir($matricula);
        return $this->redirect()->toRoute('alunos'); 
    }


}
