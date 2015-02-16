jQuery(document).ready( function($) {
    var $row = $('#add_new_default_avatar').html();
    $('#add_new_default_avatar').click( function () {
        $row2 = '<p>' + $row + '</p>';

        //get original unique id
        var regex = new RegExp( $('#add_new_default_avatar_garbage').val(), "g");

        //replace with time-generated one
        var newDate = new Date;
        k = newDate.getTime();

        $row2 = $row2.replace( regex, k );
        $(this).before( $row2 );
        return false;
    });
});