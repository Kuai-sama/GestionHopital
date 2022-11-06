<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106212755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne_diagnostic (personne_id INTEGER NOT NULL, diagnostic_id INTEGER NOT NULL, PRIMARY KEY(personne_id, diagnostic_id), CONSTRAINT FK_75C08DA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_75C08D224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_75C08DA21BD112 ON personne_diagnostic (personne_id)');
        $this->addSql('CREATE INDEX IDX_75C08D224CCA91 ON personne_diagnostic (diagnostic_id)');
        $this->addSql('CREATE TABLE personne_prescription (personne_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, PRIMARY KEY(personne_id, prescription_id), CONSTRAINT FK_3D44E76A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3D44E7693DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3D44E76A21BD112 ON personne_prescription (personne_id)');
        $this->addSql('CREATE INDEX IDX_3D44E7693DB413D ON personne_prescription (prescription_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER DEFAULT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, lit_occupe) SELECT id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER NOT NULL, CONSTRAINT FK_B6BD307F2577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F37C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307FDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id) SELECT id FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F2577470A ON message (personne1_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F37C2E8E4 ON message (personne2_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FDC304035 ON message (salle_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, raison, date_heure_entree, date_heure_sortie FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO patient (id, raison, date_heure_entree, date_heure_sortie) SELECT id, raison, date_heure_entree, date_heure_sortie FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_lit_id INTEGER DEFAULT NULL, metier_id INTEGER DEFAULT NULL, service_id INTEGER DEFAULT NULL, diagnostic_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel VARCHAR(255) NOT NULL, CONSTRAINT FK_FCEC9EF1BCE5BA FOREIGN KEY (id_lit_id) REFERENCES lit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EF224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO personne (id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BCE5BA ON personne (id_lit_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED16FA20 ON personne (metier_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED5CA9E6 ON personne (service_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF224CCA91 ON personne (diagnostic_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prescription AS SELECT id, unite, date_fin FROM prescription');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, medicament_id INTEGER NOT NULL, unite INTEGER NOT NULL, date_fin DATETIME NOT NULL, CONSTRAINT FK_1FBFB8D9AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO prescription (id, unite, date_fin) SELECT id, unite, date_fin FROM __temp__prescription');
        $this->addSql('DROP TABLE __temp__prescription');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9AB0D61F7 ON prescription (medicament_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, date_heure, duree FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, date_heure, duree) SELECT id, date_heure, duree FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__salle AS SELECT id, nom_salle, emplacement_salle, type_salle FROM salle');
        $this->addSql('DROP TABLE salle');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, service_id INTEGER DEFAULT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_4E977E5CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO salle (id, nom_salle, emplacement_salle, type_salle) SELECT id, nom_salle, emplacement_salle, type_salle FROM __temp__salle');
        $this->addSql('DROP TABLE __temp__salle');
        $this->addSql('CREATE INDEX IDX_4E977E5CED5CA9E6 ON salle (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE personne_diagnostic');
        $this->addSql('DROP TABLE personne_prescription');
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lit_occupe BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO lit (id, lit_occupe) SELECT id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO message (id) SELECT id FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE TEMPORARY TABLE __temp__patient AS SELECT id, raison, date_heure_entree, date_heure_sortie FROM patient');
        $this->addSql('DROP TABLE patient');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO patient (id, raison, date_heure_entree, date_heure_sortie) SELECT id, raison, date_heure_entree, date_heure_sortie FROM __temp__patient');
        $this->addSql('DROP TABLE __temp__patient');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel INTEGER NOT NULL)');
        $this->addSql('INSERT INTO personne (id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prescription AS SELECT id, unite, date_fin FROM prescription');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unite INTEGER NOT NULL, date_fin DATETIME NOT NULL)');
        $this->addSql('INSERT INTO prescription (id, unite, date_fin) SELECT id, unite, date_fin FROM __temp__prescription');
        $this->addSql('DROP TABLE __temp__prescription');
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, date_heure, duree FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL)');
        $this->addSql('INSERT INTO rdv (id, date_heure, duree) SELECT id, date_heure, duree FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__salle AS SELECT id, nom_salle, emplacement_salle, type_salle FROM salle');
        $this->addSql('DROP TABLE salle');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO salle (id, nom_salle, emplacement_salle, type_salle) SELECT id, nom_salle, emplacement_salle, type_salle FROM __temp__salle');
        $this->addSql('DROP TABLE __temp__salle');
    }
}
