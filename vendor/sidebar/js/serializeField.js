$(function(){
    $.fn.serializeField = function() {
        var result = {};

        this.each(function() {

            $(this).find("fieldset").each( function() {
                var $this = $(this);
                var name = $this.attr("name");

                if (name) {
                    result[name] = {};
                    $.each($this.serializeArray(), function() {
                        result[name][this.name] = this.value;
                    });
                }
                else {
                    $.each($this.serializeArray(), function() {
                        result[this.name] = this.value;
                    });
                }
            });

        });

        return result;
    };
});