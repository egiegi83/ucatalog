uc.addEvent(window,'load',function(){
	var ca=uc.url();
	
<<<<<<< HEAD
	if(ca.action != 'aggiungi-prodotto') uc.query('body>section>nav a[href *= "' + ca.controller + (ca.action ? '/'+ca.action : '') + '"]')[0].parentNode.classList.add('current');
=======
	if(ca.action != 'aggiungi-prodotto') uc.query('body>section>nav a[href $= "' + ca.controller + (ca.action ? '/'+ca.action : '') + '"]')[0].parentNode.classList.add('current');
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
	uc.query('body>section>section')[0].classList.add('loaded');
	
	switch(ca.action){
		case 'prodotti':
<<<<<<< HEAD
			uc.addEvent(uc.query('body>section>section article.prodotto[selectable]'),'click',function(){
=======
			var ips=uc.query('#ips')[0];
			uc.addEvent(uc.query('body>section>section article.prodotto'),'click',function(){
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
				this.classList.toggle('selected');
			});
			
			uc.addEvent(uc.query('#del_prodotti'),'click',function(){
				var ps=uc.query('body>section>section article.prodotto.selected'),
				tmp=[];
				for(var i=0; len=ps.length, i<len; i++){
					tmp[i]=ps[i].dataset.id;
				}
<<<<<<< HEAD
				pspe = '{"data":["' + tmp.join('","') + '"]}';
				uc.post(uc.url('prodotti/elimina-prodotti-selezionati'),pspe,function(){
					for(var i=0; len=ps.length, i<len; i++){
						ps[i].classList.add('removed');
					}
				})
=======
				ips.value = '{"data":["' + tmp.join('","') + '"]}';
				console.log(ips.value);
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
			});
				
			break;
			
		case 'aggiungi-prodotto':
			var sa=uc.query('#selected_autori')[0], 
			tb_autori=uc.query('#tb_autori')[0],
			tbc=uc.query('#tbc')[0],
			res=uc.query('#tag_autori')[0],
<<<<<<< HEAD
			ha=uc.query('#hid_autori')[0],
			lbs=false,
			hi=uc.query('#addProdotto div.hiddeni.trop')[0];
			
			uc.addEvent(uc.query('#addProdotto select[name=tipo]'),'change',function(e){
				var divs=uc.query('#addProdotto form span[data-type]');
				for(var i=0; len=divs.length, i<len; i++) 
					divs[i].classList.remove('open');
				console.log(this.value);
				if(this.value != 0) {
					uc.each(uc.query('#addProdotto form .hiddeni span[data-type ~="'+ this.value +'"]'), function(){ this.classList.add('open') });
					hi.classList.add('open');
				} else {
					uc.each(uc.query('#addProdotto form .hiddeni span'), function(){ this.classList.remove('open') });
					hi.classList.remove('open');
				}
=======
			ha=uc.query('#hid_autori')[0],lbs=false;
				
			uc.addEvent(uc.query('#addProdotto select[name=tipo]'),'change',function(e){
				var divs=uc.query('#addProdotto form div');
				for(var i=0; len=divs.length, i<len; i++) 
					divs[i].classList.remove('open');
				console.log(this.value);
				if(this.value != 0)	uc.query('#addProdotto form div[data-type="'+ this.value +'"]')[0].classList.add('open');
>>>>>>> 82660096c95a2b520f1508555c103a87ce2f5328
			});
			
			uc.addEvent(tb_autori,'keyup',function(e){
				tb_key.call(this,e);
				searchRicercatore.call(this,e);
			});
			uc.addEvent(tb_autori,'focus',function(e){ searchRicercatore.call(this,e); });
			uc.addEvent(document,'click',function(e){ if(e.target==tb_autori) return; res.classList.remove('open'); });
				
			function select_autor_ids(){
				var sps=sa.querySelectorAll('span');
				arry=[];
				for(var i=0;len=sps.length, i<len; i++){
					arry[i]=sps[i].dataset.id;
				}
				if(tb_autori.textContent.length>0){
					tmp_a=tb_autori.textContent.split(',');
					for(a in tmp_a){
						arry[i++]=tmp_a[a].trim();
					}	
				}
				ha.value = '{"data":["' + arry.join('","') + '"]}';
				console.log(ha.value);
			};
				
			function tb_key(e){
				if(e.keyCode==8 && this.textContent.length==0){
					if(lbs){
						var sps=sa.querySelectorAll('span');
						if(sps.length){
							sa.removeChild(sps[sps.length-1]);
							tbc.style.width = (sa.offsetWidth + 50> 200 ? sa.offsetWidth + 50 : 200) + 'px';
						} else{ tbc.style.width='200px'; }
						lbs=false;
					} else{ lbs=true; }
				} else{
					lbs=false;
					console.log(this.offsetWidth+' - '+tbc.offsetWidth);
					if((sa.offsetWidth + this.offsetWidth) > tbc.offsetWidth){
						tbc.style.width = (tbc.offsetWidth + 50) +'px';
					}
				}
				select_autor_ids();
			}
				
			function searchRicercatore(e){
				uc.post('/u_catalog/autori/tag', {q: this.textContent},function(data,e){
					data=JSON.parse(data);
					tmp='<ul>';
					if(data.length){
						for(d in data){
							tmp+='<li data-id="'+ data[d].id +'" onclick="select_autore(this)">'+ data[d].nome +' '+ data[d].cognome +'</li>';
						}
					} else {
						tmp+='<li>Nessun risultato</li>';
					}
					res.innerHTML = tmp + '</ul>';
					res.classList.add('open');
				});
			}
			
			select_autore = function(t){
				tb_autori.textContent='';
				sa.innerHTML += '<span data-id="' + t.dataset.id + '">'+t.innerHTML+'</span>';
				tb_autori.focus();
				if(sa.offsetWidth > tbc.offsetWidth){
					tbc.style.width = (tbc.offsetWidth + 50) +'px';
				}
				select_autor_ids();
			};
			
			var st=uc.query('select[name=tipo]')[0];
			v = st.options[st.selectedIndex].value;
			if(v != 0)	uc.query('#addProdotto form div[data-type="'+ v +'"]')[0].classList.add('open');
			break;
	}
});


