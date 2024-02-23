<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221155310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvous ADD reponse_id INT DEFAULT NULL, ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C09A9BA8CF18BB82 ON rendezvous (reponse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8CF18BB82');
        $this->addSql('DROP INDEX UNIQ_C09A9BA8CF18BB82 ON rendezvous');
        $this->addSql('ALTER TABLE rendezvous DROP reponse_id, DROP description');
    }
}
