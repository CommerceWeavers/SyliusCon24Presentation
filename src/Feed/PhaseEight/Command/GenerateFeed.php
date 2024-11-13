<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Command;

final readonly class GenerateFeed
{
    public function __construct(public string $generationId)
    {
    }
}
