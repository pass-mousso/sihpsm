<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210210426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT fk_4778a01a76ed395');
        $this->addSql('DROP INDEX idx_4778a01a76ed395');
        $this->addSql('ALTER TABLE subscriptions RENAME COLUMN user_id TO owner');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01CF60E67C FOREIGN KEY (owner) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4778A01CF60E67C ON subscriptions (owner)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT FK_4778A01CF60E67C');
        $this->addSql('DROP INDEX IDX_4778A01CF60E67C');
        $this->addSql('ALTER TABLE subscriptions RENAME COLUMN owner TO user_id');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT fk_4778a01a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4778a01a76ed395 ON subscriptions (user_id)');
    }
}
