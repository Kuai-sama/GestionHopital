<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106093804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appliquer_prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, patient_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, soignant_id INTEGER NOT NULL, date_heure_application DATETIME NOT NULL, CONSTRAINT FK_F85764726B899279 FOREIGN KEY (patient_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F857647293DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F8576472453B4D3C FOREIGN KEY (soignant_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F85764726B899279 ON appliquer_prescription (patient_id)');
        $this->addSql('CREATE INDEX IDX_F857647293DB413D ON appliquer_prescription (prescription_id)');
        $this->addSql('CREATE INDEX IDX_F8576472453B4D3C ON appliquer_prescription (soignant_id)');
        $this->addSql('CREATE TABLE horaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_personne_id INTEGER NOT NULL, tdebut DATETIME NOT NULL, tfin DATETIME DEFAULT NULL, CONSTRAINT FK_BBC83DB6BA091CE5 FOREIGN KEY (id_personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BBC83DB6BA091CE5 ON horaire (id_personne_id)');
        $this->addSql('DROP TABLE personne_prescription');
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
        $this->addSql('CREATE TABLE personne_prescription (personne_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, PRIMARY KEY(personne_id, prescription_id), CONSTRAINT FK_3D44E76A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3D44E7693DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3D44E7693DB413D ON personne_prescription (prescription_id)');
        $this->addSql('CREATE INDEX IDX_3D44E76A21BD112 ON personne_prescription (personne_id)');
        $this->addSql('DROP TABLE appliquer_prescription');
        $this->addSql('DROP TABLE horaire');
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
