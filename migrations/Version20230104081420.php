<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104081420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, salle_id, lit_occupe, id_personne FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, id_personne_id INTEGER DEFAULT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5DDB8E9DBA091CE5 FOREIGN KEY (id_personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, salle_id, lit_occupe, id_personne_id) SELECT id, salle_id, lit_occupe, id_personne FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DDB8E9DBA091CE5 ON lit (id_personne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, salle_id, id_personne_id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, id_personne INTEGER DEFAULT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, salle_id, id_personne, lit_occupe) SELECT id, salle_id, id_personne_id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
    }
}
