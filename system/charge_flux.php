<?php
## TOUTE LA LISTE DE COURSES ^^
require("system.php");include('syndexport.php');
if (is_file('lang/'.LANGUAGE.'.php')){include('lang/'.LANGUAGE.'.php');}else{$lang=array();}
## LES FONCTIONS
register_shutdown_function('Timelimitexeeded');// détourner les erreurs fatales de chargement 
function Timelimitexeeded(){$error = error_get_last();if ($error['type'] === E_ERROR) {exit('<div class="error">'.$_GET['url'].'<br/>'.msg('There was a problem downloading the feed...').'<a href="'.$_GET['feed'].'">'.msg('Click here to remove it').'</a></div>');}}
function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
function aff($a,$stop=true,$line=__LINE__){echo 'Arret a la ligne '.$line.' du fichier '.__FILE__.'<pre>';var_dump($a);echo '</pre>';if ($stop){exit();}}
function logvar($a,$stop=true){ob_start(); echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';print_r($a);echo '</pre>';$t=ob_get_flush(); file_put_contents('debug_log.txt',$t,FILE_APPEND);if ($stop){exit();}}
function msg($m){global $lang;if(isset($lang[$m])){return stripslashes($lang[$m]);}else{return stripslashes($m);}}
function file_curl_contents($url){$ch = curl_init();curl_setopt($ch, CURLOPT_HEADER, 0);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  FALSE);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt($ch, CURLOPT_URL, $url);if (!ini_get("safe_mode") && !ini_get('open_basedir') ) {curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);}curl_setopt($ch, CURLOPT_MAXREDIRS, 10); $data = curl_exec($ch);curl_close($ch);return $data;}  
function get_favicon($url,$id){ 
	// récupère la favicon du site si possible et la stocke en local 
	// si elle n'est pas déjà sur le serveur, sinon, renvoie le chemin
	// vers la version locale
	$file='feeds_content/'.$id;
	$defaultfavicon='design/img/default_favicon.png';

	if ($url==''){return $defaultfavicon;}
	// ici, on récupère la base de l'url
	preg_match('#(https?://[^/]+)#',$url,$base_url);
	$base_url=$base_url[1];
	if (!is_file('../'.$file.'.png')&&!is_file('../'.$file.'.ico')){
		@$header=file_get_contents($base_url, NULL, NULL, 0, 3000);
		if ($header){
		if (preg_match('#<link.*?href=["\'](.*?(.ico|.png))[\?"\']#',$header,$r)>0){
				$fav=$r[1];
				$ext=$r[2];

				// favicon trouvée > on récupère et on sauve en local
				@$img=file_get_contents($fav);// chemin complet dans le link ?
				if(!$img){@$img=file_get_contents($base_url.'/'.$fav);}
				if ($img){ 
					file_put_contents('../'.$file.$ext,$img);return $file.$ext;
				}
			}else{
				// si on n'a rien trouvé, on cherche simplement à la racine du site.
				@$img=file_get_contents($base_url.'/favicon.png');$ext='.png';
				if(!$img){@$img=file_get_contents($base_url.'/favicon.ico');$ext='.ico';}
				if ($img){
					file_put_contents('../'.$file.$ext,$img);return $file.$ext;
				}
			}
		}
		// impossible de récupérer la favicon > icone par défaut
		return $defaultfavicon;
	}else{
		// si la favicon a déjà été trouvée et stockée, on la renvoie
		if (!is_file('../'.$file.'.png')){$file.='.ico';}else{$file.='.png';}
		return $file;
	}
}
function create_reshaarlink_if_needed($description,$title){
	if (stripos($description,'">permalink</a>' )){
		preg_match('#<a href="([^"]+)">permalink</a>#i',$description,$link);
		return '<p class="reshaarlink"><a target="_BLANK" href="'.MY_SHAARLI_URL.'?post='.urlencode($link[1]).'&title='.urlencode(msg('About ').$title).'&source=bookmarklet">'.msg('reshaarlink this').'</a>';

	}
}
function filters($positive,$negative,$content){
	if (empty($positive)&&empty($negative)||empty($content)){return false;}
	// filtre positif prioritaire sur le négatif
	$positive=str_replace(',','|',$positive);
	$negative=str_replace(',','|',$negative);
	if (!empty($positive)&&preg_match('#'.$positive.'#i',$content)){return 'filtreyes';}// contient des mots voulus ?
	elseif (!empty($negative)&&preg_match('#'.$negative.'#i',$content)){return 'filtreno';}// contient des mots pas voulus ?
	else{return '';}
}


## GESTION DU FLUX DEMANDE
//récupération du flux
$url_decode=urldecode($_GET['url']);
ini_set('display_errors', '0');// éviter l'apparition de l'erreur dans un widget
if (!$flux=file_curl_contents($url_decode)){exit('<div class="error">'.$url_decode.'<br/>'.msg('There was a problem accessing the feed...').' '.$flux.' <a href="'.$_GET['feed'].'">'.msg('Click here to remove it').'</a></div>'); }

