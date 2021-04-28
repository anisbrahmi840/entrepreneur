<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427232753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attestation_chiffre_affaire (id INT AUTO_INCREMENT NOT NULL, entrepreneur_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_20AD573E283063EA (entrepreneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attestation_chiffre_affaire ADD CONSTRAINT FK_20AD573E283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE declaration ADD attestation_chiffre_affaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC21529194C FOREIGN KEY (attestation_chiffre_affaire_id) REFERENCES attestation_chiffre_affaire (id)');
        $this->addSql('CREATE INDEX IDX_7AA3DAC21529194C ON declaration (attestation_chiffre_affaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration DROP FOREIGN KEY FK_7AA3DAC21529194C');
        $this->addSql('DROP TABLE attestation_chiffre_affaire');
        $this->addSql('DROP INDEX IDX_7AA3DAC21529194C ON declaration');
        $this->addSql('ALTER TABLE declaration DROP attestation_chiffre_affaire_id');
    }
}
