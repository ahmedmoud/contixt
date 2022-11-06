$(function(){
    $.fn.serializeJSON = function(){
        var fields = this.serializeArray();
        var values = {};
        for(var field in fields){
            values[fields[field].name] = fields[field].value;
        }
        return values;
    };
});
