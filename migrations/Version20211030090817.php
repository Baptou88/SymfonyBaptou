<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030090817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_project_documents (project_id INTEGER NOT NULL, project_documents_id INTEGER NOT NULL, PRIMARY KEY(project_id, project_documents_id))');
        $this->addSql('CREATE INDEX IDX_875F6B60166D1F9C ON project_project_documents (project_id)');
        $this->addSql('CREATE INDEX IDX_875F6B6075A8C331 ON project_project_documents (project_documents_id)');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB6EC9B9');
        $this->addSql('DROP INDEX IDX_2FB3D0EE19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project AS SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM project');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE TABLE project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_project_id INTEGER NOT NULL, client_id INTEGER NOT NULL, code VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , description VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_2FB3D0EEB6EC9B9 FOREIGN KEY (type_project_id) REFERENCES type_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project (id, type_project_id, client_id, code, created_at, modified_at, description) SELECT id, type_project_id, client_id, code, created_at, modified_at, description FROM __temp__project');
        $this->addSql('DROP TABLE __temp__project');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB6EC9B9 ON project (type_project_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_documents AS SELECT id, doc_name, doc_size, update_at FROM project_documents');
        $this->addSql('DROP TABLE project_documents');
        $this->addSql('CREATE TABLE project_documents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, doc_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, doc_size VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO project_documents (id, doc_name, doc_size, updated_at) SELECT id, doc_name, doc_size, update_at FROM __temp__project_documents');
        $this->addSql('DROP TABLE __temp__project_documents');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_project_documents');
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_documents AS SELECT id, doc_name, doc_size, updated_at FROM project_documents');
        $this->addSql('DROP TABLE project_documents');
        $this->addSql('CREATE TABLE project_documents (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, doc_name VARCHAR(255) DEFAULT NULL, doc_size VARCHAR(255) DEFAULT NULL, update_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , doc_file VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO project_documents (id, doc_name, doc_size, update_at) SELECT id, doc_name, doc_size, updated_at FROM __temp__project_documents');
        $this->addSql('DROP TABLE __temp__project_documents');
    }
}
