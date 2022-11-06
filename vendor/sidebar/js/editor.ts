class Widget{
    constructor(
        public title: String,
        public id: Number,
        public sidebar_id: Number,
        public order: Number,
        public content: {
            type: String
        }
        ) {}
}
class PostWidget{
    constructor(
        public title: String,
        public id: Number,
        public sidebar_id: Number,
        public order: Number,
        public content: {
            type: String,
            count: Number,
            category: Number,
            order: Number,
            ordering: Number
        }
    ){}
}
class HTMLWidget{
    constructor(
        public title: String,
        public id: Number,
        public sidebar_id: Number,
        public order: Number,
        public content: {
            type: String,
            content: String
        }
    ){}
}
class Editor{
    categories: any[];
    constructor(private routes){
        
        $.ajax({
                url: '/categories',
                method: 'GET',
            }).done(function(res){
              this.categories = JSON.parse(res);
            });
        /*
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/categories');
        xhr.onreadystatechange = ()=>{
            if(xhr.readyState == 4 && xhr.status == 200){
                this.categories = JSON.parse(xhr.response);
            }
        };
        xhr.send();
        */
    }

    public getWidgets(bar: String|Number){
        let $this: this = this;
        return new Promise(function(resolve, reject){
            if(bar == null){
                reject(false);
            }else{
                let xhr = new XMLHttpRequest();
                xhr.open('GET', `${$this.routes.get}?bar=${bar}`);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        resolve(JSON.parse(xhr.response));
                    }
                };
                xhr.send();
            }
        });

    }

    public render(widget, index){
        if(widget.content.type == 'html') {
            return this.renderHTML(widget, index);
        }else if(widget.content.type == 'posts'){
            return this.renderPosts(widget, index);
        }
    }

    private renderHTML(widget: HTMLWidget, index: Number){

        let output = `<div data-id="${widget.id}"  class="card widget" id="widget${index}">`;
        output += this.renderTitle(widget);
        output += '<div class="card-body">';
        output += '<fieldset name="content">';
        output += `<textarea name="content" class="widget-content form-control">${widget.content.content}</textarea>`;
        output += '</fieldset>';
        output += '</div>';
        output += '<button type="button" class="btn btn-success save-widget-btn">Save</button>';
        output += '</div>';
        output += '</div>';
        return output;
    }



    private renderPosts(widget: PostWidget, index: Number){

        let output = `<div data-id="${widget.id}" class="card widget" id="widget${index}">`;
        output += this.renderTitle(widget);
        output += '<div class="card-body">';
        output += '<fieldset name="content">';
        output += '<div class="widget widget-content">';
        output += this.renderInput(
            {
                label : 'Style',
                name: 'template',
                optionRef: {
                    value: 'id',
                    label: 'title'
                },
                options:
                    [
                        {
                            'id': 'template1',
                            'title': 'Style1'
                        }
                        {
                            'id': 'template2',
                            'title': 'Style2'
                        },
                        {
                            'id': 'template3',
                            'title': 'Style3'
                        }
                    ],
                old: widget.content.category,
                equaliver: 'id'
            } 
        ); 
        output += this.renderInput({label : 'Category', name: 'category', id: 'categorySelect', optionRef: {value: 'id', label: 'name'},options:this.categories, old: widget.content.category, equaliver: 'id'});
        output += this.renderInput({label : 'Sort By', name: 'order', optionRef: {value: 'id', label: 'title'},options:[{id: 1, title: 'views'},{id: 2, title: 'downloads'}], old: widget.content.order, equaliver: 'id'});
        output += this.renderInput({
            'label' : 'Ordering',
            'name' : 'ordering',
            old: widget.content.ordering,
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
            ]
        });
        output += '<label>Count</label>';
        output += `<input type="number" value="${widget.content.count}" name="count" class="form-control">`;

        output += '</div>';
        output += "</fieldset>";
        output += '</div>';
        output += '<button type="button" class="btn btn-success save-widget-btn">Save</button>';
        output += '</div>';
        return output;
    }

    private renderTitle(widget: Widget){
        let output = '<div class="card-title">';
        output += '<label>Widget Title</label>';
        output += `<input name="title" type="text" class="form-control widget-title" value="${widget.title}">`;
        output += '</div>';
        return output;
    }

    public static ExtractLinkVars(link, val=null, type=1)
    {
        let match = link.match(/{(\w+)\??}/);
        if (type == 1) {
            if (typeof val === 'string') {
                return link.replace(match[0], val);
            } else {
                return link.replace(match[0], val[match[1]]);
            }
        } else {
            return match[1] ? match : false ;
        }
    }

    public renderInput(args: {label: string, type: string, name: string,options: {any}, optionRef: {value: string|any, label: string|any}, old: any, equaliver: any}){
        var output = '';
        output += '<label>'+ args.label + '</label>';
        if(args.type = 'select'){
            output += '<select name="'+args.name+'" class="form-control">';
            for(let option in args.options) {
                let selected = '';
                if(args.old == args.options[option][args.equaliver]){
                    selected = 'selected';
                }
                output +=`<option value="${args.options[option][args.optionRef.value]}" ${selected}>${args.options[option][args.optionRef.label]}</option>`;
            }
            output += '</select>';
        }
        return output;
    }
}