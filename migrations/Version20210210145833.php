<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210145833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planques (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pays ADD libelle VARCHAR(100) NOT NULL, ADD nationalite VARCHAR(100) NOT NULL, DROP libelle_pays, DROP nationalite_pays');
        $this->addSql('ALTER TABLE specialites CHANGE libelle_specialite libelle VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE statutsmissions CHANGE libelle_statutmission libelle VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE typesmissions CHANGE libelle_typemission libelle VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE typesusers CHANGE libelle_typeuser libelle VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE planques');
        $this->addSql('ALTER TABLE pays ADD libelle_pays VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD nationalite_pays VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP libelle, DROP nationalite');
        $this->addSql('ALTER TABLE specialites CHANGE libelle libelle_specialite VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE statutsmissions CHANGE libelle libelle_statutmission VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE typesmissions CHANGE libelle libelle_typemission VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE typesusers CHANGE libelle libelle_typeuser VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
