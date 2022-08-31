<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831140403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bonus_maluss (id INT AUTO_INCREMENT NOT NULL, min_co2 DOUBLE PRECISION NOT NULL, max_co2 DOUBLE PRECISION NOT NULL, montant DOUBLE PRECISION NOT NULL, lettre VARCHAR(3) DEFAULT NULL, UNIQUE INDEX uk_bonus_malus (min_co2, max_co2), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE bonus_malus');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bonus_malus (id INT AUTO_INCREMENT NOT NULL, min_co2 DOUBLE PRECISION NOT NULL, max_co2 DOUBLE PRECISION NOT NULL, montant DOUBLE PRECISION NOT NULL, lettre VARCHAR(3) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX uk_bonus_malus (min_co2, max_co2), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE bonus_maluss');
    }
}
