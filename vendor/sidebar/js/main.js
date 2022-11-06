$(document).ready(function(){
    var barsSelect = $('#sidebarSelect');
    setWidgetType();
    renderWidgets(barsSelect.val());
    barsSelect.on('change', function(){
        renderWidgets(barsSelect.val());
    });
    var widgetType = $('#widgetType');
    widgetType.on('change', setWidgetType);
    WidgetForm();
    SidebarForm();
    LocationForm();

function renderWidgets(sidebar){
    
    
    var editor = new Editor(routes.sidebar);
    var markUp = '';
    editor.getWidgets(sidebar).then(function(widgets){
        for(let widget in widgets){ console.log(widget);
            markUp += '<form class="sidebar-form">';
            markUp += '<div class="collapse-container">';
            markUp += '<button type="button" class="widgetRemoveBtn close">&times;</button>';
            markUp += '<button type="button" class="widgetCollapseBtn close collapsed" data-toggle="collapse" data-target="#widget'+widget;
            markUp += '" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-bars"></i></button> <span class="spansh">'+widgets[widget].title+'</span>';
            markUp += '</div>';
            markUp += editor.render(widgets[widget], widget);
            markUp += '</form>';
        }
        $('#widgets').html(markUp);
        $('.widgetRemoveBtn').on('click', removeWidget);
        $('.save-widget-btn').on('click', function(){
            var parent = $(this).parent().parent();
            var id = parent.find('>.widget').attr('data-id');
            var inputs = parent.serializeField();
            inputs.title = parent.find('input[name="title"]').val();

            $.ajax({
                url: Editor.ExtractLinkVars(routes.widget.update, id),
                method: 'PUT',
                data: inputs
            }).done(function(res){
               console.log(res);
            });
        });
        $( "#widgets" ).sortable();
        $('#widgets').on( "sortupdate", function( event, ui ) {
        
            var item = ui.item;
            var index = ui.item.index();
            var id = $(item).find('>.widget').attr('data-id');
            console.log(ui.item);
         
            var sarray = [];
            $('#widgets').find('.card').each(function(){
            var idd = $(this).attr('data-id');
            sarray.push(idd);
            });

            $.ajax({
                url: Editor.ExtractLinkVars(routes.sidebar.put, id),
                method: 'PUT',
                data:{
                    order: sarray
                }
            }).done(function(res){
                console.log(res);
            });
        } );
    }).catch(function(){
        return;
    });
}


function removeWidget(e){
    var parent = $(e.target).parent().parent();
    console.log(parent);
    var target = parent.children('.widget');
    var id = target.attr('data-id');
    console.log(target);
    $.ajax({
        url: Editor.ExtractLinkVars(routes.widget.delete, id),
        method: 'DELETE',

    }).done(function(){
        parent.slideUp();
        setTimeout(function(){
            parent.remove();
        }, 1000);
    });

}

function addSidebar(){
    var inputs = $('#AddSidebarForm').serializeArray();

    var form = {};
    for(input in inputs){
        form[inputs[input].name] = inputs[input].value;
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', routes.sidebar.store);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function(){
    	if(xhr.readyState == 4 && xhr.status == 201){
		var res = JSON.parse(xhr.response);
		$('#sidebarSelect').html($('#sidebarSelect').html()+ "<option value='"+ res.id +"'>"+ res.name +"</option>");
	        $('#sidebars-locations').html($('#sidebars-locations').html()+ "<option value='"+ res.id +"'>"+ res.name +"</option>");
		$('#AddSidebarModal').modal('hide');
	        $('#AddSidebarForm').find('input[name="name"]').val('');
    	}
    }
    xhr.send(JSON.stringify(form));
}

function getHTML(container){
    var output = '';
    output += '<label>Content</label>';
    output += '<textarea class="form-control" name="content"></textarea>';
    container.html(output);
}

function getPosts(container){
    var categories = [];
    var output = '';
    $.ajax({
        url: '/categories',
        method: 'GET'
    }).done(function(res){
        categories = res;
        output += renderInput({label : 'Category', name: 'category', id: 'categorySelect', optionRef: {value: 'id', label: 'name'},options:categories});
        output += renderInput(
            {
                label : 'Styles',
                name: 'template',
                optionRef:
                    {
                        value: 'id',
                        label: 'label'
                    },
                options:[
                    {
                        id: 'template1',
                        label: 'Style1'
                    },
                    {
                        id: 'template2',
                        label: 'Style2'
                    },
                    {
                        id: 'template3',
                        label: 'Style3'
                    },
                    {
                        id: 'template4',
                        label: 'Style4'
                    },
                    {
                        id: 'template5',
                        label: 'Style5'
                    },
                    {
                        id: 'template6',
                        label: 'Style6'
                    },
                    {
                        id: 'template7',
                        label: 'Style7'
                    },
                    ,
                    {
                        id: 'template8',
                        label: 'Style8'
                    },
                    
                ]
            }
        );
        output += renderInput({label : 'Sort By', name: 'order', optionRef: {value: 'id', label: 'title'},options:[{id: 1, title: 'views'},{id: 2, title: 'Creating Time'}]});
        output += renderInput({
            'label' : 'Ordering',
            'name' : 'ordering',
            optionRef: {
                value: 'value',
                label: 'label'
            },
            options: [
                {
                    value: 1,
                    label: 'Ascending'
                },
                {
                    value: 2,
                    label: 'Descending'
                }
            ]
        });
        output += '<label>Count</label>';
        output += '<input type="number" name="count" class="form-control">';
        container.html(output);
    });
}

function setWidgetType(){
    var widgetContainer = $('#widgetContainer');
    var widgetType = $('#widgetType');
    if(widgetType.val() == 'html'){
        getHTML(widgetContainer);
    }else if(widgetType.val() == 'posts'){
        getPosts(widgetContainer);
    }
}

function renderInput(args = {}){
    var output = '';
    output += '<label>'+ args.label + '</label>';
    if(args.type = 'select'){
        output += '<select name="'+args.name+'" class="form-control">';
        for(let option in args.options) {
            output += '<option value="'+ args.options[option][args.optionRef.value] +'">'+ args.options[option][args.optionRef.label] +'</option>';
        }
        output += '</select>';
    }
    return output;
}

function addSidebarToLocation(e){
    e.preventDefault();
    var body = {
        key: $('#sidebars-locations').val(),
        value: $('#location').val()
    };
    var xhr = new XMLHttpRequest();
    xhr.open('POST', routes.location);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            $('#AddSidebarToLocationModal').modal('hide');
        }
    };
    xhr.send(JSON.stringify(body));
}

function AddWidget(e){
    e.preventDefault();
    var vals = $('#AddWidgetForm').serializeField();
    vals.title = $('#widget-title').val();
    vals.sidebar_id = $('#sidebarSelect').val();
    vals.width      = 
    $.ajax({
        url: routes.widget.store,
        method: 'POST',
        data: vals
    }).done(function(res){
        renderWidgets($('#sidebarSelect').val());
        $('#AddWidgetModal').modal('hide');
    });
}
    function WidgetForm(){
        $('#SaveWidgetBtn').on('click', function(){
            $('#AddWidgetForm').submit();
        });
        $('#AddWidgetForm').on('submit', AddWidget);
    };
    function SidebarForm(){
        $('#AddSidebarForm').on('submit', function(e){
            e.preventDefault();
            addSidebar();
        });
        $('#SubmitSidebarBtn').on('click', function(){
            $('#AddSidebarForm').submit();
        });
    };
    function LocationForm(){
        $('#SaveLocationBtn').on('click', function(){
            $('#AddLocationForm').submit();
        });
        $('#AddLocationForm').on('submit', addSidebarToLocation);
    }
});