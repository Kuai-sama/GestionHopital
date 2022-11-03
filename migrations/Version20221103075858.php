<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103075858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, password, roles FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, num_tel INTEGER NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO personne (id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, password, roles) SELECT id, num_securite_sociale, num_adeli, nom, prenom, email, num_tel, password, roles FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER NOT NULL, num_adeli INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel INTEGER NOT NULL)');
        $this->addSql('INSERT INTO personne (id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
    }
}
