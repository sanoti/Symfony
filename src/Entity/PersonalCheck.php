<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\PersonalCheckRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalCheckRepository::class)]
class PersonalCheck implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecks')]
    private ?Check $fromCheck = null;

    #[ORM\ManyToOne(inversedBy: 'personalCheckProducts')]
    private ?Product $eatingProduct = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\ManyToOne(inversedBy: 'personalCheckGuests')]
    private ?Guest $guestWhoEat = null;

    #[ORM\ManyToOne(inversedBy: 'personalChecksWhoAuthor')]
    private ?User $whoAuthor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromCheck(): ?Check
    {
        return $this->fromCheck;
    }

    public function setFromCheck(?Check $fromCheck): self
    {
        $this->fromCheck = $fromCheck;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getEatingProduct(): ?Product
    {
        return $this->eatingProduct;
    }

    public function setEatingProduct(?Product $eatingProduct): self
    {
        $this->eatingProduct = $eatingProduct;

        return $this;
    }

    public function getGuestWhoEat(): ?Guest
    {
        return $this->guestWhoEat;
    }

    public function setGuestWhoEat(?Guest $guestWhoEat): self
    {
        $this->guestWhoEat = $guestWhoEat;

        return $this;
    }

    public function getWhoAuthor(): ?User
    {
        return $this->whoAuthor;
    }

    public function setWhoAuthor(?User $whoAuthor): self
    {
        $this->whoAuthor = $whoAuthor;

        return $this;
    }
}
