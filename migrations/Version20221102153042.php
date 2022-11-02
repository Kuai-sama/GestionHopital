<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102153042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fournisseur VARCHAR(255) NOT NULL, quantite INTEGER NOT NULL, etat VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE diagnostic (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, diagnostic VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lit_occupe BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE TABLE medicament (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_medicament VARCHAR(255) NOT NULL, forme VARCHAR(255) NOT NULL, stock INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_metier VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unite INTEGER NOT NULL, date_fin DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL, rfid INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, mot_de_passe FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, num_securite_sociale INTEGER NOT NULL, num_adeli INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, num_tel INTEGER NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO personne (id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, password) SELECT id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, mot_de_passe FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE lit');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE service');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, email, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel INTEGER NOT NULL)');
        $this->addSql('INSERT INTO personne (id, email, mot_de_passe, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, email, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
    }
}
