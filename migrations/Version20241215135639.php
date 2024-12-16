<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215135639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_menus DROP CONSTRAINT fk_d25ff335d823e37a');
        $this->addSql('DROP SEQUENCE section_id_seq CASCADE');
        $this->addSql('CREATE TABLE admin_menus_sections (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE section');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_menus DROP CONSTRAINT FK_D25FF335D823E37A');
        $this->addSql('CREATE SEQUENCE section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE section (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE admin_menus_sections');
        $this->addSql('ALTER TABLE admin_menus DROP CONSTRAINT fk_d25ff335d823e37a');
        $this->addSql('ALTER TABLE admin_menus ADD CONSTRAINT fk_d25ff335d823e37a FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
