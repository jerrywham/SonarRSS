+:
on peut ouvrir ++ onglets dans des fenêtres séparées (+ pour moi)
on récupère le contenu par onglet
chaque widget est chargé via ajax individuellement
chaque onglet possède son propre flux rss qui agrège tous les flux qu'il contient: les items de chaque flux sont mélangés et classés par date.
configuration de la couleur de la barre de titre de chaque widget (flux)
possibilité d'appliquer des filtres positifs ou négatifs aux flux d'un onglet.
le colonnage entièrement autogéré: sonar'rss crée les colonnes en fonction du nb de flux dans l'onglet et des dimensions de la fenêtre.
chaque onglet peut filtrer les items de ses flux pour mettre en valeur ou atténuer les items en fonction de l'intérêt qu'il représente.

todo:

ajouter le filtrage des flux de l'onglet en mettant en valeur les flux positifs et en retrait les flux négatifs
mieux gérer le chargement des onglets en mettant les pages en cache pour afficher le contenu précédent de suite puis le mettre à jour après.
mieux gérer les balises optionnelles (author, comment etc)