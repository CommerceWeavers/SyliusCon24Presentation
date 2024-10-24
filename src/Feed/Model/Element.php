<?php

declare(strict_types=1);

namespace App\Feed\Model;

final readonly class Element
{
    public function __construct(
        public string $name,
        public int $price,
    ) {
    }
}
