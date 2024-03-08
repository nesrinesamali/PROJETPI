<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308045023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(255) NOT NULL, doctor VARCHAR(255) NOT NULL, date DATE NOT NULL, diagnosis LONGTEXT NOT NULL, test LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, dossier_medical_id INT DEFAULT NULL, patient VARCHAR(255) NOT NULL, doctor VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, medications LONGTEXT DEFAULT NULL, instructions LONGTEXT DEFAULT NULL, pharmacy VARCHAR(255) DEFAULT NULL, INDEX IDX_1FBFB8D97750B79F (dossier_medical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D97750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D97750B79F');
        $this->addSql('DROP TABLE dossier_medical');
        $this->addSql('DROP TABLE prescription');
    }
}
