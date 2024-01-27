<?php

namespace App\Controller;

use App\DataObject\LinhaFolhaPonto;
use App\Entity\RegistroPonto;
use App\Entity\TipoRegistro;
use App\Repository\FuncionarioRepository;
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
    #[Route('/folha/excluir/{id}', name: 'excluir_registro_ponto')]
    public function excluirRegistroPonto(EntityManagerInterface $entityManager, RegistroPonto $id): Response
    {
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('mostrar_folha', [
            'ano'=>$id->getDataRegistro()->format('Y'),
            'mes'=>$id->getDataRegistro()->format('m')
        ]);
    }
    #[Route('/folha/{ano}/{mes}', name: 'mostrar_folha')]
    public function anoMes(RegistroPontoRepository $repository, int $ano, int $mes, Request $request, EntityManagerInterface $entityManager, FuncionarioRepository $funcionarioRepository): Response
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
        $dias = $repository->visualizarFolhaPontoMesAno(1, $ano, $mes);
        $tempoTotal = array_reduce($dias, static function (int $total, LinhaFolhaPonto $a) {
            if (count($a->getValores())%2 == 1){
                return $total;
            }
            return ($total + $a->getTotal()-(8*60));
        }, 0);
        return $this->render('folha/visualizar.html.twig', [
            'mes'=>$mes,
            'ano'=>$ano,
            'dias'=> $dias,
            'tempoTotal'=>$tempoTotal,
            'funcionario'=>$funcionarioRepository->find(1)
        ]);
    }
}
