<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725132119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_register_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event_register (id INT NOT NULL, collaborator_id UUID DEFAULT NULL, event_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1915A9C430098C8C ON event_register (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_1915A9C471F7E88B ON event_register (event_id)');
        $this->addSql('COMMENT ON COLUMN event_register.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE levels (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, level VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F2A6419DE12AB56 ON levels (created_by)');
        $this->addSql('CREATE INDEX IDX_9F2A641916FE72E1 ON levels (updated_by)');
        $this->addSql('COMMENT ON COLUMN levels.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN levels.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D5311670DE12AB56 ON skills (created_by)');
        $this->addSql('CREATE INDEX IDX_D531167016FE72E1 ON skills (updated_by)');
        $this->addSql('COMMENT ON COLUMN skills.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN skills.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE skills_levels (id INT NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2356AAA5585C142 ON skills_levels (skill_id)');
        $this->addSql('CREATE INDEX IDX_D2356AAA5FB14BA7 ON skills_levels (level_id)');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(30) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(20) NOT NULL, firstname VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_skills (id INT NOT NULL, collaborator_id UUID NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0630D4D30098C8C ON user_skills (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4D5585C142 ON user_skills (skill_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4D5FB14BA7 ON user_skills (level_id)');
        $this->addSql('COMMENT ON COLUMN user_skills.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C430098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A6419DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A641916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D531167016FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5FB14BA7 FOREIGN KEY (level_id) REFERENCES levels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D30098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D5FB14BA7 FOREIGN KEY (level_id) REFERENCES levels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_register_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE levels_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_levels_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_skills_id_seq CASCADE');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C430098C8C');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C471F7E88B');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A6419DE12AB56');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A641916FE72E1');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D5311670DE12AB56');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D531167016FE72E1');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5585C142');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5FB14BA7');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D30098C8C');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D5585C142');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D5FB14BA7');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_register');
        $this->addSql('DROP TABLE levels');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE skills_levels');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_skills');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
