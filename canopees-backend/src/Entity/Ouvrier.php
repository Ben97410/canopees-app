<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OuvrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OuvrierRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['ouvrier:read']],
    denormalizationContext: ['groups' => ['ouvrier:write']]
)]
class Ouvrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ouvrier:read', 'demande:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['ouvrier:read', 'ouvrier:write', 'demande:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['ouvrier:read', 'ouvrier:write', 'demande:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ouvrier:read', 'ouvrier:write'])]
    private ?string $role = null;

    #[ORM\OneToMany(targetEntity: DemandeDevis::class, mappedBy: 'ouvrier')]
    #[Groups(['ouvrier:read'])]
    private Collection $demandesDevis;

    public function __construct()
    {
        $this->demandesDevis = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getPrenom() . ' ' . $this->getNom() . ' (' . ($this->getRole() ?? 'Aucun rôle') . ')';
    }

    // --- Getters et Setters ---
    public function getId(): ?int { return $this->id; }
    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }
    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): static { $this->prenom = $prenom; return $this; }
    public function getRole(): ?string { return $this->role; }
    public function setRole(string $role): static { $this->role = $role; return $this; }

    /** @return Collection<int, DemandeDevis> */
    public function getDemandesDevis(): Collection { return $this->demandesDevis; }

    public function addDemandeDevi(DemandeDevis $demandeDevi): static
    {
        if (!$this->demandesDevis->contains($demandeDevi)) {
            $this->demandesDevis->add($demandeDevi);
            $demandeDevi->setOuvrier($this);
        }
        return $this;
    }

    public function removeDemandeDevi(DemandeDevis $demandeDevi): static
    {
        if ($this->demandesDevis->removeElement($demandeDevi)) {
            if ($demandeDevi->getOuvrier() === $this) {
                $demandeDevi->setOuvrier(null);
            }
        }
        return $this;
    }
}