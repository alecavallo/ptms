// JavaScript Document

function eSelect(element, eclass){
	var elements = $$("."+eclass);
	elements.each( function(dom){
		dom.className="htab noSelected"
							});

	element.className="htab selected";
	var structured = 1;
	if(element.id == 'chronological'){
		structured = 0;
	}
	new Ajax.Updater('colLeft', '/news/index/'+structured, { method: 'get' });
	if(structured == 1){
		$('otherNewsContainer').style.display="block";
	}else{
		$('otherNewsContainer').style.display="none";
	}
	/*new Ajax.Request('/news/index/'+structured,
			{
				method: get,
				onSuccess: function(response){
					$("div#colLeft")
				}
			}
			
	);*/
}

function expCol(iconId, containerId, delay){
	icon = $(iconId);
	container = $(containerId);
	clNames = icon.className.split(' ');
	classes="";
	for(i=0; i<1; i++){
		currClass = clNames[i];
		if(currClass == "minimize"){
			currClass = "maximize";
			container.style.display="none";
		}else{
			if(currClass == "maximize"){
				currClass = "minimize";
				container.style.display="block";
			}
		}
		classes=currClass+" ";
	}
	icon.className=classes;
}

function showPopup(id, delay){
	//var oElement = $(control);
	var message= $(id);
//	message.style.display='block';
	Effect.Appear(id, {duration: 0.5});
	//document[message].filters.alpha.opacity =60;
	var iReturnValue = 0;
}

function unselectMultimediaTab(elem, newsId){
	var elId= $(elem).id;
	var containerId = elId.replace('Tab','');
	$$('div#mediaSlideshowContainer div#tabsContainer div.selected').invoke('removeClassName','selected');
	$(elem).addClassName('selected');
	$$('div#mediaSlideshowContainer div.content').invoke('setStyle','display:none;');
	//$$(containerId).setStyle('display:block;');
	$$('div#'+containerId).invoke('setStyle','display:block;');
	//$$(elem).invoke('show');
	setCookie('actTab'+newsId,elId,1);
	
}

function preSelectTab(newsId){
	var tab = getCookie('actTab'+newsId);
	if(tab != ""){
		unselectMultimediaTab(tab);
	}
}

function setCookie(c_name,value,expiredays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
}
function getCookie(c_name){
	if (document.cookie.length>0){
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
	    {
	    c_start=c_start + c_name.length+1;
	    c_end=document.cookie.indexOf(";",c_start);
	    if (c_end==-1) c_end=document.cookie.length;
	    return unescape(document.cookie.substring(c_start,c_end));
	    }
	  }
	return "";
}
function showHide(element){
	if(element.getStyle('display') == 'none'){
		element.show();
	}else{
		element.hide();
	}
}