(function($){
    $.fn.menu = function(settings){

        var configs = {
            'ulIdentifier': '.navigation',
            'menuOrientation': 'horizontal',
            'menuContainer': '#menu',
            'cssFile': '/css/menu.css'
        };

        var navMenu = {

            init: function(){

                if (settings){
                    $.extend(configs,settings);
                }

                navMenu.defineCss();

            },

            defineCss: function(){

                $("<link/>",{
                    rel: "stylesheet",
                    type: "text/css",
                    href: configs.cssFile

                }).appendTo('head');

                if (configs.menuOrientation == 'horizontal'){

                    $(configs.menuContainer).css({
                        'float': 'right'
                    });

                    /*$(configs.ulIdentifier+' > li').css({
                        'display': 'inline'
                    });*/
                    $(configs.ulIdentifier+' > li').addClass('horizontal');


                }else if(configs.menuOrientation == 'vertical'){

                    /*$(configs.ulIdentifier).css({
                        'display': 'inline'
                    });*/
                    $(configs.ulIdentifier+' > li').addClass('vertical');

                }
            }
        };



        //return this.each(function(){
        //});
        navMenu.init();
        return this;

    }

})(jQuery);