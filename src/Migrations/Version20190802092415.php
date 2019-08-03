<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802092415 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260D5CB384B');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depot');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, id_partenaire_id INT DEFAULT NULL, id_depot_id INT DEFAULT NULL, compte_bancaire VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, solde BIGINT NOT NULL, INDEX IDX_CFF65260D5CB384B (id_depot_id), INDEX IDX_CFF6526026F6C2C9 (id_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, montant BIGINT NOT NULL, date_depot DATETIME NOT NULL, caissier VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526026F6C2C9 FOREIGN KEY (id_partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260D5CB384B FOREIGN KEY (id_depot_id) REFERENCES depot (id)');
    }
}
