<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AuthorRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[Id]
    #[GeneratedValue('IDENTITY')]
    #[Column]
    private int $id;

    #[Column]
    private string $fullName;

    #[Column]
    private int $quantityBooks;

    #[ManyToMany(targetEntity: Book::class, inversedBy: 'authors')]
    private Collection $books;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeInterface $createdAt;

    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
        $this->quantityBooks = 0;
        $this->createdAt = new DateTimeImmutable();
        $this->books = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getQuantityBooks(): int
    {
        return $this->quantityBooks;
    }

    public function setQuantityBooks(int $quantityBooks): self
    {
        $this->quantityBooks = $quantityBooks;

        return $this;
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->books->removeElement($book);

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
