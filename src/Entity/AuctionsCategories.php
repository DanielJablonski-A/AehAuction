<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuctionsCategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuctionsCategoriesRepository::class)]
class AuctionsCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categoryName = null;

    #[ORM\Column(length: 30)]
    private ?\DateTimeImmutable $dateTimeAdd = null;

    #[ORM\Column(length: 30)]
    private ?\DateTimeImmutable $dateTimeModify = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    public function __construct(string $categoryName) {
        $this->categoryName = $categoryName;
        $this->dateTimeAdd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getDateTimeAdd(): ?string
    {
        return $this->dateTimeAdd;
    }

    public function setDateTimeAdd(\DateTimeImmutable $dateTimeAdd): static
    {
        $this->dateTimeAdd = $dateTimeAdd;

        return $this;
    }

    public function getDateTimeModify(): ?string
    {
        return $this->dateTimeModify;
    }

    public function setDateTimeModify(\DateTimeImmutable $dateTimeModify): static
    {
        $this->dateTimeModify = $dateTimeModify;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
