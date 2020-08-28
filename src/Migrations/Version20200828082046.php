<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828082046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE member_club (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user_fonction_club');
        $this->addSql('ALTER TABLE user DROP telephone');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_fonction_club (user_id INT NOT NULL, fonction_club_id INT NOT NULL, INDEX IDX_235ADB7EA76ED395 (user_id), INDEX IDX_235ADB7EAC4966AA (fonction_club_id), PRIMARY KEY(user_id, fonction_club_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_fonction_club ADD CONSTRAINT FK_235ADB7EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_fonction_club ADD CONSTRAINT FK_235ADB7EAC4966AA FOREIGN KEY (fonction_club_id) REFERENCES fonction_club (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE member_club');
        $this->addSql('ALTER TABLE user ADD telephone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
