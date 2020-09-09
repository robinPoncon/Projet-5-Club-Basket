<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909081958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_produit (color_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_7A3361097ADA1FB5 (color_id), INDEX IDX_7A336109F347EFB (produit_id), PRIMARY KEY(color_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_taille (color_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_534E95CA7ADA1FB5 (color_id), INDEX IDX_534E95CAFF25611A (taille_id), PRIMARY KEY(color_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille_produit (taille_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_FBC8E602FF25611A (taille_id), INDEX IDX_FBC8E602F347EFB (produit_id), PRIMARY KEY(taille_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_produit ADD CONSTRAINT FK_7A3361097ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_produit ADD CONSTRAINT FK_7A336109F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_taille ADD CONSTRAINT FK_534E95CA7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_taille ADD CONSTRAINT FK_534E95CAFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE caracteristique');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE color_produit DROP FOREIGN KEY FK_7A3361097ADA1FB5');
        $this->addSql('ALTER TABLE color_taille DROP FOREIGN KEY FK_534E95CA7ADA1FB5');
        $this->addSql('ALTER TABLE color_taille DROP FOREIGN KEY FK_534E95CAFF25611A');
        $this->addSql('ALTER TABLE taille_produit DROP FOREIGN KEY FK_FBC8E602FF25611A');
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, taille VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, color VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, quantity SMALLINT NOT NULL, INDEX IDX_D14FBE8BF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT FK_D14FBE8BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE color_produit');
        $this->addSql('DROP TABLE color_taille');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE taille_produit');
    }
}
