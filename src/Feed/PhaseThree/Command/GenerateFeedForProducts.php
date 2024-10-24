<?php

declare(strict_types=1);

namespace App\Feed\PhaseThree\Command;

final readonly class GenerateFeedForProducts
{
    public function __construct(public array $productCodes)
    {
    }
}
