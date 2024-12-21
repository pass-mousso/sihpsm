<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217204853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hospital_configuration (id SERIAL NOT NULL, hospital_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_27BD230963DBB69 ON hospital_configuration (hospital_id)');
        $this->addSql('CREATE TABLE hospital_configuration_insurance (hospital_configuration_id INT NOT NULL, insurance_id INT NOT NULL, PRIMARY KEY(hospital_configuration_id, insurance_id))');
        $this->addSql('CREATE INDEX IDX_29125F9962E946C8 ON hospital_configuration_insurance (hospital_configuration_id)');
        $this->addSql('CREATE INDEX IDX_29125F99D1E63CD1 ON hospital_configuration_insurance (insurance_id)');
        $this->addSql('CREATE TABLE hospital_facility (id SERIAL NOT NULL, label VARCHAR(200) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN hospital_facility.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN hospital_facility.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE insurance (id SERIAL NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, reimbursement_limit NUMERIC(10, 2) DEFAULT NULL, is_active BOOLEAN DEFAULT true NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_640EAF4CF92F3E70 ON insurance (country_id)');
        $this->addSql('CREATE TABLE nurse (id INT NOT NULL, experience_years INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, medical_record_number VARCHAR(255) NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, number_of_children INT DEFAULT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, occupation VARCHAR(100) DEFAULT NULL, blood_group VARCHAR(3) DEFAULT NULL, resultat_depranocite VARCHAR(2) DEFAULT NULL, statut_test_depranocite VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EB29E4D8C8 ON patient (medical_record_number)');
        $this->addSql('CREATE TABLE hospital_patient (patient_id INT NOT NULL, hospital_id INT NOT NULL, PRIMARY KEY(patient_id, hospital_id))');
        $this->addSql('CREATE INDEX IDX_E867B6106B899279 ON hospital_patient (patient_id)');
        $this->addSql('CREATE INDEX IDX_E867B61063DBB69 ON hospital_patient (hospital_id)');
        $this->addSql('CREATE TABLE patient_affections (id SERIAL NOT NULL, patient_id INT NOT NULL, affection_type VARCHAR(255) NOT NULL, severity VARCHAR(50) DEFAULT NULL, notes TEXT DEFAULT NULL, is_visible BOOLEAN DEFAULT true NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3EF9FA476B899279 ON patient_affections (patient_id)');
        $this->addSql('CREATE TABLE patient_allergies (id SERIAL NOT NULL, patient_id INT NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, notes TEXT DEFAULT NULL, is_visible BOOLEAN DEFAULT true NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2B926D246B899279 ON patient_allergies (patient_id)');
        $this->addSql('CREATE TABLE patient_insurance (id SERIAL NOT NULL, patient_id INT NOT NULL, insurance_id INT NOT NULL, policy_number VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT true NOT NULL, coverage_amount NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2857D73BC44F249 ON patient_insurance (policy_number)');
        $this->addSql('CREATE INDEX IDX_C2857D736B899279 ON patient_insurance (patient_id)');
        $this->addSql('CREATE INDEX IDX_C2857D73D1E63CD1 ON patient_insurance (insurance_id)');
        $this->addSql('CREATE TABLE patient_traitement (id SERIAL NOT NULL, patient_id INT NOT NULL, name VARCHAR(150) NOT NULL, description VARCHAR(255) DEFAULT NULL, posology VARCHAR(100) DEFAULT NULL, duration INT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, additional_instructions TEXT DEFAULT NULL, is_visible BOOLEAN DEFAULT true NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9CF5CBC86B899279 ON patient_traitement (patient_id)');
        $this->addSql('CREATE TABLE patient_vaccin (id SERIAL NOT NULL, patient_id INT NOT NULL, vaccine_id INT NOT NULL, date_administered DATE DEFAULT NULL, date_rappel DATE DEFAULT NULL, dose_vaccin INT DEFAULT NULL, lot_vaccin VARCHAR(50) DEFAULT NULL, is_visible BOOLEAN DEFAULT true NOT NULL, notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BE92495D6B899279 ON patient_vaccin (patient_id)');
        $this->addSql('CREATE INDEX IDX_BE92495D2BFE75C3 ON patient_vaccin (vaccine_id)');
        $this->addSql('CREATE TABLE person_to_contact (id SERIAL NOT NULL, patient_id INT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, relation VARCHAR(50) DEFAULT NULL, phone_number VARCHAR(15) NOT NULL, address VARCHAR(255) DEFAULT NULL, is_primary_contact BOOLEAN DEFAULT false NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F441B8D86B899279 ON person_to_contact (patient_id)');
        $this->addSql('CREATE TABLE posology (id SERIAL NOT NULL, frequency_type VARCHAR(50) NOT NULL, dose DOUBLE PRECISION DEFAULT NULL, unit_type VARCHAR(50) NOT NULL, period_type VARCHAR(50) DEFAULT NULL, duration INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vaccine (id SERIAL NOT NULL, hospital_id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A7DD90B163DBB69 ON vaccine (hospital_id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ABF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_configuration ADD CONSTRAINT FK_27BD230963DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_configuration_insurance ADD CONSTRAINT FK_29125F9962E946C8 FOREIGN KEY (hospital_configuration_id) REFERENCES hospital_configuration (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_configuration_insurance ADD CONSTRAINT FK_29125F99D1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE insurance ADD CONSTRAINT FK_640EAF4CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE nurse ADD CONSTRAINT FK_D27E6D43BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_patient ADD CONSTRAINT FK_E867B6106B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital_patient ADD CONSTRAINT FK_E867B61063DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_affections ADD CONSTRAINT FK_3EF9FA476B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_allergies ADD CONSTRAINT FK_2B926D246B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_insurance ADD CONSTRAINT FK_C2857D736B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_insurance ADD CONSTRAINT FK_C2857D73D1E63CD1 FOREIGN KEY (insurance_id) REFERENCES insurance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_traitement ADD CONSTRAINT FK_9CF5CBC86B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_vaccin ADD CONSTRAINT FK_BE92495D6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_vaccin ADD CONSTRAINT FK_BE92495D2BFE75C3 FOREIGN KEY (vaccine_id) REFERENCES vaccine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_to_contact ADD CONSTRAINT FK_F441B8D86B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vaccine ADD CONSTRAINT FK_A7DD90B163DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85BC54C8C93 FOREIGN KEY (type_id) REFERENCES hospital_facility (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4282C85BC54C8C93 ON hospital (type_id)');
        $this->addSql('ALTER TABLE person ADD marital_status VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE person RENAME COLUMN firt_name TO first_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85BC54C8C93');
        $this->addSql('ALTER TABLE doctor DROP CONSTRAINT FK_1FC0F36ABF396750');
        $this->addSql('ALTER TABLE hospital_configuration DROP CONSTRAINT FK_27BD230963DBB69');
        $this->addSql('ALTER TABLE hospital_configuration_insurance DROP CONSTRAINT FK_29125F9962E946C8');
        $this->addSql('ALTER TABLE hospital_configuration_insurance DROP CONSTRAINT FK_29125F99D1E63CD1');
        $this->addSql('ALTER TABLE insurance DROP CONSTRAINT FK_640EAF4CF92F3E70');
        $this->addSql('ALTER TABLE nurse DROP CONSTRAINT FK_D27E6D43BF396750');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE hospital_patient DROP CONSTRAINT FK_E867B6106B899279');
        $this->addSql('ALTER TABLE hospital_patient DROP CONSTRAINT FK_E867B61063DBB69');
        $this->addSql('ALTER TABLE patient_affections DROP CONSTRAINT FK_3EF9FA476B899279');
        $this->addSql('ALTER TABLE patient_allergies DROP CONSTRAINT FK_2B926D246B899279');
        $this->addSql('ALTER TABLE patient_insurance DROP CONSTRAINT FK_C2857D736B899279');
        $this->addSql('ALTER TABLE patient_insurance DROP CONSTRAINT FK_C2857D73D1E63CD1');
        $this->addSql('ALTER TABLE patient_traitement DROP CONSTRAINT FK_9CF5CBC86B899279');
        $this->addSql('ALTER TABLE patient_vaccin DROP CONSTRAINT FK_BE92495D6B899279');
        $this->addSql('ALTER TABLE patient_vaccin DROP CONSTRAINT FK_BE92495D2BFE75C3');
        $this->addSql('ALTER TABLE person_to_contact DROP CONSTRAINT FK_F441B8D86B899279');
        $this->addSql('ALTER TABLE vaccine DROP CONSTRAINT FK_A7DD90B163DBB69');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE hospital_configuration');
        $this->addSql('DROP TABLE hospital_configuration_insurance');
        $this->addSql('DROP TABLE hospital_facility');
        $this->addSql('DROP TABLE insurance');
        $this->addSql('DROP TABLE nurse');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE hospital_patient');
        $this->addSql('DROP TABLE patient_affections');
        $this->addSql('DROP TABLE patient_allergies');
        $this->addSql('DROP TABLE patient_insurance');
        $this->addSql('DROP TABLE patient_traitement');
        $this->addSql('DROP TABLE patient_vaccin');
        $this->addSql('DROP TABLE person_to_contact');
        $this->addSql('DROP TABLE posology');
        $this->addSql('DROP TABLE vaccine');
        $this->addSql('DROP INDEX IDX_4282C85BC54C8C93');
        $this->addSql('ALTER TABLE hospital DROP type_id');
        $this->addSql('ALTER TABLE person DROP marital_status');
        $this->addSql('ALTER TABLE person DROP type');
        $this->addSql('ALTER TABLE person RENAME COLUMN first_name TO firt_name');
    }
}
