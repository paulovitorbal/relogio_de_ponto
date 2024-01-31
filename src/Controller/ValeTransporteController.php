<?php

namespace App\Controller;

use App\Empregador;
use App\Entity\RegistroPonto;
use App\Entity\ValeTransporte;
use App\Repository\FuncionarioRepository;
use App\Repository\ValeTransporteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValeTransporteController extends AbstractController
{
    #[Route('/vale-transporte', name: 'vale_transporte')]
    public function index(Request $request, EntityManagerInterface $entityManager, ValeTransporteRepository $repository, FuncionarioRepository $funcRepo): Response
    {
        $funcionario=$funcRepo->find(1);
        dump($request->getPayload());
        if ($request->isMethod(Request::METHOD_POST)){
            [$ano, $mes] = explode("-", $request->get("mesAno"));
            $valor = $request->get("valor")*100;
            if ($valor !== $funcionario->getCustoDiarioPassagem()){
                $funcionario->setCustoDiarioPassagem($valor);
                $entityManager->persist($funcionario);
            }
            $valeTransporte = new ValeTransporte();
            $valeTransporte->setCustoDiarioPassagem($valor);
            $valeTransporte->setAno($ano);
            $valeTransporte->setMes($mes);
            $valeTransporte->setQuantidadeDias($request->get("quantidadeDias"));
            $valeTransporte->setFuncionario(1);
            $valeTransporte->setDataEmissao(new \DateTimeImmutable());
            $entityManager->persist($valeTransporte);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Registro salvo!'
            );
            return $this->redirectToRoute('vale_transporte');
        }
        return $this->render('vale_transporte/index.html.twig', [
            'vales_emitidos' => $repository->findBy(['funcionario'=>1]),
            'funcionario'=> $funcionario
        ]);
    }
    #[Route('//vale-transporte/excluir/{id}', name: 'excluir_vale_transporte')]
    public function excluirRegistroPonto(EntityManagerInterface $entityManager, ValeTransporte $id): Response
    {
        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('vale_transporte');
    }
    #[Route('/vale-transporte/{id}', name: 'vale_transporte_ver')]
    public function ver(ValeTransporteRepository $repository, $id, FuncionarioRepository $funcRepo, Empregador $empregador): Response
    {
        return $this->render('vale_transporte/visualizar.html.twig', [
            'vale_transporte' => $repository->find($id),
            'funcionario'=>$funcRepo->find(1),
            'empregador'=> $empregador,
            'meses'=>[
                1 => 'Janeiro',
                2 => 'Fevereiro',
                3 => 'Março',
                4 => 'Abril',
                5 => 'Maio',
                6 => 'Junho',
                7 => 'Julho',
                8 => 'Agosto',
                9 => 'Setembro',
                10 => 'Outubro',
                11 => 'Novembro',
                12 => 'Dezembro'
            ]
        ]);
    }
}
