<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Application\Model\ArtistaTable;
use Application\Model\MusicaTable;
use Application\Model\Artista;

class ArtistaController extends AbstractActionController
{
    private ArtistaTable $artistaTable;
    private MusicaTable  $musicaTable;

    public function __construct(ArtistaTable $artistaTable, MusicaTable  $musicaTable)
    {
        $this->musicaTable  = $musicaTable;
        $this->artistaTable = $artistaTable;
    }

    public function indexAction()
    {
        $artistas = $this -> artistaTable ->listar();
        return new ViewModel([ 'artistas' => $artistas]);
    }

    public function musicaAction()
    {
        $codigo = $this->params('codigo');        
        $musicas = $this->musicaTable->listar($codigo);     
        return new JsonModel([ 'musicas' => $musicas->toArray()]);
    }

    public function editarAction()
    {
        $codigo = $this->params('codigo');
        $artista = $this->artistaTable->buscarArtista($codigo);
        return new ViewModel(['artista' => $artista]);
    }

    public function gravarAction()
    {
        $codigo = $this->getRequest()->getPost('codigo');
        $nome = $this->getRequest()->getPost('nome');
        $artista = new Artista();
        $artista->codigo = (int) $codigo;
        $artista->nome = $nome;
        $this->artistaTable->gravar($artista);
        return $this->redirect()->toRoute('artistas'); 
    }

    public function excluirAction()
    {
        $codigo = $this->params('codigo');
        $this->artistaTable->excluir($codigo);
        return $this->redirect()->toRoute('artistas'); 
    }

    

   

}
