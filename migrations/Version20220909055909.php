<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909055909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guest_party (guest_id INT NOT NULL, party_id INT NOT NULL, PRIMARY KEY(guest_id, party_id))');
        $this->addSql('CREATE INDEX IDX_9C6BD9F49A4AA658 ON guest_party (guest_id)');
        $this->addSql('CREATE INDEX IDX_9C6BD9F4213C1059 ON guest_party (party_id)');
        $this->addSql('ALTER TABLE guest_party ADD CONSTRAINT FK_9C6BD9F49A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_party ADD CONSTRAINT FK_9C6BD9F4213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE guest_party');
    }
}
