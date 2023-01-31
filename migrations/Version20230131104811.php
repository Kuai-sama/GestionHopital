<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131104811 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE personne_diagnostic');
    }
}
