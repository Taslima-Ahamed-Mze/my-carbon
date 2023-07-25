<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725105002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_register_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event_register (id INT NOT NULL, collaborator_id UUID DEFAULT NULL, event_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1915A9C430098C8C ON event_register (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_1915A9C471F7E88B ON event_register (event_id)');
        $this->addSql('COMMENT ON COLUMN event_register.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C430098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE event_register_id_seq CASCADE');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C430098C8C');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C471F7E88B');
        $this->addSql('DROP TABLE event_register');
    }
}
