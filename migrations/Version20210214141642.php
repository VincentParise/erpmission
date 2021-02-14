<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214141642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents_specialites (agents_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_F6BF24EA709770DC (agents_id), INDEX IDX_F6BF24EA5AEDDAD9 (specialites_id), PRIMARY KEY(agents_id, specialites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_missions (agents_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_B804F404709770DC (agents_id), INDEX IDX_B804F40417C042CF (missions_id), PRIMARY KEY(agents_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA5AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F404709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F40417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents ADD pays_id INT DEFAULT NULL, ADD code INT NOT NULL, ADD firstname VARCHAR(100) NOT NULL, ADD lastname VARCHAR(100) NOT NULL, ADD birthday DATETIME NOT NULL');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_9596AB6EA6E44244 ON agents (pays_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE agents_specialites');
        $this->addSql('DROP TABLE agents_missions');
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6EA6E44244');
        $this->addSql('DROP INDEX IDX_9596AB6EA6E44244 ON agents');
        $this->addSql('ALTER TABLE agents DROP pays_id, DROP code, DROP firstname, DROP lastname, DROP birthday');
    }
}
