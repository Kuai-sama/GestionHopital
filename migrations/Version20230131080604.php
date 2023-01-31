<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131080604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree INTEGER DEFAULT NULL, titre VARCHAR(100) DEFAULT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description) SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__rdv AS SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description FROM rdv');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('CREATE TABLE rdv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, personne1_id INTEGER NOT NULL, personne2_id INTEGER NOT NULL, salle_id INTEGER DEFAULT NULL, date_heure DATETIME NOT NULL, duree INTEGER DEFAULT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, CONSTRAINT FK_10C31F862577470A FOREIGN KEY (personne1_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F8637C2E8E4 FOREIGN KEY (personne2_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_10C31F86DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO rdv (id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description) SELECT id, personne1_id, personne2_id, salle_id, date_heure, duree, titre, description FROM __temp__rdv');
        $this->addSql('DROP TABLE __temp__rdv');
        $this->addSql('CREATE INDEX IDX_10C31F862577470A ON rdv (personne1_id)');
        $this->addSql('CREATE INDEX IDX_10C31F8637C2E8E4 ON rdv (personne2_id)');
        $this->addSql('CREATE INDEX IDX_10C31F86DC304035 ON rdv (salle_id)');
    }
}
