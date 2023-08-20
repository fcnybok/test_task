<?php

declare(strict_types=1);

namespace App\Listener\Doctrine;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use function array_unique;
use function count;

/**
 * TODO: May bad implementation, need move this logic on worker or cron task recalculation
 */
final class QuantityBookAuthorCalculatorSubscriber implements EventSubscriber
{
    private array $authorIds;

    public function __construct(
        private readonly AuthorRepository $authorRepository,
    )
    {
        $this->authorIds = [];
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::postFlush
        ];
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        if (!$args->getObject() instanceof Book) {
            return;
        }

        foreach ($args->getObject()->getAuthors() as $author) {
            $this->authorIds[] = $author->getId();
        }
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        if (count($this->authorIds) > 0) {
            $this->authorRepository->updateCountBookByAuthors(array_unique($this->authorIds));
        }

        $this->authorIds = [];
    }
}
