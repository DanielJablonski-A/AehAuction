<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourierRepository::class)]
class Courier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $courierName = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?int $sortOrder = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateTimeAdd = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateTimeModify = null;

    public function __construct(string $courierName = null) {
        $this->courierName = $courierName;
        $this->dateTimeAdd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourierName(): ?string
    {
        return $this->courierName;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getDateTimeAdd(): ?\DateTimeImmutable
    {
        return $this->dateTimeAdd;
    }

    public function getDateTimeModify(): ?\DateTimeImmutable
    {
        return $this->dateTimeModify;
    }

    public function setDateTimeModify(?\DateTimeImmutable $dateTimeModify): static
    {
        $this->dateTimeModify = $dateTimeModify;

        return $this;
    }
}
