<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408111150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, doc LONGTEXT NOT NULL, request_id INT DEFAULT NULL, home_id INT NOT NULL, UNIQUE INDEX UNIQ_D8698A76427EB8A5 (request_id), INDEX IDX_D8698A7628CDC89C (home_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE home (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) NOT NULL, image LONGTEXT DEFAULT NULL, title VARCHAR(255) NOT NULL, surface INT NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, code_mail VARCHAR(18) NOT NULL, done TINYINT NOT NULL, service_id INT NOT NULL, INDEX IDX_3B978F9FED5CA9E6 (service_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7628CDC89C FOREIGN KEY (home_id) REFERENCES home (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76427EB8A5');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7628CDC89C');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FED5CA9E6');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE home');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
