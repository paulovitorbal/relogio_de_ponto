<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127133605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE funcionario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nome VARCHAR(1024) NOT NULL, custo_diario_passagem INTEGER NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, data_registro, tipo, funcionario, processado_em FROM registro_ponto');
        $this->addSql('DROP TABLE registro_ponto');
        $this->addSql('CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, data_registro DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , tipo VARCHAR(25) NOT NULL, funcionario INTEGER NOT NULL, processado_em DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO registro_ponto (id, data_registro, tipo, funcionario, processado_em) SELECT id, data_registro, tipo, funcionario, processado_em FROM __temp__registro_ponto');
        $this->addSql('DROP TABLE __temp__registro_ponto');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE funcionario');
        $this->addSql('CREATE TEMPORARY TABLE __temp__registro_ponto AS SELECT id, data_registro, tipo, funcionario, processado_em FROM registro_ponto');
        $this->addSql('DROP TABLE registro_ponto');
        $this->addSql('CREATE TABLE registro_ponto (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, data_registro DATETIME NOT NULL, tipo VARCHAR(25) NOT NULL, funcionario INTEGER NOT NULL, processado_em DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO registro_ponto (id, data_registro, tipo, funcionario, processado_em) SELECT id, data_registro, tipo, funcionario, processado_em FROM __temp__registro_ponto');
        $this->addSql('DROP TABLE __temp__registro_ponto');
    }
}
