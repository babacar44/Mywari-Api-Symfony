<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190802083711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526012469DE2');
        $this->addSql('DROP INDEX IDX_CFF6526012469DE2 ON compte');
        $this->addSql('ALTER TABLE compte CHANGE category_id id_depot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260D5CB384B FOREIGN KEY (id_depot_id) REFERENCES depot (id)');
        $this->addSql('CREATE INDEX IDX_CFF65260D5CB384B ON compte (id_depot_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260D5CB384B');
        $this->addSql('DROP INDEX IDX_CFF65260D5CB384B ON compte');
        $this->addSql('ALTER TABLE compte CHANGE id_depot_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526012469DE2 FOREIGN KEY (category_id) REFERENCES depot (id)');
        $this->addSql('CREATE INDEX IDX_CFF6526012469DE2 ON compte (category_id)');
    }
}
