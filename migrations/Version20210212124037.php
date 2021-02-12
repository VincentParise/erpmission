<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212124037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497D8A5F2E');
        $this->addSql('DROP TABLE missions_user');
        $this->addSql('DROP TABLE typesusers');
        $this->addSql('DROP TABLE user_specialites');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EF5D6347');
        $this->addSql('DROP INDEX IDX_8D93D6497D8A5F2E ON user');
        $this->addSql('DROP INDEX IDX_8D93D649EF5D6347 ON user');
        $this->addSql('ALTER TABLE user DROP paysuser_id, DROP typeuser_id, DROP firstname, DROP lastname, DROP created_at, DROP birthday, DROP code, DROP namecode');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE missions_user (missions_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_304E3C2217C042CF (missions_id), INDEX IDX_304E3C22A76ED395 (user_id), PRIMARY KEY(missions_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE typesusers (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_specialites (user_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_5E9122445AEDDAD9 (specialites_id), INDEX IDX_5E912244A76ED395 (user_id), PRIMARY KEY(user_id, specialites_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE missions_user ADD CONSTRAINT FK_304E3C2217C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_user ADD CONSTRAINT FK_304E3C22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_specialites ADD CONSTRAINT FK_5E9122445AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_specialites ADD CONSTRAINT FK_5E912244A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD paysuser_id INT NOT NULL, ADD typeuser_id INT NOT NULL, ADD firstname VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD lastname VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD created_at DATETIME NOT NULL, ADD birthday DATETIME NOT NULL, ADD code INT NOT NULL, ADD namecode VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497D8A5F2E FOREIGN KEY (typeuser_id) REFERENCES typesusers (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EF5D6347 FOREIGN KEY (paysuser_id) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6497D8A5F2E ON user (typeuser_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EF5D6347 ON user (paysuser_id)');
    }
}
