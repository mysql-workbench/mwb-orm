<?php

namespace Mwb\Orm;

use Mwb\Orm\Entity;
use Mwb\Grt\Db\ForeignKey;

class Relation {
	const MANY_TO_MANY = 'ManyToMany';
	const MANY_TO_ONE  = 'ManyToOne';
	const ONE_TO_ONE   = 'OneToOne';
	const ONE_TO_MANY  = 'OneToMany';

	public ?string $type  = Null;

	public ?Entity $referencingEntity = Null;
	public ?Entity $referencedEntity  = Null;
	//public ?Entity $referencedProperty  = Null;
	//public ?Entity $referencedProperty  = Null;

	public ?ForeignKey $foreignKey = Null;// ->referencedTable

	public function __construct(string $type) {
		if (in_array($type, [self::MANY_TO_MANY, self::ONE_TO_MANY, self::MANY_TO_ONE, self::ONE_TO_ONE])) {
			$this->type = $type;
		}
	}
	public function setReferencingEntity(?Entity $referencingEntity) {
		$this->referencingEntity = $referencingEntity;
	}
	public function setReferencedEntity(?Entity $referencedEntity) {
		$this->referencedEntity = $referencedEntity;
	}
}


// relation: ManyToOne, OneToManu, ManyToManu, OneToOne
// owner: parent|child|orphan
// key: isole-unique|adoptable|sharable
// display: visible|hidden
// Unique, Shared, and Weak
/*

[1] Relation ownership (95% des cas)
  [A] owned : Le parent possède l'enfant
      - suppression automatique
      - cascade persist/remove
      - OneToMany pi OneToOne
      (ex: OrderItem, InvoiceLine, Photo profil)
  [B] shared : ressource partagé - Plusieurs ressource peuvent pointer vers la meme
    - ManyToMany | ManyToMany
    - pas de cascade sur remove
    - entité autonome
    (ex: Tag, adresse réutilissable, Catégorie, Produit lié a plusieur panier)
  [C] Referenced : reference qui n'implique pas de possession
    - nullable
    - aucune cascade
    - aucune suppression automatique
    - pas d'effet sur le cycle de vie
    (Dernier utilisateur qui a modifier un document, reference vers un parent optionel, auteur d'un commentaire)
[2] Agregat (DDD-light) - Permet d'exprimer qu'un groupe d'entité fonctionne comme une unité transactionnel
    tu ajoute un flag
      - aggregate_root : true/false
    - Et dans un agrega :
      - owned = entité interns
      - shared/referenced = entité externe
  (ex: Commande, factures, dossiers, comptes clients)
[3] Cardinalité (1,,optionel, requis)
   - one_to_one
   - one_to_many
   - many_to_one
   - many_to_many
      - nullable: true/false
      - unique: true/false
  (indispensable pour exprimer toutes les relation valide)

[4] Relation temporaire (rare 0.1% mais critique)
   - historique de possession
   - versionning metier
   - validité temporraire
   Representation:
   - relation : temporal
   - valid_from : date_time
   - valid_to : datetime
  ( Ex: Une addresse qui appartient a un user de 2020 à 2023
        Une equipe projet avec des membres sur differentes périodes
        Un abonnement avec une periode

[5] Relation polymorphe (rare 0.1%)
  - commentaires liés a plusieurs types d'entité
  - Fichier attaché a plusieurs type d'object

  - relation: polymorphic
  - targets
     - post
     - video
     - product


Avec ces 5 concept :
  - relation doctrine
  - gestion du cycle de vie
  - strategie de suppression
  - regle de cascade
  - contrainte SQL
  - logique metier coherente
  - API/DTO coherent


{
	relations: {
		profile: {
			type: owned,
			cardinality: one_to_many,
			target: Profil,
			orphanRemoval: true,
		}
		Addresses : {
			type: shared,
			cardinality: one_to_many,
			target: Address
		}
	}
}

// ============================================
DSL :

entities:
	EntityName:
		aggregate_root: true|false
		table : custom_table_name (optional)
		fields :
			fieldName :
				type: string|int|float|bool|datetime|text|json|uuid
				nullable: true|false
				unique: true|false
				default: value
		relations :
			relationName :
				type: owned|shared|referenced|polimorphic|temporal
				cardinality: one_to_one|one_to_many|many_to_one|many_to_many
				target: EntityName
				mappedBy: fieldName (optional)
				inversedBy: fieldName (optional)
				nullable: true|false
				orphan_removal: true|false
				cascade:
					- persist
					- remove
					- update
			temporal :
				start_field: valid_from (optional)
				end_field: valid_to (optional)
			polymorphic :
				target:
					- EntityA
					- EntityB
					- EntityC


*/

