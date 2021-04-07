<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407132627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, declaration_id INT NOT NULL, date_pai DATE NOT NULL, type VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, etat_ent TINYINT(1) NOT NULL, etat TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1EC06258A3 (declaration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EC06258A3 FOREIGN KEY (declaration_id) REFERENCES declaration (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paiement');
    }
}
