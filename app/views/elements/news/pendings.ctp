<?php 
if (empty($data)) {
	$data = $this->requestAction('/news/listNews/0/70');
}

$selected = isset($selected)?$selected:'Todas';
?>
<div id="pendings">
	<h1 class="greyTitle" style="margin-bottom: 20px;" title="Con tu voto podés hacer que estas noticias lleguen a portada!">Noticias pendientes de ser publicadas</h1>
	<img src="/img/degradee.png" alt="" class="degradee">
	<div id="categoryIndicator" onclick="showHide($('categoryPicker'))"><?php echo $selected;?>▼</div>
	<div id="categoryPicker" style="display: none;">
	<?php 
		echo $this->Ajax->link('Todas','/news/listNews/0/70',array('update'=>"pending"));
		foreach ($categories as $row) {
			echo $this->Html->para('filter', 
				$this->Ajax->link($row['Category']['name'],"/news/listNews/{$row['Category']['id']}/70",array('update'=>"pending"))
			);
		}
	?>
	</div>
	<div id="rows">
		<?php
		$votes = $session->read('votes');
		$votes = !empty($votes)?$votes:array(); 
		foreach ($data as $row) {
			$image = !empty($row[0])?$row[0]['avatar']:"empty.jpg";
			$image = $this->Html->image($image,array('alt'=>"",'class'=>"avatar"));
			$section = $this->Html->tag('h4', $row['Category']['name'], array('class'=> "section grey"));
			if(!empty($row['News']['link'])){
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), $row['News']['link'], array('target'=>'blank', 'escape'=>false));
			}else{
				$title = $this->Html->link($this->Html->tag('h3', $row['News']['title']), "/columna/{$row[0]['alias']}/noticia/{$row['News']['id']}-".Inflector::slug($row['News']['title'],"-").".html", array('target'=>'blank', 'escape'=>false));
			}
			$summary = $this->Html->para('summary', $this->Text->truncate($row['News']['summary'], 250, array('ending'=>"...", 'html'=>true, 'exact'=>false)));
			$up = $this->Html->image('OK.png', array("class"=>"vote")); //$this->Ajax->link(, "/visits/incrementaContador/{$row['News']['id']}/2", array('escape'=>false));
			$down = $this->Html->image('NO.png', array("class"=>"votedown")); //$this->Ajax->link(, "/visits/incrementaContador/{$row['News']['id']}/-1", array('escape'=>false));
			
			if (!in_array($row['News']['id'], $votes)) {
				$vote = $this->Html->div('vote_buttons',$up.$down);
			}else {
				$vote = $this->Html->div('vote_buttons',"");
			}
			
			echo $this->Html->div('newsRows', $image.$section.$title.$summary.$vote, array('id'=>$row['News']['id']));
		}
		?>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('img.vote').click(function(){
			var parent = jQuery(this).closest('div.newsRows').attr('id');
			
			jQuery('div#'+parent+' div.vote_buttons').fadeOut('fast');
			jQuery.ajax({
				url:'/news/vote/'+parent+"/1",
				success: function(data){
					jQuery('div#'+parent+' div.vote_buttons').html('Gracias por contribuir!');
					jQuery('div#'+parent+' div.vote_buttons').fadeIn('fast');
					var hide = function(){ jQuery('div#'+parent+' div.vote_buttons').fadeOut('slow');};
					setTimeout(hide, 3000);
				}
			});
		});

		jQuery('img.votedown').click(function(){
			var parent = jQuery(this).closest('div.newsRows').attr('id');
			jQuery('div#'+parent+' div.vote_buttons').fadeOut('fast');

			jQuery.ajax({
				url:'/news/vote/'+parent+"/-1",
				success: function(data){
					jQuery('div#'+parent+' div.vote_buttons').html('Gracias por contribuir!');
					jQuery('div#'+parent+' div.vote_buttons').fadeIn('fast');
					var hide = function(){ jQuery('div#'+parent+' div.vote_buttons').fadeOut('slow');};
					setTimeout(hide, 3000);
				}
			});
			
		});	

			
	});
</script>
<script type="text/javascript">
		jQuery(function(){
				jQuery('div#rows').jScrollPane();
				setTimeout(function(){
					jQuery('div#rows').data('jsp').reinitialise();
				},7000);
				
		});
</script>