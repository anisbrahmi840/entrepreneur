<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401101229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE declaration (id INT AUTO_INCREMENT NOT NULL, entrepreneur_id INT DEFAULT NULL, chiffre DOUBLE PRECISION NOT NULL, date_dec DATE NOT NULL, date_ex DATE NOT NULL, date_cr DATE NOT NULL, penalite DOUBLE PRECISION NOT NULL, cotisation DOUBLE PRECISION NOT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_7AA3DAC2283063EA (entrepreneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC2283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE declaration');
    }
}
