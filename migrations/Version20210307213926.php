<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307213926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrepreneur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD cin INT NOT NULL, ADD genre VARCHAR(255) NOT NULL, ADD datenais DATE NOT NULL, ADD villenais VARCHAR(255) NOT NULL, ADD paynais VARCHAR(255) NOT NULL, ADD dateexpcin DATE NOT NULL, ADD tel INT NOT NULL, ADD etat TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrepreneur DROP nom, DROP prenom, DROP cin, DROP genre, DROP datenais, DROP villenais, DROP paynais, DROP dateexpcin, DROP tel, DROP etat');
    }
}
