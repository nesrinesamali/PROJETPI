<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215193553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC73345E0A3');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, nompatient VARCHAR(255) NOT NULL, nommedecin VARCHAR(255) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC73345E0A3 ON reponse');
        $this->addSql('ALTER TABLE reponse CHANGE rendezvous_id reponse_id INT DEFAULT NULL, CHANGE statut description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7CF18BB82 FOREIGN KEY (reponse_id) REFERENCES rendezvous (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC7CF18BB82 ON reponse (reponse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7CF18BB82');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, nom_patient VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom_medecin VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, heure TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC7CF18BB82 ON reponse');
        $this->addSql('ALTER TABLE reponse CHANGE reponse_id rendezvous_id INT DEFAULT NULL, CHANGE description statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC73345E0A3 FOREIGN KEY (rendezvous_id) REFERENCES rendez_vous (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC73345E0A3 ON reponse (rendezvous_id)');
    }
}
