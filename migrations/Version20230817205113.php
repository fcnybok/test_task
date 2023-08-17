<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230817205113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init db schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE author
            (
                id             SERIAL                         NOT NULL,
                full_name      VARCHAR(255)                   NOT NULL,
                quantity_books INT                            NOT NULL,
                created_at     TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )
            SQL
            );
        $this->addSql('COMMENT ON COLUMN author.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            <<<SQL
            CREATE TABLE author_book
            (
                author_id INT NOT NULL,
                book_id   INT NOT NULL,
                PRIMARY KEY (author_id, book_id)
            )
            SQL
            );
        $this->addSql('CREATE INDEX IDX_2F0A2BEEF675F31B ON author_book (author_id)');
        $this->addSql('CREATE INDEX IDX_2F0A2BEE16A2B381 ON author_book (book_id)');
        $this->addSql(
            <<<SQL
            CREATE TABLE book
            (
                id          SERIAL                         NOT NULL,
                name        VARCHAR(255)                   NOT NULL,
                description TEXT                           NOT NULL,
                public_at   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )
            SQL
                );
        $this->addSql('COMMENT ON COLUMN book.public_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            <<<SQL
            ALTER TABLE author_book 
                ADD CONSTRAINT FK_2F0A2BEEF675F31B 
                    FOREIGN KEY (author_id) 
                        REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL

        );
        $this->addSql(
            <<<SQL
            ALTER TABLE author_book 
                ADD CONSTRAINT FK_2F0A2BEE16A2B381 
                    FOREIGN KEY (book_id) 
                        REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEEF675F31B');
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEE16A2B381');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE book');
    }
}
