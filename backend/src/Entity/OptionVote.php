<?php

namespace App\Entity;

use App\Repository\OptionVoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Un des choix proposés dans une consultation (ex. « Option A : piste cyclable »).
 * Créée via Consultation::ajouterOption().
 */
#[ORM\Entity(repositoryClass: OptionVoteRepository::class)]
class OptionVote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'options')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Consultation $consultation;

    #[ORM\Column(length: 255)]
    private string $libelle;

    /** @var Collection<int, Vote> */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'option')]
    private Collection $votes;

    public function __construct(Consultation $consultation, string $libelle)
    {
        $this->consultation = $consultation;
        $this->libelle = $libelle;
        $this->votes = new ArrayCollection();
    }

    public function getNombreVotes(): int
    {
        return $this->votes->count();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsultation(): Consultation
    {
        return $this->consultation;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    /** @return Collection<int, Vote> */
    public function getVotes(): Collection
    {
        return $this->votes;
    }
}
