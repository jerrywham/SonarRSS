<?php
require("system.php");
function store($file,$datas){file_put_contents($file,gzdeflate(json_encode($datas)));}
function unstore($file){return json_decode(gzinflate(file_get_contents($file)),true);}
function aff($a,$stop=true){echo 'Arret a la ligne '.__LINE__.' du fichier '.__FILE__.'<pre>';var_dump($a);echo '</pre>';if ($stop){exit();}}

if (is_file('tabs.cfg')){$onglet=unstore('tabs.cfg');
	if (isset($_GET['delfeed'])&&isset($onglet[$_GET['tab']]['feeds'][$_GET['delfeed']])){
    	unset($onglet[$_GET['tab']]['feeds'][$_GET['delfeed']]);
		store('tabs.cfg',$onglet);
	}
}
?>