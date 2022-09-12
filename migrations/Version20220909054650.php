<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909054650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_check ADD eating_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_check ADD guest_who_eat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA0592B1ED28 FOREIGN KEY (eating_product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA0570DC450E FOREIGN KEY (guest_who_eat_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64D7EA0592B1ED28 ON personal_check (eating_product_id)');
        $this->addSql('CREATE INDEX IDX_64D7EA0570DC450E ON personal_check (guest_who_eat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA0592B1ED28');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA0570DC450E');
        $this->addSql('DROP INDEX IDX_64D7EA0592B1ED28');
        $this->addSql('DROP INDEX IDX_64D7EA0570DC450E');
        $this->addSql('ALTER TABLE personal_check DROP eating_product_id');
        $this->addSql('ALTER TABLE personal_check DROP guest_who_eat_id');
    }
}
