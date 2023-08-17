<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[Id]
    #[GeneratedValue('IDENTITY')]
    #[Column]
    private int $id;

    #[ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    #[Column]
    private string $name;

    #[Column(type: Types::TEXT)]
    private string $description;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeInterface $publicAt;

    public function __construct(string $name, string $description, DateTimeInterface $publicAt)
    {
        $this->name = $name;
        $this->description = $description;
        $this->publicAt = $publicAt;
        $this->authors = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removedAuthor(Author $author): self
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublicAt(): DateTimeInterface
    {
        return $this->publicAt;
    }

    public function setPublicAt(DateTimeInterface $publicAt): self
    {
        $this->publicAt = $publicAt;

        return $this;
    }
}
