<?php require('system/header.php');?>


			<aside>
				<?php 
					foreach ($onglet[$onglet_selectionne]['feeds'] as $key=>$url){ 
						if(!is_string($key)){
							
							if (isset($onglet[$onglet_selectionne]['colors'][$key])){$color=$onglet[$onglet_selectionne]['colors'][$key];}else{$color='transparent';}
							echo str_replace(array('#URL','#ID','#TAB','#KEY','#COLOR','#FILTERYES','#FILTERNO'), array($url,sha1($url),$onglet_selectionne,$key,$color,$onglet[$onglet_selectionne]['positive_filter'],$onglet[$onglet_selectionne]['negative_filter']),$tpl['invoque_widget']);
						}
					}
				?>
			</aside>
<?php require('system/footer.php');
	