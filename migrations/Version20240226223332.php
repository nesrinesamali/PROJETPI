<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226223332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre_don (id INT AUTO_INCREMENT NOT NULL, nom_centre VARCHAR(255) NOT NULL, date_ouverture TIME NOT NULL, datefermeture TIME NOT NULL, gouvernorat VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numero INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dons (id INT AUTO_INCREMENT NOT NULL, centre_don_id INT NOT NULL, date_don DATETIME NOT NULL, datedernierdon DATE NOT NULL, genre VARCHAR(255) NOT NULL, groupe_sanguin VARCHAR(255) NOT NULL, etatmarital VARCHAR(255) NOT NULL, typededon VARCHAR(255) NOT NULL, cin INT NOT NULL, INDEX IDX_E4F955FAA8819EC6 (centre_don_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dons ADD CONSTRAINT FK_E4F955FAA8819EC6 FOREIGN KEY (centre_don_id) REFERENCES centre_don (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dons DROP FOREIGN KEY FK_E4F955FAA8819EC6');
        $this->addSql('DROP TABLE centre_don');
        $this->addSql('DROP TABLE dons');
    }
}
