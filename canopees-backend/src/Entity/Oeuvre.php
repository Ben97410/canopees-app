<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['oeuvre:read']]
)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['oeuvre:read', 'prestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['oeuvre:read', 'prestation:read'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Groups(['oeuvre:read', 'prestation:read'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['oeuvre:read', 'prestation:read'])]
    private ?int $numCarrousel = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['oeuvre:read'])]
    private ?Prestation $prestation = null;

    
    public function __toString(): string
    {
        return $this->titre ?? 'Oeuvre sans titre';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getNumCarrousel(): ?int
    {
        return $this->numCarrousel;
    }

    public function setNumCarrousel(int $numCarrousel): static
    {
        $this->numCarrousel = $numCarrousel;
        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): static
    {
        $this->prestation = $prestation;
        return $this;
    }
}