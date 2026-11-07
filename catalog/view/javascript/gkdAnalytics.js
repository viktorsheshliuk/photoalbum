function gkdEctTrack(action, pid, desc) {
  var async = action == 'remove_from_cart' ? false : true;
	$.ajax({
		url: 'index.php?route=geekodev/analytics/getTrackData',
		type: 'post', dataType: 'json', cache: false, async: async,
		data: {pid: pid, action: action},
		success: function(res) {
      if (typeof res !== 'undefined') {
        gtag('event', action, res);
      }
		}
	});
}
/*
  function gkdEctTrackCheckout(step, desc) {
    return false;
    if (typeof jQuery != 'undefined') {
      $.ajax({
        url: 'index.php?route=geekodev/analytics/getTrackData',
        type: 'post', dataType: 'json', cache: false,
        data: {cart:1},
        success: function(res) {
          if (typeof res !== 'undefined') {
            gtag('event', action, res);
          }

        }
      });
    }
  }

if (typeof jQuery != 'undefined') {
  $(document).delegate('#button-confirm', 'click', function(){
    $.ajax({
      url: 'index.php?route=geekodev/analytics/getTrackData',
      type: 'post', dataType: 'json', cache: false,
      data: {cart:1},
      success: function(res) {
        if (typeof res !== 'undefined') {
          gtag('event', 'purchase', res);
        }
      }
    });
  });
}
*/