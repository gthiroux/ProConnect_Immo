<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260409121050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request ADD uuid VARCHAR(255) NOT NULL, ADD house_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F6BB74515 FOREIGN KEY (house_id) REFERENCES home (id)');
        $this->addSql('CREATE INDEX IDX_3B978F9F6BB74515 ON request (house_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F6BB74515');
        $this->addSql('DROP INDEX IDX_3B978F9F6BB74515 ON request');
        $this->addSql('ALTER TABLE request DROP uuid, DROP house_id');
    }
}
