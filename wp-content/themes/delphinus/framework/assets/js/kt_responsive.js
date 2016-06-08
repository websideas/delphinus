/*
 *
 *	KT socials in composer
 *	------------------------------------------------
 *
 */

(function($){
    $( 'body' ).on( 'focusout', '.kt-input-group input', function ( ){
        var $parent = $(this).closest('.edit_form_line'),
            $value = '',
            $unit = $parent.find('.kt-responsive-unit').text(),
            $result = $parent.find('.kt-responsive-value');

        $parent.find('.form-control').each(function(){
            var $this = $(this),
                $val = parseInt( $(this).val());

            if(!isNaN($val) && $val != 0 ){
                $value += $this.attr('name')+':'+$val+$unit+';';
            }

        });

        $result.val($value);
    });
})(jQuery);