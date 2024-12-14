<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209230711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospital ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD website VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD latitude NUMERIC(10, 8) DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD longitude NUMERIC(11, 8) DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD postal_code VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD founded_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD registration_number VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD ownership VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE hospital DROP identifier');
        $this->addSql('ALTER TABLE hospital DROP status');
        $this->addSql('ALTER TABLE hospital DROP authorization_number');
        $this->addSql('ALTER TABLE hospital ALTER name TYPE VARCHAR(150)');
        $this->addSql('COMMENT ON COLUMN hospital.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN hospital.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85BC54C8C93 FOREIGN KEY (type_id) REFERENCES hopital_facility (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4282C85BC54C8C93 ON hospital (type_id)');
        $this->addSql('CREATE INDEX IDX_4282C85B98260155 ON hospital (region_id)');
        $this->addSql('CREATE INDEX IDX_4282C85BF92F3E70 ON hospital (country_id)');
        $this->addSql('ALTER TABLE hospital_emails ADD CONSTRAINT FK_93E05D0163DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_managers ADD CONSTRAINT FK_83D476F363DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_phone_numbers ADD CONSTRAINT FK_6583C01563DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_staff ADD CONSTRAINT FK_4334633E63DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hospital_staff DROP CONSTRAINT FK_4334633E63DBB69');
        $this->addSql('ALTER TABLE hospital_managers DROP CONSTRAINT FK_83D476F363DBB69');
        $this->addSql('ALTER TABLE hospital_emails DROP CONSTRAINT FK_93E05D0163DBB69');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85BC54C8C93');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85B98260155');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85BF92F3E70');
        $this->addSql('DROP INDEX IDX_4282C85BC54C8C93');
        $this->addSql('DROP INDEX IDX_4282C85B98260155');
        $this->addSql('DROP INDEX IDX_4282C85BF92F3E70');
        $this->addSql('ALTER TABLE hospital ADD identifier VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD status BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE hospital ADD authorization_number VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital DROP type_id');
        $this->addSql('ALTER TABLE hospital DROP region_id');
        $this->addSql('ALTER TABLE hospital DROP country_id');
        $this->addSql('ALTER TABLE hospital DROP description');
        $this->addSql('ALTER TABLE hospital DROP address');
        $this->addSql('ALTER TABLE hospital DROP website');
        $this->addSql('ALTER TABLE hospital DROP latitude');
        $this->addSql('ALTER TABLE hospital DROP longitude');
        $this->addSql('ALTER TABLE hospital DROP postal_code');
        $this->addSql('ALTER TABLE hospital DROP founded_date');
        $this->addSql('ALTER TABLE hospital DROP registration_number');
        $this->addSql('ALTER TABLE hospital DROP ownership');
        $this->addSql('ALTER TABLE hospital DROP created_at');
        $this->addSql('ALTER TABLE hospital DROP updated_at');
        $this->addSql('ALTER TABLE hospital ALTER name TYPE VARCHAR(200)');
        $this->addSql('ALTER TABLE hospital_phone_numbers DROP CONSTRAINT FK_6583C01563DBB69');
    }
}
