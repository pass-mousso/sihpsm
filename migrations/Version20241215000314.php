<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215000314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE messenger_messages_id_seq CASCADE');
        $this->addSql('CREATE TABLE admin_menus (id SERIAL NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, url VARCHAR(255) DEFAULT NULL, "order" INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D25FF335727ACA70 ON admin_menus (parent_id)');
        $this->addSql('CREATE TABLE menu_roles (menu_id INT NOT NULL, admin_role_id INT NOT NULL, PRIMARY KEY(menu_id, admin_role_id))');
        $this->addSql('CREATE INDEX IDX_27920DA0CCD7E912 ON menu_roles (menu_id)');
        $this->addSql('CREATE INDEX IDX_27920DA0123FA025 ON menu_roles (admin_role_id)');
        $this->addSql('CREATE TABLE admin_permissions (id SERIAL NOT NULL, role_id INT NOT NULL, resource VARCHAR(150) NOT NULL, action VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0F78566D60322AC ON admin_permissions (role_id)');
        $this->addSql('CREATE TABLE admin_roles (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1614D53D5E237E06 ON admin_roles (name)');
        $this->addSql('ALTER TABLE admin_menus ADD CONSTRAINT FK_D25FF335727ACA70 FOREIGN KEY (parent_id) REFERENCES admin_menus (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_roles ADD CONSTRAINT FK_27920DA0CCD7E912 FOREIGN KEY (menu_id) REFERENCES admin_menus (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_roles ADD CONSTRAINT FK_27920DA0123FA025 FOREIGN KEY (admin_role_id) REFERENCES admin_roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_permissions ADD CONSTRAINT FK_B0F78566D60322AC FOREIGN KEY (role_id) REFERENCES admin_roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE messenger_messages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE messenger_messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_75ea56e016ba31db ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX idx_75ea56e0e3bd61ce ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX idx_75ea56e0fb7336f0 ON messenger_messages (queue_name)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_menus DROP CONSTRAINT FK_D25FF335727ACA70');
        $this->addSql('ALTER TABLE menu_roles DROP CONSTRAINT FK_27920DA0CCD7E912');
        $this->addSql('ALTER TABLE menu_roles DROP CONSTRAINT FK_27920DA0123FA025');
        $this->addSql('ALTER TABLE admin_permissions DROP CONSTRAINT FK_B0F78566D60322AC');
        $this->addSql('DROP TABLE admin_menus');
        $this->addSql('DROP TABLE menu_roles');
        $this->addSql('DROP TABLE admin_permissions');
        $this->addSql('DROP TABLE admin_roles');
    }
}
