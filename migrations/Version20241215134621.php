<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215134621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE section (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE admin_menus ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_menus ADD CONSTRAINT FK_D25FF335D823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D25FF335D823E37A ON admin_menus (section_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_menus DROP CONSTRAINT FK_D25FF335D823E37A');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP INDEX IDX_D25FF335D823E37A');
        $this->addSql('ALTER TABLE admin_menus DROP section_id');
    }
}