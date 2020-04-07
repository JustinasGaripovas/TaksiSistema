<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407141714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD lat_coordinate_start VARCHAR(255) DEFAULT NULL, ADD lng_coordinate_start VARCHAR(255) DEFAULT NULL, ADD lat_coordinate_destination VARCHAR(255) DEFAULT NULL, ADD lng_coordinate_destination VARCHAR(255) DEFAULT NULL, DROP lat_coordinate, DROP lng_coordinate');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` ADD lat_coordinate VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD lng_coordinate VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP lat_coordinate_start, DROP lng_coordinate_start, DROP lat_coordinate_destination, DROP lng_coordinate_destination');
    }
}
