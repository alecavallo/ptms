<div class="twitterNews" style="<?php if(isset($customStyle)) echo $customStyle; ?>">
	<div class="icon">
		<?php
			if (!empty($tweet['profile_img'])) {
				echo $html->image($tweet['profile_img'], array('alt'=>$tweet['username'], 'width'=>"50"));
			}else {
				echo $html->para('', $tweet['username']);
			}
		?>
	</div>
	<div class="tContent">
		<h4 class="section grey">
			<?php 
				$usr = "<span style='font-weight: 700'>{$tweet['username']}</span> - ";
				echo $usr."<span style='font-weight: 400'>{$tweet['Category']['name']}</span>";
			?>
		
		</h4>
		<div class="photo">
			<?php
			/*if (!empty($tweet['Media']) && !empty($tweet['Media']['url'])) {
				echo $html->image($tweet['Media']['url'], array('alt'=>"", 'width'=>"50"));
			}*/
			?>
		</div>
		<p class="summary">
			<?php
				$text = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $tweet['text']);
				echo '"'.$this->Text->truncate($text,150, array('ending'=>'...', 'exact'=>false, 'html'=>true)).'"';
			?>
		</p>
	</div>

	<div class="mainComments">
		<span class="green right bottom">
		<br />
		
			<?php
				//echo $tweet['created'];
			?>
		</span>
		<br />
		<br />
		<br />
	</div>

	<br clear="both"/>
</div>