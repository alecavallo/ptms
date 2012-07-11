<div id="menu">
	<?php
		$menuItems = "";
		//$menuItems = Cache::read('mobilemenuItems', 'default');
		if (!$menuItems) {
			$items = $this->requestAction('categories/getList');
			$menuItems = $this->Menu->generate($items, 'nav', true);
			$image = $this->Html->image('pendientes.png');
			$menuItems = $this->Menu->add($image, "/users/index", $menuItems,'beginning',null, 'separator');
			Cache::set(array('duration' => '+30 minutes'));
			Cache::write('mobilemenuItems', $menuItems, 'default');

		}

		echo $menuItems;
		
		


	?>
	
</div>
