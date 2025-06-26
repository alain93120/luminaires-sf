<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626130641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ligne_commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE paiement
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD cart_id INT NOT NULL, ADD produit_id INT NOT NULL, ADD quantity INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F0FE25271AD5CDBF ON cart_item (cart_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F0FE2527F347EFB ON cart_item (produit_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX categorie_id ON produit
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD description LONGTEXT DEFAULT NULL, CHANGE nom nom VARCHAR(150) NOT NULL, CHANGE prix prix_unitaire NUMERIC(10, 2) NOT NULL, CHANGE categorie_id stock INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP nom, CHANGE email email VARCHAR(180) NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX email TO UNIQ_8D93D649E7927C74
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, date_commande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX client_id (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, produit_id INT NOT NULL, quantite INT DEFAULT 1 NOT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, INDEX commande_id (commande_id), INDEX produit_id (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, client_id INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX commande_id (commande_id), INDEX client_id (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_BA388B7A76ED395 ON cart
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527F347EFB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F0FE25271AD5CDBF ON cart_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_F0FE2527F347EFB ON cart_item
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP cart_id, DROP produit_id, DROP quantity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP description, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prix_unitaire prix NUMERIC(10, 2) NOT NULL, CHANGE stock categorie_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX categorie_id ON produit (categorie_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD nom VARCHAR(100) NOT NULL, CHANGE email email VARCHAR(150) NOT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` RENAME INDEX uniq_8d93d649e7927c74 TO email
        SQL);
    }
}
