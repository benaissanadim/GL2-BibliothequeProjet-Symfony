<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611160431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_category');
        $this->addSql('ALTER TABLE newsletters DROP FOREIGN KEY FK_8ECF000C12469DE2');
        $this->addSql('DROP INDEX IDX_8ECF000C12469DE2 ON newsletters');
        $this->addSql('ALTER TABLE newsletters DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_category (users_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7D0D321B12469DE2 (category_id), INDEX IDX_7D0D321B67B3B43D (users_id), PRIMARY KEY(users_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_category ADD CONSTRAINT FK_7D0D321B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_category ADD CONSTRAINT FK_7D0D321B67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletters ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE newsletters ADD CONSTRAINT FK_8ECF000C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8ECF000C12469DE2 ON newsletters (category_id)');
    }
}
