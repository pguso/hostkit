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

                params.show_path.prepend = "Pfad: <span>/" + path + "</span>";
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
                    setAttribute("id", file.fPath.toLowerCase())
                    className = "item parent ft_" + file.fType;
                    innerHTML = file.fName;
                }

                if (file.fType == 'folder') {
                    params.folders.append(element);
                } else {
                    params.files.append(element);
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
                    className = "item ft_" + file.fType;
                    innerHTML = file.fName;
                }

                if (file.fType == 'folder') {
                    $(target_id + " ul").append(element);
                } else {
                    params.files.append(element);
                }
            }

            $(target_id + " ul li:first-child").remove();
            $(target_id + " ." + target_class).slideDown("fast");

        }

        var event_target = '';
        var status = true;


        $('#file-manager-folders li').off('click').click(function(event) {

            var str = $(event.target).attr('class');
            var id = "#" + $(event.target).attr('id');

            if(event_target != $(event.target).attr('id')) {

                if(str.match(/active/g) === null) {
                    selectItem(event);
                } else {
                    $(id + " ul").slideToggle("fast");
                }

                event_target = $(event.target).attr('id');
                status = false;
                $(id).unbind('click');

            }
        });

        function selectItem(event) {

            var ftype = $(event.target).attr("fType");
            var fpath = $(event.target).attr("fPath");
            var ftitle = $(event.target).attr("title");

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

    search();
}

$('#file-manager-folders li').live( 'click', function() {
    alert('go for it');
});

function init() {
    filemanager({
        folders:$("#file-manager-folders"),
        files:$("#file-manager-files"),
        btn_refresh:$("#btn-refresh"),
        show_path:$("#file-manager-path"),
        filter:$("#file-manager-filter"),
        openFolderOnSelect:true,
        current_path:""
    });
}

var file_manager;

if (file_manager == 1) {
    $(window).load(function () {
        init();
    });
}

$(".ico_new_file").click(function () {
    var path = $('#file-manager-path span');
    $.ajax({
        type:"GET",
        url:"/add_file/",
        data:{
            filename:"test.php",
            current_path: path
        }
    })
});

