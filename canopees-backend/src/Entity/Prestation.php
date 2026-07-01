<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(), 
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['prestation:read']],
    denormalizationContext: ['groups' => ['prestation:write']]
)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['prestation:read', 'oeuvre:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['prestation:read', 'prestation:write', 'oeuvre:read'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['prestation:read', 'prestation:write'])]
    private ?string $contenuDetaille = null;

    #[ORM\OneToMany(targetEntity: Oeuvre::class, mappedBy: 'prestation')]
    #[Groups(['prestation:read'])] 
    private Collection $oeuvres;

    #[ORM\OneToMany(targetEntity: DemandeDevis::class, mappedBy: 'prestation')]
    private Collection $demandesDevis;

    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
        $this->demandesDevis = new ArrayCollection();
    }

    
    public function getId(): ?int { return $this->id; }
    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(string $titre): static { $this->titre = $titre; return $this; }
    public function getContenuDetaille(): ?string { return $this->contenuDetaille; }
    public function setContenuDetaille(string $contenuDetaille): static { $this->contenuDetaille = $contenuDetaille; return $this; }
    
    /** @return Collection<int, Oeuvre> */
    public function getOeuvres(): Collection { return $this->oeuvres; }

    public function addOeuvre(Oeuvre $oeuvre): static
    {
        if (!$this->oeuvres->contains($oeuvre)) {
            $this->oeuvres->add($oeuvre);
            $oeuvre->setPrestation($this);
        }
        return $this;
    }

    public function removeOeuvre(Oeuvre $oeuvre): static
    {
        if ($this->oeuvres->removeElement($oeuvre)) {
            if ($oeuvre->getPrestation() === $this) {
                $oeuvre->setPrestation(null);
            }
        }
        return $this;
    }

    
}