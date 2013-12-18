uc.addEvent(window,'load',function(){
	var ca=uc.url(),t;
	console.log(ca);
	
	if(ca.current == 'admin') 
		t=uc.query('body>section>nav a[href $= "lista-utenti"]')[0];
	else
		t=uc.query('body>section>nav a[href $= "' + ca.current + '"]')[0];
	
	if(t) t.parentNode.classList.add('current');
	
	uc.query('body>section>section')[0].classList.add('loaded');
	
	switch(ca.action){
		case '/':
			var cb_ricercatore=uc.query('#cb_ricercatore')[0],
				div_ratio=uc.query('#div_ratio')[0];
			
			uc.addEvent(cb_ricercatore,'click',function(e){
				if(this.checked){
					div_ratio.style.display='inherit';
				} else {
					div_ratio.style.display='none';
				}
			});
			break;
	};
			
});
