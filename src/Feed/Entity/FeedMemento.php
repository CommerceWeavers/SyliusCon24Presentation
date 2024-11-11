<?php

declare(strict_types=1);

namespace App\Feed\Entity;

use App\Feed\Repository\FeedMementoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedMementoRepository::class)]
class FeedMemento
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        public readonly ?string $id = null,
        #[ORM\Column(type: 'integer')]
        public int $amountOfProcessedChunks = 0,
        #[ORM\Column(type: 'json')]
        public array $processedChunks = [])
    {
    }
}
