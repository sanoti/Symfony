<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\CheckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CheckRepository::class)]
#[ORM\Table(name: '`check`')]
class Check implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $store = null;

    #[ORM\ManyToOne(inversedBy: 'checks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Guest $byingGuest = null;

    #[ORM\ManyToOne(inversedBy: 'checksWhoAuthor')]
    private ?User $whoAuthor = null;

    #[ORM\OneToMany(mappedBy: 'fromCheck', targetEntity: PersonalCheck::class)]
    private Collection $personalChecks;

    public function __construct()
    {
        $this->personalChecks = new ArrayCollection();
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

    public function getStore(): ?string
    {
        return $this->store;
    }

    public function setStore(string $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getByingGuest(): ?Guest
    {
        return $this->byingGuest;
    }

    public function setByingGuest(?Guest $byingGuest): self
    {
        $this->byingGuest = $byingGuest;

        return $this;
    }



    public function __toString(): string
    {
        return $this->getid();
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
     * @return Collection<int, PersonalCheck>
     */
    public function getPersonalChecks(): Collection
    {
        return $this->personalChecks;
    }

    public function addPersonalCheck(PersonalCheck $personalCheck): self
    {
        if (!$this->personalChecks->contains($personalCheck)) {
            $this->personalChecks->add($personalCheck);
            $personalCheck->setFromCheck($this);
        }

        return $this;
    }

    public function removePersonalCheck(PersonalCheck $personalCheck): self
    {
        if ($this->personalChecks->removeElement($personalCheck)) {
            // set the owning side to null (unless already changed)
            if ($personalCheck->getFromCheck() === $this) {
                $personalCheck->setFromCheck(null);
            }
        }

        return $this;
    }
}
