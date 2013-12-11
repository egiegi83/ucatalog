uc.addEvent(window,'load',function(){
	uc.liveEvent('.tT','click',function(e){
		var t=uc.query(this.dataset.target)[0];
		t.classList.toggle('open');	
		this.classList.toggle('active');
	});
});
