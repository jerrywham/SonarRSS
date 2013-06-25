<?php require('system/header.php');?>
			<aside>
			
					<?php 
						$coul=array('transparent','antiquewhite','aqua','aquamarine','beige','bisque','burlywood','cadetblue',
						'chartreuse','chocolate','coral','cornflowerblue','darkgray','darkkhaki','darkorange','darksalmon',
						'deepskyblue','fuchsia','gold','goldenrod','greenyellow','hotpink','indianred','lawngreen',
						'peachpuff','paleturquoise','palegreen','orchid','orangered','orange','peru','pink',
						'lime','mediumaquamarine','mediumorchid','mediumpurple','mediumseagreen','orange','lightsteelblue','lightskyblue',
						'lightgreen','lightpink','lightsalmon','lightseagreen',
						'yellow','yellowgreen','violet','turquoise');
						sort($coul);
						foreach($onglet as $key=>$feed){
							echo '<div class="widget" id="'.$feed['titre'].'"><h1>'.$feed['titre'].'</h1><div class="scrollable">';
								echo '<form name="config" action="config.php" method="POST">';
								echo '<input type="hidden" name="id" value="'.$key.'"/>';
								echo '<li><label for="titre_'.$key.$feed['titre'].'">'.msg("Tab's title").'</label><input type="text" id="titre_'.$key.$feed['titre'].'" name="titre" value="'.$feed['titre'].'"/></li>';
								echo '<fieldset><legend>'.msg('Filters').'</legend>';
								echo '<li><label for="include_'.$key.$feed['titre'].'">'.msg('Highlight feeds with those words').'</label><input type="text" id="include_'.$key.$feed['titre'].'" name="positive_filter" value="'.$feed['positive_filter'].'"/></li>';
								echo '<li><label for="exclude_'.$key.$feed['titre'].'">'.msg('Exclude those words').'</label><input type="text" id="exclude_'.$key.$feed['titre'].'" name="negative_filter" value="'.$feed['negative_filter'].'"/></li>';
								echo '</fieldset>';

								echo '<fieldset><legend>'.msg('feeds of ').$feed['titre'].'</legend>';
								$c=0;

								foreach ($feed['feeds'] as $key=>$link){		
									if (!isset($feed['colors'][$key])){$feed['colors'][$key]='transparent';}						
									echo 
									'<li>
											<select style="background-color:'.$feed['colors'][$key].'" name="'.$key.'color" class="color" title="'.msg('widget\'s titlebar color').'">';	
												foreach($coul as $color){
													if (isset($feed['colors'][$key])&&$color==$feed['colors'][$key]){$sel='selected="selected"';}else{$sel='';}
													echo '<option style="background-color:'.$color.'" value="'.$color.'" '.$sel.'/>'.$color.'</option>';
												}
									echo '
											</select><input type="text" class="feed" name="'.$c.'" value="'.$link.'"/> 
									</li>';
									$c++;
								
								}
								echo '<input type="hidden" name="nb" value="'.$c.'"/></fieldset><input type="submit" value="'.msg('save').'"></form>';
							echo '</div></div>';
						}
					?>
				


			</aside>
<?php require('system/footer.php');
	