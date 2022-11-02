<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102145707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__salle AS SELECT id, nom_salle, emplacement_salle, type_salle FROM salle');
        $this->addSql('DROP TABLE salle');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO salle (id, nom_salle, emplacement_salle, type_salle) SELECT id, nom_salle, emplacement_salle, type_salle FROM __temp__salle');
        $this->addSql('DROP TABLE __temp__salle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle ADD COLUMN rfid INTEGER NOT NULL');
    }
}
