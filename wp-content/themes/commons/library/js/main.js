jQuery(document).ready( function($) {


  // COLLECT URL PARAMETERS FOR USE LATER
  function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable){return pair[1];}
    }
    return(false);
  }


  // OPEN EXTERNAL LINKS IN NEW WINDOW
  $('a').each(function() {
    if($(this).attr('href')) {
      var a = new RegExp('/' + window.location.host + '/');
      if(!a.test(this.href)) {
        $(this).click(function(event) {
          event.preventDefault();
          event.stopPropagation();
          window.open(this.href, '_blank');
        });
      }
    }
  });


  // WIDGET OPENING AND CLOSING:
  $(".widget-accordian-group .widgettitle").click(function() {
    var widget = $(this).parents(".widget");
    var widgetContent = widget.find(".widget-content");
    if(widget.is(".open")) {
      widgetContent.slideUp();
      widget.toggleClass("open");
    } else {
      widgetContent.slideDown();
      widget.toggleClass("open");
    }
  });


  // CREATE A GROUP PAGE
  if($('.group-page').length) {
    var groupID = getQueryVariable("id");
    $('#acf-this_group').hide();
    $('input#acf-field-this_group').val(groupID);

    if($('#create').length) {
      // Reset ACF form fields
      $('#acf-field-page_title, .wp-editor-area').val('');
    }
  }

  // SET SELECT WHEN CREATING A GROUP EVENT
  if($("body").is(".my-events")) {
    var groupID = getQueryVariable("id");
    $('select[name=group_id] option[value='+ groupID +']').prop('selected',true);
  }


  // CLEAN UP THE SOCIAL LINKS IF NEED BE
  $('.socialLinks a:not([href*="http://"])').each(function() {
    var url = $(this).attr('href');
    $(this).attr('href','http://'+ url);
  });


  // ADD JUMP BUTTON TO FORUMS
  if($('body:not(.group-forum-topic)').is('.forum')) { // Only show button for creating topic, not replies
    var dest = $('form#new-post');
    if($(dest).length > 0) { // Workaround to see if current user has permissions to post
      $('#bbpress-forums:eq(0) h3').append('<span class="blue-button jump">Start New Topic</span>');

      $('.jump').on('click',function() {
        $('html,body').animate({scrollTop: dest.offset().top}, 'slow');
        $('input#bbp_topic_title').focus();
      });
    }
  }


  // ADD CHOSEN TO SELECT BOXES
  $(".profile select").chosen({width: "75%"});
  $("select[name=group_id], #signup_form select").chosen();


  // MOBILE MENU OPEN/CLOSE
  $(".mobile-menu .nav-toggle").click(function() {
    var parent = $(this).parents(".mobile-menu");
    var inner = parent.find(".inner");
    if(parent.is(".open")) {
      inner.slideUp();
      parent.toggleClass("open");
    } else {
      inner.slideDown();
      parent.toggleClass("open");
    }
  });

});
