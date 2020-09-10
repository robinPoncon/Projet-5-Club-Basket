<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910131613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE produit_color');
        $this->addSql('ALTER TABLE color ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E9F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_665648E9F347EFB ON color (produit_id)');
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B38F347EFB');
        $this->addSql('DROP INDEX IDX_76508B38F347EFB ON taille');
        $this->addSql('ALTER TABLE taille DROP produit_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produit_color (produit_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_56CA2F7DF347EFB (produit_id), INDEX IDX_56CA2F7D7ADA1FB5 (color_id), PRIMARY KEY(produit_id, color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_color ADD CONSTRAINT FK_56CA2F7D7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_color ADD CONSTRAINT FK_56CA2F7DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color DROP FOREIGN KEY FK_665648E9F347EFB');
        $this->addSql('DROP INDEX IDX_665648E9F347EFB ON color');
        $this->addSql('ALTER TABLE color DROP produit_id');
        $this->addSql('ALTER TABLE taille ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B38F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_76508B38F347EFB ON taille (produit_id)');
    }
}
