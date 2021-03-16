<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314182110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, entrepreneur_id INT DEFAULT NULL, client VARCHAR(255) NOT NULL, date_fact DATE NOT NULL, mf VARCHAR(255) DEFAULT NULL, prix_ttc DOUBLE PRECISION NOT NULL, prix_ht DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, INDEX IDX_FE866410283063EA (entrepreneur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, facture_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, nb INT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, prix_total INT NOT NULL, INDEX IDX_29A5EC277F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410283063EA FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277F2DEE08');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE produit');
    }
}
