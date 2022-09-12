<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\PartyRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PrePersist;


#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Party implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAt = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToMany(targetEntity: Guest::class, mappedBy: 'parties')]
    private Collection $guests;

    #[ORM\ManyToOne(inversedBy: 'partiesWhoAuthor')]
    private ?User $whoAuthor = null;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }


//    public function doStuffOnPrePersist(LifecycleEventArgs $eventArgs): void
//    {
//        $this->dateAt = date_create_from_format(date('Y-m-d'), da);
//    }


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

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }



    public function getDateCall(): ?string
    {
        return $this->dateCall;
    }

    public function setDateCall(string $dateCall): self
    {
        $this->dateCall = $dateCall;

        return $this;
    }





    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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

    /**
     * @return Collection<int, Guest>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Guest $guest): self
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->addParty($this);
        }

        return $this;
    }

    public function removeGuest(Guest $guest): self
    {
        if ($this->guests->removeElement($guest)) {
            $guest->removeParty($this);
        }

        return $this;
    }
}
