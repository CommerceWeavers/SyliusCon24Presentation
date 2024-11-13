<?php

declare(strict_types=1);

namespace App\Feed\Entity;

use App\Feed\PhaseEight\Grid\FeedGenerationGrid;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\BulkDelete;
use Sylius\Resource\Metadata\Delete;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Model\ResourceInterface;

#[ORM\Entity()]
#[AsResource(section: 'admin', routePrefix: 'admin')]
#[Index(grid: FeedGenerationGrid::class)]
#[BulkDelete]
#[Delete]
class FeedGeneration implements ResourceInterface
{
    public const TO_GENERATE = 'to_generate';
    public const GENERATED = 'generated';

    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        public readonly string $id,
        #[ORM\Column(type: 'integer')]
        public readonly int $amountOfChunksToProcess,
        #[ORM\Column]
        public string $status = self::TO_GENERATE,
        #[ORM\Column]
        public string $generationPath = '',
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
