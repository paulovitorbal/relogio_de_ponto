<?php

namespace App\Controller;

use App\Entity\RegistroPonto;
use App\Entity\TipoRegistro;
use App\Repository\RegistroPontoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function anoMes(RegistroPontoRepository $repository, int $ano, int $mes, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod(Request::METHOD_POST)){

            $registro = new RegistroPonto();
            $registro->setDataRegistro(\DateTimeImmutable::createFromFormat('Y-m-d\\TH:i', $request->get('data')));
            $registro->setTipo(TipoRegistro::INSERCAO);
            $registro->setFuncionario(1);

            $entityManager->persist($registro);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Registro salvo!'
            );
        }
        return $this->render('folha/visualizar.html.twig', [
            'mes'=>$mes,
            'ano'=>$ano,
            'dias'=>$repository->visualizarFolhaPontoMesAno(1, $ano, $mes)
        ]);
    }
}
