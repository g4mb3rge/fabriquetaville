<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261110102608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(80) NOT NULL, slug VARCHAR(80) NOT NULL, UNIQUE INDEX UNIQ_497DD6346C6E55B5 (nom), UNIQUE INDEX UNIQ_497DD634989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, date_ouverture DATETIME NOT NULL, date_fermeture DATETIME NOT NULL, decision LONGTEXT DEFAULT NULL, projet_id INT NOT NULL, INDEX IDX_964685A6C18272 (projet_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contribution (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) NOT NULL, adresse VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, titre VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, statut VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, quartier_id INT NOT NULL, categorie_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_EA351E158CDE5729 (type), INDEX IDX_EA351E15E564F0BF (statut), INDEX IDX_EA351E15DF1E57AB (quartier_id), INDEX IDX_EA351E15BCF5E72D (categorie_id), INDEX IDX_EA351E1560BB6FE6 (auteur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE historique_statut (id INT AUTO_INCREMENT NOT NULL, ancien_statut VARCHAR(30) NOT NULL, nouveau_statut VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, contribution_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_2C2650E3FE5E5FBD (contribution_id), INDEX IDX_2C2650E33414710B (agent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE option_vote (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, consultation_id INT NOT NULL, INDEX IDX_B21E2F8762FF6CDF (consultation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, statut VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, contribution_origine_id INT DEFAULT NULL, quartier_id INT NOT NULL, UNIQUE INDEX UNIQ_50159CA9F3BC0C10 (contribution_origine_id), INDEX IDX_50159CA9DF1E57AB (quartier_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(120) NOT NULL, UNIQUE INDEX UNIQ_FEE8962D6C6E55B5 (nom), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reponse_officielle (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL, contribution_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_5A2BAD62FE5E5FBD (contribution_id), INDEX IDX_5A2BAD623414710B (agent_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE soutien (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, contribution_id INT NOT NULL, UNIQUE INDEX soutien_unique (user_id, contribution_id), INDEX IDX_99A7D321A76ED395 (user_id), INDEX IDX_99A7D321FE5E5FBD (contribution_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, consultation_id INT NOT NULL, option_vote_id INT NOT NULL, UNIQUE INDEX vote_unique (user_id, consultation_id), INDEX IDX_5A108564A76ED395 (user_id), INDEX IDX_5A10856462FF6CDF (consultation_id), INDEX IDX_5A1085646A28CD89 (option_vote_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E1560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE historique_statut ADD CONSTRAINT FK_2C2650E3FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contribution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historique_statut ADD CONSTRAINT FK_2C2650E33414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE option_vote ADD CONSTRAINT FK_B21E2F8762FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9F3BC0C10 FOREIGN KEY (contribution_origine_id) REFERENCES contribution (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('ALTER TABLE reponse_officielle ADD CONSTRAINT FK_5A2BAD62FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contribution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_officielle ADD CONSTRAINT FK_5A2BAD623414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE soutien ADD CONSTRAINT FK_99A7D321A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE soutien ADD CONSTRAINT FK_99A7D321FE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contribution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856462FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646A28CD89 FOREIGN KEY (option_vote_id) REFERENCES option_vote (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6C18272');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15DF1E57AB');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15BCF5E72D');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E1560BB6FE6');
        $this->addSql('ALTER TABLE historique_statut DROP FOREIGN KEY FK_2C2650E3FE5E5FBD');
        $this->addSql('ALTER TABLE historique_statut DROP FOREIGN KEY FK_2C2650E33414710B');
        $this->addSql('ALTER TABLE option_vote DROP FOREIGN KEY FK_B21E2F8762FF6CDF');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9F3BC0C10');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9DF1E57AB');
        $this->addSql('ALTER TABLE reponse_officielle DROP FOREIGN KEY FK_5A2BAD62FE5E5FBD');
        $this->addSql('ALTER TABLE reponse_officielle DROP FOREIGN KEY FK_5A2BAD623414710B');
        $this->addSql('ALTER TABLE soutien DROP FOREIGN KEY FK_99A7D321A76ED395');
        $this->addSql('ALTER TABLE soutien DROP FOREIGN KEY FK_99A7D321FE5E5FBD');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856462FF6CDF');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646A28CD89');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('DROP TABLE historique_statut');
        $this->addSql('DROP TABLE option_vote');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE reponse_officielle');
        $this->addSql('DROP TABLE soutien');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vote');
    }
}
