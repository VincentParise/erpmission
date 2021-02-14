<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214122625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6EA832C1C9');
        $this->addSql('DROP INDEX UNIQ_9596AB6EA832C1C9 ON agents');
        $this->addSql('ALTER TABLE agents DROP email_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agents ADD email_id INT NOT NULL');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EA832C1C9 FOREIGN KEY (email_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9596AB6EA832C1C9 ON agents (email_id)');
    }
}
