<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318111028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, note INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_user (produit_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A40BABA6F347EFB (produit_id), INDEX IDX_A40BABA6A76ED395 (user_id), PRIMARY KEY(produit_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit_user ADD CONSTRAINT FK_A40BABA6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_user ADD CONSTRAINT FK_A40BABA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE produit_user DROP FOREIGN KEY FK_A40BABA6F347EFB');
        $this->addSql('ALTER TABLE produit_user DROP FOREIGN KEY FK_A40BABA6A76ED395');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_user');
    }
}
