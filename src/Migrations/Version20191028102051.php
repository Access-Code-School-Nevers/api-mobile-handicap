<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028102051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, api_key VARCHAR(180) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649C912ED9D (api_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE structure_save');
        $this->addSql('ALTER TABLE departement CHANGE nom nom VARCHAR(250) NOT NULL');
        $this->addSql('ALTER TABLE type_handicap CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE ville DROP code_postal, CHANGE nom nom VARCHAR(250) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE structure_save (id INT AUTO_INCREMENT NOT NULL, code_departement_id INT NOT NULL, code_commune_id INT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, adresse VARCHAR(200) DEFAULT NULL COLLATE utf8mb4_unicode_ci, longitude NUMERIC(25, 20) DEFAULT NULL, latitude NUMERIC(25, 20) DEFAULT NULL, information LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, lien VARCHAR(250) DEFAULT NULL COLLATE utf8mb4_unicode_ci, type_structure INT NOT NULL, INDEX IDX_6F0137EA3BB4B294 (code_commune_id), INDEX IDX_6F0137EA87C027E4 (code_departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE departement CHANGE nom nom VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE type_handicap MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE type_handicap DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_handicap CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE ville ADD code_postal INT NOT NULL, CHANGE nom nom VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
