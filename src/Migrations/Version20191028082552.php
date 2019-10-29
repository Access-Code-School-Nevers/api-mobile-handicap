<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028082552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, nom VARCHAR(250) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE handicap (structure_id_id INT NOT NULL, type_handicap_id_id INT NOT NULL, INDEX IDX_35FD7ABBAA95C5C1 (structure_id_id), INDEX IDX_35FD7ABB367CA986 (type_handicap_id_id), PRIMARY KEY(structure_id_id, type_handicap_id_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, code_departement_id INT NOT NULL, code_commune_id INT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(200) DEFAULT NULL, longitude NUMERIC(25, 20) DEFAULT NULL, latitude NUMERIC(25, 20) DEFAULT NULL, information LONGTEXT DEFAULT NULL, lien VARCHAR(250) DEFAULT NULL, type_structure INT NOT NULL, INDEX IDX_6F0137EA87C027E4 (code_departement_id), INDEX IDX_6F0137EA3BB4B294 (code_commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_handicap (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(250) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE handicap ADD CONSTRAINT FK_35FD7ABBAA95C5C1 FOREIGN KEY (structure_id_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE handicap ADD CONSTRAINT FK_35FD7ABB367CA986 FOREIGN KEY (type_handicap_id_id) REFERENCES type_handicap (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA87C027E4 FOREIGN KEY (code_departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA3BB4B294 FOREIGN KEY (code_commune_id) REFERENCES ville (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA87C027E4');
        $this->addSql('ALTER TABLE handicap DROP FOREIGN KEY FK_35FD7ABBAA95C5C1');
        $this->addSql('ALTER TABLE handicap DROP FOREIGN KEY FK_35FD7ABB367CA986');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA3BB4B294');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE handicap');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE type_handicap');
        $this->addSql('DROP TABLE ville');
    }
}
