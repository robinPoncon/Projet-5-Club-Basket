<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828085045 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member_club_fonction_club (member_club_id INT NOT NULL, fonction_club_id INT NOT NULL, INDEX IDX_B13B7491DEEDBDA6 (member_club_id), INDEX IDX_B13B7491AC4966AA (fonction_club_id), PRIMARY KEY(member_club_id, fonction_club_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_club_equipe (member_club_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_D8BB125DDEEDBDA6 (member_club_id), INDEX IDX_D8BB125D6D861B89 (equipe_id), PRIMARY KEY(member_club_id, equipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_member_club (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member_club_fonction_club ADD CONSTRAINT FK_B13B7491DEEDBDA6 FOREIGN KEY (member_club_id) REFERENCES member_club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_club_fonction_club ADD CONSTRAINT FK_B13B7491AC4966AA FOREIGN KEY (fonction_club_id) REFERENCES fonction_club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_club_equipe ADD CONSTRAINT FK_D8BB125DDEEDBDA6 FOREIGN KEY (member_club_id) REFERENCES member_club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_club_equipe ADD CONSTRAINT FK_D8BB125D6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_club ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member_club ADD CONSTRAINT FK_4466142E7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo_member_club (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4466142E7E9E4C8C ON member_club (photo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_club DROP FOREIGN KEY FK_4466142E7E9E4C8C');
        $this->addSql('DROP TABLE member_club_fonction_club');
        $this->addSql('DROP TABLE member_club_equipe');
        $this->addSql('DROP TABLE photo_member_club');
        $this->addSql('DROP INDEX UNIQ_4466142E7E9E4C8C ON member_club');
        $this->addSql('ALTER TABLE member_club DROP photo_id');
    }
}
