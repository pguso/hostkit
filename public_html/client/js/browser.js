function browser(params){ 
	if(params == null) params={};
	if(params.contentsDisplay == null) params.contentsDisplay = document.body;
        if(params.contentsFiles == null) params.contentsFiles = "";
	if(params.currentPath == null) params.currentPath="";
	if(params.filter == null) params.filter="";
	if(params.loadingMessage == null) params.loadingMessage="Loading...";
	if(params.data == null) params.data="";

	var search = function(){
		if(params.pathDisplay!= null) params.pathDisplay.innerHTML = params.loadingMessage;
		
		var f=typeof(params.filter)=="object"?params.filter.value:params.filter;
		var a=new Ajax();
		with (a){
			Method="POST";
			URL="/client/filemanager";
			Data="path=" + params.currentPath + "&filter=" + f + "&data=" + params.data; 
			ResponseFormat="json";
			ResponseHandler = showFiles;
			Send();
		}
                
	}
	
	if(params.refreshButton!=null)params.refreshButton.onclick=search;

	var showFiles = function(res){
		if(params.pathDisplay != null){
			var p = res.currentPath;
			p = p.replace(/^(\.\.\/|\.\/|\.)*/g,"");
			
			if(params.pathDisplay != null){
				params.pathDisplay.title = p;
				if(params.pathMaxDisplay!=null){
					if(p.length>params.pathMaxDisplay)p="..."+p.substr(p.length-params.pathMaxDisplay,params.pathMaxDisplay);
				}
				params.pathDisplay.innerHTML= "Pfad: <span>/" + p + "</span>";
			}
		}
		
		params.contentsDisplay.innerHTML = "";
                params.contentsFiles.innerHTML = "";
		
		for (i=0; i<res.contents.length; i++){
			var f = res.contents[i];
			var element = document.createElement("p");
			with(element){
				setAttribute("title",f.fName);
				setAttribute("fPath",f.fPath);
				setAttribute("fType",f.fType);
				className=" item ft_"+f.fType;
				innerHTML=f.fName;
			}
                        
                        if(f.fType == 'folder') {
                            params.contentsDisplay.appendChild(element);
                        } else {
                            params.contentsFiles.appendChild(element);
                        }

			element.onclick = selectItem;
		}
                
                if(params.contentsFiles.innerHTML == '') {
                    params.contentsFiles.innerHTML = '<p class="no-files">In diesem Ordner sind keine Dateien vorhanden.</p>';
                }
	}

	var selectItem = function(){
		var ftype=this.getAttribute("fType");
		var fpath=this.getAttribute("fPath");
		var ftitle=this.getAttribute("title");

		if(params.onSelect!=null)params.openFolderOnSelect=params.onSelect({"type":ftype,"path":fpath,"title":ftitle,"item":this},params);
		if(params.openFolderOnSelect==null)params.openFolderOnSelect = true;

		if(ftype=="folder" && params.openFolderOnSelect){
			params.currentPath=fpath;
			search();
		}
	}

	search();
}