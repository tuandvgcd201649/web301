<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026071146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart');
        $this->addSql('ALTER TABLE product ADD publisher_id INT DEFAULT NULL, CHANGE image image VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD40C86FCE FOREIGN KEY (publisher_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD40C86FCE ON product (publisher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (cartId INT NOT NULL, productId INT NOT NULL, sId VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, productName VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, price VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, quantity INT NOT NULL, Image VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(cartId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD40C86FCE');
        $this->addSql('DROP INDEX IDX_D34A04AD40C86FCE ON product');
        $this->addSql('ALTER TABLE product DROP publisher_id, CHANGE image image VARCHAR(55) NOT NULL');
    }
}
