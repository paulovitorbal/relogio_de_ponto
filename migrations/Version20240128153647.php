<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128153647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'criando tabela para guardar os vales transportes emitidos';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vale_transporte (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, funcionario INTEGER NOT NULL, quantidade_dias INTEGER NOT NULL, custo_diario_passagem INTEGER NOT NULL, mes INTEGER NOT NULL, ano INTEGER NOT NULL, data_emissao DATE NOT NULL --(DC2Type:date_immutable)
        )');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vale_transporte');
    }
}
