<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208122212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospital_emails (id SERIAL NOT NULL, hospital_id INT NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93E05D0163DBB69 ON hospital_emails (hospital_id)');
        $this->addSql('CREATE TABLE hospital_managers (id SERIAL NOT NULL, hospital_id INT NOT NULL, manager_name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, contact_phone VARCHAR(15) DEFAULT NULL, contact_email VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_83D476F363DBB69 ON hospital_managers (hospital_id)');
        $this->addSql('COMMENT ON COLUMN hospital_managers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN hospital_managers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE hospital_phone_numbers (id SERIAL NOT NULL, hospital_id INT NOT NULL, phone_number VARCHAR(15) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6583C01563DBB69 ON hospital_phone_numbers (hospital_id)');
        $this->addSql('CREATE TABLE hospital_staff (id SERIAL NOT NULL, hospital_id INT NOT NULL, staff_count INT NOT NULL, doctors_count INT NOT NULL, nurses_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4334633E63DBB69 ON hospital_staff (hospital_id)');
        $this->addSql('ALTER TABLE hospital_emails ADD CONSTRAINT FK_93E05D0163DBB69 FOREIGN KEY (hospital_id) REFERENCES hopital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_managers ADD CONSTRAINT FK_83D476F363DBB69 FOREIGN KEY (hospital_id) REFERENCES hopital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_phone_numbers ADD CONSTRAINT FK_6583C01563DBB69 FOREIGN KEY (hospital_id) REFERENCES hopital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_staff ADD CONSTRAINT FK_4334633E63DBB69 FOREIGN KEY (hospital_id) REFERENCES hopital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD name VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD website VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD latitude NUMERIC(10, 8) DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD longitude NUMERIC(11, 8) DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD postal_code VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD founded_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE hopital ADD registration_number VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD ownership VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2CC54C8C93 FOREIGN KEY (type_id) REFERENCES hopital_facility (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2C98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8718F2CC54C8C93 ON hopital (type_id)');
        $this->addSql('CREATE INDEX IDX_8718F2C8BAC62AF ON hopital (city_id)');
        $this->addSql('CREATE INDEX IDX_8718F2C98260155 ON hopital (region_id)');
        $this->addSql('CREATE INDEX IDX_8718F2CF92F3E70 ON hopital (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hospital_emails DROP CONSTRAINT FK_93E05D0163DBB69');
        $this->addSql('ALTER TABLE hospital_managers DROP CONSTRAINT FK_83D476F363DBB69');
        $this->addSql('ALTER TABLE hospital_phone_numbers DROP CONSTRAINT FK_6583C01563DBB69');
        $this->addSql('ALTER TABLE hospital_staff DROP CONSTRAINT FK_4334633E63DBB69');
        $this->addSql('DROP TABLE hospital_emails');
        $this->addSql('DROP TABLE hospital_managers');
        $this->addSql('DROP TABLE hospital_phone_numbers');
        $this->addSql('DROP TABLE hospital_staff');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2CC54C8C93');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2C8BAC62AF');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2C98260155');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2CF92F3E70');
        $this->addSql('DROP INDEX IDX_8718F2CC54C8C93');
        $this->addSql('DROP INDEX IDX_8718F2C8BAC62AF');
        $this->addSql('DROP INDEX IDX_8718F2C98260155');
        $this->addSql('DROP INDEX IDX_8718F2CF92F3E70');
        $this->addSql('ALTER TABLE hopital DROP type_id');
        $this->addSql('ALTER TABLE hopital DROP city_id');
        $this->addSql('ALTER TABLE hopital DROP region_id');
        $this->addSql('ALTER TABLE hopital DROP country_id');
        $this->addSql('ALTER TABLE hopital DROP name');
        $this->addSql('ALTER TABLE hopital DROP description');
        $this->addSql('ALTER TABLE hopital DROP address');
        $this->addSql('ALTER TABLE hopital DROP website');
        $this->addSql('ALTER TABLE hopital DROP latitude');
        $this->addSql('ALTER TABLE hopital DROP longitude');
        $this->addSql('ALTER TABLE hopital DROP postal_code');
        $this->addSql('ALTER TABLE hopital DROP founded_date');
        $this->addSql('ALTER TABLE hopital DROP registration_number');
        $this->addSql('ALTER TABLE hopital DROP ownership');
    }
}
