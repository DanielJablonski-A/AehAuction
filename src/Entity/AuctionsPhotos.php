<?php

namespace App\Entity;

use App\Repository\AuctionsPhotosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuctionsPhotosRepository::class)]
class AuctionsPhotos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photoUrl = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateTimeAdd = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auction $auction = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateTimeDeleted = null;

    public function __construct(Auction $auction, string $photoUrl)
    {
        $this->auction = $auction;
        $this->photoUrl = $photoUrl;
        $this->isDeleted = false;
        $this->dateTimeAdd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getDateTimeAdd(): ?\DateTimeImmutable
    {
        return $this->dateTimeAdd;
    }

    public function getDateTimeDeleted(): ?\DateTimeImmutable
    {
        return $this->dateTimeDeleted;
    }

    public function setDateTimeDeleted(?\DateTimeImmutable $dateTimeDeleted): static
    {
        $this->dateTimeDeleted = $dateTimeDeleted;

        return $this;
    }


}
