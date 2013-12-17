uc.addEvent(window,'load',function(){
	var ca=uc.url(),t;
	
	t=uc.query('body>section>nav a[href *= "' + ca.current + '"]')[0];
	if(t) t.parentNode.classList.add('current');
	
	uc.query('body>section>section')[0].classList.add('loaded');
	
	switch(ca.action){
		case 'prodotti':
			var selectable=uc.query('body>section>section article.prodotto[selectable] .remove');
			if(selectable.length>0){
				uc.addEvent(selectable,'click',function(){
					this.parentNode.parentNode.classList.toggle('selected');
				});
			}
			
			uc.addEvent(uc.query('#del_prodotti'),'click',function(e){
				e.preventDefault();
				var ps=uc.query('body>section>section article.prodotto.selected:not(.removed)'),
				tmp=[];
				for(var i=0; len=ps.length, i<len; i++){
					tmp[i]=ps[i].dataset.id;
				}
				pspe = '{"data":["' + tmp.join('","') + '"]}';
				uc.post(uc.url('prodotti/elimina-prodotti-selezionati'),pspe,function(){
					for(var i=0; len=ps.length, i<len; i++){
						ps[i].classList.add('removed');
					}
					window.setTimeout(function(){
						for(i=0; len=ps.length, i<len; i++){
							ps[i].style.display='none';
						}
					},500);
				})
			});
				
			break;
			
		case 'aggiungi-prodotto': case 'modifica':
			var sa=uc.query('#selected_autori')[0], 
			tb_autori=uc.query('#tb_autori')[0],
			tbc=uc.query('#tbc')[0],
			res=uc.query('#tag_autori')[0],
			ha=uc.query('#hid_autori')[0],
			lbs=false,
			hi=uc.query('#addProdotto div.hiddeni.trop')[0],
			allegati=uc.query('#addProdotto #allegati')[0];
			
			uc.addEvent(uc.query('#addProdotto select[name=tipo]'),'change',function(e){
				var divs=uc.query('#addProdotto form span[data-type]');
				for(var i=0; len=divs.length, i<len; i++) 
					divs[i].classList.remove('open');
				if(this.value != 0 && this.value != 'brevetti') {
					uc.each(uc.query('#addProdotto form .hiddeni span[data-type ~="'+ this.value +'"]'), function(){ this.classList.add('open') });
					hi.classList.add('open');
				} else {
					uc.each(uc.query('#addProdotto form .hiddeni span'), function(){ this.classList.remove('open') });
					hi.classList.remove('open');
				}
			});
			
			uc.addEvent(uc.query('#addProdotto input,#addProdotto select,#addProdotto textarea'),'focus',function(e){
				this.parentNode.querySelector('label.err').style.display='none';
			});
			
			uc.addEvent(tb_autori,'keyup',function(e){
				tb_key.call(this,e);
				searchRicercatore.call(this,e);
			});
			uc.addEvent(tb_autori,'focus',function(e){ searchRicercatore.call(this,e); });
			uc.addEvent(document,'click',function(e){ if(e.target==tb_autori) return; res.classList.remove('open'); });
			uc.addEvent(uc.query('#addProdotto #add_file'),'click',function(){
				ouf=document.createElement('input');
				ouf.type='file';
				ouf.name='allegati[]';
				
				allegati.appendChild(ouf);
			});
			
			var oldalldel = uc.query('#addProdotto .oldallegati li .icon.remove');
			if(oldalldel.length>0){
				uc.addEvent(oldalldel,'click',function(e){
					var t=this;
					if(confirm('Sei sicuro di voler cancellare il file?')){
						uc.post(uc.url('prodotti/rimuovi-allegato'), {ra: this.dataset.id},function(data,e){
							t.parentNode.classList.add('removed');
							window.setTimeout(function(){
								t.parentNode.style.display='none';
							},500);
						});
					}
				});	
			}
			
			function getSelected_autors(){
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
				return arry;
			}	
				
			function select_autor_ids(){
				ha.value = '{"data":["' + getSelected_autors().join('","') + '"]}';
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
					if((sa.offsetWidth + this.offsetWidth) > tbc.offsetWidth){
						tbc.style.width = (tbc.offsetWidth + 50) +'px';
					}
				}
				select_autor_ids();
			}
				
			function searchRicercatore(e){
				uc.post(uc.url('autori/tag'), {q: this.textContent},function(data,e){
					if(data != '') {
						data=JSON.parse(data);
						tmp='<ul>';
						if(data.length){
							for(d in data){
								tmp+='<li data-id="'+ data[d].ricercatore.id +'" onclick="select_autore(this)">'+ data[d].nome +' '+ data[d].cognome +'</li>';
							}
						} else {
							tmp+='<li>Nessun risultato</li>';
						}
						res.innerHTML = tmp + '</ul>';
						res.classList.add('open');
					} else {
						res.innerHTML = '<ul><li>Nessun risultato</li></ul>';
						res.classList.add('open');
					}
				});
			}
			
			select_autore = function(t){
				var _sa=getSelected_autors(),f=false;
				for(var j=0; len=_sa.length, j<len; j++){ if(_sa[j]==t.dataset.id){ f=true; break;}}
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
			if(v != 0 && v != 'brevetti'){	
				uc.each(uc.query('#addProdotto form span[data-type ~= "'+ v +'"]'),function(){ this.classList.add('open'); });
				hi.classList.add('open');
			}
			
			if(sa.offsetWidth > tbc.offsetWidth){
					tbc.style.width = (tbc.offsetWidth + sa.offsetWidth) +'px';
			}
			select_autor_ids();
			
			break;
	}
});


