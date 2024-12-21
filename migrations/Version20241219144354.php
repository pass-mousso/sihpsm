<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219144354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE person ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE person ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17698260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1768BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_34DCD176F92F3E70 ON person (country_id)');
        $this->addSql('CREATE INDEX IDX_34DCD17698260155 ON person (region_id)');
        $this->addSql('CREATE INDEX IDX_34DCD1768BAC62AF ON person (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD176F92F3E70');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD17698260155');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD1768BAC62AF');
        $this->addSql('DROP INDEX IDX_34DCD176F92F3E70');
        $this->addSql('DROP INDEX IDX_34DCD17698260155');
        $this->addSql('DROP INDEX IDX_34DCD1768BAC62AF');
        $this->addSql('ALTER TABLE person DROP country_id');
        $this->addSql('ALTER TABLE person DROP region_id');
        $this->addSql('ALTER TABLE person DROP city_id');
    }
}
