<?php

declare(strict_types=1);

namespace App\Feed\PhaseSix\Event;

final readonly class FeedForProductsGenerated
{
    public function __construct(public array $productFeeds, public int $totalChunks)
    {
    }
}