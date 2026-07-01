<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\DemandeDevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeDevisRepository::class)]
#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(security: "is_granted('ROLE_ADMIN')"),
        new Post(), 
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            uriTemplate: '/clients/{client_id}/demandes_devis',
            uriVariables: [
                'client_id' => new Link(fromClass: Client::class, toProperty: 'client')
            ],
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['devis:read']],
    denormalizationContext: ['groups' => ['devis:write']]
)]
class DemandeDevis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['devis:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'demandesDevis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'demandesDevis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?Prestation $prestation = null;

    #[ORM\ManyToOne(targetEntity: Ouvrier::class, inversedBy: 'demandesDevis')]
    #[Groups(['devis:read', 'devis:write'])]
    private ?Ouvrier $ouvrier = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length(min: 10, max: 20)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $budget = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $message = null;

    // ... tes méthodes getters et setters restent identiques
    
    public function getId(): ?int { return $this->id; }
    public function getClient(): ?Client { return $this->client; }
    public function setClient(?Client $client): static { $this->client = $client; return $this; }
    // (Ajoute ici le reste de tes getters/setters...)
}