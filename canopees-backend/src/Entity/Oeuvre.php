<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OeuvreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['oeuvre:read']],
    denormalizationContext: ['groups' => ['oeuvre:write']]
)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['oeuvre:read', 'prestation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['oeuvre:read', 'oeuvre:write', 'prestation:read'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['oeuvre:read', 'oeuvre:write', 'prestation:read'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Groups(['oeuvre:read', 'oeuvre:write', 'prestation:read'])]
    private ?int $numCarrousel = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['oeuvre:read', 'oeuvre:write'])]
    private ?Prestation $prestation = null;

    // --- Méthode virtuelle pour faciliter l'affichage dans React ---
    #[Groups(['prestation:read', 'oeuvre:read'])]
    public function getOeuvreImageApi(): ?string
    {
        return $this->image;
    }

    public function __toString(): string
    {
        return $this->titre ?? 'Oeuvre sans titre';
    }

    // --- Getters et Setters ---

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