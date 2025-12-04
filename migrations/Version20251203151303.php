<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203151303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, name_cat VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, name_task VARCHAR(50) NOT NULL, content_task LONGTEXT NOT NULL, date_task DATETIME NOT NULL, user_task_id INT NOT NULL, cat_task_id INT NOT NULL, INDEX IDX_527EDB25D5BB1F8C (user_task_id), INDEX IDX_527EDB25AD0783D0 (cat_task_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name_user VARCHAR(50) NOT NULL, first_name_user VARCHAR(50) NOT NULL, login_user VARCHAR(50) NOT NULL, mdp_user VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25D5BB1F8C FOREIGN KEY (user_task_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25AD0783D0 FOREIGN KEY (cat_task_id) REFERENCES cat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25D5BB1F8C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25AD0783D0');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE `user`');
    }
}
