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

class PontoController extends AbstractController
{
    #[Route('/ponto', name: 'ponto_home')]
    public function index(Request $request, EntityManagerInterface $entityManager, RegistroPontoRepository $repository): Response
    {
        $params = ['mensagem'=>''];
        $date = new \DateTimeImmutable("now", new \DateTimeZone('America/Sao_Paulo'));
        if ($request->isMethod(Request::METHOD_POST)){
            $registro = new RegistroPonto();
            $registro->setDataRegistro($date->setTime($date->format('H'), $date->format('i')));
            $registro->setTipo(TipoRegistro::INSERCAO);
            $registro->setFuncionario(1);

            $entityManager->persist($registro);
            $entityManager->flush();
            $params['mensagem']="Sucesso!";
        }
        $params['registros']=$repository->findByFuncionario(1);

        $params['agora']=$date;
        $params['tempoTotal']=$repository->tempoTotal($params['registros'],$date->setTime($date->format('H'), $date->format('i')));
        dump($params);
        return $this->render('ponto/index.html.twig', $params);
    }
}
