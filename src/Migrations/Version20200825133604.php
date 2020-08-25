<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825133604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo_diaporama (id INT AUTO_INCREMENT NOT NULL, diaporama_id INT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7A980E9F7F32056C (diaporama_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_diaporama ADD CONSTRAINT FK_7A980E9F7F32056C FOREIGN KEY (diaporama_id) REFERENCES diaporama (id)');
        $this->addSql('ALTER TABLE diaporama DROP image_name, DROP updated_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE photo_diaporama');
        $this->addSql('ALTER TABLE diaporama ADD image_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD updated_at DATETIME NOT NULL');
    }
}
