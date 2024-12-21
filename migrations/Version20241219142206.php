<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219142206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical_record (id SERIAL NOT NULL, patient_id INT NOT NULL, unique_identifier VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F06A283E6BD2BEA0 ON medical_record (unique_identifier)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F06A283E6B899279 ON medical_record (patient_id)');
        $this->addSql('ALTER TABLE medical_record ADD CONSTRAINT FK_F06A283E6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE medical_record DROP CONSTRAINT FK_F06A283E6B899279');
        $this->addSql('DROP TABLE medical_record');
    }
}
