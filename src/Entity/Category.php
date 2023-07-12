<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Blag::class)]
    private Collection $blags;

    public function __construct()
    {
        $this->blags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Blag>
     */
    public function getBlags(): Collection
    {
        return $this->blags;
    }

    public function addBlag(Blag $blag): static
    {
        if (!$this->blags->contains($blag)) {
            $this->blags->add($blag);
            $blag->setCategory($this);
        }

        return $this;
    }

    public function removeBlag(Blag $blag): static
    {
        if ($this->blags->removeElement($blag)) {
            // set the owning side to null (unless already changed)
            if ($blag->getCategory() === $this) {
                $blag->setCategory(null);
            }
        }

        return $this;
    }
}
