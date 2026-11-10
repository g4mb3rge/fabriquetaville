<?php

namespace App\Entity;

use App\Enum\StatutContribution;
use App\Enum\TypeContribution;
use App\Repository\ContributionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Un signalement ou une idée déposé(e) par un habitant.
 * Correspond aux 5 étapes du formulaire (brand book, 8.7).
 */
#[ORM\Entity(repositoryClass: ContributionRepository::class)]
#[ORM\Index(columns: ['type'])]
#[ORM\Index(columns: ['statut'])]
class Contribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Étape 1 — Que souhaitez-vous faire ?
    #[ORM\Column(length: 20, enumType: TypeContribution::class)]
    private TypeContribution $type;

    // Étape 2 — Où ?
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner une adresse.')]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Veuillez placer la contribution sur la carte.')]
    #[Assert\Range(min: -90, max: 90)]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Veuillez placer la contribution sur la carte.')]
    #[Assert\Range(min: -180, max: 180)]
    private ?float $longitude = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Veuillez choisir un quartier.')]
    private ?Quartier $quartier = null;

    // Étape 3 — Expliquez-nous
    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un titre.')]
    #[Assert\Length(min: 5, max: 150, minMessage: 'Le titre doit faire au moins {{ limit }} caractères.')]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez décrire votre contribution.')]
    #[Assert\Length(max: 3000)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Veuillez choisir une catégorie.')]
    private ?Categorie $categorie = null;

    // Étape 4 — Ajouter une photo (facultatif) : on stocke le nom du fichier
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    // Suivi
    #[ORM\Column(length: 30, enumType: StatutContribution::class)]
    private StatutContribution $statut;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    /** @var Collection<int, Soutien> */
    #[ORM\OneToMany(targetEntity: Soutien::class, mappedBy: 'contribution', orphanRemoval: true)]
    private Collection $soutiens;

    /** @var Collection<int, HistoriqueStatut> */
    #[ORM\OneToMany(targetEntity: HistoriqueStatut::class, mappedBy: 'contribution', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private Collection $historique;

    /** @var Collection<int, ReponseOfficielle> */
    #[ORM\OneToMany(targetEntity: ReponseOfficielle::class, mappedBy: 'contribution', orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $reponses;

    public function __construct(TypeContribution $type)
    {
        $this->type = $type;
        $this->statut = StatutContribution::initial($type);
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
        $this->soutiens = new ArrayCollection();
        $this->historique = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    /**
     * Fait avancer la contribution dans son parcours et garde une trace
     * de qui a fait quoi et quand (transparence, brand book 8.6).
     */
    public function changerStatut(StatutContribution $nouveau, User $agent): void
    {
        if (!$this->statut->peutPasserA($nouveau)) {
            throw new \DomainException(sprintf(
                'Impossible de passer de « %s » à « %s ».',
                $this->statut->libelle(),
                $nouveau->libelle()
            ));
        }

        $this->historique->add(new HistoriqueStatut($this, $this->statut, $nouveau, $agent));
        $this->statut = $nouveau;
        $this->updatedAt = new \DateTimeImmutable();
    }

    /** Seules les idées peuvent être soutenues (les signalements ont un statut de traitement). */
    public function peutEtreSoutenue(): bool
    {
        return TypeContribution::IDEE === $this->type;
    }

    public function getNombreSoutiens(): int
    {
        return $this->soutiens->count();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): TypeContribution
    {
        return $this->type;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(Quartier $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatut(): StatutContribution
    {
        return $this->statut;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /** @return Collection<int, Soutien> */
    public function getSoutiens(): Collection
    {
        return $this->soutiens;
    }

    /** @return Collection<int, HistoriqueStatut> */
    public function getHistorique(): Collection
    {
        return $this->historique;
    }

    /** @return Collection<int, ReponseOfficielle> */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }
}
