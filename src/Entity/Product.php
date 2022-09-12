<?php

namespace App\Entity;

use App\Helper\Interface\AuthorInterface;
use App\Repository\ProductRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements AuthorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'eatingProduct', targetEntity: PersonalCheck::class)]
    private Collection $personalCheckProducts;

    #[ORM\ManyToOne(inversedBy: 'productsWhoAuthor')]
    private ?User $whoAuthor = null;

    public function __construct()
    {
        $this->personalCheckProducts = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
    public function getPersonalCheckProducts(): Collection
    {
        return $this->personalCheckProducts;
    }

    public function addPersonalCheckProduct(PersonalCheck $personalCheckProduct): self
    {
        if (!$this->personalCheckProducts->contains($personalCheckProduct)) {
            $this->personalCheckProducts->add($personalCheckProduct);
            $personalCheckProduct->setEatingProduct($this);
        }

        return $this;
    }

    public function removePersonalCheckProduct(PersonalCheck $personalCheckProduct): self
    {
        if ($this->personalCheckProducts->removeElement($personalCheckProduct)) {
            // set the owning side to null (unless already changed)
            if ($personalCheckProduct->getEatingProduct() === $this) {
                $personalCheckProduct->setEatingProduct(null);
            }
        }

        return $this;
    }
}