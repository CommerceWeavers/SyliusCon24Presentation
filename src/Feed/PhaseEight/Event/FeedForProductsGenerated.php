<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Event;

final readonly class FeedForProductsGenerated
{
    public function __construct(public string $generationId)
    {
    }
}
