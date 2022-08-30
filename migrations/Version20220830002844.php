<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830002844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE energies (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, etat INT NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_CDFAEB396C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, etat INT NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_67884F2D6C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, abrev VARCHAR(6) NOT NULL, ordre INT NOT NULL, UNIQUE INDEX UNIQ_349F3CAE6C6E55B5 (nom), UNIQUE INDEX UNIQ_349F3CAE5C661BD (abrev), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE energies');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE pays');
    }
}
