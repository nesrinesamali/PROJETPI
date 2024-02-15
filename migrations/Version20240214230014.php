<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214230014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier_medical_prescription (dossier_medical_id INT NOT NULL, prescription_id INT NOT NULL, INDEX IDX_B25AC6B07750B79F (dossier_medical_id), INDEX IDX_B25AC6B093DB413D (prescription_id), PRIMARY KEY(dossier_medical_id, prescription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossier_medical_prescription ADD CONSTRAINT FK_B25AC6B07750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier_medical_prescription ADD CONSTRAINT FK_B25AC6B093DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical_prescription DROP FOREIGN KEY FK_B25AC6B07750B79F');
        $this->addSql('ALTER TABLE dossier_medical_prescription DROP FOREIGN KEY FK_B25AC6B093DB413D');
        $this->addSql('DROP TABLE dossier_medical_prescription');
    }
}
