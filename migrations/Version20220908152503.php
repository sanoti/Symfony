<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908152503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE personal_check_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personal_check (id INT NOT NULL, from_check_id INT DEFAULT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64D7EA05367C657D ON personal_check (from_check_id)');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA05367C657D FOREIGN KEY (from_check_id) REFERENCES "check" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE guest_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE personal_check_id_seq CASCADE');
        $this->addSql('CREATE TABLE guest_product (guest_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(guest_id, product_id))');
        $this->addSql('CREATE INDEX idx_938fc0e19a4aa658 ON guest_product (guest_id)');
        $this->addSql('CREATE INDEX idx_938fc0e14584665a ON guest_product (product_id)');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT fk_938fc0e19a4aa658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT fk_938fc0e14584665a FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE personal_check');
    }
}
