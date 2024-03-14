<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312010721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration will create the initial tables that are needed.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `image` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', filename VARCHAR(255) NOT NULL, file_extension VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `image_image_label` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', image_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', image_label_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, INDEX IDX_D6349FCF3DA5256D (image_id), INDEX IDX_D6349FCFBC49A191 (image_label_id), UNIQUE INDEX UNIQ_D6349FCF3DA5256DBC49A191 (image_id, image_label_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `image_label` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `image_image_label` ADD CONSTRAINT FK_D6349FCF3DA5256D FOREIGN KEY (image_id) REFERENCES `image` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `image_image_label` ADD CONSTRAINT FK_D6349FCFBC49A191 FOREIGN KEY (image_label_id) REFERENCES `image_label` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `image_image_label` DROP FOREIGN KEY FK_D6349FCF3DA5256D');
        $this->addSql('ALTER TABLE `image_image_label` DROP FOREIGN KEY FK_D6349FCFBC49A191');
        $this->addSql('DROP TABLE `image`');
        $this->addSql('DROP TABLE `image_image_label`');
        $this->addSql('DROP TABLE `image_label`');
    }
}
