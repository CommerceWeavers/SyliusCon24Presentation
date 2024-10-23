<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Packaging\OrderProcessor\PackagingOrderProcessor;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Order as BaseOrder;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_order')]
class Order extends BaseOrder
{
    public function getPackagingTotal(): int
    {
        return $this->getAdjustmentsTotalRecursively(PackagingOrderProcessor::ADJUSTMENT_TYPE);
    }
}
