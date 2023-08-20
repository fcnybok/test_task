<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class BookResolver implements ResolverInterface, MutationInterface
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getBook(int $id): Book
    {
        return $this->bookRepository->find($id);
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->bookRepository->findAll();
    }

    public function create(string $name, string $description, DateTimeInterface $publicAt, array $authors): Book
    {
        $book = new Book($name, $description, $publicAt);

        $book->clearAuthors();

        foreach ($authors as $authorId) {
            $author = $this->authorRepository->find($authorId);

            if (null === $author) {
                throw new BadRequestHttpException();
            }

            $book->addAuthor($author);
        }

        $this->bookRepository->save($book);

        $this->entityManager->flush();

        return $book;
    }

    public function update(
        int $id,
        string $name,
        string $description,
        DateTimeInterface $publicAt,
        array $authors
    ): Book {
        /** @var Book|null $book */
        $book = $this->bookRepository->find($id);

        if (null === $book) {
            throw new BadRequestHttpException();
        }

        $book->clearAuthors();

        foreach ($authors as $authorId) {
            $author = $this->authorRepository->find($authorId);

            if (null === $author) {
                throw new BadRequestHttpException();
            }

            $book->addAuthor($author);
        }

        $book->setName($name);
        $book->setDescription($description);
        $book->setPublicAt($publicAt);

        $this->bookRepository->save($book);

        $this->entityManager->flush();

        return $book;
    }

    public function delete(int $id): void
    {
        /** @var Book|null $book */
        $book = $this->bookRepository->find($id);

        if (null === $book) {
            throw new BadRequestHttpException();
        }

        $this->bookRepository->delete($book);

        $this->entityManager->flush();
    }
}
