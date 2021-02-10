<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210165330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, typemission_id INT NOT NULL, statutmission_id INT NOT NULL, paysmission_id INT NOT NULL, specialitemission_id INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, codename VARCHAR(100) NOT NULL, datestart DATETIME NOT NULL, dateend DATETIME NOT NULL, INDEX IDX_34F1D47E47364E9D (typemission_id), INDEX IDX_34F1D47E525E9A4F (statutmission_id), INDEX IDX_34F1D47E6B748028 (paysmission_id), INDEX IDX_34F1D47E5FA61C83 (specialitemission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_cibles (missions_id INT NOT NULL, cibles_id INT NOT NULL, INDEX IDX_6C327F1417C042CF (missions_id), INDEX IDX_6C327F149E046BDF (cibles_id), PRIMARY KEY(missions_id, cibles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_planques (missions_id INT NOT NULL, planques_id INT NOT NULL, INDEX IDX_F9E5FE8A17C042CF (missions_id), INDEX IDX_F9E5FE8A70AF8C0F (planques_id), PRIMARY KEY(missions_id, planques_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_user (missions_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_304E3C2217C042CF (missions_id), INDEX IDX_304E3C22A76ED395 (user_id), PRIMARY KEY(missions_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E47364E9D FOREIGN KEY (typemission_id) REFERENCES typesmissions (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E525E9A4F FOREIGN KEY (statutmission_id) REFERENCES statutsmissions (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E6B748028 FOREIGN KEY (paysmission_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E5FA61C83 FOREIGN KEY (specialitemission_id) REFERENCES specialites (id)');
        $this->addSql('ALTER TABLE missions_cibles ADD CONSTRAINT FK_6C327F1417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_cibles ADD CONSTRAINT FK_6C327F149E046BDF FOREIGN KEY (cibles_id) REFERENCES cibles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_planques ADD CONSTRAINT FK_F9E5FE8A17C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_planques ADD CONSTRAINT FK_F9E5FE8A70AF8C0F FOREIGN KEY (planques_id) REFERENCES planques (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_user ADD CONSTRAINT FK_304E3C2217C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_user ADD CONSTRAINT FK_304E3C22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE missions_cibles DROP FOREIGN KEY FK_6C327F1417C042CF');
        $this->addSql('ALTER TABLE missions_planques DROP FOREIGN KEY FK_F9E5FE8A17C042CF');
        $this->addSql('ALTER TABLE missions_user DROP FOREIGN KEY FK_304E3C2217C042CF');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE missions_cibles');
        $this->addSql('DROP TABLE missions_planques');
        $this->addSql('DROP TABLE missions_user');
    }
}
