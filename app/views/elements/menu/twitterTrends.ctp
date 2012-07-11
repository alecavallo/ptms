<?php
/*echo $this->Html->script('prototype',array('inline'=>false));
echo $this->Html->script('Marquee',array('inline'=>false));*/
echo $this->Html->script(array('prototype', 'Marquee'),array('inline'=>true, 'once'=>true));

$city = array_key_exists('State', $city['City'])?$city['City']:$city;
$tweets = $this->requestAction("twitter/trends/{$city['State']['Country']['woeid']}");
$trends = "";
foreach ($tweets as $value) {
	$link = $this->Html->link($value['value'], $value['url'], array('target' => '_blank'));
	$trends .= "{message: '".$link."'},";
}
$trends = substr($trends, 0, -1);

/*$tweetsContainer = $this->Html->div('tweetsContainer',$trends);*/
echo $this->Html->div('pTweets',"",array('id'=>'pTweets'));

//debug($tweets);

$jscript =  <<<BLOCK
var m1 = new Marquee({
    element: "pTweets",
    data: [
    $trends
    ]
    });
BLOCK;
$this->Js->buffer($jscript);
?>