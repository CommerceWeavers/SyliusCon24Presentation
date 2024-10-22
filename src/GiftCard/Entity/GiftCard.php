<?php

declare(strict_types=1);

namespace App\GiftCard\Entity;

use App\GiftCard\Form\GiftCardType;
use App\GiftCard\Grid\GiftCardGrid;
use App\GiftCard\Repository\GiftCardRepository;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\BulkDelete;
use Sylius\Resource\Metadata\Create;
use Sylius\Resource\Metadata\Delete;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Update;
use Sylius\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: GiftCardRepository::class)]
#[AsResource(section: 'admin', templatesDir: '@SyliusAdmin/shared/crud', routePrefix: 'admin')]
#[Index(grid: GiftCardGrid::class)]
#[Create(formType: GiftCardType::class)]
#[BulkDelete]
#[Update(formType: GiftCardType::class)]
#[Delete]
class GiftCard implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(type: 'integer')]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}