<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241205092906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospital (id SERIAL NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN hospital.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN hospital.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE hopital_facility (id SERIAL NOT NULL, label VARCHAR(200) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN hopital_facility.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN hopital_facility.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE hospital (id SERIAL NOT NULL, city_id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(200) NOT NULL, identifier VARCHAR(20) NOT NULL, status BOOLEAN NOT NULL, authorization_number VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4282C85B8BAC62AF ON hospital (city_id)');
        $this->addSql('CREATE INDEX IDX_4282C85B7E3C61F9 ON hospital (owner_id)');
        $this->addSql('CREATE TABLE subscription_plans (id SERIAL NOT NULL, currency VARCHAR(150) DEFAULT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION NOT NULL, frequency INT NOT NULL, is_default BOOLEAN NOT NULL, trial_days INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sms_limit INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subscription_plans.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_plans.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscriptions (id SERIAL NOT NULL, tenant_id INT NOT NULL, plan_id INT NOT NULL, status INT NOT NULL, plan_amount INT NOT NULL, plan_frequency INT NOT NULL, starts_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ends_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, trial_ends_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sms_limit BIGINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4778A019033212A ON subscriptions (tenant_id)');
        $this->addSql('CREATE INDEX IDX_4778A01E899029B ON subscriptions (plan_id)');
        $this->addSql('COMMENT ON COLUMN subscriptions.starts_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.ends_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.trial_ends_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE super_admin_currency_settings (id SERIAL NOT NULL, currency_name VARCHAR(200) NOT NULL, currency_code VARCHAR(200) NOT NULL, currency_icon VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN super_admin_currency_settings.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN super_admin_currency_settings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_subscription (id SERIAL NOT NULL, user_id_id INT NOT NULL, subscription_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_230A18D19D86650F ON user_subscription (user_id_id)');
        $this->addSql('CREATE INDEX IDX_230A18D19A1887DC ON user_subscription (subscription_id)');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hospital ADD CONSTRAINT FK_4282C85B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A019033212A FOREIGN KEY (tenant_id) REFERENCES hospital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01E899029B FOREIGN KEY (plan_id) REFERENCES subscription_plans (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D19D86650F FOREIGN KEY (user_id_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D19A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85B8BAC62AF');
        $this->addSql('ALTER TABLE hospital DROP CONSTRAINT FK_4282C85B7E3C61F9');
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT FK_4778A019033212A');
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT FK_4778A01E899029B');
        $this->addSql('ALTER TABLE user_subscription DROP CONSTRAINT FK_230A18D19D86650F');
        $this->addSql('ALTER TABLE user_subscription DROP CONSTRAINT FK_230A18D19A1887DC');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE hopital_facility');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE subscription_plans');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('DROP TABLE super_admin_currency_settings');
        $this->addSql('DROP TABLE user_subscription');
    }
}
