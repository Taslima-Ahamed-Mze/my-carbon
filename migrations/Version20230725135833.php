<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725135833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "user" ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649CCFA12B8 ON "user" (profile_id)');
        $this->addSql('ALTER TABLE user_skills ADD created_by UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE user_skills ADD updated_by UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE user_skills ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user_skills ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_skills.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_skills.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4DDE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D16FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B0630D4DDE12AB56 ON user_skills (created_by)');
        $this->addSql('CREATE INDEX IDX_B0630D4D16FE72E1 ON user_skills (updated_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP INDEX IDX_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE "user" DROP profile_id');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4DDE12AB56');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D16FE72E1');
        $this->addSql('DROP INDEX IDX_B0630D4DDE12AB56');
        $this->addSql('DROP INDEX IDX_B0630D4D16FE72E1');
        $this->addSql('ALTER TABLE user_skills DROP created_by');
        $this->addSql('ALTER TABLE user_skills DROP updated_by');
        $this->addSql('ALTER TABLE user_skills DROP created_at');
        $this->addSql('ALTER TABLE user_skills DROP updated_at');
    }
}
