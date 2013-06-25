<?php
function xss($chaine){return stripslashes(htmlentities($chaine, ENT_QUOTES, 'UTF-8'));}

$lang=array(
	'Free and open source (please keep a link to warriordudimanche.net for the author ^^)'=> xss('Libre et open source, merci de laisser un lien vers warriordudimanche.net pour citer l\'auteur ;)'),
	'on GitHub'=>'sur GitHub',
	'save'=>'Sauvegarder',
	'reshaarlink this'=>xss('Répondre via shaarli'),
	'Filters'=>'Filtres',
	'feeds of '=>'Flux de ',
	'About '=>'A propos de ',
	'Add a feed to this tab'=> xss('Ajouter un flux à cet onglet'),
	"Feed's URL"=>'Adresse du flux',
	'Add a tab'=>'Ajouter un onglet',
	"Tab's title"=>"Titre de l'onglet",
	'Highlight feeds with those words'=>'Surligner les items contenant',
	'Exclude those words'=>'Diminuer les items contenant',
	'Delete this tab'=>"Supprimer l'onglet",
	'Close this feed'=>"Fermer ce flux",
	'There was a problem downloading the feed...'=>xss("Il y a eu un problème en téléchargeant le flux..."),
	'There was a problem accessing the feed...'=>xss("Il y a eu un problème d'accès au flux..."),
	'An ultra minimalist NetVibes alternative'=>xss("Une alternative minimaliste à Netvibes"),
	'Refresh this feed'=>xss("Raffraîchir ce flux"),
	'toggle read/unread state'=>xss("Changer l\'état lu/non lu"),
	'Click here to remove it'=>'Cliquer ici pour le supprimer',
	'Mark all as read'=>'Tout marquer comme lu',
	'Mark all as unread'=>'Tout marquer comme non lu',
	'Fold unfold all items'=>xss('Plier / déplier tous les items du widget'),
	'This tab\'s feed: all feeds in one...'=>'Le flux global de cet onglet: tous les flux en un ...',
	'widget\'s titlebar color'=>'Couleur de fond de la barre de titre du widget',
	
);
?>