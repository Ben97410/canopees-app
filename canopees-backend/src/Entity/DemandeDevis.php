<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Admin\CreateDevisController;
use App\Repository\DemandeDevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeDevisRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['devis:read']]),
        new GetCollection(normalizationContext: ['groups' => ['devis:read']]),
        new Post(
            controller: CreateDevisController::class,
            denormalizationContext: ['groups' => ['devis:write']],
            
        ),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]
class DemandeDevis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['devis:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    #[Groups(['devis:read'])]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['devis:read', 'devis:write'])]
    #[Assert\NotNull(message: "La prestation est obligatoire.")]
    private ?Prestation $prestation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $budget = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?\DateTimeInterface $debutTravaux = null;


    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $message = null;

    #[ORM\ManyToOne]
    private ?Ouvrier $ouvrier = null;

    

    // --- Getters et Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): self
    {
        $this->prestation = $prestation;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDebutTravaux(): ?\DateTimeInterface
    {
        return $this->debutTravaux;
    }

    public function setDebutTravaux(?\DateTimeInterface $debutTravaux): self
    {
        $this->debutTravaux = $debutTravaux;

        return $this;
    }

    

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

}