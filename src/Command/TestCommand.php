<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:test');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $author = new Author('name');
        $this->authorRepository->save($author);

        $book1 = new Book('book1', 'description', new DateTimeImmutable());
        $this->bookRepository->save($book1);

        $book2 = new Book('book2', 'description', new DateTimeImmutable());
        $this->bookRepository->save($book2);

        $author->addBook($book1);
        $author->addBook($book2);

        $this->entityManager->flush();

        return self::SUCCESS;
    }
}