$contenu=array();
$flux =new SyndExport($flux,false);
$contenu['infos']=$flux->exportInfos();
$contenu['items']=$flux->exportItems(-1);
ini_set('display_errors', '1');   
// fallback pour les infos inexistantes et éviter d'afficher des erreurs de noobs
if (!isset($contenu['infos']['description'])){$contenu['infos']['description']='';}
if (!isset($contenu['infos']['link'])){$link='';$contenu['infos']['link']=$url_decode;}else{$link=$contenu['infos']['link'];}
if (!isset($contenu['infos']['date'])&&isset($contenu['infos']['last'])){$contenu['infos']['date']=$contenu['infos']['last'];}
if (!isset($contenu['infos']['date'])){$contenu['infos']['date']='';}

if (!isset($_GET['feed'])){$feed='';}else{$feed=$_GET['feed'];}
$filename=$_GET['id'];
$favicon=get_favicon($url_decode,$filename);

if ($_GET['color']!=''){$color='style="background-color:'.$_GET['color'].'"';}else{$color='';}
if (isset($_GET['filterno'])&&$_GET['filterno']!=''){$filterno=urldecode($_GET['filterno']);}else{$filterno='';}
if (isset($_GET['filteryes'])&&$_GET['filteryes']!=''){$filteryes=urldecode($_GET['filteryes']);}else{$filteryes='';}
## LES TEMPLATES
$titre='<h1 '.$color.'><img class="favicon" src="'.$favicon.'"/><em class="mark_all_read" data-nb="'.$filename.'" title="'.msg('Mark all as read').'">#NB</em><a href="'.$contenu['infos']['link'].'" title="'.$contenu['infos']['description'].'">'.$contenu['infos']['title'].'</a> <button class="close nomobile" data-nb="'.$feed.'" title="'.msg('Close this feed').'"> </button><button class="refresh nomobile" data-nb="'.$url_decode.'" data-param="&color='.$_GET['color'].'&filteryes='.$filteryes.'&filterno='.$filterno.'" title="'.msg('Refresh this feed').'"> </button><button class="foldunfoldall nomobile" title="'.msg('Fold unfold all items').'"> </button><p style="clear:both"></p></h1>';
$tpl_item='<ul class="#STATUS" data-nb="#INDEX"><li class="titre"><button class="toggle" title="'.msg('toggle read/unread state').'"></button><a href="#URL" class="toggle" target="_blank">#TITRE</a></li><li class="description">#DESCRIPTION #MEDIA</li><li class="infos"><a href="#PERMALINK" alt="Guid info" >GUID</a> - #DATE</li></ul> ';


/* on traite le tableau de contenu 
pour obtenir un index unique représentatif 
de l'item (permet de gérer plus simplement
les items déjà présents dans la base)
*/
$new_contenu=array();

$nom_du_flux=$contenu['infos']['title'];
foreach($contenu['items'] as $item){
	// création du contenu normalisé
	if(!isset($item['date'])){$item['date']='';}
	$index=sha1($nom_du_flux.$item['link'].$item['date']);
	$new_contenu[$index]=$item;
	$new_contenu[$index]['status']='unread';
}

// récupération des flux précédents
$filename='../feeds_content/'.$filename;
if (is_file($filename)){$old_contenu=unstore($filename);}else{$old_contenu=array();}
if (!is_array($new_contenu)){$new_contenu=array();}	
if (!is_array($old_contenu)){$old_contenu=array();}	
// fuuuuuuuuusion ! (on ne garde que les NB_ITEM_MAX_PAR_FLUX plus récents)
$contenu=array_slice(array_merge($new_contenu,$old_contenu),-NB_ITEM_MAX_PAR_FLUX);
// on sauve le flux dans la base 
store($filename,$contenu);

/* on affiche le tableau dans le template */
$echo='';$c=0;
foreach($contenu as $key=>$item){
	// gestion des cas particuliers dans la structure
	if (!isset($item['description'])&&isset($item['content'])){$item['description']=$item['content'];}
	if (!isset($item['description'])){$item['description']='';}
	
	if (isset($item['media']['url'])){$media='<br/><a href="'.$item['media']['url'].'" alt="media link">'.basename($item['media']['url']).'</a>';}else{$media='';}

	$classes=$item['status'].' '.filters($filteryes,$filterno,$item['title'].$item['description']);
	$item['description']=$item['description'].create_reshaarlink_if_needed($item['description'],$item['title'].' ('.$nom_du_flux.')');

	$s=array('#URL','#TITRE','#DESCRIPTION','#DATE','#STATUS','#INDEX','#PERMALINK','#MEDIA');
	$d=array($item['link'],$item['title'],$item['description'],$item['date'],$classes,$key,$item['guid'],$media);
	$echo.=str_replace($s,$d,$tpl_item);
	if($item['status']=='unread'){$c++;}
}

echo str_replace('#NB',$c,$titre);
echo '<div class="scrollable">';
echo $echo;
echo '</div>';

?>