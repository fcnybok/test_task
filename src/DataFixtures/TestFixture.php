<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class TestFixture extends Fixture
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $author1 = new Author($faker->name());
        $this->authorRepository->save($author1);

        $author2 = new Author($faker->name());
        $this->authorRepository->save($author2);

        $book1 = new Book($faker->name, $faker->text, new DateTimeImmutable());
        $this->bookRepository->save($book1);

        $book2 = new Book($faker->name, $faker->text, new DateTimeImmutable());
        $this->bookRepository->save($book2);

        $author1->addBook($book1);
        $author1->addBook($book2);

        $manager->flush();
    }
}
