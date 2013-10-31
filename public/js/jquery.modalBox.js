(function($){
    $.fn.modalBox = function(settings){

        var configs = {
            'height': "250",
            'width': "500",
            'top': "20%",
            'left': "30%",
            'title': "Demo title",
            modalContents: ''
        };

        if (settings){
            $.extend(configs,settings);
        }

        function addBlockPage(){

            var blockPage = $('<div class="modalBlockPage"></div>');

            $(blockPage).appendTo('body');

        };

        function addModalWindow(){

            var modalWindow = (configs.modalContents != '') ? $('<div class="modalWindow"><a href="javascript:void(0);" class="modalWindowClose"></a><div class="innerModelWindow"><h2>'+configs.title +'</h2><div>'+configs.modalContents+'</div></div></div>')
        : $('<div class="modalWindow"><a href="javascript:void(0);" class="modalWindowClose"></a><div class="innerModelWindow"><h2>'+configs.title +'</h2></div></div>');

            //var modalWindow = $('<div class="modalWindow"><a href="javascript:void(0);" class="modalWindowClose"></a><div class="innerModelWindow"><h2>'+configs.title +'</h2></div></div>');
            $(modalWindow).appendTo('.modalBlockPage');

            $('.modalWindowClose').click(function(evt){
                evt.preventDefault();

                $('.modalBlockPage').fadeOut().remove();
                $(this).parent().fadeOut().remove();
            });

        };

        function addBlockWindowStyles(){
            var pageHeight = $(document).height();
            var pageWidth = $(window).width();

            $('.modalBlockPage').css({
                'position': 'absolute',
                'top': '0',
                'left': '0',
                'z-index': '100',
                'background-color': 'rgba(0,0,0,0.6)',
                'height': pageHeight,
                'width': pageWidth
            });
        };

        function addModalWindowStyles(){

            $('.modalWindow').css({
                'position': 'absolute',
                'top': configs.top,
                'left': configs.left,
                'display': 'none',
                'height': configs.height + 'px',
                'width': configs.width + 'px',
                'border': '1px solid #fff',
                'box-shadow': '0px 2px 7px #292929',
                '-moz-box-shadow': '0px 2px 7px #292929',
                '-webkit-box-shadow': '0px 2px 7px #292929',
                'border-radius': '10px',
                '-moz-border-radius': '10px',
                '-webkit-border-radius': '10px',
                'background': '#f2f2f2',
                'z-index': '50'
            });

            $('.modalWindowClose').css({
                'position': 'relative',
                'top': '-25px',
                'left': '20px',
                'float':'right',
                'display': 'block',
                'height': '50px',
                'width': '50px',
                'background': 'url(http://www.paulund.co.uk/playground/demo/jquery_modal_box/images/close.png) no-repeat'
            });

            $('.innerModelWindow').css({
                'background-color': '#fff',
                'height': (configs.height - 50) + 'px',
                'width': (configs.width - 50) + 'px',
                'padding': '10px',
                'margin': '15px',
                'border-radius': '10px',
                '-moz-border-radius': '10px',
                '-webkit-border-radius': '10px'
            });

        };

        return this.click(function(evt){
            evt.preventDefault();

            addBlockPage();
            addModalWindow();
            addBlockWindowStyles();
            addModalWindowStyles();

            $('.modalWindow').fadeIn();
        });

        return this;
    }
})(jQuery);
