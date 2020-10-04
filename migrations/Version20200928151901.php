<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928151901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, civilite VARCHAR(5) NOT NULL, email VARCHAR(255) NOT NULL, prenom VARCHAR(55) NOT NULL, nom VARCHAR(55) NOT NULL, password VARCHAR(40) NOT NULL, tel VARCHAR(15) NOT NULL, user_name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, annee INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, num_permis VARCHAR(50) NOT NULL, civilite VARCHAR(5) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(50) NOT NULL, disponibilite VARBINARY(255) NOT NULL, email VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, tel VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, civilite VARCHAR(5) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(50) NOT NULL, email VARCHAR(50) DEFAULT NULL, num_permis VARCHAR(50) DEFAULT NULL, password VARCHAR(50) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(50) NOT NULL, user_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, marque_id INT NOT NULL, categorie_id INT NOT NULL, annee_id INT NOT NULL, INDEX IDX_100285584827B9B2 (marque_id), INDEX IDX_10028558BCF5E72D (categorie_id), INDEX IDX_10028558543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, chauffeur_id INT DEFAULT NULL, client_id INT NOT NULL, voiture_id INT NOT NULL, withdriver VARBINARY(255) NOT NULL, date_reservation DATETIME NOT NULL, date_retour DATETIME NOT NULL, tarif DOUBLE PRECISION NOT NULL, INDEX IDX_42C8495585C0B3BE (chauffeur_id), INDEX IDX_42C8495519EB6921 (client_id), INDEX IDX_42C84955181A8BA (voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, modele_id INT NOT NULL, matricule VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, tarifjrne DOUBLE PRECISION NOT NULL, INDEX IDX_E9E2810FAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495585C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558543EC5F0');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558BCF5E72D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495585C0B3BE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FAC14B70A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955181A8BA');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE modele');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE voiture');
    }
}
