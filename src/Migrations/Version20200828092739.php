<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828092739 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipe_member_club (equipe_id INT NOT NULL, member_club_id INT NOT NULL, INDEX IDX_8EF6E5FE6D861B89 (equipe_id), INDEX IDX_8EF6E5FEDEEDBDA6 (member_club_id), PRIMARY KEY(equipe_id, member_club_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipe_member_club ADD CONSTRAINT FK_8EF6E5FE6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_member_club ADD CONSTRAINT FK_8EF6E5FEDEEDBDA6 FOREIGN KEY (member_club_id) REFERENCES member_club (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE member_club_equipe');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member_club_equipe (member_club_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_D8BB125DDEEDBDA6 (member_club_id), INDEX IDX_D8BB125D6D861B89 (equipe_id), PRIMARY KEY(member_club_id, equipe_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE member_club_equipe ADD CONSTRAINT FK_D8BB125D6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_club_equipe ADD CONSTRAINT FK_D8BB125DDEEDBDA6 FOREIGN KEY (member_club_id) REFERENCES member_club (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE equipe_member_club');
    }
}
