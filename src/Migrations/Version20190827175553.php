<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827175553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agendamentos (id INT AUTO_INCREMENT NOT NULL, data DATETIME NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lancamento ADD agendamentos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lancamento ADD CONSTRAINT FK_6693B3BD4C64A725 FOREIGN KEY (agendamentos_id) REFERENCES agendamentos (id)');
        $this->addSql('CREATE INDEX IDX_6693B3BD4C64A725 ON lancamento (agendamentos_id)');       
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lancamento DROP FOREIGN KEY FK_6693B3BD4C64A725');
        $this->addSql('DROP TABLE agendamentos');
        $this->addSql('DROP INDEX IDX_6693B3BD4C64A725 ON lancamento');
        $this->addSql('ALTER TABLE lancamento DROP agendamentos_id');
       
    }
}
