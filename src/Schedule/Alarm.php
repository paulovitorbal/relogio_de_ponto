<?php

namespace App\Schedule;

use App\Repository\RegistroPontoRepository;
use DateTimeImmutable;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Scheduler\Attribute\AsCronTask;

#[AsCronTask('* * * * *')]
#[AsCommand(name: 'check-alarm')]
class Alarm extends Command
{
    private RegistroPontoRepository $repository;

    public function __construct(RegistroPontoRepository $repository){
        parent::__construct();
        $this->repository = $repository;

    }

    /**
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Executando alarme");
        $date = new DateTimeImmutable("now", new \DateTimeZone('America/Sao_Paulo'));
        $registros=$this->repository->findByFuncionario(1, 1000);
        if ($registros==null || count($registros)%2 == 0) {
            $output->writeln("Não há ponto em aberto");
            return Command::FAILURE;
        }
        $tempoTotal=(8*60)-$this->repository->tempoTotal($registros,$date->setTime($date->format('H'), $date->format('i')));
        $output->writeln("Tempo total: ".$tempoTotal);
        switch ($tempoTotal) {
            case 15: $output->writeln("faltam 15 minutos");break;
            case 10: $output->writeln("faltam 10 minutos");break;
            case $tempoTotal < 5 && $tempoTotal > 0:
            case 5: $output->writeln("faltam 5 minutos");break;
            case $tempoTotal < 0 && $tempoTotal > -10: $output->writeln("tempo esgotado");;
        }
        return Command::SUCCESS;
    }
}