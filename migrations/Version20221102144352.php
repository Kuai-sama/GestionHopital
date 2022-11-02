<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102144352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lit_occupe BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_metier VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL, rfid INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lit');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE service');
    }
}
