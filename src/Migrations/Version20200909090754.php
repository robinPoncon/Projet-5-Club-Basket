<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909090754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE taille_color');
        $this->addSql('DROP TABLE taille_produit');
        $this->addSql('ALTER TABLE taille ADD color_id INT DEFAULT NULL, ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B387ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B38F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_76508B387ADA1FB5 ON taille (color_id)');
        $this->addSql('CREATE INDEX IDX_76508B38F347EFB ON taille (produit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taille_color (taille_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_5900BB76FF25611A (taille_id), INDEX IDX_5900BB767ADA1FB5 (color_id), PRIMARY KEY(taille_id, color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE taille_produit (taille_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_FBC8E602FF25611A (taille_id), INDEX IDX_FBC8E602F347EFB (produit_id), PRIMARY KEY(taille_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE taille_color ADD CONSTRAINT FK_5900BB767ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_color ADD CONSTRAINT FK_5900BB76FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille_produit ADD CONSTRAINT FK_FBC8E602FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B387ADA1FB5');
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B38F347EFB');
        $this->addSql('DROP INDEX IDX_76508B387ADA1FB5 ON taille');
        $this->addSql('DROP INDEX IDX_76508B38F347EFB ON taille');
        $this->addSql('ALTER TABLE taille DROP color_id, DROP produit_id');
    }
}
