<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']]
)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read', 'devis:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 30, unique: true, nullable: true)]
    #[Groups(['client:read', 'devis:read'])]
    private ?string $numeroClient = null;

    #[ORM\OneToMany(targetEntity: DemandeDevis::class, mappedBy: 'client')]
    #[Groups(['client:read'])] 
    private Collection $demandesDevis;

    public function __construct()
    {
        $this->demandesDevis = new ArrayCollection();
    }

    public function generateNumeroClient(): void
    {
        if (null === $this->numeroClient) {
            $this->numeroClient = 'CLI-' . date('Y') . '-' . bin2hex(random_bytes(3));
        }
    }

    // Getters et Setters
    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom(): ?string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $telephone): self { $this->telephone = $telephone; return $this; }

    public function getNumeroClient(): ?string { return $this->numeroClient; }

    /**
     * @return Collection<int, DemandeDevis>
     */
    public function getDemandesDevis(): Collection { return $this->demandesDevis; }

    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}