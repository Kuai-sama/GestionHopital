<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230106092219 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne_prescription (personne_id INTEGER NOT NULL, prescription_id INTEGER NOT NULL, PRIMARY KEY(personne_id, prescription_id), CONSTRAINT FK_3D44E76A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3D44E7693DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3D44E7693DB413D ON personne_prescription (prescription_id)');
        $this->addSql('CREATE INDEX IDX_3D44E76A21BD112 ON personne_prescription (personne_id)');
        $this->addSql('DROP TABLE appliquer_prescription');
        $this->addSql('DROP TABLE horaire');
    }
}
