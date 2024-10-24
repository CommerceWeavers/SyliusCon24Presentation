<?php

declare(strict_types=1);

namespace App\Feed\PhaseFour\Command;

final readonly class GenerateFeedForProducts
{
    public function __construct(public array $productCodes)
    {
    }
}
