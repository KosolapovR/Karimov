<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107114421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad CHANGE user_id user_id INT DEFAULT NULL, CHANGE location location VARCHAR(60) DEFAULT NULL, CHANGE price price VARCHAR(60) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE user_id user_id INT DEFAULT NULL, CHANGE price price VARCHAR(60) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD ad_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307F4F34D596 ON message (ad_id)');
        $this->addSql('ALTER TABLE photo CHANGE ad_id ad_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad CHANGE user_id user_id INT DEFAULT NULL, CHANGE location location VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE price price VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F4F34D596');
        $this->addSql('DROP INDEX UNIQ_B6BD307F4F34D596 ON message');
        $this->addSql('ALTER TABLE message DROP ad_id, CHANGE user_id user_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(30) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE photo CHANGE ad_id ad_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE user_id user_id INT DEFAULT NULL, CHANGE price price VARCHAR(60) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
