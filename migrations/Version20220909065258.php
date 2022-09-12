<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909065258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE party DROP date_call');
        $this->addSql('ALTER TABLE personal_check ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA057DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64D7EA057DE27E26 ON personal_check (who_author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party ADD date_call VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA057DE27E26');
        $this->addSql('DROP INDEX IDX_64D7EA057DE27E26');
        $this->addSql('ALTER TABLE personal_check DROP who_author_id');
    }
}
