uc.addEvent(window,'load',function(){
	var tb_search = uc.query('#tb_search')[0],
			ac = uc.query('#autocomplete')[0],
			btn_search = uc.query('#btn_search')[0],
			prodotti = uc.query('#prodotti')[0],
			h2r = uc.query('#h2r')[0];
		
	uc.addEvent(tb_search,'keyup',function(e){
		if(e.keyCode == 13 || e.keyCode ==40 || e.keyCode == 37 || e.keyCode == 39) return; 
		uc.post('search', {Cerca:this.value},function(data,e){
			data=JSON.parse(data);
			tmp='<ul tabindex="0">';
			i=1;
			for(d in data){
				tmp+='<li tabindex="'+i+'" onclick="sotb(this)">'+data[d].titolo+'</li>';
				i++;
			}
			tmp+='</ul>';
			ac.innerHTML = tmp;
			ac.classList.add('open');
		});
	});
	
	sotb = function (t){
		tb_search.value=t.innerHTML;
		btn_search.click();
	}
	
	uc.addEvent(tb_search,'focus',function(){ ac.classList.add('open'); });
	uc.addEvent(document,'click',function(e){ if(e.target==tb_search) return; ac.classList.remove('open'); });
	
	uc.addEvent(uc.query('#arrow>span.right')[0],'click',function(){ 
		uc.query('body>section')[0].style.left= -window.innerWidth+'px';
		c=this.parentNode.children;
		c[0].style.display='block';
		c[1].style.display='none';
	});
	uc.addEvent(uc.query('#arrow>span.left')[0],'click',function(){ 
		tb_search.parentNode.parentNode.classList.remove('active');
		h2r.style.visibility='visible';
		uc.query('body>section')[0].style.left= '0px';
		c=this.parentNode.children;
		c[1].style.display='block';
		c[0].style.display='none';
	});
	uc.addEvent(document,'keyup',function(e){ 
		switch(e.keyCode){
			case 37:
				if(e.target === tb_search) return;
				uc.query('#arrow>span.left')[0].click();
				break;			
			case 39:
				if(e.target === tb_search) return;
				uc.query('#arrow>span.right')[0].click();
				break;
			case 40:
				ac.children[0].firstChild.focus();
				break;
			case 13:
				if(e.target.parentNode.parentNode === ac) 
					e.target.click();
				break;
		}	
		return true;
	});
	
	
	uc.addEvent(btn_search,'click',function(e){
		e.preventDefault();
		uc.query('#arrow>span.right')[0].click();
		sl=uc.query('#arrow>span.left')[0];
		
		tb_search.parentNode.parentNode.classList.add('active');
		h2r.style.visibility='hidden';
		
		ac.classList.remove('open');
		
		
		form=this.parentNode;
		uc.post(form.action, uc.serialize(form),function(data,e){
			data=JSON.parse(data);
			prodotti.innerHTML = data.html;
			h2r.innerHTML = data.count + ' risultati trovati per <i>\'' + data.query + '\'</i>';
		});
		
	});
	
	resizePage();
	document.body.classList.add('load');
});
uc.addEvent(window,'resize',function(){
	resizePage();
});

function resizePage(){
	var pages=uc.query('.page');
	h=(window.innerHeight-60-38)+'px';
	w=window.innerWidth;		
	for(i=0; len=pages.length, i<len; i++){
		pages[i].style.height=h;
		pages[i].style.width=w+'px';
	}
	
	pages[0].parentNode.style.width=(w * 2)	+'px';
	sec=pages[0].parentNode.parentNode;
	sec.style.width=w	+'px';
	sec.style.height=h;
}
