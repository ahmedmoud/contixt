

        var Widget = /** @class */ (function () {
    function Widget(title, id, sidebar_id, order, content) {
        this.title = title;
        this.id = id;
        this.sidebar_id = sidebar_id;
        this.order = order;
        this.content = content;
    }
    return Widget;
}());
var PostWidget = /** @class */ (function () {
    function PostWidget(title, id, sidebar_id, order, content) {
        this.title = title;
        this.id = id;
        this.sidebar_id = sidebar_id;
        this.order = order;
        this.content = content;
    }
    return PostWidget;
}());
var HTMLWidget = /** @class */ (function () {
    function HTMLWidget(title, id, sidebar_id, order, content) {
        this.title = title;
        this.id = id;
        this.sidebar_id = sidebar_id;
        this.order = order;
        this.content = content;
    }
    return HTMLWidget;
}());
var Editor = /** @class */ (function () {
    function Editor(routes) {
        var _this = this;
        this.routes = routes;
        
    $.ajax({
        url: '/categories',
        method: 'GET'
    }).done(function(res){ _this.categories = res; });
    
   
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/categories');
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                _this.categories =  this.categories  = JSON.parse(xhr.response);
            }
        };
        xhr.send();
  
    }
    Editor.prototype.getWidgets = function (bar) {
        var $this = this;
        return new Promise(function (resolve, reject) {
            if (bar == null) {
                reject(false);
            }
            else {
                var xhr_1 = new XMLHttpRequest();
                xhr_1.open('GET', $this.routes.get + "?bar=" + bar);
                xhr_1.onreadystatechange = function () {
                    if (xhr_1.readyState == 4 && xhr_1.status == 200) {
                        resolve(JSON.parse(xhr_1.response));
                    }
                };
                xhr_1.send();
            }
        });
    };
    Editor.prototype.render = function (widget, index) {
        if (widget.content.type == 'html') {
            return this.renderHTML(widget, index);
        }
        else if (widget.content.type == 'posts') {
            return this.renderPosts(widget, index);
        }
    };
    Editor.prototype.renderHTML = function (widget, index) {
        console.log(widget);
        var output = "<div data-id=\"" + widget.id + "\"  class=\" card widget collapse  \" id=\"widget" + index + "\">";
        output += this.renderTitle(widget);
        output += '<div class="card-body">';
        output += '<fieldset name="content">';
        

        
        output += this.renderInput({
            label: 'Width',
            name: 'width',
            optionRef: {
                value: 'id',
                label: 'title'
            },
            options: [
                {
                    'id': '12',
                    'title': '1'
                },
                {
                    'id': '4',
                    'title': '1/3'
                },
                {
                    'id': '8',
                    'title': '2/3'
                },
                {
                    'id': '3',
                    'title': '1/4'
                },
                {
                    'id': '6',
                    'title': '1/2'
                },
                {
                    'id': '9',
                    'title': '3/4'
                },
                
            ],
            old: widget.content.width,
            equaliver: 'id'
        });  
        


        output += "<textarea name=\"content\" class=\"widget-content form-control\">" + widget.content.content + "</textarea>";
        output += '</fieldset>';
        output += '</div>';
        output += '<button type="button" class="btn btn-success save-widget-btn">Save</button>';
        output += '</div>';
        output += '</div>';
        return output;
    };
    Editor.prototype.renderPosts = function (widget, index) {
        var output = "<div data-id=\"" + widget.id + "\" class=\"card widget collapse \" id=\"widget" + index + "\">";
        output += this.renderTitle(widget);
        
        
             output += '<div class="card-body">';
        output += '<fieldset name="content">';
        output += '<div class="widget widget-content">';

        
        
          output += this.renderInput({
            label: 'Width',
            name: 'width',
            optionRef: {
                value: 'id',
                label: 'title'
            },
            options: [
                {
                    'id': '12',
                    'title': '1'
                },
                {
                    'id': '4',
                    'title': '1/3'
                },
                {
                    'id': '8',
                    'title': '2/3'
                },
                {
                    'id': '3',
                    'title': '1/4'
                },
                {
                    'id': '6',
                    'title': '1/2'
                },
                {
                    'id': '9',
                    'title': '3/4'
                },
                
            ],
            old: widget.content.width,
            equaliver: 'id'
        });  
        
        
        
      output += this.renderInput({
            label: 'Posts IDs Or Categories',
            name: 'postsOrcategories',
            optionRef: {
                value: 'id',
                label: 'title'
            },
            options: [
                {
                    'id': 'cats',
                    'title': 'categories'
                },
                {
                    'id': 'posts',
                    'title': 'Posts Ids'
                }
            ],
            old: widget.content.postsOrcategories,
            equaliver: 'id'
        });  
        
                
        
        output += '<div class="card-body">';
        output += '<label>Posts IDs</label>';
        output += "<textarea name=\"postsIDs\" class=\"widget-content form-control\">" + widget.content.postsIDs + "</textarea>";
        output += '</div>';  
                

        output += this.renderInput({
            label: 'Style',
            name: 'template',
            optionRef: {
                value: 'id',
                label: 'title'
            },
            options: [
                {
                    'id': 'template1',
                    'title': 'Style1'
                },
                {
                    'id': 'template2',
                    'title': 'Style2'
                },
                {
                    'id': 'template3',
                    'title': 'Style3'
                },
                {
                    'id': 'template4',
                    'title': 'Style4'
                },
                {
                    'id': 'template5',
                    'title': 'Style5'
                },
                {
                    'id': 'template6',
                    'title': 'Style6'
                },
                {
                    'id': 'template7',
                    'title': 'Style7'
                },
                {
                    'id': 'template8',
                    'title': 'Style8'
                }
            ],
            old: widget.content.template,
            equaliver: 'id'
        }); 

        output += this.renderInput({ label: 'Category', name: 'category', id: 'categorySelect', optionRef: { value: 'id', label: 'name' }, options: main_cats, old: widget.content.category, equaliver: 'id' });
        output += this.renderInput({ label: 'Sort By', name: 'order', optionRef: { value: 'id', label: 'title' }, options: [{ id: 1, title: 'views' }, { id: 2, title: 'Creation Time' }], old: widget.content.order, equaliver: 'id' });
        output += this.renderInput({
            'label': 'Ordering',
            'name': 'ordering',
            equaliver: 'value',
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
            ],
            old: widget.content.ordering,
        });
        
        output += '<label>Color</label>';
        output += "<input type=\"text\" value=\"" + widget.content.color + "\" name=\"color\" class=\"colorpicker form-control\">";
        
        
        
        output += '<label>Count</label>';
        output += "<input type=\"number\" value=\"" + widget.content.count + "\" name=\"count\" class=\"form-control\">";
        output += '</div>';
        output += "</fieldset>";
        output += '</div>';
        output += '<button type="button" class="btn btn-success save-widget-btn">Save</button>';
        output += '</div>';
        return output;
    };
    Editor.prototype.renderTitle = function (widget) {
        var output = '<div class="card-title">';
        output += '<label>Widget Title</label>';
        output += "<input name=\"title\" type=\"text\" class=\"form-control widget-title\" value=\"" + widget.title + "\">";
        output += '</div>';
    

        return output;
    };
    Editor.ExtractLinkVars = function (link, val, type) {
        if (val === void 0) { val = null; }
        if (type === void 0) { type = 1; }
        var match = link.match(/{(\w+)\??}/);
        if (type == 1) {
            if (typeof val === 'string') {
                return link.replace(match[0], val);
            } 
            else {
                return link.replace(match[0], val[match[1]]);
            }
        }
        else {
            return match[1] ? match : false;
        }
    };
    Editor.prototype.renderInput = function (args) {
        var output = '';
        output += '<label>' + args.label + '</label>';
        if (args.type = 'select') {  
            output += '<select name="' + args.name + '" class="form-control">';
            for (var option in args.options) { 
                var selected = '';
                if (args.old == args.options[option][args.equaliver]) {
                    selected = 'selected';
                }
                output += "<option value=\"" + args.options[option][args.optionRef.value] + "\" " + selected + ">" + args.options[option][args.optionRef.label] + "</option>";
            }
            output += '</select>';
        }
        return output;
    };
    return Editor;
}());
