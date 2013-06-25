<?php
if (is_file('system/tabs.cfg')){$onglet=unstore('system/tabs.cfg');}else{$onglet=array();}
if (isset($_GET['rss'])&&isset($onglet[$_GET['rss']])){ // flux rss global de l'onglet 
    	$feeds=$onglet[$_GET['rss']]['feeds'];
    	$title=$onglet[$_GET['rss']]['titre'];
    	$numonglet=$_GET['rss'];
    	include 'system/funnel.php';
    	exit();
}
require("system/auto_restrict.php");
require("system/system.php");
//if (is_file('system/config.cfg')){$config=unstore('system/config.cfg');}else{$config=array();}
if (is_file('system/lang/'.LANGUAGE.'.php')){include('system/lang/'.LANGUAGE.'.php');}else{$lang=array();}

# FONCTIONS
function aff($a,$stop=true){echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';var_dump($a);echo '</pre>';if ($stop){exit();}}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
function BodyClasses(){$regex='#(msie)[/ ]([0-9])+|(firefox)/([0-9])+|(chrome)/([0-9])+|(opera)/([0-9]+)|(safari)/([0-9]+)|(android)|(iphone)|(ipad)|(blackberry)|(Windows Phone)|(symbian)|(mobile)|(bada])#i';preg_match($regex,$_SERVER['HTTP_USER_AGENT'],$resultat);echo ' class="'.preg_replace('#([a-zA-Z ]+)[ /]([0-9]+)#','$1 $1$2',$resultat[0]).' '.basename($_SERVER['PHP_SELF'],'.php').'" ';}
if (!function_exists('xss')){function xss($chaine){return stripslashes(htmlentities($chaine, ENT_QUOTES, 'UTF-8'));}}
function msg($m){global $lang;if(isset($lang[$m])){return stripslashes($lang[$m]);}else{return stripslashes($m);}}

# TEMPLATES
$tpl=array();
$tpl['invoque_widget']='<div class="widget" id="#ID"><script>$("##ID").load("system/charge_flux.php?tab=#TAB&url=#URL&id=#ID&feed=#KEY&color=#COLOR&filteryes=#FILTERYES&filterno=#FILTERNO");</script></div>';
//if (!isset($_GET['public'])){require("system/auto_restrict.php");} // on verrouille si ce n'est pas la page publique 
    /* GESTION DES PARAMETRES GET*/
    if (isset($_GET['tab'])){$onglet_selectionne=$_GET['tab'];}	else {$temp=each($onglet);$onglet_selectionne=$temp['key'];unset($temp);}	
    if (isset($_GET['discotime'])){log_user('disco','time');}	
    if (isset($_GET['deltab'])&&isset($onglet[$_GET['deltab']])){
    	unset($onglet[$_GET['deltab']]);
    	unlink('feeds_content/'.$_GET['deltab']);
		store('system/tabs.cfg',$onglet);
		header('location: index.php');
	}
  

    /* GESTION DES PARAMETRES POST*/
    if (count($_POST)>0){
    	if (isset($_POST['newtab'])&&$_POST['newtab']!=''){ 
    		//création du tab,
    		$id=uniqid(); 
    		$onglet[$id]['titre']=$_POST['newtab'];
    		$onglet[$id]['feeds']=array();
    		//$onglet=natcasesort($onglet);

    		store('system/tabs.cfg',$onglet);
    		// redirection vers ce tab
    		header('location: index.php?tab='.$id);
    	}

    	if (isset($_POST['newfeed'])&&$_POST['newfeed']!=''){  	
    		//ajout du flux à l'onglet courant,
    		if (!array_search($_POST['newfeed'],$onglet[$onglet_selectionne]['feeds'])){
	    		$onglet[$onglet_selectionne]['feeds'][]=$_POST['newfeed'];
	    		store('system/tabs.cfg',$onglet);    		
    		}
    	}

		if (isset($_POST['id'])&&$_POST['id']!=''){ 
			//modif de la config d'un onglet
		
		    $temp=array();
		    $id=$_POST['id'];unset($_POST['id']);
		    $temp['titre']=	xss($_POST['titre']);unset($_POST['titre']);
		    $temp['positive_filter']=xss($_POST['positive_filter']);unset($_POST['positive_filter']);
		    $temp['negative_filter']=xss($_POST['negative_filter']);unset($_POST['negative_filter']);
		    foreach($_POST as $key=>$val){
		    		if (!is_string($key)){$temp['feeds'][$key]=$_POST[$key];}
		    		elseif (strpos($key,'color')){ $temp['colors'][(integer)$key]=$_POST[$key];}
		    }
		    $onglet[$id]=$temp;
			store('system/tabs.cfg',$onglet);
		}


    }

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head >
		<title><?php echo APP_TITLE.' : '.xss($onglet[$onglet_selectionne]['titre']);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="design/img/favicon.png" />
		<script src="system/jquery.js"></script>
		<link type="application/rss+xml" rel="alternate" title="RSS 2.0 - Articles Résumés" href="?rss=<?php echo $onglet_selectionne;?>" />
		 <!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->
		 <?php include('design/auto_css.php'); ?>
		 <link rel="stylesheet" type="text/css" href="<?php 
			// mediaqueries adaptées au nb de flux de l'onglet
			$nb=count($onglet[$onglet_selectionne]['feeds']);
			if($nb==1){echo 'design/mediaqueries_1.css';}
			elseif ($nb==2){echo 'design/mediaqueries_2.css';}
			elseif($nb%2==0){echo 'design/mediaqueries_4.css';}
			elseif($nb%3==0){echo 'design/mediaqueries_3.css';}
			else{echo 'design/mediaqueries_4.css';}

		?>"  media="screen" />

	</head>
	<body <?php BodyClasses(); ?>>
			<header><a href="index.php" title="<?php echo msg('An ultra minimalist NetVibes alternative');?>"><p class="logo"> </p></a>
				<nav> 
					<ul>
						<?php 
							foreach($onglet as $key=>$val){
								if ($onglet_selectionne==$key){$active='class="active"';}else{$active='';}
								echo '<li '.$active.'><a href="index.php?tab='.$key.'">'.xss($val['titre']).'</a></li>';
							} 
						?>
					</ul>
					<ul class="toolbar nomobile">
						<li  class="add_feed" title="<?php echo msg('Add a feed to this tab');?>">&#9660; <form method="post" action="index.php?tab=<?php echo $onglet_selectionne;?>"><input type="text" name="newfeed" placeholder="<?php echo msg("Feed's URL");?>" required="required"/><input type="hidden" value="<?php echo $onglet_selectionne;?>" name="tab"/><input type="submit"/></form></li>
						<li  class="add_tab" title="<?php echo msg('Add a tab');?>">&#9713; <form method="post" action="index.php"><input type="text" name="newtab" placeholder="<?php echo msg("Tab's title");?>" required="required"/><input type="hidden" value="<?php echo $onglet_selectionne;?>" name="tab"/><input type="submit"/></form></li>
						<li class="close" title="<?php echo msg('Delete this tab');?> <?php echo $onglet[$onglet_selectionne]['titre'];?>" data-nb="<?php echo $onglet_selectionne;?>">&#10006;</li>
					</ul>
				</nav>
			</header>