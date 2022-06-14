<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Model\MusicaTable;
use Application\Model\ArtistaTable;
use Application\Model\Musica;



class MusicaController extends AbstractActionController
{
    private MusicaTable  $musicaTable;
    private ArtistaTable $artistaTable;

    public function __construct( MusicaTable $musicaTable,  ArtistaTable $artistaTable    )
    {
        $this->musicaTable   = $musicaTable;
        $this->artistaTable  = $artistaTable; 

    }

    public function indexAction()
    {
        $musicas = $this -> musicaTable ->listar();
        return new ViewModel([ 'musicas' => $musicas  ]);
    }

    public function editarAction()
    {
       
        $codigo = $this->params('codigo');
        $musica = $this->musicaTable->buscarMusica($codigo);
        
        $artistas = $this->artistaTable->listar();  

        return new ViewModel(['musica' => $musica,'artistas' => $artistas]);
     
    }

    public function gravarAction()
    {
        $codigo = $this->getRequest()->getPost('codigo');
        $nome = $this->getRequest()->getPost('nome');
        $codigo_artista = $this->getRequest()->getPost('artista');

        $musica = new Musica();

        $musica ->codigo         = (int) $codigo;
        $musica ->nome           = $nome;
        $musica ->codigo_artista = (int) $codigo_artista;

        $this->musicaTable->gravar($musica);

        return $this->redirect()->toRoute('musicas'); 

    }

    public function excluirAction()
    {
        $codigo = $this->params('codigo');
        $this->musicaTable->excluir($codigo);
        return  $this->redirect()->toRoute('musicas'); 
    }

    


}
