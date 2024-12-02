<?php

namespace App\Controller;

use App\DataObject\LinhaFolhaPonto;
use App\Empregador;
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
    public function anoMes(
        RegistroPontoRepository $repository,
        int $ano,
        int $mes,
        Request $request,
        EntityManagerInterface $entityManager,
        FuncionarioRepository $funcionarioRepository,
        Empregador $empregador
    ): Response
    {
        if ($request->isMethod(Request::METHOD_POST)){
            switch ($request->get('acao')){
                case 'Adicionar registro':
                    $this->inserirRegistroPonto($request->get('data'), $entityManager);
                    break;
                case 'Adicionar folga':
                    $this->inserirRegistroPonto($request->get('data')."T08:00", $entityManager);
                    $this->inserirRegistroPonto($request->get('data')."T08:00", $entityManager);
                    $this->inserirRegistroPonto($request->get('data')."T08:00", $entityManager);
                    $this->inserirRegistroPonto($request->get('data')."T08:00", $entityManager);
                    break;
            }
        }
        $dias = $repository->visualizarFolhaPontoMesAno(1, $ano, $mes);
        $tempoTotal = $repository->getTempoTotalLinhas(...$dias);
        return $this->render('folha/visualizar.html.twig', [
            'mes'=>$mes,
            'ano'=>$ano,
            'dias'=> $dias,
            'tempoTotal'=>$tempoTotal,
            'funcionario'=>$funcionarioRepository->find(1),
            'empregador'=>$empregador
        ]);
    }

    private function inserirRegistroPonto(string $data, EntityManagerInterface $entityManager): void
    {
        $registro = new RegistroPonto();
        $registro->setDataRegistro(\DateTimeImmutable::createFromFormat('Y-m-d\\TH:i', $data));
        $registro->setTipo(TipoRegistro::INSERCAO);
        $registro->setFuncionario(1);

        $entityManager->persist($registro);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Registro salvo!'
        );
    }

}
