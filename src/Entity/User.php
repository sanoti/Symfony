<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Guest::class)]
    private Collection $guestsWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Check::class)]
    private Collection $checksWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Product::class)]
    private Collection $productsWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Payment::class)]
    private Collection $paymentWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: Party::class)]
    private Collection $partiesWhoAuthor;

    #[ORM\OneToMany(mappedBy: 'whoUser', targetEntity: Guest::class)]
    private Collection $guestWhoUser;

    #[ORM\OneToMany(mappedBy: 'whoAuthor', targetEntity: PersonalCheck::class)]
    private Collection $personalChecksWhoAuthor;


    public function __construct()
    {
        $this->setRoles(['ROLE_USER']);
        $this->guestsWhoAuthor = new ArrayCollection();
        $this->checksWhoAuthor = new ArrayCollection();
        $this->productsWhoAuthor = new ArrayCollection();
        $this->paymentWhoAuthor = new ArrayCollection();
        $this->partiesWhoAuthor = new ArrayCollection();
        $this->guestWhoUser = new ArrayCollection();
        $this->personalChecksWhoAuthor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getEmail();
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuestsWhoAuthor(): Collection
    {
        return $this->guestsWhoAuthor;
    }

    public function addGuestsWhoAuthor(Guest $guestsWhoAuthor): self
    {
        if (!$this->guestsWhoAuthor->contains($guestsWhoAuthor)) {
            $this->guestsWhoAuthor->add($guestsWhoAuthor);
            $guestsWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeGuestsWhoAuthor(Guest $guestsWhoAuthor): self
    {
        if ($this->guestsWhoAuthor->removeElement($guestsWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($guestsWhoAuthor->getWhoAuthor() === $this) {
                $guestsWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }




    /**
     * @return Collection<int, Check>
     */
    public function getChecksWhoAuthor(): Collection
    {
        return $this->checksWhoAuthor;
    }

    public function addChecksWhoAuthor(Check $checksWhoAuthor): self
    {
        if (!$this->checksWhoAuthor->contains($checksWhoAuthor)) {
            $this->checksWhoAuthor->add($checksWhoAuthor);
            $checksWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeChecksWhoAuthor(Check $checksWhoAuthor): self
    {
        if ($this->checksWhoAuthor->removeElement($checksWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($checksWhoAuthor->getWhoAuthor() === $this) {
                $checksWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsWhoAuthor(): Collection
    {
        return $this->productsWhoAuthor;
    }

    public function addProductsWhoAuthor(Product $productsWhoAuthor): self
    {
        if (!$this->productsWhoAuthor->contains($productsWhoAuthor)) {
            $this->productsWhoAuthor->add($productsWhoAuthor);
            $productsWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removeProductsWhoAuthor(Product $productsWhoAuthor): self
    {
        if ($this->productsWhoAuthor->removeElement($productsWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($productsWhoAuthor->getWhoAuthor() === $this) {
                $productsWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPaymentWhoAuthor(): Collection
    {
        return $this->paymentWhoAuthor;
    }

    public function addPaymentWhoAuthor(Payment $paymentWhoAuthor): self
    {
        if (!$this->paymentWhoAuthor->contains($paymentWhoAuthor)) {
            $this->paymentWhoAuthor->add($paymentWhoAuthor);
            $paymentWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePaymentWhoAuthor(Payment $paymentWhoAuthor): self
    {
        if ($this->paymentWhoAuthor->removeElement($paymentWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($paymentWhoAuthor->getWhoAuthor() === $this) {
                $paymentWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getPartiesWhoAuthor(): Collection
    {
        return $this->partiesWhoAuthor;
    }

    public function addPartiesWhoAuthor(Party $partiesWhoAuthor): self
    {
        if (!$this->partiesWhoAuthor->contains($partiesWhoAuthor)) {
            $this->partiesWhoAuthor->add($partiesWhoAuthor);
            $partiesWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePartiesWhoAuthor(Party $partiesWhoAuthor): self
    {
        if ($this->partiesWhoAuthor->removeElement($partiesWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($partiesWhoAuthor->getWhoAuthor() === $this) {
                $partiesWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Guest>
     */
    public function getGuestWhoUser(): Collection
    {
        return $this->guestWhoUser;
    }

    public function addGuestWhoUser(Guest $guestWhoUser): self
    {
        if (!$this->guestWhoUser->contains($guestWhoUser)) {
            $this->guestWhoUser->add($guestWhoUser);
            $guestWhoUser->setWhoUser($this);
        }

        return $this;
    }

    public function removeGuestWhoUser(Guest $guestWhoUser): self
    {
        if ($this->guestWhoUser->removeElement($guestWhoUser)) {
            // set the owning side to null (unless already changed)
            if ($guestWhoUser->getWhoUser() === $this) {
                $guestWhoUser->setWhoUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalCheck>
     */
    public function getPersonalChecksWhoAuthor(): Collection
    {
        return $this->personalChecksWhoAuthor;
    }

    public function addPersonalChecksWhoAuthor(PersonalCheck $personalChecksWhoAuthor): self
    {
        if (!$this->personalChecksWhoAuthor->contains($personalChecksWhoAuthor)) {
            $this->personalChecksWhoAuthor->add($personalChecksWhoAuthor);
            $personalChecksWhoAuthor->setWhoAuthor($this);
        }

        return $this;
    }

    public function removePersonalChecksWhoAuthor(PersonalCheck $personalChecksWhoAuthor): self
    {
        if ($this->personalChecksWhoAuthor->removeElement($personalChecksWhoAuthor)) {
            // set the owning side to null (unless already changed)
            if ($personalChecksWhoAuthor->getWhoAuthor() === $this) {
                $personalChecksWhoAuthor->setWhoAuthor(null);
            }
        }

        return $this;
    }

}
