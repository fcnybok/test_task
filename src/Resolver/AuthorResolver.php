<?php

declare(strict_types=1);

namespace App\Resolver;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class AuthorResolver implements ResolverInterface, MutationInterface
{
	public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getAuthor(int $id): ?Author
    {
        return $this->authorRepository->find($id);
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authorRepository->findAll();
    }

    public function create(string $fullName): Author
    {
        $author = new Author($fullName);

        $this->authorRepository->save($author);

        $this->entityManager->flush();

        return $author;
    }

    public function update(int $id, string $fullName): Author
    {
        /** @var Author|null $book */
		$author = $this->authorRepository->find($id);

        if (null === $author) {
            throw new BadRequestHttpException();
        }

        $author->setFullName($fullName);

        $this->entityManager->flush();

        return $author;
    }

    public function delete(int $id): void
    {
        /** @var Author|null $book */
		$author = $this->authorRepository->find($id);

        if (null === $author) {
            throw new BadRequestHttpException();
        }

        $this->authorRepository->delete($author);

        $this->entityManager->flush();
    }
}
