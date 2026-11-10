<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Consultation lancée par la Ville sur un projet : une question + des options de vote.
 */
#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Projet $projet;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la question posée aux habitants.')]
    private ?string $question = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $dateOuverture;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\GreaterThan(propertyPath: 'dateOuverture', message: 'La date de fermeture doit être après la date d\'ouverture.')]
    private \DateTimeImmutable $dateFermeture;

    /** Décision retenue par la Ville, publiée après la consultation. */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $decision = null;

    /** @var Collection<int, OptionVote> */
    #[ORM\OneToMany(targetEntity: OptionVote::class, mappedBy: 'consultation', cascade: ['persist'], orphanRemoval: true)]
    private Collection $options;

    /** @var Collection<int, Vote> */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'consultation', orphanRemoval: true)]
    private Collection $votes;

    public function __construct(Projet $projet, \DateTimeImmutable $dateOuverture, \DateTimeImmutable $dateFermeture)
    {
        $this->projet = $projet;
        $this->dateOuverture = $dateOuverture;
        $this->dateFermeture = $dateFermeture;
        $this->options = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    /** On ne peut voter que pendant la période d'ouverture. */
    public function estOuverte(?\DateTimeImmutable $maintenant = null): bool
    {
        $maintenant ??= new \DateTimeImmutable();

        return $maintenant >= $this->dateOuverture && $maintenant < $this->dateFermeture;
    }

    public function ajouterOption(string $libelle): OptionVote
    {
        $option = new OptionVote($this, $libelle);
        $this->options->add($option);

        return $option;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjet(): Projet
    {
        return $this->projet;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getDateOuverture(): \DateTimeImmutable
    {
        return $this->dateOuverture;
    }

    public function getDateFermeture(): \DateTimeImmutable
    {
        return $this->dateFermeture;
    }

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(?string $decision): static
    {
        $this->decision = $decision;

        return $this;
    }

    /** @return Collection<int, OptionVote> */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /** @return Collection<int, Vote> */
    public function getVotes(): Collection
    {
        return $this->votes;
    }
}
