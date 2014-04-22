function filemanager(params) {

    if (params == null) {
        params = {};
    }

    if ($(params.folders).length == 0) {
        params.folders = document.body;
    }

    if ($(params.files).length == 0) {
        params.files = "";
    }

    if ($(params.current_path).length == 0) {
        params.current_path = "";
    }

    if ($(params.filter).length == 0) {
        params.filter = "";
    }

    if ($(params.loadingMessage).length == 0) {
        params.loadingMessage = "Loading...";
    }

    if ($(params.data).length == 0) {
        params.data = "";
    }

    if(params.btn_refresh != null) {
        params.btn_refresh.onclick = search();
    }

    var event_target = '';
    var status = '';
    var fpath = '';

    var showFiles = function(res) {

        if (params.show_path != null && params.show_path != '') {
            var path = res.currentPath;
            path = path.replace(/^(\.\.\/|\.\/|\.)*/g, "");

            if (params.show_path != null) {
                params.show_path.title = path;
                if (params.pathMaxDisplay != null) {
                    if (path.length > params.pathMaxDisplay) {
                        path = "..." + path.substr(path.length - params.pathMaxDisplay, params.pathMaxDisplay);
                    }
                }

                params.show_path.append = "Pfad: <span>/" + path + "</span>";
            }
        }

        params.folders.innerHTML = "";
        params.files.innerHTML = "";

        if(params.current_path == '') {

            for (i = 0; i < res.contents.length; i++) {
                var file = res.contents[i];
                var element = document.createElement("li");
                with (element) {
                    setAttribute("title", file.fName);
                    setAttribute("fPath", file.fPath);
                    setAttribute("fType", file.fType);
                    setAttribute("id", file.fPath.toLowerCase());
                    innerHTML = file.fName;
                    if(file.fType != 'folder') {
                        className = "item parent ft_" + file.fType + " file-menu";
                    } else {
                        className = "item parent ft_" + file.fType;
                    }
                }

                if (file.fType == 'folder') {
                    params.folders.append(element);
                } else {
                    //params.files.append(element);

                }

            }
        } else {
            var current_path = params.current_path.toLowerCase().replace(/\//g,"_");
            var target_folder = $("#file-manager-folders").find("#" + current_path);
            var target_class = current_path;
            var target_id = "#" + current_path;

            $(target_id).addClass('active');
            $("#file-manager-files").empty();

            $(target_id).append('<ul style="display: none" class="' + target_class + '"></ul>');

            for (i = 0; i < res.contents.length; i++) {
                var file = res.contents[i];
                var element = document.createElement("li");

                with (element) {
                    setAttribute("title", file.fName);
                    setAttribute("fPath", file.fPath);
                    setAttribute("fType", file.fType);
                    setAttribute("id", file.fPath.toLowerCase().replace(/\//g,"_"))
                    if(file.fType != 'folder') {
                        className = "item parent ft_" + file.fType + " file-menu";
                    } else {
                        className = "item parent ft_" + file.fType;
                    }
                    innerHTML = file.fName;
                }

                if (file.fType == 'folder') { //&& $(target_id).attr('class') != 'item parent ft_folder active') { //&& $(target_id + ' li').children().length) {
                    $(target_id + " ul").append(element);
                } else if (file.fType != 'folder') {
                    params.files.append(element);
                }
            }

            $(target_id + " ul li:first-child").remove();
            $(target_id + " ." + target_class).slideToggle("fast");

        }

        $('#file-manager-folders li').off('click').click(function(event) {

            var str = $(event.target).attr('class');
            var id = "#" + $(event.target).attr('id');

            if(event_target != $(event.target).attr('id')) {

                if(str.match(/active/g) === null) {
                    selectItem(event);
                    $(event.target).addClass('open');
                }

                event_target = $(event.target).attr('id');

            } else {
                toggleFolderContent(event);
                event.stopImmediatePropagation();
                //console.log(event.isImmediatePropagationStopped());
            }
        });

        $('#file-manager-folders .parent').one('click',function(event){
            toggleFolderContent(event);
        });

        function toggleFolderContent(event) {
            var id = "#" + $(event.target).attr('id');

            $(event.target).toggleClass('open');
            $(id + " ul").slideToggle("fast");

        }

        function selectItem(event) {

            var ftype = $(event.target).attr("fType");
            var ftitle = $(event.target).attr("title");
            fpath = $(event.target).attr("fPath");

            if (params.onSelect != null) {
                params.openFolderOnSelect = params.onSelect({"type":ftype, "path":fpath, "title":ftitle, "item":this}, params);
            }

            if (params.openFolderOnSelect == null) {
                params.openFolderOnSelect = true;
            }

            if(ftype == "folder" && params.openFolderOnSelect) {
                params.current_path = fpath;
                search();
            }
        }

        if (params.files.innerHTML == '') {
            params.files.innerHTML = '<p class="no-files">In diesem Ordner sind keine Dateien vorhanden.</p>';
        }
    }

    function search() {
        if (params.show_path != null) {
            params.show_path.innerHTML = params.loadingMessage;
        }

        var filter = typeof(params.filter) == "object" ? params.filter.value : params.filter;
        var ajax = new Ajax();
        with (ajax) {
            Method = "POST";
            URL = "/client/filemanager";
            Data = "path=" + params.current_path + "&filter=" + filter + "&data=" + params.data;
            ResponseFormat = "json";
            ResponseHandler = showFiles;
            Send();
        }

    }

    $(".ico_new_file").click(function () {
        if(params.current_path == '') {
            params.current_path = './';
        }

        var filename = prompt('Neue Datei in ' + params.current_path + ' anlegen. \nDateiname:');

        $.ajax({
            type:"POST",
            url:"/client/add_file",
            data:{
                filename: filename,
                path: params.current_path
            }
        })
    });

    $(".ico_new_folder").click(function () {
        if(params.current_path == '') {
            params.current_path = './';
        }

        var foldername = prompt('Neuen Ordner in ' + params.current_path + ' anlegen. \nOrdnername:');

        $.ajax({
            type:"POST",
            url:"/client/add_folder",
            data:{
                filename: foldername,
                path: params.current_path
            }
        })
    });

    search();
}

function init() {
    filemanager({
        folders: $("#file-manager-folders"),
        files: $("#file-manager-files"),
        btn_refresh: $("#btn-refresh"),
        show_path: $("#file-manager-path"),
        filter: $("#file-manager-filter"),
        openFolderOnSelect: true,
        current_path: ""
    });
}

var file_manager;

if (file_manager == 1) {
    $(window).load(function () {
        init();
    });
}

/***** kontext menu *******/
$(function(){
    if($('.context-menu-one').length != 0) {
        $.contextMenu({
            selector: '.file-menu',
            callback: function(key, options) {
                var m = "clicked: " + key;
                window.console && console.log(m) || alert(m);
            },
            items: {
                "edit": {name: "ändern", icon: "edit"},
                "cut": {name: "ausschneiden", icon: "cut"},
                "copy": {name: "kopieren", icon: "copy"},
                "paste": {name: "einfügen", icon: "paste"},
                "delete": {name: "löschen", icon: "delete"},
                "sep1": "---------",
                "quit": {name: "abbrechen", icon: "quit"}
            }
        });
    }

    $('.context-menu-one').on('click', function(e){
        console.log('clicked', this);
    })
});




