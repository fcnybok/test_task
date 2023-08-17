<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class BookRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Book::class));
    }

    public function save(Book $book): void
    {
        $this->_em->persist($book);
    }

    public function delete(Book $book): void
    {
        $this->_em->remove($book);
    }
}
