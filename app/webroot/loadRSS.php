<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	require_once('iam_opml_parser.php');
	$db = mysql_connect("127.0.0.1", "root", "ac17nc22");
	mysql_select_db("posteamos",$db);


	function writeValues($data,$db) {
		mysql_query("start transaction", $db);
		foreach ($data['fuente'] as $key => $fuente) {
			$sql = "select * from sources where name like '{$data['fuente'][$key]}'";
			$resulta = mysql_query($sql,$db);
			var_dump(mysql_error($db));
			if (mysql_num_rows($resulta)==0) {
				/**inserto la fuente si hiciera falta**/
				$country_id = (array_key_exists($key, $data['country']) && $data['country'][$key]!=-1)?$data['country'][$key]:'null';
				$sql = "insert into sources (name,url,country_id) values ('{$fuente}','{$data['urlFuente'][$key]}',{$country_id})";
				$result = mysql_query($sql,$db);
				$sid = mysql_insert_id($db);
				if (mysql_errno($db)) {
					echo "{$data['country'][$key]}####  ";
					var_dump($data['country']); var_dump($key);
					echo "error insertando fuente: ".mysql_error($db)."<br/>";
					mysql_query("rollback", $db);
					return false;
				}
			}else {
				$sid = mysql_fetch_assoc($resulta);
				$sid = $sid['id'];
			}

			$sql = "select * from feeds where url like '{$data['url'][$key]}'";
			$result = mysql_query($sql,$db);
			if (mysql_num_rows($result)==0) {
				/**inserto el feed si hiciera falta**/
				$city_id = (array_key_exists($key, $data['city']) && $data['city'][$key]!=-1)?$data['city'][$key]:'null';
				$state_id = (array_key_exists($key, $data['state']) && $data['state'][$key]!=-1)?$data['state'][$key]:'null';
				$tweeter = array_key_exists($key, $data['tweeter'])?$data['tweeter'][$key]:0;
				$sql = "insert into feeds(url,source_id,category_id,city_id,state_id,enabled,social_network) values ('{$data['url'][$key]}',{$sid},{$data['cate'][$key]},{$city_id},{$state_id},1,{$tweeter});";
				$result = mysql_query($sql,$db);
				$fid = mysql_insert_id($db);
				if (mysql_errno($db)) {
					echo "error insertando feed: ".mysql_error($db)."<br/>";
					echo $sql;
					mysql_query("rollback", $db);
					return false;
				}
			}
		}
		mysql_query("commit", $db);
		return true;

	}
	if (empty($_POST)) {
		$sql = "select * from categories";
		$result = mysql_query($sql,$db);
		$categories = "<select name=\"cate[ID]\">";
		while (($row = mysql_fetch_assoc($result))!==false) {
			$categories .= "<option value=\"{$row['id']}\">".utf8_encode($row['name'])."</option>";
		}
		$categories .= "</select>";

		$sql = "select cities.*, states.name as state_name from cities inner join states on states.id=cities.state_id order by name asc";
		$result = mysql_query($sql,$db);
		$cities = "<select name=\"city[ID]\"><option value=\"-1\" selected=\"selected\">Ciudad</option>";
		while (($row = mysql_fetch_assoc($result))!==false) {
			$cities .= "<option value=\"{$row['id']}\">".utf8_encode($row['name']." - ".$row['state_name'])."</option>";
		}
		$cities .= "</select>";

		$sql = "select * from states order by name asc";
		$result = mysql_query($sql,$db);
		$states = "<select name=\"state[ID]\"><option value=\"-1\" selected=\"selected\">Provincia</option>";
		while (($row = mysql_fetch_assoc($result))!==false) {
			$states .= "<option value=\"{$row['id']}\">".utf8_encode($row['name'])."</option>";
		}
		$states .= "</select>";

		$sql = "select * from countries order by name asc";
		$result = mysql_query($sql,$db);
		$countries = "<select name=\"country[ID]\"><option value=\"-1\" selected=\"selected\">País</option>";
		while (($row = mysql_fetch_assoc($result))!==false) {
			$countries .= "<option value=\"{$row['id']}\">".utf8_encode($row['name'])."</option>";
		}
		$countries .= "</select>";

		echo "<h2>Feeds a subir</h2>";
		$parser = new IAM_OPML_Parser();
		$feeds = $parser->getFeeds("http://posteamos.localhost.com/Fuentes.xml");
?>
<h3>Procesando <?php echo count($feeds);?></h3>
<form id="lalala" action="loadRSS.php" method="post">
<table border="1">
  <tr>
    <th>Feed</th>
    <th>URL</th>
    <th>Fuente</th>
    <th>URL Fuente</th>
    <th>Categoría</th>
    <th>Tweeter</th>
    <th>Localidad</th>
  </tr>

<?php
//TODO: agregar el url del RSS $sources['urls']
		$i=0;
		foreach ($feeds as $sources) {
			if (strpos($sources['feeds'], 'twitter.com')!==false || strpos($sources['feeds'], 'com.mx')!==false) {
				continue;
			}
			$sql = "select id from feeds where url like '{$sources['feeds']}';";
			$result = mysql_query($sql, $db);
			$exists = mysql_num_rows($result);
			if ($exists) {
				continue;
			}
			echo "<tr>";
			if (empty($sources['feeds'])) {
				echo "<td colspan=7><b>{$sources['names']}</b>"."<td colspan=5>";
			}else{
				echo "<td>{$sources['names']}</td><td>{$sources['feeds']}<input type=\"hidden\" id=\"url{$i}\" name=\"url{$i}\" value=\"{$sources['feeds']}\"/></td><td><input type=\"text\" id=\"fuente{$i}\" name=\"fuente{$i}\"></input></td><td>{$sources['urls']}<input type=\"hidden\" id=\"urlFuente{$i}\" name=\"urlFuente{$i}\" value=\"{$sources['urls']}\"/></td><td>".str_replace("[ID]", $i, $categories)."</td><td><input type=\"checkbox\" id=\"tweeter{$i}\" name=\"tweeter{$i}\">Tweeter?</input><td>".str_replace("[ID]", $i, $cities).str_replace("[ID]", $i, $states).str_replace("[ID]", $i, $countries)."</td>";
				if (!$exists) {
					$i++;
				}
			}
			echo "</tr>";

			if($i > 450){
				break 1;
			}
		}
?>

</table>
	<input type="submit"/>
	<input type="reset"/>
</form>
<?php
echo "<pre>";
//var_dump($parser->getFeeds("http://posteamos.localhost.com/Fuentes.xml"));
echo "</pre>";
?>

<?php
	}else {
		//echo "<pre>"; var_dump($_POST); echo "</pre>";
		$i=0;
		$continue = -1;
		$url = array();
		$fuente = array();
		$urlFuente = array();
		$cate = array();
		$tweeter = array();
		$city = array();
		$state = array();
		$country = array();
		foreach ($_POST as $key => $item) {
			$dataItem = preg_replace('#[!^\d+]#i', '', $key);
			$itemNumber = preg_replace('#[^\d+]#i', '', $key);
			if (empty($_POST["fuente{$itemNumber}"])) {
				//echo "<h3>Continue {$dataItem} -- {$item}</h3><br/>";
				$continue = $itemNumber;
				continue 1;
			}
			//echo "<b>$item=></b><br/>";




			//var_dump($dataItem);
			//var_dump($item);
			switch ($dataItem) {
				case 'url':
					//echo "URL|||<BR/>";
				$url[$itemNumber]=$item;
				break;

				case 'fuente':
					//echo "FUENTE|||<BR/>";
				$fuente[$itemNumber]=$item;
				break;

				case 'urlFuente':
					//echo "URL_FUENTE|||<BR/>";
				$urlFuente[$itemNumber]=$item;
				break;

				case 'cate':
					//echo "CATE|||<BR/>";
				$cate[$itemNumber]=$item;
				break;

				case 'tweeter':
					//echo "CATE|||<BR/>";
				$tweeter[$itemNumber]=$item=="on"?true:false;
				break;

				case 'city':
					//echo "CITY|||<BR/>";
				$city[$itemNumber]=$item;
				break;

				case 'state':
					//echo "STATE|||<BR/>";
				$state[$itemNumber]=$item;
				break;

				case 'country':
					//echo "COUNTRY|||<BR/>";
				$country[$itemNumber]=$item;
				break;
			}


		}
		$data = array(
			'url'		=>	$url,
			'fuente'	=>	$fuente,
			'urlFuente'	=>	$urlFuente,
			'cate'		=>	$cate,
			'tweeter'	=>	$tweeter,
			'city'		=>	$city,
			'state'		=>	$state,
			'country'	=>	$country
		);

		echo "url: "; var_dump($url); echo "<br/><br/><br/>";
		echo "fuente: "; var_dump($fuente); echo "<br/><br/><br/>";
		echo "urlFuente: "; var_dump($urlFuente); echo "<br/><br/><br/>";
		echo "cate: "; var_dump($cate); echo "<br/><br/><br/>";
		echo "tweeter: "; var_dump($tweeter); echo "<br/><br/><br/>";
		echo "city: "; var_dump($city); echo "<br/><br/><br/>";
		echo "state: "; var_dump($state); echo "<br/><br/><br/>";
		echo "country: "; var_dump($country); echo "<br/><br/><br/>";

		$saved = writeValues($data, $db);

		if (!saved) {
			echo "<h1>HA OCURRIDO UN ERROR GUARDANDO LOS DATOS</h1>";
		}


	}
	mysql_close($db);
?>

</body>
</html>