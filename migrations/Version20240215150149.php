<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215150149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendrier (id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation DROP date, DROP duree, DROP diagnostique, DROP recommandations, DROP id_medecin, DROP id_patients, CHANGE id id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('ALTER TABLE consultation ADD date DATETIME NOT NULL, ADD duree VARCHAR(255) NOT NULL, ADD diagnostique LONGTEXT NOT NULL, ADD recommandations LONGTEXT NOT NULL, ADD id_medecin INT NOT NULL, ADD id_patients INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
