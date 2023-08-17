<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

final class AuthorRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Author::class));
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
