<?php

namespace App\Enum;

/**
 * Statuts des contributions (brand book, section 8.6).
 *
 * Signalement : Signalé → Pris en charge → Intervention prévue → Résolu
 * Idée        : Proposé → À l'étude → Réponse apportée
 */
enum StatutContribution: string
{
    // Parcours signalement
    case SIGNALE = 'signale';
    case PRIS_EN_CHARGE = 'pris_en_charge';
    case INTERVENTION_PREVUE = 'intervention_prevue';
    case RESOLU = 'resolu';

    // Parcours idée / besoin
    case PROPOSE = 'propose';
    case A_L_ETUDE = 'a_l_etude';
    case REPONSE_APPORTEE = 'reponse_apportee';

    /** Libellé affiché dans l'interface (toujours accompagné d'un picto + couleur). */
    public function libelle(): string
    {
        return match ($this) {
            self::SIGNALE => 'Signalé',
            self::PRIS_EN_CHARGE => 'Pris en charge',
            self::INTERVENTION_PREVUE => 'Intervention prévue',
            self::RESOLU => 'Résolu',
            self::PROPOSE => 'Proposé',
            self::A_L_ETUDE => 'À l\'étude',
            self::REPONSE_APPORTEE => 'Réponse apportée',
        };
    }

    /** Statut de départ selon le type de contribution. */
    public static function initial(TypeContribution $type): self
    {
        return match ($type) {
            TypeContribution::SIGNALEMENT => self::SIGNALE,
            TypeContribution::IDEE => self::PROPOSE,
        };
    }

    /** Étape suivante du parcours, ou null si c'est la dernière. */
    public function suivant(): ?self
    {
        return match ($this) {
            self::SIGNALE => self::PRIS_EN_CHARGE,
            self::PRIS_EN_CHARGE => self::INTERVENTION_PREVUE,
            self::INTERVENTION_PREVUE => self::RESOLU,
            self::PROPOSE => self::A_L_ETUDE,
            self::A_L_ETUDE => self::REPONSE_APPORTEE,
            self::RESOLU, self::REPONSE_APPORTEE => null,
        };
    }

    /** On ne peut avancer que d'une étape à la fois, dans le bon parcours. */
    public function peutPasserA(self $nouveau): bool
    {
        return $this->suivant() === $nouveau;
    }
}
