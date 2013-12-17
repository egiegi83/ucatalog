ucatalog = {
	basePath: 'ucatalog',
	
	url: function(s){
		if(typeof s != 'undefined'){
			return 'http://'+document.domain+'/'+uc.basePath + (s[0] == '/' ? s : '/'+s);
		} else { 
			if(! typeof uc._url == 'undefined') return uc._url;
			var 	url=document.URL,
			bp=url.indexOf(uc.basePath);
			url = url.substr(bp + uc.basePath.length + 1,url.length),
			ou = url;
		
			url = url.split('/'); 
			uc._url = {};
			switch(url.length){
				case 0:
					uc._url = { controller : '/', action:'', data:'' }; 
					break;
				case 1:
					uc._url = { controller : url[0], action:'', data:'' };
					break;
				case 2:
					uc._url = { controller : url[0], action:url[1], data:'' };
					break;
				case 3:
					uc._url = { controller : url[0], action:url[1], data:url[2] };
					break;
			}
			uc._url.current=ou;
			return uc._url;
		}
	},
	query: function(selector){
		return document.querySelectorAll(selector);
	},
	match: function(el,selector){
		matchesSelector = el.matches || el.webkitMatchesSelector || el.mozMatchesSelector || el.msMatchesSelector;
		return matchesSelector.bind(el)(selector);
	},
	each: function(els,callback){
		for(var i=0; len=els.length, i<len; i++){
			callback.call(els[i],i,els);
		}
	},
	addEvent: function(els,type,callback){
		if(els.length)
			for(var i=0;len = els.length, i < len; i++){
				els[i].addEventListener(type,callback,false);
			}
		else els.addEventListener(type,callback,false);
	},
	liveEvent: function(els,type,callback){
		document.addEventListener(type, function (event) {
			if (ucatalog.match(event.target,els) && event.type==type) {
				callback.call(event.target, event);
			}
		},false);
	}, 
	post: function(url,data,complete){
		var xhr=new XMLHttpRequest();
		xhr.addEventListener("load",function (evt) {
			if(xhr.status == 200) complete.call(xhr,xhr.response,evt);
		},false);
		xhr.open('POST', url, true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('Content-Type','application/json');
		
		xhr.send((typeof data=='string' ? data : JSON.stringify(data)));
	}, 
	get: function(url,complete){
		var xhr=new XMLHttpRequest();
		xhr.addEventListener("load",function (evt) {
			if(xhr.status == 200) complete.call(xhr,xhr.response,evt);
		},false);
		xhr.open('GET', url, true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.send();
	},
	serialize: function(){
        if (!form || form.nodeName !== "FORM") return;
        var i, j, q = [];
        for (i = form.elements.length - 1; i >= 0; i = i - 1) {
                if (form.elements[i].name === "") continue;
                switch (form.elements[i].nodeName) {
                	case 'INPUT':
                        switch (form.elements[i].type) {
	                    	case 'text': case 'hidden': case 'password': case 'button': case 'reset': case 'submit':
		                            q.push(form.elements[i].name + '" : "' + form.elements[i].value);
		                            break;
		                    case 'checkbox': case 'radio':
	                            if (form.elements[i].checked)
	                            	q.push(form.elements[i].name + '" : "' + form.elements[i].value);                                  
	                            break;
	                    	case 'file':
		                    	break; 
	                	}
	                	break;
                case 'TEXTAREA':
                        q.push(form.elements[i].name + '" : "' + form.elements[i].value);
                        break;
                case 'SELECT':
                        switch (form.elements[i].type) {
		                    case 'select-one':
	                            q.push(form.elements[i].name + '" : "' + form.elements[i].value);
	                            break;
		                    case 'select-multiple':
	                            for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1)
	                                    if (form.elements[i].options[j].selected) {
	                                            q.push(form.elements[i].name + '" : "' + form.elements[i].options[j].value);
            	       		break;
	             		}
	                    break;
                case 'BUTTON':
                    switch (form.elements[i].type) {
                    	case 'reset': case 'submit': case 'button':
                                q.push(form.elements[i].name + '" : "' + form.elements[i].value);
                                break;
                  	}
                    break;
            	}
            }
        }
        return JSON.parse('{ "' + q.join('", "') + '" }');
	}
}

var uc = window.uc = ucatalog;
