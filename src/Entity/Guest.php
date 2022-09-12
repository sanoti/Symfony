<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\GuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: GuestRepository::class)]
class Guest implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\OneToMany(mappedBy: 'FromGuest', targetEntity: Payment::class)]
    private Collection $incomingPayments;

    #[ORM\OneToMany(mappedBy: 'toGuest', targetEntity: Payment::class)]
    private Collection $outcommingPayments;

    #[ORM\OneToMany(mappedBy: 'guestWhoEat', targetEntity: PersonalCheck::class)]
    private Collection $personalCheckGuests;

    #[ORM\ManyToMany(targetEntity: Party::class, inversedBy: 'guests')]
    private Collection $parties;

    #[ORM\ManyToOne(inversedBy: 'guestsWhoAuthor')]
    private ?User $whoAuthor = null;

    #[ORM\ManyToOne(inversedBy: 'guestWhoUser')]
    private ?User $whoUser = null;



    public function __construct()
    {
        $this->incomingPayments = new ArrayCollection();
        $this->outcommingPayments = new ArrayCollection();
        $this->personalCheckGuests = new ArrayCollection();
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getIncomingPayments(): Collection
    {
        return $this->incomingPayments;
    }

    public function addIncomingPayment(Payment $incomingPayment): self
    {
        if (!$this->incomingPayments->contains($incomingPayment)) {
            $this->incomingPayments->add($incomingPayment);
            $incomingPayment->setFromGuest($this);
        }

        return $this;
    }

    public function removeIncomingPayment(Payment $incomingPayment): self
    {
        if ($this->incomingPayments->removeElement($incomingPayment)) {
            // set the owning side to null (unless already changed)
            if ($incomingPayment->getFromGuest() === $this) {
                $incomingPayment->setFromGuest(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getOutcommingPayments(): Collection
    {
        return $this->outcommingPayments;
    }

    public function addOutcommingPayment(Payment $outcommingPayment): self
    {
        if (!$this->outcommingPayments->contains($outcommingPayment)) {
            $this->outcommingPayments->add($outcommingPayment);
            $outcommingPayment->setToGuest($this);
        }

        return $this;
    }

    public function removeOutcommingPayment(Payment $outcommingPayment): self
    {
        if ($this->outcommingPayments->removeElement($outcommingPayment)) {
            // set the owning side to null (unless already changed)
            if ($outcommingPayment->getToGuest() === $this) {
                $outcommingPayment->setToGuest(null);
            }
        }

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

    public function getWhoUser(): ?User
    {
        return $this->whoUser;
    }

    public function setWhoUser(?User $whoUser): self
    {
        $this->whoUser = $whoUser;

        return $this;
    }

    /**
     * @return Collection<int, PersonalCheck>
     */
    public function getPersonalCheckGuests(): Collection
    {
        return $this->personalCheckGuests;
    }

    public function addPersonalCheckGuest(PersonalCheck $personalCheckGuest): self
    {
        if (!$this->personalCheckGuests->contains($personalCheckGuest)) {
            $this->personalCheckGuests->add($personalCheckGuest);
            $personalCheckGuest->setGuestWhoEat($this);
        }

        return $this;
    }

    public function removePersonalCheckGuest(PersonalCheck $personalCheckGuest): self
    {
        if ($this->personalCheckGuests->removeElement($personalCheckGuest)) {
            // set the owning side to null (unless already changed)
            if ($personalCheckGuest->getGuestWhoEat() === $this) {
                $personalCheckGuest->setGuestWhoEat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        $this->parties->removeElement($party);

        return $this;
    }



}
