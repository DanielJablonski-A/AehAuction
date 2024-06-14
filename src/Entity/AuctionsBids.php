<?php

namespace App\Entity;

use App\Repository\AuctionsBidsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AuctionsBidsRepository::class)]
//#[ORM\Table(name: "auctions_bids")]
class AuctionsBids
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $currentBidPriceNet = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auction $auction = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateTimeAdd = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function __construct(Auction $auction, int $currentBidNet, User $owner)
    {
        $this->auction = $auction;
        $this->currentBidPriceNet = $currentBidNet;
        $this->owner = $owner;
        $this->dateTimeAdd = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentBidPriceNet(): ?int
    {
        return $this->currentBidPriceNet;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function getDateTimeAdd(): ?\DateTimeImmutable
    {
        return $this->dateTimeAdd;
    }
}
