function validarn(e) { 
	    tecla = (document.all) ? e.keyCode : e.which; 
	    if (tecla==8) return true; 
		 if (tecla==9) return true; 
		 if (tecla==11) return true; 
	    patron = /[0-9-A-Za-z.@ñÑáéíóúÁÉÍÓÚàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛÑñäëïöüÄËÏÖÜ\s\t]/; 
	    te = String.fromCharCode(tecla); 
	    return patron.test(te); 
	}
	function float(e){
		 tecla = (document.all) ? e.keyCode : e.which; 
	    if (tecla==8) return true; 
		 if (tecla==9) return true; 
		 if (tecla==11) return true; 
	    patron = /[0-9-.\s\t]/; 
	    te = String.fromCharCode(tecla); 
	    return patron.test(te); 
	} 
function DataTable(){/*Constructor*/
	/*Atributos*/
	var self=this;/**/
	this.idContainer;
	this.idTable;
	this.url;
	this.type;
	this.filters;
	this.paginator;
	this.DataTable;
	this.tabla;
	this.thead;
	this.tbody;
	this.tfoot;
	this.title;
	this.click;
	this.attributesrow;
	/*Constructor recibe varios parametros*/
	function CerateDataTable(idContainer,idTable,url,type,filters,paginator){
		this.idContainer=idContainer;
		this.idTable=idTable;
		this.url=url;
		this.type=type;
		this.filters=filters || false;
		this.paginator=paginator|| false;
	};
	/*Constructor recibe un objeto*/
	this.CerateDataTable=function(DataTable){
		this.idContainer=DataTable.idContainer;
		this.idTable=DataTable.idTable;
		this.url=DataTable.url;
		this.type=DataTable.type;
		this.filters=DataTable.filters;
		this.paginator=DataTable.paginator;
		this.thead=DataTable.thead;
		this.tfoot=DataTable.tfoot;
		this.title=DataTable.title;
		this.cick=DataTable.click;
		this.DataTable=DataTable;
		CreateTable();
	};
	function CreateTable(){
		CreateDataTable();
	}
	function AsignFiltersTh(name,placeholder,id){
		var input=document.createElement('input');
		input.setAttribute('name',name);
		input.setAttribute('placeholder',placeholder);
		input.setAttribute('id','input'+id);
		input.setAttribute('class','form-control filters');
		input.addEventListener("keypress", function(e){
			tecla = (document.all) ? e.keyCode : e.which;
			if(tecla==13)
				loadTable();
		});
		return input;
	}
	function CreateDataTable(){/*Crea en si la tabla*/
		var table=document.createElement('table');
		var thead=document.createElement("thead");
		table.setAttribute('id',self.getidTable());
		table.setAttribute('class','table table-bordered table-striped table-condensed flip-content');
		var theads=document.createElement('thead');
		theads.setAttribute('class','flip-content');
		var thead=self.getThead();
		var tr=document.createElement('tr');
		tr.setAttribute('class','flip-content');
		for(var i=0;i<thead.length;i++){
			var th=document.createElement('th');
			if(typeof(thead[i].type) === "undefined"){
				var NodText=document.createTextNode(thead[i].text);
				th.appendChild(AsignFiltersTh(thead[i].bdName,thead[i].text,thead[i].text));
				th.appendChild(NodText);
				tr.appendChild(th);
			}else{
				var NodText=document.createTextNode(thead[i].text);
				th.appendChild(NodText);
				th.setAttribute('class','inputth');
				tr.appendChild(th);
			}
			//theads.appendChild(th);
			
		}
		theads.appendChild(tr);
		table.appendChild(theads);
		getId(self.getidContainer()).appendChild(table);
		loadTable();
	}
	function loadTable(){/*Carga la tabala datatable*/
		DeleteRows();
 		var xhttp = new XMLHttpRequest();
    	xhttp.onreadystatechange = function() {
	      	if(xhttp.readyState == 4 && xhttp.status == 200) {//Si todo salio bien
	      		var result=JSON.parse(xhttp.responseText);
        		var tbody=document.createElement("tbody");
        		var text="";
        		var tr="";
        		var thead=self.getThead();
        		 if(isEmptyJSON(result)==false){/*Si tiene información*/
        		 	for(var i=0;i<result.length;i++){//Recorremos el resultado de la petición
        		 		tr=document.createElement('tr');
        		 		llaves(tr,result,i);
        		 		for(var j=0;j<thead.length;j++){//Recorremos el thead para ver que campos vamos a poner en el tbody
        		 			td=document.createElement('td');        		 			
        		 			if(typeof(thead[j].type) !== "undefined"){
								td.appendChild(createInputTr(thead[j],result[i][thead[j].bdName]));
								td.style.textAlign = "center";
								tr.appendChild(td);
        		 			}else{
        		 				text=document.createTextNode(result[i][thead[j].bdName]);
	        		 			td.appendChild(text);
	        		 			tr.appendChild(td);	
	        		 			tr.addEventListener("click", self.DataTable.click);	
        		 			}
        		 			
        		 		}
        		 		tbody.appendChild(tr);
        		 	}
        		 	
        		 }else{

        		 	tr=document.createElement("tr");
        		 	var td=document.createElement("td");
        		 	td.setAttribute("class","vacio");
        		 	td.setAttribute("colspan",thead.length);
        		 	text=document.createTextNode("No exísten registros");
        		 	td.appendChild(text);
        		 	tr.appendChild(td);
        		 	tbody.appendChild(tr);
        		 }
        		 getId(self.idTable).appendChild(tbody);
	      	}
      	}
      	xhttp.open(self.getType(), self.getUrl(), true);
	    if(self.getFilters()==true){
	       xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	       xhttp.send(CreateUrlFilter());
	    }else{
	       xhttp.send();  
	    }
	}
	function createInputTr(td,id){
		var input=td.type;
		switch(input){
			case'img':
				var img=document.createElement('img');
        		img.setAttribute('class','tblimg');
				img.setAttribute('src',td.src);
				img.setAttribute('id',id);
				img.style.width=td.width;
				img.style.height=td.height;
				img.addEventListener("click",td.click);
				return img;
			break;
			case'radio':
				var radio=document.createElement('input');
				radio.setAttribute('type','radio');
        		radio.setAttribute('class',td.class);
        		radio.setAttribute('id','tlbrdb'+id);
        		radio.setAttribute('name','tlbrdb');
				radio.setAttribute('value',id);
				radio.style.width=td.width;
				radio.style.height=td.height;
				radio.addEventListener("click",td.click);
				return radio;
			break;
			case'select':
				var select=document.createElement('select');
        		select.setAttribute('class',td.class);
        		select.setAttribute('id','tlbslct'+id);
        		select.setAttribute('name','tlbslct');
        		if(typeof(td.options)!=="undefined"){
        			var i=td.options.length-1;
        			for (i;i>=0;i--) {
        				var options=document.createElement("option");
					    options.value = td.options[i].value;
					    options.text = td.options[i].option;
					    select.appendChild(options);
					}
        		}
				select.style.width=td.width;
				select.style.height=td.height;
				select.addEventListener("change",td.onchange,false);
				return select;
			break;
			case'text':
				var text=document.createElement('input');
				text.setAttribute('type','text');
        		text.setAttribute('class',td.class);
        		text.setAttribute('id','tlbrdb'+id);
        		text.setAttribute('name','tlbtxt');
				text.setAttribute('value',id);
				text.style.width=td.width;
				text.style.height=td.height;
				text.addEventListener("keypress",td.onkeypress);
				return text;
			break;
		}

	}
	function llaves(tr,json,posi){
		var pos=posi;
		var attributes=[];
		for( var i in json){
			var indexs=Object.keys(json[pos]);
			for(var x=0;x<indexs.length;x++){
				attributes[x]=indexs[x];
				tr.setAttribute('data-'+indexs[x],json[pos][indexs[x]]);		
			}
			
		}
		self.setAttributesrow(attributes);
		return tr;
	}
	function CreateUrlFilter(){/*Metodo que se encarga de armar la url para el filytrado de datoas*/
	    var urlSend="";
	    var Input=document.getElementsByClassName('filters');
	    console.log(Input);
	    for (i=0;i<Input.length;i++){
	      if(i==0){
	        urlSend+='_token='+document.getElementById("txttoken").value+'&'+Input[i].name+'='+Input[i].value ;
	      }else if(i==Input.length-1){
	        urlSend+='&'+Input[i].name+'='+Input[i].value ;
	      }else{
	        urlSend+='&'+Input[i].name+'='+Input[i].value ;
	      }
	    }
	    console.log(urlSend);
	    return urlSend;
	}
	function DeleteRows(){
		var table = getId(self.getidTable());
	    if(table.rows.length>1)
	      for(var i=table.rows.length-1;i>=1;i--){table.deleteRow(i);}  
	    
	}
/*Metodos pulicob*/
this.reload=function(){
	loadTable();
}
	/*Nos regresa el id  del elemento deceado para mayor comodida(escribir menos document.getElementById)*/
	function getId(id){
		return document.getElementById(id);
	}
	function isEmptyJSON(obj){
		for(var i in obj) { return false; }
    	return true;
	}
	/*Getters*/
	this.getidContainer=function(){
		return this.idContainer;
	};
	this.getidTable=function(){
		return this.idTable;
	};
	this.getUrl=function(){
		return this.url;
	};
	this.getType=function(){
		return this.type;
	};
	this.getFilters=function(){
		return this.filters;
	};
	this.getPaginator=function(){
		return this.paginator;
	};
	this.getDataTable=function(){
		return this.tabla;
	};
	this.getThead=function(){
		return this.thead;
	}
	this.getTbody=function(){
		return this.tbody;
	}
	this.gettfooter=function(){
		return this.tfoot;
	}
	this.gettclick=function(){
		return this.click;
	}
	this.getDataTable=function(){
		return this.DataTable;
	}
	this.getAttributesrow=function(){
		return this.attributesrow;
	}
	/*Setters*/
	this.setidContainer=function(idContainer){
		this.idContainer=idContainer;
	};
	this.setidTable=function(idTable){
		this.idTable=idTable;
	};
	this.setUrl=function(url){
		this.url=url;
	};
	this.setType=function(type){
		this.type=type;
	};
	this.setFilters=function(filters){
		this.filters=filters;
	};
	this.setPaginator=function(paginator){
		this.paginator=paginator;
	};
	this.setDataTable=function(DataTable){
		this.tabla=DataTable;
	};
	this.setThead=function(thead){
		this.thead=thead;
	}
	this.setTbody=function(tbody){
		this.tbody=tbody;
	}
	this.settfooter=function(tfooter){
		thie.tfoot=tfooter;
	}
	this.setAttributesrow=function(attributes){
		this.attributesrow=attributes;
	}
	

}

