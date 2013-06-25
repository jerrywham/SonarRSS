<?php
/**
 * @author bronco@warriordudimanche.com
 * @copyright open source 
 * @version 0.1
 * @web warriordudimanche.net
 */
function cache_read($fichier,$path=''){  if (!is_dir($path.'temp/')){mkdir ($path.'temp');return false;}if (file_exists($path.'temp/'.$fichier)&&!cache_is_obsolete($fichier)){$donnees=file_get_contents($path.'temp/'.$fichier);if ($donnees2=@unserialize($donnees)){$donnees=$donnees2;}return $donnees; }else{return false;}}
function cache_write($fichier,$donnees,$duree){ if (!is_dir('temp/')){mkdir ('temp');}if (is_array($donnees)){$donnees=serialize($donnees);}file_put_contents('temp/'.$fichier,$donnees);if ($duree!=0){$duree=@date('U')+(60*$duree);}touch('temp/'.$fichier,$duree);}
function cache_clear(){ if (!is_dir('temp/')){mkdir ('temp');return false;}$fs=glob('temp/*');foreach ($fs as $file){unlink ($file);}}
function cache_is_obsolete($fichier){$dat=@filemtime('temp/'.$fichier);if (!file_exists('temp/'.$fichier)){return true;} if ($dat==0){return false;} if ($dat<@date('U')){cache_delete($fichier);return true;}return false;}
function cache_delete($fichier){if (file_exists('temp/'.$fichier)){unlink ('temp/'.$fichier);}}
function cache_start(){ob_start();}
function cache_end($fichier,$duree){$donnees=ob_get_clean();cache_write($fichier,$donnees,$duree);return $donnees;}
?>