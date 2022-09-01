<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901001331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, pays_id INT NOT NULL, nom_commercial VARCHAR(255) NOT NULL, raison_sociale VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postale VARCHAR(24) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, tel VARCHAR(64) DEFAULT NULL, fax VARCHAR(64) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, siret VARCHAR(64) DEFAULT NULL, tva_intra_comm VARCHAR(64) DEFAULT NULL, tva DOUBLE PRECISION NOT NULL, etat INT NOT NULL, emplacement_file VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_369ECA32E2B45978 (raison_sociale), INDEX IDX_369ECA32A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A6E44244');
        $this->addSql('DROP TABLE fournisseur');
    }
}
