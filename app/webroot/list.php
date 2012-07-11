<?php
require_once('iam_opml_parser.php');

$opml_url = 'http://www.scripting.com/feeds/top100.opml';
$parser = new IAM_OPML_Parser();
$links = $parser->getFeeds($opml_url);

// Start List
print "<ul>";
foreach($links as $feed)
{
	$link = parse_url($feed['feeds'],PHP_URL_SCHEME).'://'.parse_url($feed['feeds'], PHP_URL_HOST);
	if(trim(parse_url($feed['feeds'], PHP_URL_HOST))!='')
		print "<li><a href=\"$link\">{$feed[names]}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"{$feed[feeds]}\">RSS Feed</a></li>";
}
print "</ul>";
?>