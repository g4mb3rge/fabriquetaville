<?php

namespace App\Entity;

use App\Enum\StatutProjet;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Projet de la Ville, souvent né d'un besoin citoyen retenu
 * (Besoin retenu → Projet → Consultation → Décision → Réalisation).
 */
#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** Besoin d'origine (facultatif : la Ville peut aussi créer un projet directement). */
    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Contribution $contributionOrigine = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un titre.')]
    #[Assert\Length(max: 150)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez décrire le projet.')]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Veuillez choisir un quartier.')]
    private ?Quartier $quartier = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(length: 30, enumType: StatutProjet::class)]
    private StatutProjet $statut = StatutProjet::PROJET_RETENU;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    /** @var Collection<int, Consultation> */
    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'projet', orphanRemoval: true)]
    private Collection $consultations;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->consultations = new ArrayCollection();
    }

    /** Crée un projet à partir d'un besoin retenu, en reprenant ses infos. */
    public static function depuisContribution(Contribution $contribution): self
    {
        $projet = new self();
        $projet->contributionOrigine = $contribution;
        $projet->titre = $contribution->getTitre();
        $projet->description = $contribution->getDescription();
        $projet->quartier = $contribution->getQuartier();
        $projet->latitude = $contribution->getLatitude();
        $projet->longitude = $contribution->getLongitude();

        return $projet;
    }

    public function changerStatut(StatutProjet $nouveau): void
    {
        if (!$this->statut->peutPasserA($nouveau)) {
            throw new \DomainException(sprintf(
                'Impossible de passer de « %s » à « %s ».',
                $this->statut->libelle(),
                $nouveau->libelle()
            ));
        }

        $this->statut = $nouveau;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContributionOrigine(): ?Contribution
    {
        return $this->contributionOrigine;
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

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(Quartier $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getStatut(): StatutProjet
    {
        return $this->statut;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /** @return Collection<int, Consultation> */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }
}
