/**
 * 
 */
jQuery(document).ready(function(){
	if(typeof users == 'undefined'){
		return false;
	}
	//console.log(users);
	var template = jQuery('#usrRow').html();
	jQuery('input#filterbox').attr('disabled', true);
	jQuery.each(users,function(index, value){
		var row = _.template(template, value);
		jQuery('div#users').append(row);
	});
	
	jQuery.ajax({
		url:'/users/getAll',
		success: function(data){
			window.users = data;
			//jQuery('div#users').html('');
			var pane = jQuery('div#users');
			var api = pane.data('jsp');
			api.getContentPane().html('');
			jQuery.each(data,function(index, value){
				var row = _.template(template, value);
				api.getContentPane().append(row);
			});
			//jQuery('div#users').jScrollPane();
			
			api.reinitialise();
			jQuery('input#filterbox').attr('disabled', false);
		}
	});
	
	jQuery('input#filterbox').keyup(function(event){
		//console.log(event);
		if(jQuery(this).val().length >= 1){
			var fusers = new Array();
			var chain = new RegExp(jQuery(this).val(),"i");
			//console.log(window.users);
			fusers = jQuery.grep(window.users,function(elm,idx){
				if((elm.User.first_name.search(chain) != -1)||(elm.User.last_name.search(chain) != -1)||(elm.User.alias.search(chain) != -1)){
					return true;
				}else{
					return false;
				}
			});
			jQuery('div#users').html('');
			jQuery.each(fusers,function(index, value){
				var row = _.template(template, value);
				jQuery('div#users').append(row);
			});
		}else{
			jQuery('div#users').html('');
			jQuery.each(window.users,function(index, value){
				var row = _.template(template, value);
				jQuery('div#users').append(row);
			});
		}
		
		jQuery('span#reset').click(function(event){
			jQuery('input#filterbox').val('');
			jQuery('div#users').html('');
			jQuery.each(window.users,function(index, value){
				var row = _.template(template, value);
				jQuery('div#users').append(row);
			});
		});
	});
	
});