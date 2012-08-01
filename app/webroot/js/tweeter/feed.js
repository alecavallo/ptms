/**
 * Esta arichivo contiene la clase javascript que se encarga de obtener los feeds, formatearlos y mostrarlo en una marquesina vertical 
 */
jQuery.noConflict();

function Twitter(){
	var twitterUrl = "http://api.twitter.com";
	var glistName="";
	var gresultsPerpage=0;
	var sinceId = 0;
	
	
	var filterTweets = function(element, index){
		if(jQuery.trim(element.text).length > 45){
			return true;
		}else{
			console.log('NO PASA: '+element.text);
			return false;
		}
	};
	
	var retFunction= function(data){
		
		var feedSpeed = 3500;
		var tweetsPerColumn=12;
		var initial=true;
		var delay=1;
		var delta=1; //se le da 1 tiempo de accion de margen
		var cnt=0;
		if(typeof(sinceId)!='undefined' && sinceId != 0){
			initial=false;
		}else{
			sinceId=0;
		}
		//console.log("ejecuto?");
		if((data.length < 1 && initial) && false){//si está vacío no hago nada
			//console.log('NO');
			return false;
		}else{
			//console.log('SI');
			if(data.length > 0){//si existen datos, aplico filtros de tweets
				//filterTweets(elem, index)
				data = jQuery.grep(data, filterTweets);
			}
			if(data.length > 0){//rechequeo si existen tweets, cargo el id del mas reciente
				if(sinceId == data[0].id){
					data = new Array();
					delay=22;
				}else{
					sinceId = data[0].id;
				}
				if(data.length < 10){
					delta = 12;
				}
			}else{
				delta=22;
			}
			
			data.reverse();
			template = jQuery('#tweetRow').html();
			var fSize = data.length;
			console.log("A mostrar: "+fSize+" tuits;")
			data.each(function(elm, index){
				//console.log("iteracion: "+index);
				var appUsername = false;
				jQuery.ajax({
					  url: '/users/getUsername/'+elm.user.screen_name,
					  async: false,
					  success: function (data,textStatus){
						  appUsername = data;
					  },
					  failure: function(data, textStatus){
						  //alert("Error!");
						  console.log('Error conectandose al servidor. posteamos');
					  },
					  dataType: "json"
				});
				
				/*if(appUsername != false){
					console.log(appUsername.User.first_name+' '+appUsername.User.last_name);
				}else{
					console.log(appUsername);
				}*/
				
				if(appUsername != false){
					//console.log(appUsername.User.first_name+' '+appUsername.User.last_name);
					var tmplData = {
							profile_img: appUsername.User.avatar,
							username: appUsername.User.first_name+' '+appUsername.User.last_name,
							category_name: glistName.replace("-"," & "),
							text: jQuery.trim(elm.text),
							created: elm.created_at
					};
					var row = "";
					row = _.template(template, tmplData);
					if(cnt < tweetsPerColumn && initial){
						jQuery('#tweets').prepend(row);
						cnt++;
						//retFunction(data,cnt);
						//setTimeout(function(){retFunction(data,cnt)}, 1001);
					}else{
						
						setTimeout(function(){
							//var c = index+1;
							jQuery('#tweets').prepend(row);
							jQuery('div.twitterNews:last').remove();
						}, feedSpeed*(delay));
						cnt++;
						delay++;
						/*jQuery('.twitterNews').each(function(){
							var $this = jQuery(this);
							var top = parseInt($this.css('top'));
							if(typeof(top) == 'NaN'){
								top = 0;
							}
							$this.animate(
								{
									top: parseInt(top)+50
								},
									1000, 'linear',
									function(){
										//jQuery('#tweets').prepend(row);
										return true;
									}
							);
						});*/
					}
					
					
				}else{
					//console.log('no usuario '+cnt);
					//setTimeout(function(){retFunction(data,cnt)}, 5001);
					//return false;
				}
				
			}); //end foreach
			
			//console.log('Espero: '+(feedSpeed*(delay+delta)/1000/60)+" mins");
			//jQuery.proxy(function(){
				setTimeout(function(){
					//alert('Recursion!!!!');
					t.getList('posteamos',glistName,gresultsPerpage,1);
				},feedSpeed*(delay+delta));
			//}, this)
		
		
		
		}
	};
	
	var renderHomeFeed = function(data){
		var tweetsPerColumn=12;
		sinceId = data[1];
		var tweets = data[0];
		var container = jQuery('#tweets');
		var count=1;
		var delay=1;
		var feedSpeed = 3000;
		jQuery.each(tweets,function(idx, row){
			if(typeof(row)!= 'undefined' || row != 'undefined'){
				if(count < tweetsPerColumn){
						container.prepend(row);
				}else{
					setTimeout(function(){
						container.prepend(row);
						jQuery('div.twitterNews:last').remove();
					}, feedSpeed*delay);
					delay++;
				}
				count++;				
			}
		});
		if(count < 	13){
			delay=19;
		}
		setTimeout(function(){
			t.getHomeFeed(sinceId);
		}, feedSpeed*(delay+1));
		
	};
	
	return{
		getListWrapper: function(data){
			data= eval(data);
			retFunction(data);
		},
		
		getList: function(userScreenName, listName, resultsPerpage, page){
			wrapper = 't.getListWrapper';
			glistName = listName;
			gresultsPerpage = resultsPerpage;
			if(typeof(sinceId) == 'undefined' || sinceId == 0){
				var query= "/1/lists/statuses.json?slug="+listName+"&owner_screen_name="+userScreenName+"&per_page="+resultsPerpage+"&page="+page+"&include_entities=true&callback=?";
				var res = this.requestAction(query, 0, retFunction);
			}else{
				var query= "/1/lists/statuses.json?slug="+listName+"&owner_screen_name="+userScreenName+"&per_page="+resultsPerpage+"&page="+page+"&include_entities=true&since_id="+sinceId+"&callback=?";
				var res = this.requestAction(query, retFunction);
			}
		},
		
		getHomeFeed: function(lastTweet){
			jQuery.ajax({
				  url: '/twtr/getTimeline/'+lastTweet,
				  cache: false,
				  success: function (data,textStatus){
					  	//console.log(data);
					  	//console.log(textStatus);
					  	renderHomeFeed(data);
				  },
				  failure: function(data, textStatus){
					  console.log("No se puede conectar a posteamos. Error: "+data);
				  },
				  dataType: "json"
			});
		},
		
		requestAction: function(query, callback){
			if(sinceId == 0){
				 	if(jQuery.browser.msie) {
				 		query = query.replace('callback=?','callback='+wrapper);
			            // Use Microsoft XDR
						 jQuery(document).ready(function(){
							document.body.appendChild(document.createElement('script')).src=encodeURI(twitterUrl+query);
						 });
						 
						 //callback(window.twtrResp);

			        } else {
			        	jQuery.ajax({
							  url: twitterUrl+query,
							  cache: false,
							  success: function (data,textStatus){
								  	console.log(data);
								  	console.log(textStatus);
								  	callback(data);
							  },
							  failure: function(data, textStatus){
								  console.log("No se puede conectar a twitter. Error: "+data);
							  },
							  dataType: "jsonp"
						});
			        }
				
				
			}else{
				if(jQuery.browser.msie) {
					query = query.replace('callback=?','callback='+wrapper);
		            // Use Microsoft XDR
					 jQuery(document).ready(function(){
						document.body.appendChild(document.createElement('script')).src=encodeURI(twitterUrl+query);
					 });
					 
					 
		        } else {
					try{
						jQuery.ajax({
							  url: twitterUrl+query,
							  cache: false,
							  success: function (data,textStatus){
								  	console.log(data);
								  	console.log(textStatus);
								  	callback(data);
							  },
							  failure: function(data, textStatus){
								  alert("Error!");
								  console.log(data);
							  },
							  dataType: "json"
						});
					}catch(err){
						console.log(err);
					}
		        }
			}
		}
	}
}