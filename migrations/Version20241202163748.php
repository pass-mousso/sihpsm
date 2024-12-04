<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202163748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person (id SERIAL NOT NULL, users_id INT NOT NULL, firt_name VARCHAR(150) NOT NULL, last_name VARCHAR(200) NOT NULL, birth_date DATE NOT NULL, gender VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD17667B3B43D ON person (users_id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17667B3B43D FOREIGN KEY (users_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE users ADD username VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE users ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE users ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE users ADD email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD status BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(180)');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.email_verified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT FK_34DCD17667B3B43D');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL');
        $this->addSql('ALTER TABLE "users" DROP roles');
        $this->addSql('ALTER TABLE "users" DROP username');
        $this->addSql('ALTER TABLE "users" DROP created_at');
        $this->addSql('ALTER TABLE "users" DROP updated_at');
        $this->addSql('ALTER TABLE "users" DROP email_verified_at');
        $this->addSql('ALTER TABLE "users" DROP status');
        $this->addSql('ALTER TABLE "users" ALTER email TYPE VARCHAR(150)');
    }
}
