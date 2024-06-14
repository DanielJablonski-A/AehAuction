<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuctionRepository::class)]
class Auction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuctionsCategories $auctionCategory = null;

    #[ORM\Column(length: 80)]
    private ?string $title = null;

    #[ORM\Column(length: 40)]
    private ?string $productState = null;

    #[ORM\Column(length: 100)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isCompany = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?string $quantityType = null;

    #[ORM\Column]
    private ?int $auctionDuration = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $auctionBuyNowPriceNet = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $auctionBidStartPriceNet = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Courier $courier = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $courierPrePaymentPriceNet = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $courierAfterDeliveryPaymentPriceNet = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(length: 20)]
    private ?\DateTimeImmutable $dateTimeAdd = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?\DateTimeImmutable $dateTimeModify = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?\DateTimeImmutable $dateTimeDeleted = null;

    /**
     * @var bool Non-persisted property to help determine if the auction is owned by the authenticated user
     */
    //private bool $isOwnedByAuthenticatedUser = false;

    public function __construct(User $owner, AuctionsCategories $auctionCategory, int $auctionBidStartPriceNet, int $auctionDuration, bool $isCompany, string $productState)
    {
        $this->owner = $owner;
        $this->auctionCategory = $auctionCategory;
        $this->auctionBidStartPriceNet = $auctionBidStartPriceNet;
        $this->auctionDuration = $auctionDuration;
        $this->isCompany = $isCompany;
        $this->productState = $productState;

        $this->dateTimeAdd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getProductState(): ?string
    {
        return $this->productState;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsCompany(): ?bool
    {
        return $this->isCompany;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantityType(): ?string
    {
        return $this->quantityType;
    }

    public function setQuantityType(string $quantityType): static
    {
        $this->quantityType = $quantityType;

        return $this;
    }

    public function getAuctionDuration(): ?int
    {
        return $this->auctionDuration;
    }

    public function getAuctionBuyNowPriceNet(): ?int
    {
        return $this->auctionBuyNowPriceNet;
    }

    public function setAuctionBuyNowPriceNet(int $auctionBuyNowPriceNet): static
    {
        $this->auctionBuyNowPriceNet = $auctionBuyNowPriceNet;

        return $this;
    }

    public function getAuctionBidStartPriceNet(): ?int
    {
        return $this->auctionBidStartPriceNet;
    }

    public function getAuctionCategory(): ?AuctionsCategories
    {
        return $this->auctionCategory;
    }

    public function getCourier(): Courier
    {
        return $this->courier;
    }

    public function setCourier(?Courier $courier): void
    {
        $this->courier = $courier;
    }

    public function getCourierPrePaymentPriceNet(): ?int
    {
        return $this->courierPrePaymentPriceNet;
    }

    public function setCourierPrePaymentPriceNet(?int $courierPrePaymentPriceNet): void
    {
        $this->courierPrePaymentPriceNet = $courierPrePaymentPriceNet;
    }

    public function getCourierAfterDeliveryPaymentPriceNet(): ?int
    {
        return $this->courierAfterDeliveryPaymentPriceNet;
    }

    public function setCourierAfterDeliveryPaymentPriceNet(?int $courierAfterDeliveryPaymentPriceNet): void
    {
        $this->courierAfterDeliveryPaymentPriceNet = $courierAfterDeliveryPaymentPriceNet;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function getDateTimeModify(): ?\DateTimeImmutable
    {
        return $this->dateTimeModify;
    }

    public function setDateTimeModify(\DateTimeImmutable $dateTimeModify): static
    {
        $this->dateTimeModify = $dateTimeModify;

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
