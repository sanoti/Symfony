<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $sum = null;

    #[ORM\ManyToOne(inversedBy: 'incomingPayments')]
    private ?Guest $fromGuest = null;

    #[ORM\ManyToOne(inversedBy: 'outcommingPayments')]
    private ?Guest $toGuest = null;

    #[ORM\ManyToOne(inversedBy: 'paymentWhoAuthor')]
    private ?User $whoAuthor = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getFromGuest(): ?Guest
    {
        return $this->fromGuest;
    }

    public function setFromGuest(?Guest $fromGuest): self
    {
        $this->fromGuest = $fromGuest;

        return $this;
    }

    public function getToGuest(): ?Guest
    {
        return $this->toGuest;
    }

    public function setToGuest(?Guest $toGuest): self
    {
        $this->toGuest = $toGuest;

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
