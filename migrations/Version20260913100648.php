<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260913100648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add app_user (admin login), employment_entry, and education_entry with education_course children.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_88BDF3E9E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE education_course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(160) NOT NULL, grade VARCHAR(40) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, domain_url VARCHAR(255) DEFAULT NULL, other_url VARCHAR(255) DEFAULT NULL, position INT NOT NULL, education_entry_id INT NOT NULL, INDEX IDX_5E90D5E8322237CB (education_entry_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE education_entry (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, university VARCHAR(160) NOT NULL, qualification VARCHAR(160) NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employment_entry (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, company_name VARCHAR(160) NOT NULL, company_title VARCHAR(160) NOT NULL, description LONGTEXT NOT NULL, position INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE education_course ADD CONSTRAINT FK_5E90D5E8322237CB FOREIGN KEY (education_entry_id) REFERENCES education_entry (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education_course DROP FOREIGN KEY FK_5E90D5E8322237CB');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE education_course');
        $this->addSql('DROP TABLE education_entry');
        $this->addSql('DROP TABLE employment_entry');
    }
}
