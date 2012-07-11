var woeid = 23424747;
new Ajax.Request('http://api.twitter.com/1/trends/'+woeid+'.json',{
	asynchronous:true,
	evalJSON:true,
	method: 'get',
	onSuccess: function(response){
		console.log(response);
	}
}
);