<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200609124430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipe_training DROP FOREIGN KEY FK_171D7534BEFD98D1');
        $this->addSql('CREATE TABLE convocation (id INT AUTO_INCREMENT NOT NULL, equipes_id INT NOT NULL, day VARCHAR(255) NOT NULL, horaire TIME NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_C03B3F5F737800BA (equipes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE convocation ADD CONSTRAINT FK_C03B3F5F737800BA FOREIGN KEY (equipes_id) REFERENCES equipe (id)');
        $this->addSql('DROP TABLE equipe_training');
        $this->addSql('DROP TABLE training');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipe_training (equipe_id INT NOT NULL, training_id INT NOT NULL, INDEX IDX_171D75346D861B89 (equipe_id), INDEX IDX_171D7534BEFD98D1 (training_id), PRIMARY KEY(equipe_id, training_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, horaire TIME NOT NULL, address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipe_training ADD CONSTRAINT FK_171D75346D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_training ADD CONSTRAINT FK_171D7534BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE convocation');
    }
}
