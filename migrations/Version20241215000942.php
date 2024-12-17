<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215000942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_menu_roles (menu_id INT NOT NULL, admin_role_id INT NOT NULL, PRIMARY KEY(menu_id, admin_role_id))');
        $this->addSql('CREATE INDEX IDX_EFACAB25CCD7E912 ON admin_menu_roles (menu_id)');
        $this->addSql('CREATE INDEX IDX_EFACAB25123FA025 ON admin_menu_roles (admin_role_id)');
        $this->addSql('ALTER TABLE admin_menu_roles ADD CONSTRAINT FK_EFACAB25CCD7E912 FOREIGN KEY (menu_id) REFERENCES admin_menus (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_menu_roles ADD CONSTRAINT FK_EFACAB25123FA025 FOREIGN KEY (admin_role_id) REFERENCES admin_roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_roles DROP CONSTRAINT fk_27920da0ccd7e912');
        $this->addSql('ALTER TABLE menu_roles DROP CONSTRAINT fk_27920da0123fa025');
        $this->addSql('DROP TABLE menu_roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE menu_roles (menu_id INT NOT NULL, admin_role_id INT NOT NULL, PRIMARY KEY(menu_id, admin_role_id))');
        $this->addSql('CREATE INDEX idx_27920da0123fa025 ON menu_roles (admin_role_id)');
        $this->addSql('CREATE INDEX idx_27920da0ccd7e912 ON menu_roles (menu_id)');
        $this->addSql('ALTER TABLE menu_roles ADD CONSTRAINT fk_27920da0ccd7e912 FOREIGN KEY (menu_id) REFERENCES admin_menus (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_roles ADD CONSTRAINT fk_27920da0123fa025 FOREIGN KEY (admin_role_id) REFERENCES admin_roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_menu_roles DROP CONSTRAINT FK_EFACAB25CCD7E912');
        $this->addSql('ALTER TABLE admin_menu_roles DROP CONSTRAINT FK_EFACAB25123FA025');
        $this->addSql('DROP TABLE admin_menu_roles');
    }
}
