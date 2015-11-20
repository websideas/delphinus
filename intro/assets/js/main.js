(function($){
    "use strict"; // Start of use strict



    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */

    $(window).load(function(){

        $(window).trigger("scroll");
        $(window).trigger("resize");

    });

    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).resize(function(){

        init_js_height();
    });

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function(){
        init_wow();

    });

    /* ---------------------------------------------
     Height 100%
     --------------------------------------------- */
    function init_js_height(){

        $(".item-height-window").css('height', $(window).height());
        $(".item-height-parent").each(function(){
            $(this).height($(this).parent().first().height());
        });

    }


    /* ---------------------------------------------
     WOW animations
     --------------------------------------------- */

    function init_wow(){
        var wow = new WOW({
            mobile: false
        });

        if ($("body").hasClass("appear-animate")){
            wow.init();
        }
    }


})(jQuery); // End of use strict