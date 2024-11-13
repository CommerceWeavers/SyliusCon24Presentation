<?php

declare(strict_types=1);

namespace App\Feed\Entity;

use App\Feed\Repository\SingleFeedMementoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SingleFeedMementoRepository::class)]
class SingleFeedMemento
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        public readonly string $id,
        #[ORM\Column]
        public readonly string $generationId,
        #[ORM\Column(type: 'json')]
        public array $processedChunks
    ) {
    }
}
