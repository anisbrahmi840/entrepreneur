<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429222147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attestation_fiscale (id INT AUTO_INCREMENT NOT NULL, entrepreneur_id INT NOT NULL, date_cr DATE NOT NULL, ref VARCHAR(255) NOT NULL, annee VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_1EE2A57B283063EA (entrepreneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attestation_fiscale ADD CONSTRAINT FK_1EE2A57B283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE declaration ADD attestation_fiscale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC2A3918967 FOREIGN KEY (attestation_fiscale_id) REFERENCES attestation_fiscale (id)');
        $this->addSql('CREATE INDEX IDX_7AA3DAC2A3918967 ON declaration (attestation_fiscale_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration DROP FOREIGN KEY FK_7AA3DAC2A3918967');
        $this->addSql('DROP TABLE attestation_fiscale');
        $this->addSql('DROP INDEX IDX_7AA3DAC2A3918967 ON declaration');
        $this->addSql('ALTER TABLE declaration DROP attestation_fiscale_id');
    }
}
