<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521210916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, license_number VARCHAR(255) NOT NULL, is_damaged TINYINT(1) DEFAULT NULL, manufactured_at DATETIME DEFAULT NULL, technically_approved_till DATETIME DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_773DE69DC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price_per_km INT NOT NULL, price_per_minute INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, code VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_car (order_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_3466A9FD8D9F6D38 (order_id), INDEX IDX_3466A9FDC3C6F69F (car_id), PRIMARY KEY(order_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, lat VARCHAR(255) DEFAULT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_accident (id INT AUTO_INCREMENT NOT NULL, accident_date DATETIME NOT NULL, are_people_hurt TINYINT(1) DEFAULT NULL, estimated_damage_cost DOUBLE PRECISION DEFAULT NULL, is_insured TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DC54C8C93 FOREIGN KEY (type_id) REFERENCES car_type (id)');
        $this->addSql('ALTER TABLE order_car ADD CONSTRAINT FK_3466A9FD8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_car ADD CONSTRAINT FK_3466A9FDC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD used_discount_id INT DEFAULT NULL, ADD user_id INT NOT NULL, ADD car_accident_id INT DEFAULT NULL, ADD status INT DEFAULT NULL, CHANGE driver_id driver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F185D18D FOREIGN KEY (used_discount_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993987C5AAA30 FOREIGN KEY (car_accident_id) REFERENCES car_accident (id)');
        $this->addSql('CREATE INDEX IDX_F5299398F185D18D ON `order` (used_discount_id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993987C5AAA30 ON `order` (car_accident_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_car DROP FOREIGN KEY FK_3466A9FDC3C6F69F');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DC54C8C93');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F185D18D');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993987C5AAA30');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE car_type');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE order_car');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE car_accident');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398F185D18D ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('DROP INDEX UNIQ_F52993987C5AAA30 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP used_discount_id, DROP user_id, DROP car_accident_id, DROP status, CHANGE driver_id driver_id INT NOT NULL');
    }
}
