<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414104753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, owned_by_id INT NOT NULL, expires_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', token VARCHAR(68) NOT NULL, scopes LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_7BA2F5EB5E70BCD7 (owned_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auction (id INT AUTO_INCREMENT NOT NULL, auction_category_id INT NOT NULL, courier_id INT NOT NULL, owner_id INT NOT NULL, title VARCHAR(80) NOT NULL, product_state VARCHAR(40) NOT NULL, isbn VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, is_company TINYINT(1) NOT NULL, quantity INT NOT NULL, quantity_type VARCHAR(255) NOT NULL, auction_duration INT NOT NULL, auction_buy_now_price_net BIGINT NOT NULL, auction_bid_start_price_net BIGINT NOT NULL, courier_pre_payment_price_net INT NOT NULL, courier_after_delivery_payment_price_net INT NOT NULL, date_time_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_time_modify DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_time_deleted DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_DEE4F5934DE2837E (auction_category_id), INDEX IDX_DEE4F593E3D8151C (courier_id), INDEX IDX_DEE4F5937E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auctions_bids (id INT AUTO_INCREMENT NOT NULL, auction_id INT NOT NULL, owner_id INT NOT NULL, current_bid_price_net BIGINT NOT NULL, date_time_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5DAFB24157B8F0DE (auction_id), INDEX IDX_5DAFB2417E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auctions_categories (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, date_time_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_time_modify DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auctions_photos (id INT AUTO_INCREMENT NOT NULL, auction_id INT NOT NULL, photo_url VARCHAR(255) NOT NULL, is_deleted TINYINT(1) NOT NULL, date_time_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_time_deleted DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_78DAFFE57B8F0DE (auction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier (id INT AUTO_INCREMENT NOT NULL, courier_name VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, sort_order INT NOT NULL, date_time_add DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_time_modify DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EB5E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE auction ADD CONSTRAINT FK_DEE4F5934DE2837E FOREIGN KEY (auction_category_id) REFERENCES auctions_categories (id)');
        $this->addSql('ALTER TABLE auction ADD CONSTRAINT FK_DEE4F593E3D8151C FOREIGN KEY (courier_id) REFERENCES courier (id)');
        $this->addSql('ALTER TABLE auction ADD CONSTRAINT FK_DEE4F5937E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE auctions_bids ADD CONSTRAINT FK_5DAFB24157B8F0DE FOREIGN KEY (auction_id) REFERENCES auction (id)');
        $this->addSql('ALTER TABLE auctions_bids ADD CONSTRAINT FK_5DAFB2417E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE auctions_photos ADD CONSTRAINT FK_78DAFFE57B8F0DE FOREIGN KEY (auction_id) REFERENCES auction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EB5E70BCD7');
        $this->addSql('ALTER TABLE auction DROP FOREIGN KEY FK_DEE4F5934DE2837E');
        $this->addSql('ALTER TABLE auction DROP FOREIGN KEY FK_DEE4F593E3D8151C');
        $this->addSql('ALTER TABLE auction DROP FOREIGN KEY FK_DEE4F5937E3C61F9');
        $this->addSql('ALTER TABLE auctions_bids DROP FOREIGN KEY FK_5DAFB24157B8F0DE');
        $this->addSql('ALTER TABLE auctions_bids DROP FOREIGN KEY FK_5DAFB2417E3C61F9');
        $this->addSql('ALTER TABLE auctions_photos DROP FOREIGN KEY FK_78DAFFE57B8F0DE');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE auction');
        $this->addSql('DROP TABLE auctions_bids');
        $this->addSql('DROP TABLE auctions_categories');
        $this->addSql('DROP TABLE auctions_photos');
        $this->addSql('DROP TABLE courier');
        $this->addSql('DROP TABLE `user`');
    }
}
