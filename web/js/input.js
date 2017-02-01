var entityMap = {
  "&": "&amp;",
  "<": "&lt;",
  ">": "&gt;",
  '"': '&quot;',
  "'": '&#39;',
  "/": '&#x2F;'
};

function escapeHtml(string) {
  return String(string).replace(/[&<>"'\/]/g, function (s) {
    return entityMap[s];
  });
}

function postForm( $form, callback ){
 
  /*
   * Get all form values
   */
  var values = {};
  $.each( $form.serializeArray(), function(i, field) {
    values[field.name] = field.value;
  });
  var input = escapeHtml($("#user_input_input").val());
  $("#append_container").append('<div class="log0">' + input + '</div>');
  $("#user_input_input").val('');


  $.ajax({
    type        : $form.attr( 'method' ),
    url         : $form.attr( 'action' ),
    data        : values,
    success     : function(msg) {
        if (input == 'quit') {
          location.reload();
         }
         else {
            $("#append_container").append('<div>' + msg + '</div>');
            $('html, body').animate({ 
                scrollTop: $(document).height()-$(window).height()}, 
                200, 
                "linear"
                );
         }

    }
  });
 
}
