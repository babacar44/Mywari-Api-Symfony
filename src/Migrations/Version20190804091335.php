<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804091335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC8510D4DE');
        $this->addSql('DROP INDEX IDX_47948BBC8510D4DE ON depot');
        $this->addSql('ALTER TABLE depot CHANGE compte_id depot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC8510D4DE FOREIGN KEY (depot_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC8510D4DE ON depot (depot_id)');
        $this->addSql('ALTER TABLE partenaire CHANGE telephone telephone INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC8510D4DE');
        $this->addSql('DROP INDEX IDX_47948BBC8510D4DE ON depot');
        $this->addSql('ALTER TABLE depot CHANGE depot_id compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC8510D4DE FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC8510D4DE ON depot (compte_id)');
        $this->addSql('ALTER TABLE partenaire CHANGE telephone telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
