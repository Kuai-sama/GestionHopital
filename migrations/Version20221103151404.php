<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103151404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lit_occupe BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO lit (id, lit_occupe) SELECT id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__lit AS SELECT id, lit_occupe FROM lit');
        $this->addSql('DROP TABLE lit');
        $this->addSql('CREATE TABLE lit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, salle_id INTEGER NOT NULL, lit_occupe BOOLEAN DEFAULT NULL, CONSTRAINT FK_5DDB8E9DDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO lit (id, lit_occupe) SELECT id, lit_occupe FROM __temp__lit');
        $this->addSql('DROP TABLE __temp__lit');
        $this->addSql('CREATE INDEX IDX_5DDB8E9DDC304035 ON lit (salle_id)');
    }
}