function valudateForm(){
	var self=this;/**/
	this.idfrm;
	this.iddlg;
	function validate(id,iddlg){
		this.id=id;
		this.iddlg=iddlg;
	}
/*Metodo que sire para validar el formulario,recive el id del formulario,el color si para la validacion,el color si no pasa la validacion, y los elementos a ignorar la validacion si es que los hay(a estos elementos no se le aplicara la validacion, tiene que ser el id del elemento|)*/
	this.Validate=function(frm,successcolor,unseccesscolor,elementsignorate){
		var exito=0;
		var inputs=document.getElementById(frm);
		for(var i=0;i<inputs.elements.length;i++){
			var  input=inputs.elements[i];
			if(input.type=="text"){
				if(exceptions(elementsignorate,input.id)!=1){
					if(input.value==""){
						getId(input.id).style.borderBottomColor=unseccesscolor;
						exito++;
					}else{
						getId(input.id).style.borderBottomColor=successcolor;
					}	
				}
			}else if(input.type=="select" || input.type=="select-one"){
				if(exceptions(elementsignorate,input.id)!=1){
					if(input.value=="9999" || input.value==""){
						getId(input.id).style.borderBottomColor=unseccesscolor;
						exito++;
					}else{
						getId(input.id).style.borderBottomColor=successcolor;
					}	
				}
			}
		}
		console.log(exito);
		return exito;
	}
	this.isEmptyJSON=function(obj){
		 for(var i in obj) { return false; }
		 return true;
	}
	this.validateEmail=function(id){
		var exito=0;
		var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		if (!regex.test(getId(id).value.trim())) 
		    exito=1;
		return exito;
	}
	this.filldlgelement=function(row,atributostr){
		var inputs=atributostr
			data=[];//generamos un array
        for(var i=0;i<atributostr.length;i++){//Reccorremos los atributos para sacr el valor
          data[i]=row.getAttribute('data-'+atributostr[i]); //Obtenemos el valor yt lo almacenamnos en el array
        }
		for(var i=0;i<inputs.length;i++){
			var elements=document.getElementById(self.getFrm());
			for(var j=0;j<elements.elements.length;j++){
				var  input=elements.elements[j];
				var inputaux='txt'+inputs[i];
				if(input.id==inputaux){
					console.log(input.id);
					getId(input.id).value=data[i];
				}
			}
		}
	}
	this.Clrfrm=function(idfrm,successcolor){
		var inputs=document.getElementById(idfrm);
		for(var i=0;i<inputs.elements.length;i++){
			var  input=inputs.elements[i];
			if(input.type=="text"){
				input.value="";
				getId(input.id).style.borderBottomColor=successcolor;
			}else if(input.type=="select" || input.type=="select-one"){
				getId(input.id).style.borderBottomColor=successcolor;
				document.getElementById(input.id).selectedIndex =0;
			}
		}
	}
	function exceptions(elements,elemtn){//funcion que busca en el erreglo si existen elementos a ignorar , es decir no se le aplicara la validacion de formulario
		console.log(elements);
		if(elements.length>0){
			for(var i=0;i<elements.length;i++){
				if(elements[i]==elemtn)
					return 1;
			}
		}

	}

	/*Getters*/
	this.getFrm=function(){
		return this.idfrm;
	}
	this.getIddlg=function(){
		return this.iddlg;
	}
	/*Setters*/
	this.setFrm=function(frm){
		this.idfrm=frm;
	}
	this.setIddlg=function(iddlg){
		this.iddlg=iddlg;
	}
	function getId(id){
		return document.getElementById(id);
	}
}

