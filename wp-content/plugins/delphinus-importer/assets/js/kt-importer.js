
/*
 *
 *  Admin $ Functions
 *  ------------------------------------------------
 *
 */



(function($){
    "use strict"; // Start of use strict

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        
        var $start = 1,
            $progress = 0,
            $last_step = false;
        
    
        $('body').on('click','.kt-importer-button',function(e){
    
            e.preventDefault();
    
            var $this = $(this),
                $count = parseInt($this.data('count')),
                $id = $this.data('id'),
                $theme = $(this).closest('.theme').addClass('importing'),
                $progressbar = $theme.find('.demo-import-process span'),
                $progress_step = Math.ceil(100/$count),
                $imported = $theme.find('.kt-importer-imported');
                
            $progressbar.css('width', '5%');
            $('.demo-import-loader').show();
    
            import_content( $id, $progressbar, $progress_step, $imported, $this, $theme);
            
            
    
        });
        
        function import_content($id, $progressbar, $progress_step, $imported, $this, $theme){
            var $data = {
                action: 'kt_importer_content',
                demo: $id,
                count: $start
            };
            
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: $data,
                success: function (data, textStatus, XMLHttpRequest) {
                    
                    if ( $progress + $progress_step < 100 ){
                        $progress += $progress_step;
                        $progressbar.css('width', $progress+'%');
                        $start++;
                        import_content($id, $progressbar, $progress_step, $imported, $this, $theme);
                    }else{
                        $last_step = true;
                        $progress = 0;
                    }
                    if($last_step){
                        import_options_widgets($id);
                        var $data = {
                            action: 'kt_importer_content',
                            demo: $id
                        };
                        $.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: $data,
                            success: function(data, textStatus, XMLHttpRequest){
                                $progressbar.css('width', '100%');
                                $('.demo-import-loader').hide();
                                $imported.css('display', 'inline-block');
                                $this.hide();
                                $theme.addClass('active').removeClass('importing');
                            }
                        });
                    }
                    
                    
                }
            });
        }
    
        function import_options_widgets($id){
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: { action: 'kt_importer_options', demo: $id },
                success: function(data){ }
            });
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: { action: 'kt_importer_widgets', demo: $id },
                success: function(data){ }
            });
        }



    });
})(jQuery);