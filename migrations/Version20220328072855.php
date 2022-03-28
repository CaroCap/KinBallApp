<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328072855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) DEFAULT NULL, numero VARCHAR(20) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, ville VARCHAR(150) DEFAULT NULL, pays VARCHAR(150) DEFAULT NULL, nom_lieu VARCHAR(150) DEFAULT NULL, type_adresse VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type_categorie VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, player_id INT NOT NULL, saison VARCHAR(30) NOT NULL, jour_entrainement VARCHAR(30) NOT NULL, date_inscription DATETIME NOT NULL, paiement TINYINT(1) NOT NULL, date_paiement DATETIME DEFAULT NULL, fiche_medicale VARCHAR(255) DEFAULT NULL, certif_medical VARCHAR(255) DEFAULT NULL, INDEX IDX_5E90F6D6BCF5E72D (categorie_id), INDEX IDX_5E90F6D699E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_entrainement (id INT AUTO_INCREMENT NOT NULL, inscription_id INT NOT NULL, seance_id INT DEFAULT NULL, type_presence VARCHAR(20) DEFAULT NULL, INDEX IDX_9E2D7FE55DAC5993 (inscription_id), INDEX IDX_9E2D7FE5E3797A94 (seance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance_entrainement (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, title VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, INDEX IDX_43470E364DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(200) NOT NULL, telephone VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, rue VARCHAR(255) DEFAULT NULL, numero VARCHAR(20) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, ville VARCHAR(150) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, accord_photo TINYINT(1) NOT NULL, pers_contact_nom VARCHAR(50) DEFAULT NULL, pers_contact_tel VARCHAR(20) DEFAULT NULL, pers_contact_mail VARCHAR(200) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D699E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation_entrainement ADD CONSTRAINT FK_9E2D7FE55DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE participation_entrainement ADD CONSTRAINT FK_9E2D7FE5E3797A94 FOREIGN KEY (seance_id) REFERENCES seance_entrainement (id)');
        $this->addSql('ALTER TABLE seance_entrainement ADD CONSTRAINT FK_43470E364DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance_entrainement DROP FOREIGN KEY FK_43470E364DE7DC5C');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BCF5E72D');
        $this->addSql('ALTER TABLE participation_entrainement DROP FOREIGN KEY FK_9E2D7FE55DAC5993');
        $this->addSql('ALTER TABLE participation_entrainement DROP FOREIGN KEY FK_9E2D7FE5E3797A94');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D699E6F5DF');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE participation_entrainement');
        $this->addSql('DROP TABLE seance_entrainement');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
