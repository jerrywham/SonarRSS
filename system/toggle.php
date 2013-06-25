<?php
function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
function aff($a,$stop=true){echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';var_dump($a);echo '</pre>';if ($stop){exit();}}

if (isset($_GET['lien'])&&isset($_GET['flux'])&&$_GET['lien']!=''&&$_GET['flux']!=''){
	$filename='../feeds_content/'.$_GET['flux'];
	$index=$_GET['lien'];
	if (is_file($filename)){
		$contenu=unstore($filename);
		if($index=='allread'){
			foreach($contenu as $key=>$val){$contenu[$key]['status']='read';}
			store($filename, $contenu);
			echo '<em class="success">ok all read...</em>';
		}elseif($index=='allunread'){ 
			foreach($contenu as $key=>$val){$contenu[$key]['status']='unread';}
			store($filename, $contenu);
			echo '<em class="success">ok all unread...</em>';
		}else{
			if (isset($contenu[$index])){
				if ($contenu[$index]['status']=='read'){$contenu[$index]['status']='unread';}else{$contenu[$index]['status']='read';}
				store($filename, $contenu);
				echo '<em class="success">ok 1...</em>';
			}else{
				echo '<em class="error">Ce lien n\'existe pas dans la base</em>';
			}
		}	
	}else{
		echo '<em class="error">Ce flux n\'existe pas dans la base: '.$filename.'</em>';
	}
}else{echo '<em class="error">Erreur...</em>';}
?>