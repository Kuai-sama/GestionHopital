<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104092051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_lit_id INTEGER DEFAULT NULL, metier_id INTEGER DEFAULT NULL, service_id INTEGER DEFAULT NULL, diagnostic_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel VARCHAR(255) NOT NULL, CONSTRAINT FK_FCEC9EF1BCE5BA FOREIGN KEY (id_lit_id) REFERENCES lit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EF224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO personne (id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE INDEX IDX_FCEC9EF224CCA91 ON personne (diagnostic_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED5CA9E6 ON personne (service_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED16FA20 ON personne (metier_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BCE5BA ON personne (id_lit_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__personne AS SELECT id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM personne');
        $this->addSql('DROP TABLE personne');
        $this->addSql('CREATE TABLE personne (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_lit_id INTEGER DEFAULT NULL, metier_id INTEGER DEFAULT NULL, service_id INTEGER DEFAULT NULL, diagnostic_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, num_securite_sociale INTEGER DEFAULT NULL, num_adeli INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel INTEGER NOT NULL, CONSTRAINT FK_FCEC9EF1BCE5BA FOREIGN KEY (id_lit_id) REFERENCES lit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FCEC9EF224CCA91 FOREIGN KEY (diagnostic_id) REFERENCES diagnostic (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO personne (id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel) SELECT id, id_lit_id, metier_id, service_id, diagnostic_id, email, roles, password, num_securite_sociale, num_adeli, nom, prenom, num_tel FROM __temp__personne');
        $this->addSql('DROP TABLE __temp__personne');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFE7927C74 ON personne (email)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BCE5BA ON personne (id_lit_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED16FA20 ON personne (metier_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EFED5CA9E6 ON personne (service_id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF224CCA91 ON personne (diagnostic_id)');
    }
}
