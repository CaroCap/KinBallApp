<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330100634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type_categorie VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_seance (categorie_id INT NOT NULL, seance_id INT NOT NULL, INDEX IDX_595B5737BCF5E72D (categorie_id), INDEX IDX_595B5737E3797A94 (seance_id), PRIMARY KEY(categorie_id, seance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, player_id INT NOT NULL, saison_id INT NOT NULL, jour_entrainement VARCHAR(30) NOT NULL, date_inscription DATETIME NOT NULL, paiement TINYINT(1) NOT NULL, date_paiement DATETIME DEFAULT NULL, fiche_medicale VARCHAR(255) DEFAULT NULL, certif_medical VARCHAR(255) DEFAULT NULL, INDEX IDX_5E90F6D6BCF5E72D (categorie_id), INDEX IDX_5E90F6D699E6F5DF (player_id), INDEX IDX_5E90F6D6F965414C (saison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, seance_id INT DEFAULT NULL, user_id INT NOT NULL, type_presence VARCHAR(20) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_AB55E24FE3797A94 (seance_id), INDEX IDX_AB55E24FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saison (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, saison_id INT NOT NULL, title VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, numero VARCHAR(20) DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, ville VARCHAR(150) DEFAULT NULL, INDEX IDX_DF7DFD0EF965414C (saison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(200) NOT NULL, telephone VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, rue VARCHAR(255) DEFAULT NULL, numero VARCHAR(20) DEFAULT NULL, code_postal VARCHAR(20) DEFAULT NULL, ville VARCHAR(150) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, accord_photo TINYINT(1) NOT NULL, pers_contact_nom VARCHAR(50) DEFAULT NULL, pers_contact_tel VARCHAR(20) DEFAULT NULL, pers_contact_mail VARCHAR(200) DEFAULT NULL, date_update DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_seance ADD CONSTRAINT FK_595B5737BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_seance ADD CONSTRAINT FK_595B5737E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D699E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FE3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EF965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_seance DROP FOREIGN KEY FK_595B5737BCF5E72D');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BCF5E72D');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6F965414C');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EF965414C');
        $this->addSql('ALTER TABLE categorie_seance DROP FOREIGN KEY FK_595B5737E3797A94');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FE3797A94');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D699E6F5DF');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_seance');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE saison');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
