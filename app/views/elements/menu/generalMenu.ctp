<div id="menu">
	<?php
		$menuItems = "";
		$menuItems = Cache::read('menuItems', 'default');
		if (!$menuItems) {
			$items = $this->requestAction('categories/getList');
			$menuItems = $this->Menu->generate($items, 'nav');
			$menuItems = $this->Menu->add(htmlentities('Columnas & Pendientes'), "/columnas-pendientes.html", $menuItems,'beginning',null, 'separator');
			$menuItems = $this->Menu->add('Posteá!', "/postea.html", $menuItems,'beginning',null, 'separator');

			Cache::set(array('duration' => '+30 minutes'));
			Cache::write('menuItems', $menuItems, 'default');

		}

		echo $menuItems;
		
		


	?>
</div>