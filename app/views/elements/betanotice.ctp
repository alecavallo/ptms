<?php 
	echo $this->Html->css('popup');
	echo $this->Html->script(array('tweeter/jquery'),array('inline'=>true, 'once'=>true));
?>
<div id="Popup">  
	<a id="popupClose">x</a>  
	<br/>
	
	<div id="contenedor">
		<div id="h_1">
			<!-- <div id="txt">Estamos en la fase de <strong>beta cerrada</strong>, realizando las &uacute;ltimas pruebas del sistema, si quieres ser uno de los primeros en utilizar la aplicación, haz <a href="http://registracion.posteamos.com" target="_self">click aqui</a> y pide una invitaci&oacute;n.</div> -->
			<div id="txt">
				<p>Estamos en una etapa de prueba, por lo que algunas funcionalidades pueden tener algunos desperfectos, sepan disculpar los errores. Cualquier opinión tuya es muy importante para nosotros, al pie de la página se encuentra el link para contactarnos.</p>
				<p>Esperamos que disfrutes de Posteamos.com</p>
			</div>
		</div>
		<div id="h_2">
			<div id="c_video">
		
					<iframe src="http://player.vimeo.com/video/45605534?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="400" height="267" frameborder="0"></iframe>
		
			</div>
		</div>
	</div>
	
	
	
	<input type="checkbox" onclick="dontShow(this)"/> No mostrarme mas este mensaje    
</div>   
<div id="bgPopup"></div>

<script type="text/javascript">
jQuery.noConflict();
function loadPopup(){  
    //loads popup only if it is disabled  
    if(jQuery("#bgPopup").data("state")==0){  
        jQuery("#bgPopup").css({  
            "opacity": "0.7"  
        });  
        jQuery("#bgPopup").fadeIn("medium");  
        jQuery("#Popup").fadeIn("medium");  
        jQuery("#bgPopup").data("state",1);  
    }  
}  
  
function disablePopup(){  
    if (jQuery("#bgPopup").data("state")==1){  
        jQuery("#bgPopup").fadeOut("medium");  
        jQuery("#Popup").fadeOut("medium");  
        jQuery("#bgPopup").data("state",0);  
    }  
}  
  
function centerPopup(){  
    var winw = jQuery(window).width();  
    var winh = jQuery(window).height();  
    var popw = jQuery('#Popup').width();  
    var poph = jQuery('#Popup').height();  
    jQuery("#Popup").css({  
        "position" : "absolute",  
        "top" : winh/2-poph/2,  
        "left" : winw/2-popw/2  
    });  
    //IE6  
    jQuery("#bgPopup").css({  
        "height": winh    
    });  
} 

function dontShow(p){
	if(jQuery(p).is(':checked')){
		setCookie('nonotice', 1, 365);
	}else{
		delCookie('nonotice');
	}
}


jQuery(document).ready(function() {
	jQuery("#bgPopup").data("state",0);
	if(getCookie('nonotice') != 1){
		
		centerPopup();
		loadPopup();
	}
	   jQuery("#popupClose").click(function(){
		   	disablePopup();
	   });
	   jQuery(document).keypress(function(e){
			if(e.keyCode==27) {
				disablePopup();	
			}
		});
	});

//Recenter the popup on resize - Thanks @Dan Harvey [http://www.danharvey.com.au/]
jQuery(window).resize(function() {
	centerPopup();
});
</script>