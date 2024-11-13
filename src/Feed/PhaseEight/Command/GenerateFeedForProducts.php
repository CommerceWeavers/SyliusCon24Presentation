<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Command;

final readonly class GenerateFeedForProducts
{
    public function __construct(public array $productCodes, public string $id)
    {
    }
}
