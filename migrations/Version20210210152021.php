<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210152021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planques ADD typeplanque_id INT NOT NULL');
        $this->addSql('ALTER TABLE planques ADD CONSTRAINT FK_30F1AF9DF5B24206 FOREIGN KEY (typeplanque_id) REFERENCES typesplanques (id)');
        $this->addSql('CREATE INDEX IDX_30F1AF9DF5B24206 ON planques (typeplanque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planques DROP FOREIGN KEY FK_30F1AF9DF5B24206');
        $this->addSql('DROP INDEX IDX_30F1AF9DF5B24206 ON planques');
        $this->addSql('ALTER TABLE planques DROP typeplanque_id');
    }
}
