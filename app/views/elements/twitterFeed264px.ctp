<?php
//extraigo las variables en el array
extract($tweetData);
$twitter = "<script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
<script>
tweetPoint = '{$coordinates}';
//$('NewsCoordinates').value = tweetPoint;
var widget = new TWTR.Widget({
  version: 2,
  type: 'search',
  search: '{$search} geocode:'+tweetPoint,
  interval: 6000,
  title: '{$title}',
  subject: '{$subtitle}',
  width: 264,
  height: 350,
  theme: {
    shell: {
      background: '#8ac33f',
      color: '#000000'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#1985b5'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: true,
    behavior: 'default'
  }
}).render().start();
</script>";
echo $this->Html->div('twitterFeed',$twitter);

?>