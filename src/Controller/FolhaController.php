<?php

namespace App\Controller;

use App\Repository\RegistroPontoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FolhaController extends AbstractController
{
    #[Route('/folha', name: 'listar_folha')]
    public function index(RegistroPontoRepository $repository): Response
    {
        return $this->render('folha/listar.html.twig', [
            'folhas'=>$repository->listMeses()
        ]);
    }
    #[Route('/folha/{ano}/{mes}', name: 'mostrar_folha')]
    public function anoMes(RegistroPontoRepository $repository, int $ano, int $mes): Response
    {
        return $this->render('folha/visualizar.html.twig', [
            'mes'=>$mes,
            'ano'=>$ano,
            'dias'=>$repository->visualizarFolhaPontoMesAno(1, $ano, $mes)
        ]);
    }
}
