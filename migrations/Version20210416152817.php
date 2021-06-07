<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416152817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE testiness (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, information VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price CHANGE price price VARCHAR(255) NOT NULL');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, poster LONGTEXT NOT NULL, uploaded_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE theme CHANGE uploaded_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, poster LONGTEXT NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, poster LONGTEXT NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repport (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, message LONGTEXT NOT NULL, date DATE NOT NULL, INDEX IDX_25A5E28A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repport ADD CONSTRAINT FK_25A5E28A6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, resume LONGTEXT NOT NULL, poster LONGTEXT NULL, content LONGTEXT NOT NULL, INDEX IDX_3BAE0AA712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE event ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('INSERT INTO category (name) VALUES ("Actualités"),("Ateliers"),("Evènements")');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE testiness');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE price');
        $this->addSql('ALTER TABLE price CHANGE price price INT NOT NULL');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE theme CHANGE updated_at uploaded_at DATETIME DEFAULT NULL');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE individual');
        $this->addSql('DROP TABLE repport');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('ALTER TABLE event DROP updated_at');
        $this->addSql('TRUNCATE TABLE category');

    }
}
