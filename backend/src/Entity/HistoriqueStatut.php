<?php

namespace App\Entity;

use App\Enum\StatutContribution;
use App\Repository\HistoriqueStatutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trace de chaque changement de statut : sert à afficher la timeline
 * « Que devient ma contribution ? » côté habitant.
 * Créé uniquement via Contribution::changerStatut().
 */
#[ORM\Entity(repositoryClass: HistoriqueStatutRepository::class)]
class HistoriqueStatut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'historique')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Contribution $contribution;

    #[ORM\Column(length: 30, enumType: StatutContribution::class)]
    private StatutContribution $ancienStatut;

    #[ORM\Column(length: 30, enumType: StatutContribution::class)]
    private StatutContribution $nouveauStatut;

    /** Agent de la Ville qui a fait le changement. */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $agent;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Contribution $contribution,
        StatutContribution $ancienStatut,
        StatutContribution $nouveauStatut,
        User $agent,
    ) {
        $this->contribution = $contribution;
        $this->ancienStatut = $ancienStatut;
        $this->nouveauStatut = $nouveauStatut;
        $this->agent = $agent;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContribution(): Contribution
    {
        return $this->contribution;
    }

    public function getAncienStatut(): StatutContribution
    {
        return $this->ancienStatut;
    }

    public function getNouveauStatut(): StatutContribution
    {
        return $this->nouveauStatut;
    }

    public function getAgent(): User
    {
        return $this->agent;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
