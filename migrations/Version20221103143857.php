<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103143857 extends AbstractMigration
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
        $this->addSql('CREATE TABLE medicament_commande (medicament_id INTEGER NOT NULL, commande_id INTEGER NOT NULL, PRIMARY KEY(medicament_id, commande_id), CONSTRAINT FK_81D516D1AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_81D516D182EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_81D516D1AB0D61F7 ON medicament_commande (medicament_id)');
        $this->addSql('CREATE INDEX IDX_81D516D182EA2E54 ON medicament_commande (commande_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER NOT NULL, CONSTRAINT FK_B6BD307F2577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F37C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307FDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B6BD307F2577470A ON message (personne1_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F37C2E8E4 ON message (personne2_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FDC304035 ON message (salle_id)');
        $this->addSql('CREATE TABLE metier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_metier VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne_id INTEGER NOT NULL, raison VARCHAR(255) NOT NULL, date_heure_entree DATETIME NOT NULL, date_heure_sortie DATETIME DEFAULT NULL, CONSTRAINT FK_1ADAD7EBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBA21BD112 ON patient (personne_id)');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_lit_id INTEGER DEFAULT NULL, metier_id INTEGER DEFAULT NULL, service_id INTEGER DEFAULT NULL, diagnostic_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel INTEGER NOT NULL, CONSTRAINT FK_FCEC9EF1BCE5BA FOREIGN KEY (id_lit_id) REFERENCES lit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EF224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BCE5BA ON personne (id_lit_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED16FA20 ON personne (metier_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED5CA9E6 ON personne (service_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF224CCA91 ON personne (diagnostic_id)');
        $this->addSql('CREATE TABLE personne_diagnostic (personne_id INTEGER NOT NULL, diagnostic_id INTEGER NOT NULL, PRIMARY KEY(personne_id, diagnostic_id), CONSTRAINT FK_75C08DA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_75C08D224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_75C08DA21BD112 ON personne_diagnostic (personne_id)');
        $this->addSql('CREATE INDEX IDX_75C08D224CCA91 ON personne_diagnostic (diagnostic_id)');
        $this->addSql('CREATE TABLE personne_prescription (personne_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, PRIMARY KEY(personne_id, prescription_id), CONSTRAINT FK_3D44E76A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3D44E7693DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3D44E76A21BD112 ON personne_prescription (personne_id)');
        $this->addSql('CREATE INDEX IDX_3D44E7693DB413D ON personne_prescription (prescription_id)');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, medicament_id INTEGER NOT NULL, unite INTEGER NOT NULL, date_fin DATETIME NOT NULL, CONSTRAINT FK_1FBFB8D9AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9AB0D61F7 ON prescription (medicament_id)');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree TIME DEFAULT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
        $this->addSql('CREATE TABLE salle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, service_id INTEGER DEFAULT NULL, nom_salle VARCHAR(255) NOT NULL, emplacement_salle INTEGER NOT NULL, type_salle VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_4E977E5CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4E977E5CED5CA9E6 ON salle (service_id)');
        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE lit');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE medicament_commande');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_diagnostic');
        $this->addSql('DROP TABLE personne_prescription');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE service');
    }
}
