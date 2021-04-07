<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401150257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration CHANGE chiffre chiffre DOUBLE PRECISION DEFAULT NULL, CHANGE date_dec date_dec DATE DEFAULT NULL, CHANGE date_cr date_cr DATE DEFAULT NULL, CHANGE penalite penalite DOUBLE PRECISION DEFAULT NULL, CHANGE cotisation cotisation DOUBLE PRECISION DEFAULT NULL, CHANGE totalapayer totalapayer DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration CHANGE chiffre chiffre DOUBLE PRECISION NOT NULL, CHANGE date_dec date_dec DATE NOT NULL, CHANGE date_cr date_cr DATE NOT NULL, CHANGE penalite penalite DOUBLE PRECISION NOT NULL, CHANGE cotisation cotisation DOUBLE PRECISION NOT NULL, CHANGE totalapayer totalapayer DOUBLE PRECISION NOT NULL');
    }
}
