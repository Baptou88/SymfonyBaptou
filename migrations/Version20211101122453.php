<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101122453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar_event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, all_day BOOLEAN NOT NULL, textcolor VARCHAR(10) NOT NULL, bgcolor VARCHAR(10) NOT NULL, bordercolor VARCHAR(10) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('DROP INDEX IDX_2FB3D0EE19EB6921');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB6EC9B9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_project_id INTEGER NOT NULL, client_id INTEGER NOT NULL, code VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , description VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_2FB3D0EEB6EC9B9 FOREIGN KEY (type_project_id) REFERENCES type_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project (id, type_project_id, client_id, code, created_at, modified_at, description) SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB6EC9B9 ON project (type_project_id)');
        $this->addSql('DROP INDEX IDX_875F6B6075A8C331');
        $this->addSql('DROP INDEX IDX_875F6B60166D1F9C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_project_documents AS SELECT project_id, project_documents_id FROM project_project_documents');
        $this->addSql('DROP TABLE project_project_documents');
        $this->addSql('CREATE TABLE project_project_documents (project_id INTEGER NOT NULL, project_documents_id INTEGER NOT NULL, PRIMARY KEY(project_id, project_documents_id), CONSTRAINT FK_875F6B60166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_875F6B6075A8C331 FOREIGN KEY (project_documents_id) REFERENCES project_documents (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project_project_documents (project_id, project_documents_id) SELECT project_id, project_documents_id FROM __temp__project_project_documents');
        $this->addSql('DROP TABLE __temp__project_project_documents');
        $this->addSql('CREATE INDEX IDX_875F6B6075A8C331 ON project_project_documents (project_documents_id)');
        $this->addSql('CREATE INDEX IDX_875F6B60166D1F9C ON project_project_documents (project_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_documents AS SELECT id, doc_name, doc_size, updated_at, doc_file FROM project_documents');
        $this->addSql('DROP TABLE project_documents');
        $this->addSql('CREATE TABLE project_documents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, doc_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, doc_size VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , doc_file VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO project_documents (id, doc_name, doc_size, updated_at, doc_file) SELECT id, doc_name, doc_size, updated_at, doc_file FROM __temp__project_documents');
        $this->addSql('DROP TABLE __temp__project_documents');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendar_event');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB6EC9B9');
        $this->addSql('DROP INDEX IDX_2FB3D0EE19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_project_id INTEGER NOT NULL, client_id INTEGER NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO project (id, type_project_id, client_id, code, created_at, modified_at, description) SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB6EC9B9 ON project (type_project_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_documents AS SELECT id, doc_file, doc_name, doc_size, updated_at FROM project_documents');
        $this->addSql('DROP TABLE project_documents');
        $this->addSql('CREATE TABLE project_documents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, doc_file VARCHAR(255) NOT NULL COLLATE BINARY, doc_name VARCHAR(255) DEFAULT NULL, doc_size VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO project_documents (id, doc_file, doc_name, doc_size, updated_at) SELECT id, doc_file, doc_name, doc_size, updated_at FROM __temp__project_documents');
        $this->addSql('DROP TABLE __temp__project_documents');
        $this->addSql('DROP INDEX IDX_875F6B60166D1F9C');
        $this->addSql('DROP INDEX IDX_875F6B6075A8C331');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_project_documents AS SELECT project_id, project_documents_id FROM project_project_documents');
        $this->addSql('DROP TABLE project_project_documents');
        $this->addSql('CREATE TABLE project_project_documents (project_id INTEGER NOT NULL, project_documents_id INTEGER NOT NULL, PRIMARY KEY(project_id, project_documents_id))');
        $this->addSql('INSERT INTO project_project_documents (project_id, project_documents_id) SELECT project_id, project_documents_id FROM __temp__project_project_documents');
        $this->addSql('DROP TABLE __temp__project_project_documents');
        $this->addSql('CREATE INDEX IDX_875F6B60166D1F9C ON project_project_documents (project_id)');
        $this->addSql('CREATE INDEX IDX_875F6B6075A8C331 ON project_project_documents (project_documents_id)');
    }
}
