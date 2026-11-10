# Spécifications fonctionnelles — Fabrique ta Ville

Résumé technique du brand book, à destination du développement.
**Le brand book reste la seule référence** : en cas de doute, c'est lui qui fait foi.

---

## 1. Concept

Trois dimensions + un principe transversal :

- **Exprimer** : signaler un problème ou proposer une idée
- **Soutenir** : appuyer les besoins partagés (« Je soutiens »)
- **Participer** : donner son avis / voter sur les projets
- **Suivre** (transversal) : voir ce que devient chaque contribution

Fil conducteur : *Besoin → Soutien collectif → Étude → Réponse → Projet → Consultation → Action*

## 2. Rôles

| Rôle | Description |
|------|-------------|
| Habitant (`ROLE_USER`) | Cœur de cible 15–25 ans, mais ouvert à tous les Rennais |
| Agent collectivité (`ROLE_AGENT`) | Services municipaux de Rennes |

## 3. Fonctionnalités du MVP

### Côté habitants
- Créer un compte et se connecter
- Signaler un problème (catégorie, localisation, description)
- Exprimer un besoin / proposer une idée
- Carte interactive des signalements, idées et projets
- Détail d'une contribution
- Soutenir un besoin existant (« Je soutiens »)
- Suivre le statut et l'avancement d'une contribution
- Consulter les réponses officielles de la Ville
- Données territoriales liées à certaines contributions
- Participer à une consultation / voter quand un besoin devient un projet

### Côté collectivité
- Espace de gestion simplifié
- Centraliser, consulter et filtrer les contributions
- Voir leur localisation
- Repérer les besoins les plus soutenus
- Consulter les données territoriales associées
- Modifier le statut des contributions
- Publier une réponse officielle visible par les habitants
- Lancer des consultations et suivre les projets

### Secondaire (si le temps le permet)
- Notifications lors de l'évolution d'une contribution

### Hors périmètre
- ❌ Commentaires et discussions publiques entre habitants
- ❌ Messagerie privée habitants / collectivité
- ❌ Points, badges, gamification

## 4. Statuts (section 8.6)

| Type | Parcours de statuts |
|------|---------------------|
| Signalement | Signalé → Pris en charge → Intervention prévue → Résolu |
| Idée / besoin | Proposé → À l'étude → Réponse apportée |
| Projet | Projet retenu → Consultation ouverte → Décision prise → En réalisation → Réalisé |

Le nombre de soutiens est affiché à part : **ce n'est pas un statut**.

Un statut s'affiche toujours avec **pictogramme + libellé + couleur** (jamais la couleur seule).

## 5. Catégories (exemples du brand book)

Mobilité, Espaces verts / Environnement, Accessibilité, Aménagement, Équipements,
Propreté, Énergie, Eau, Commerces et services, Culture, Sports, Vie locale et événements.

## 6. Formulaire de dépôt (5 étapes)

1. Que souhaitez-vous faire ? (Signaler un problème / Proposer une idée)
2. Où ? (localisation / adresse / carte)
3. Expliquez-nous (titre, description, catégorie)
4. Ajouter une photo (facultatif)
5. Vérifier et envoyer

Indicateur « Étape X sur 5 » toujours visible. Erreurs : champ identifié + message simple.

## 7. Carte de contribution

Catégorie · Titre · Quartier / localisation · Nombre de soutiens · Statut · Lien « Voir la proposition → »

## 8. Design system

### Couleurs principales
| Nom | Hex | Rôle |
|-----|-----|------|
| Corail | `#EE7253` | Identité, CTA primaire (texte noir), états actifs |
| Bleu clair | `#6CAEDB` | Structure, cartes, navigation secondaire, territoire |
| Jaune | `#FED140` | Accent rare : chiffres clés, surlignages |
| Noir | `#000000` | Textes, titres, pictos, contours |
| Blanc | `#FFFFFF` | Fonds (~60 % de l'interface) |

Répartition indicative : 60 % blanc · 20 % corail · 15 % bleu clair · 5 % jaune.
*« Le corail identifie, le bleu structure, le jaune attire et le noir informe. »*

### Couleurs fonctionnelles (statuts uniquement)
| Nom | Hex | Usage |
|-----|-----|-------|
| Bleu foncé | `#2563A6` | Pris en charge, traitement en cours |
| Orange ambré | `#B65A12` | À l'étude, intervention prévue |
| Vert | `#287A55` | Résolu, projet réalisé |
| Rouge | `#B83B46` | Erreur, alerte, action impossible |
| Gris moyen | `#667085` | Infos secondaires, états inactifs |

Badges : fond clair (opacité réduite) + texte de la couleur pleine.

### Typographie : DM Sans
- H1 / H2 : Bold 700
- H3, titres de cartes, boutons : SemiBold 600
- Texte courant, métadonnées : Regular 400
- Alignement à gauche, pas de texte justifié, pas de longs textes en majuscules

### Boutons
- **Primaire** : fond corail, texte noir — « Je propose une idée », « Je soutiens », « Je vote »
- **Secondaire** : contour noir, fond blanc — « Voir les détails », « Voir sur la carte »
- **Lien** : texte corail + flèche, sans encadré — « Voir la proposition → »
- **Tertiaire** : lien discret — « Retour », « Annuler »
- Toujours un verbe d'action explicite (« Envoyer mon signalement », pas « Validation »)

### Pictogrammes
Style linéaire (outline), trait noir homogène, pas de dégradé ni d'ombre, toujours accompagnés d'un libellé.

## 9. Navigation mobile

Barre basse : **Accueil · Carte · Participer · Suivi · Profil** (Participer mis en avant).
Accueil : 3 entrées principales — Proposer une idée · Signaler un problème · Découvrir les projets.

## 10. Messages de confirmation

- Soutien : « Votre soutien a été pris en compte. »
- Vote : « Votre vote a été enregistré. »
- Signalement : « Votre signalement a bien été envoyé. Vous pourrez suivre son évolution depuis votre espace. »
- Idée : « Votre idée a bien été envoyée. Vous pourrez suivre son évolution depuis votre espace. »

## 11. Datavisualisations

1. **Carte participative** — filtres : type, catégorie, quartier, statut, date
2. **Besoins les plus soutenus** — barres horizontales
3. **Que deviennent les contributions ?** — répartition par état d'avancement
4. **Données territoriales** — uniquement si un dataset réel les fournit

Chaque graphique : titre, période, unité, source. Données fictives marquées
**« Données de démonstration »**. Pas de 3D, pas de camembert surchargé.

## 12. Accessibilité

- Objectif minimum WCAG AA pour les contrastes
- Texte noir sur jaune, sur bleu clair et sur corail
- Jamais d'information transmise uniquement par la couleur
- Zones cliquables suffisamment grandes sur mobile
- Vocabulaire simple et constant (« Proposer une idée », pas « Soumettre une contribution citoyenne »)
