<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530103828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE grand_prix (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, map VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, grandprix_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, INDEX IDX_C53D045F765FCE6F (grandprix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pilote (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, datenaissance DATETIME NOT NULL, nationalite VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_6A3254DD296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, pilote_id INT NOT NULL, grand_prix_id INT NOT NULL, team VARCHAR(255) NOT NULL, annee INT NOT NULL, chrono VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_574767AAF510AAE9 (pilote_id), INDEX IDX_574767AA6E53349A (grand_prix_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, moteur VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, password_confirm VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F765FCE6F FOREIGN KEY (grandprix_id) REFERENCES grand_prix (id)');
        $this->addSql('ALTER TABLE pilote ADD CONSTRAINT FK_6A3254DD296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AAF510AAE9 FOREIGN KEY (pilote_id) REFERENCES pilote (id)');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AA6E53349A FOREIGN KEY (grand_prix_id) REFERENCES grand_prix (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F765FCE6F');
        $this->addSql('ALTER TABLE stats DROP FOREIGN KEY FK_574767AA6E53349A');
        $this->addSql('ALTER TABLE stats DROP FOREIGN KEY FK_574767AAF510AAE9');
        $this->addSql('ALTER TABLE pilote DROP FOREIGN KEY FK_6A3254DD296CD8AE');
        $this->addSql('DROP TABLE grand_prix');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE pilote');
        $this->addSql('DROP TABLE stats');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
    }
}
