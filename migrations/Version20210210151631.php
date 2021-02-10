<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210151631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planques ADD pays_planque_id INT NOT NULL');
        $this->addSql('ALTER TABLE planques ADD CONSTRAINT FK_30F1AF9DAACC71E3 FOREIGN KEY (pays_planque_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_30F1AF9DAACC71E3 ON planques (pays_planque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planques DROP FOREIGN KEY FK_30F1AF9DAACC71E3');
        $this->addSql('DROP INDEX IDX_30F1AF9DAACC71E3 ON planques');
        $this->addSql('ALTER TABLE planques DROP pays_planque_id');
    }
}
