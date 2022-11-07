<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107090440 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appliquer_prescription');
    }
}
