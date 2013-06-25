Alternative à NetVibes pour la lecture de flux
Auteur: Bronco@warriordudimanche.net
licence: opensource & libre (laissez simplement un petit lien pour créditer mon boulot ^^ )

-gestion d'onglets (ajout et suppression, renommage)
-ajout, suppression, modification de widget/flux pour chaque onglet,
-Sonar'RSS cherche toujours à présenter les widgets de la façon la plus homogène et logique, en fonction du nombre de widgets de l'onglet et de la taille de la fenêtre...
-gestion du statut lu/ nonlu individuel (pour chaque item) et global (pour tout le widget/flux)
-customisation des couleurs de la barre de titre des widgets
-fold / unfold de la description de chaque item (individuelle sur clic dans la description et par widget via un bouton)
-raffraîchissement individuel des widgets
-chaque widget/flux est chargé en asynchrone, individuellement.
-la page de configuration permet d'ajouter des filtres aux onglets servant à augmenter ou diminuer la visibilité de certains items des widgets qui le composent:
-un filtre positif:les items contenant un des mots (séparés par une virgule) seront mis en valeur avec un fond vert
-un filtre négatif: les items contenant un des mots auront un fond rose et une opacité moindre
-Cette option permet par exemple de voir en priorité les flux qui parlent de toi ou, pour la récup de films de vacances, qui offrent du "1080" et de passer au second plan ceux qui ne proposent que des "sons LD" ou qualite R5" (je pense qu'on se comprend )
-J'ai de plus ajouté une option pour les flux shaarli: un lien répondre via shaarli qui permet d'ajouter l'item dans son propre shaarli pour y répondre ou compléter.
-J'ai réutilisé mon funnel pour proposer en plus un flux rss qui agrège tous les flux de chaque onglet: Le flux global de l'onglet se trouve en bas de page, à gauche.


TODO:
raffraîchissement périodique / cronjob
page publique
