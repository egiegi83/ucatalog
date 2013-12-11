uc.addEvent(window,'load',function(){
	var tb_search = uc.query('#tb_search')[0],
			ac = uc.query('#autocomplete')[0];
		
	uc.addEvent(tb_search,'keyup',function(){
		uc.post('/u_catalog/search', {Cerca:this.value},function(data,e){
			data=JSON.parse(data);
			tmp='<ul>';
			for(d in data){
				tmp+='<li>'+data[d].titolo+'</li>';
			}
			tmp+='</ul>';
			ac.innerHTML = tmp;
			ac.classList.add('open');
		});
	});
	
	uc.addEvent(tb_search,'focus',function(){ ac.classList.add('open'); });
	uc.addEvent(document,'click',function(e){ if(e.target==tb_search) return; ac.classList.remove('open'); });
	
	uc.addEvent(uc.query('#arrow>span.right')[0],'click',function(){ 
		uc.query('body>section')[0].style.left= -window.innerWidth+'px';
		c=this.parentNode.children;
		c[0].style.display='block';
		c[1].style.display='none';
	});
	uc.addEvent(uc.query('#arrow>span.left')[0],'click',function(){ 
		uc.query('body>section')[0].style.left= '0px';
		c=this.parentNode.children;
		c[1].style.display='block';
		c[0].style.display='none';
	});
	uc.addEvent(document,'keyup',function(e){ 
		switch(e.keyCode){
			case 37:
				uc.query('#arrow>span.left')[0].click();
			break;			
			case 39:
				uc.query('#arrow>span.right')[0].click();
			break;
		}	
	});
	resizePage();
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
