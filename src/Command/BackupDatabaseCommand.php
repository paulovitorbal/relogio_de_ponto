<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

#[AsCommand(
    name: 'backup-database',
    description: 'Realiza backup do banco de dados',
)]
class BackupDatabaseCommand extends Command
{
    private MailerInterface $mailer;
    private string $databaseFile;

    public function __construct(MailerInterface $mailer, string $projectDir)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->databaseFile = implode(DIRECTORY_SEPARATOR, [$projectDir, 'var', 'relogio_de_ponto.db']);
    }

    protected function configure(): void
    {

    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = (new Email())
            ->from('paulovitorbal@gmail.com')
            ->to('paulovitorbal@gmail.com')
            ->subject('Backup diário da folha de ponto')
            ->addPart(new DataPart(new File($this->databaseFile), 'relogio_de_ponto'.date('Ymd_Hisd').'.db'));

        $this->mailer->send($email);
        $io->success('Backup realizado com sucesso!');

        return Command::SUCCESS;
    }
}
