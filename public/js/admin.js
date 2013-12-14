uc.addEvent(window,'load',function(){
	var ca=uc.url();
	
	uc.query('body>section>nav a[href $= "' + ca.action + '"]')[0].parentNode.classList.add('current');
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


