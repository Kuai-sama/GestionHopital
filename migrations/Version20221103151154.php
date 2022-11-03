<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103151154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle VARCHAR(255) NOT NULL, type_salle VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP TABLE personne');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE "BINARY", prenom VARCHAR(255) NOT NULL COLLATE "BINARY", email VARCHAR(255) NOT NULL COLLATE "BINARY", num_tel INTEGER NOT NULL, mot_de_passe VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('DROP TABLE lit');
        $this->addSql('DROP TABLE salle');
    }
}
