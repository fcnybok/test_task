<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class AuthorRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Author::class));
    }

    public function updateCountBookByAuthors(array $authorIds): void
    {
        $this
            ->_em
            ->getConnection()
            ->executeStatement(
                <<<SQL
                UPDATE
                    author AS au
                SET
                    quantity_books = author_count_books.count_books
                FROM
                    (
                        SELECT
                            b_a.author_id AS author_id, COUNT(b_a.author_id) AS count_books
                        FROM
                            book_author AS b_a
                        WHERE
                                b_a.author_id IN (:authorIds)
                        GROUP BY
                            b_a.author_id
                    ) AS author_count_books
                WHERE
                    au.id = author_count_books.author_id;
                SQL,
                [
					'authorIds' => $authorIds,
                ],
                [
                    'authorIds' => ArrayParameterType::INTEGER,
                ]
            );
    }

    public function save(Author $author): void
    {
        $this->_em->persist($author);
    }

    public function delete(Author $author): void
    {
        $this->_em->remove($author);
    }
}
