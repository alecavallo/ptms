function Marquee(){
    var options = {
        anSpeed: 500,
        delay: 5000,
        changeDelay: 900,
        animation: 'fade'
    };
    
    var prevPressed = false;
    var onload = false;
    
    var container;
    
    var iterator;
    var animTimeout;
    
    var items= new Array();
    var shown= new Array();
    
    var doNext = function(){
    	if(items.length == 0){//valido almacen
            return false;
        }
        
    	//extraigo el primer elemento y lo pongo al final
        itm = items.shift();
        items.push(itm);
        if(prevPressed==true){//si se apreto el boton prev, acomodar la lista
        	itm = items.shift();
            items.push(itm);
            prevPressed=false;
        }
        
        //muestro el elemento extraido
        toggleShow(itm.text, itm.link);
    };
    
    var doPrev = function(){
    	if(items.length == 0){//valido almacen
            return false;
        }
        
        //extraigo el ultimo elemento y lo pongo al principio
        itm = items.pop();
        items.unshift(itm);
        
        if(prevPressed == false){//se ejecuta 2 veces para que no muestre el mismo elemento al hacer prev por primera vez
        	itm = items.pop();
            items.unshift(itm);
            prevPressed = true;
        }
        
        
        toggleShow(itm.text, itm.link);
    };
    
    var toggleShow= function(item, link){
        jQuery(container).fadeOut(options.anSpeed);
        var showItm = function(){
        	jQuery(container).html(item);
            if(typeof link != 'undefined'){
                jQuery(container).click(function(){
                    window.open(link);
                });
            }else{
                jQuery(container).unbind('click');
            }
        }
        
        setTimeout(showItm, options.anSpeed);
        
        jQuery(container).fadeIn(options.anSpeed);
        //demoro la aparición del nuevo contenido
        /*setTimeout(function(){
        	jQuery(container).unbind('click');
        	console.log('oculto');
        	jQuery(container).fadeOut(options.anSpeed);
        }, options.delay);*/
        
    };
    
    var hide = function(item){
        jQuery(container).fadeOut(anSpeed);
    }
        
    var show = function(item, speed, link){
        //cargo los datos del item a mostrar
        jQuery(container).html(item);
        if(typeof link != 'undefined'){
            jQuery(container).click(function(){
                window.open(link);
            });
        }else{
            $(container).unbind('click');
        }        
    
        jQuery(container).fadeIn(anSpeed);
    }

    return{
        load: function(it, cont){
        	onload=true;
            items = it;
            container = cont;
            jQuery(container).css('cursor: pointer');
            shown = new Array();
            jQuery(container).hide();
            this.start();
        },
        
        start: function(){
            if(items.length == 0 && shown.length == 0){
                return false;
            }
            
            if(onload){
            	doNext();
            	onload = false;
            }
            
            iterator = setInterval(doNext,options.delay+options.changeDelay);
        },
        
        next: function(){
        	clearInterval(iterator); //paro el iterator
        	jQuery(container).stop();
        	doNext(); //muestro el siguiente elemento
        	iterator = setInterval(doNext,options.delay+options.changeDelay);
        },
        
        prev: function(){
        	clearInterval(iterator); //paro el iterator
        	jQuery(container).stop();
        	doPrev(); //muestro el anterior elemento
        	iterator = setInterval(doNext,options.delay+options.changeDelay);
        	
        }
    }
}