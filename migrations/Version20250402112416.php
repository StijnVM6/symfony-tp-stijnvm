<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402112416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE student_project (student_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_C2856516CB944F1A (student_id), INDEX IDX_C2856516166D1F9C (project_id), PRIMARY KEY(student_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_project ADD CONSTRAINT FK_C2856516CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_project ADD CONSTRAINT FK_C2856516166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP FOREIGN KEY FK_B723AF331EDE0F55
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B723AF331EDE0F55 ON student
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP projects_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE student_project DROP FOREIGN KEY FK_C2856516CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_project DROP FOREIGN KEY FK_C2856516166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student_project
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD projects_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD CONSTRAINT FK_B723AF331EDE0F55 FOREIGN KEY (projects_id) REFERENCES project (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B723AF331EDE0F55 ON student (projects_id)
        SQL);
    }
}
