<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106093515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) DEFAULT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL, code_entre VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre) SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL, code_entre VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre) SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie, code_entre FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
    }
}
