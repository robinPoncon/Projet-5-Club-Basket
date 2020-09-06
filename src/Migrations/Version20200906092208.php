<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906092208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo_produit (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, important TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_1C45FBAAF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, taille VARCHAR(255) NOT NULL, price NUMERIC(5, 2) NOT NULL, color VARCHAR(255) NOT NULL, quantity SMALLINT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_29A5EC27989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_produit ADD CONSTRAINT FK_1C45FBAAF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo_produit DROP FOREIGN KEY FK_1C45FBAAF347EFB');
        $this->addSql('DROP TABLE photo_produit');
        $this->addSql('DROP TABLE produit');
    }
}
