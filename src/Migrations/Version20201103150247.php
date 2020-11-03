<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103150247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo_sponsor (id INT AUTO_INCREMENT NOT NULL, sponsor_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B46CDE5912F7FB51 (sponsor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_sponsor ADD CONSTRAINT FK_B46CDE5912F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id)');
        $this->addSql('ALTER TABLE sponsor DROP image_name, DROP updated_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE photo_sponsor');
        $this->addSql('ALTER TABLE sponsor ADD image_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD updated_at DATETIME NOT NULL');
    }
}
