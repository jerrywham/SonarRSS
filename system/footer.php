
			<footer>
				<a class="rss_link nomobile" href="?rss=<?php echo $onglet_selectionne;?>" alt="rss link" title="<?php echo msg('This tab\'s feed: all feeds in one...'); ?>"> </a>
				<a class="config_link nomobile" href="config.php" alt="config link" title="configuration"> </a>
				<a class="deconnect_link " href="index.php?discotime" alt="config link" title="Deconnexion">Deconnexion</a>
				<img src="design/img/favicon.png" alt="minilogo" width="16" height="16"/> <em title="<?php echo msg('An ultra minimalist NetVibes alternative');?>">Sonar'RSS</em> v<?php echo APP_VERSION;?> <p class="ajax"></p>
				<a href="http://warriordudimanche.net">Bronco - warriordudimanche.net</a> 
				<a href="#" title="<?php echo msg('Free and open source (please keep a link to warriordudimanche.net for the author ^^)');?>"><em class="nomobile">Licence</em></a>  
				<a href="https://github.com/broncowdd/SonarRSS" title="<?php echo msg('on GitHub');?>" class="github"> </a> 
				<script id='flattrbtn'>(function(i){var f,s=document.getElementById(i);f=document.createElement('iframe');f.src='//api.flattr.com/button/view/?uid=Broncowdd&url='+encodeURIComponent(document.URL);f.title='Flattr';f.height=62;f.width=55;f.style.borderWidth=0;s.parentNode.insertBefore(f,s);})('flattrbtn');</script>
			</footer>

			
			<script>
				
				$('document').ready(function(){
					$(document).on("change", ".color", function(){
						//config-> couleur de lien 
						couleur=$(this).find('option:selected').val();
						$(this).css('background',couleur);
						$(this).parent().parent().parent().parent().parent().find('h1').attr('style','background-color:'+couleur);
						

					}); 


					$(document).on("click", "nav .close", function(){
						//fermer un onglet 
						if (confirm("Supprimer cet onglet ?")){
							document.location.href="index.php?deltab="+$(this).attr('data-nb');
						}
						$(this).parent().click(function(){return false;});
					}); 
					$(document).on("click", ".widget h1 .close", function(){
						//fermer un flux via la croix 
						if (confirm("Supprimer ce flux ?")){
							$(this).parent().parent().hide(200);
							$('.ajax').load("system/supprime_flux.php?tab=<?php echo $onglet_selectionne;?>&delfeed="+$(this).attr('data-nb'));
						}
						$(this).parent().click(function(){return false;});
					});
					
					$(document).on("click", ".error a", function(){
						//fermer un flux erroné via le lien
						$(this).parent().parent().hide(200);
						$('.ajax').load("system/supprime_flux.php?tab=<?php echo $onglet_selectionne;?>&delfeed="+$(this).attr('href'));
						return false;
					}); 

					$("nav .add_feed, nav .add_tab").click(function(){
						$(this).find('input[type=text]').focus();
						$(this).toggleClass('width_auto').children().click(function(){return false;});
					});
					$("input[type=submit]").click(function(){$(this).parent("form").submit();});
					
					$(document).on("click", ".toggle", function(){
						// marquer comme lu/non lu
						// affichage
						parent=$(this).parent().parent();
						parent.toggleClass('read');
						parent.toggleClass('unread');
						lien=parent.attr('data-nb');
						widget=parent.parent().parent();
						flux=widget.attr('id');
						nbunread=widget.find(".mark_all_read");
						nb=nbunread.html();
						if (parent.hasClass('read')){nb--;}else{nb++;}
						nbunread.html(nb);
						// sauvegarde dans le fichier du flux
						$('.ajax').load('system/toggle.php?lien='+lien+'&flux='+flux);
					}); 

					$(document).on("click", ".mark_all_read", function(){
						// tout marquer comme lu
						// affichage
						parent=$(this).parent().parent();
						feeds=parent.find('ul');
						flux=parent.attr('id');
						read_or_unread=parent.find(".mark_all_read");
						$.each(feeds,function(){
							if (read_or_unread.html()=='0'){
								$(this).removeClass('read');
								$(this).addClass('unread');
							}else{
								$(this).addClass('read');
								$(this).removeClass('unread');
							}
						});
						if (read_or_unread.html()=='0'){
							read_or_unread.html(feeds.length);
							$('.ajax').load('system/toggle.php?lien=allunread&flux='+flux);
							read_or_unread.attr('title',"<?php echo msg('Mark all as read'); ?>");
						}else{
							read_or_unread.html('0');
							$('.ajax').load('system/toggle.php?lien=allread&flux='+flux);
							read_or_unread.attr('title',"<?php echo msg('Mark all as unread'); ?>");
						}
						// sauvegarde dans le fichier du flux
						

					}); 

					$(document).on("click", ".widget h1 .foldunfoldall", function(){
						// plier/deplier tous les items du widget
						$(this).parent().parent().find('.description').toggleClass('height_auto');
					}); 

					$(document).on("click", ".description", function(){
						// plier/déplier la description
						$(this).toggleClass('height_auto');
					}); 

					$(document).on("click", ".refresh", function(){
						//actualiser le flux
						widget=$(this).parent().parent();
						id=widget.attr('id');
						lien=$(this).attr('data-nb');
						param=$(this).attr('data-param');
						widget.fadeTo(200,0.2);
						str="system/charge_flux.php?url="+lien+"&id="+id+param;
						widget.load(str,function(){$(this).fadeTo(200,1);});
						
					}); 
					
				});
			</script>
	</body>

</html>
