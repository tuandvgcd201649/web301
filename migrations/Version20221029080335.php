<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029080335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46FCDAEAAA');
        $this->addSql('DROP INDEX idx_ed896f46fcdaeaaa ON order_detail');
        $this->addSql('CREATE INDEX IDX_ED896F468D9F6D38 ON order_detail (order_id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46FCDAEAAA FOREIGN KEY (order_id) REFERENCES oder (id)');
        $this->addSql('ALTER TABLE product ADD description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F468D9F6D38');
        $this->addSql('DROP INDEX idx_ed896f468d9f6d38 ON order_detail');
        $this->addSql('CREATE INDEX IDX_ED896F46FCDAEAAA ON order_detail (order_id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F468D9F6D38 FOREIGN KEY (order_id) REFERENCES oder (id)');
        $this->addSql('ALTER TABLE product DROP description');
    }
}
