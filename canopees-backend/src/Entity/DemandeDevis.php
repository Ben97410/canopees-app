<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DemandeDevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeDevisRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
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
    #[ORM\JoinColumn(nullable: true)]
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

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $prenom = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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

    public function getOuvrier(): ?Ouvrier
    {
        return $this->ouvrier;
    }

    public function setOuvrier(?Ouvrier $ouvrier): static
    {
        $this->ouvrier = $ouvrier;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }


    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
}