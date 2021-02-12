<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212130554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, code INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(50) NOT NULL, birthday DATETIME NOT NULL, INDEX IDX_9596AB6EA6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_specialites (agents_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_F6BF24EA709770DC (agents_id), INDEX IDX_F6BF24EA5AEDDAD9 (specialites_id), PRIMARY KEY(agents_id, specialites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA5AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agents_specialites DROP FOREIGN KEY FK_F6BF24EA709770DC');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE agents_specialites');
    }
}
