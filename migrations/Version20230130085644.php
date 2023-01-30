<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130085644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appliquer_prescription AS SELECT id, patient_id, prescription_id, soignant_id, date_heure_application FROM appliquer_prescription');
        $this->addSql('DROP TABLE appliquer_prescription');
        $this->addSql('CREATE TABLE appliquer_prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, soignant_id INTEGER DEFAULT NULL, date_heure_application DATETIME DEFAULT NULL, CONSTRAINT FK_F85764726B899279 FOREIGN KEY (patient_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F857647293DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F8576472453B4D3C FOREIGN KEY (soignant_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appliquer_prescription (id, patient_id, prescription_id, soignant_id, date_heure_application) SELECT id, patient_id, prescription_id, soignant_id, date_heure_application FROM __temp__appliquer_prescription');
        $this->addSql('DROP TABLE __temp__appliquer_prescription');
        $this->addSql('CREATE INDEX IDX_F8576472453B4D3C ON appliquer_prescription (soignant_id)');
        $this->addSql('CREATE INDEX IDX_F857647293DB413D ON appliquer_prescription (prescription_id)');
        $this->addSql('CREATE INDEX IDX_F85764726B899279 ON appliquer_prescription (patient_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, salle_id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, id_personne_id INTEGER DEFAULT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5DDB8E9DBA091CE5 FOREIGN KEY (id_personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, salle_id, lit_occupe) SELECT id, salle_id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DDB8E9DBA091CE5 ON lit (id_personne_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) DEFAULT NULL, date_heure_entree DATETIME DEFAULT NULL, date_heure_sortie DATETIME DEFAULT NULL, code_entre VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, personne_id, raison, date_heure_entree, date_heure_sortie) SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree INTEGER NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, personne1_id, personne2_id, salle_id, date_heure, duree) SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__appliquer_prescription AS SELECT id, patient_id, prescription_id, soignant_id, date_heure_application FROM appliquer_prescription');
        $this->addSql('DROP TABLE appliquer_prescription');
        $this->addSql('CREATE TABLE appliquer_prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, soignant_id INTEGER NOT NULL, date_heure_application DATETIME NOT NULL, CONSTRAINT FK_F85764726B899279 FOREIGN KEY (patient_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F857647293DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F8576472453B4D3C FOREIGN KEY (soignant_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appliquer_prescription (id, patient_id, prescription_id, soignant_id, date_heure_application) SELECT id, patient_id, prescription_id, soignant_id, date_heure_application FROM __temp__appliquer_prescription');
        $this->addSql('DROP TABLE __temp__appliquer_prescription');
        $this->addSql('CREATE INDEX IDX_F85764726B899279 ON appliquer_prescription (patient_id)');
        $this->addSql('CREATE INDEX IDX_F857647293DB413D ON appliquer_prescription (prescription_id)');
        $this->addSql('CREATE INDEX IDX_F8576472453B4D3C ON appliquer_prescription (soignant_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, salle_id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, salle_id, lit_occupe) SELECT id, salle_id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, personne_id, raison, date_heure_entree, date_heure_sortie) SELECT id, personne_id, raison, date_heure_entree, date_heure_sortie FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, personne1_id, personne2_id, salle_id, date_heure, duree) SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
    }
}
