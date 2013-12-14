ucatalog = {
	basePath: 'ucatalog',
	
	url: function(s){
		if(typeof s !== 'undefined'){
			return 'http://'+document.domain+'/'+uc.basePath + (s[0] == '/' ? s : '/'+s);
		} else { 
			var 	url=document.URL,
			bp=url.indexOf(uc.basePath);
			url = url.substr(bp + uc.basePath.length + 1,url.length);
			url = url.split('/');
		
			return url.length==1 ? { controller: url[url.length-1], action: url[url.length-1]} : { controller: url[url.length-2], action: url[url.length-1] };
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
	}
};

var uc = window.uc = ucatalog;
