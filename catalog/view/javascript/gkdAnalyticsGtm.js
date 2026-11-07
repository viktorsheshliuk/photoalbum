function gkdEctTrack(action, pid, desc) {
  var async = action == 'remove' ? false : true;
	$.ajax({
		url: 'index.php?route=geekodev/analytics/getTrackData',
		type: 'post', dataType: 'json', cache: false, async: async,
		data: {pid: pid, action: action},
		success: function(res) {
      if (typeof res[0] !== 'undefined') {
        gkaLayer.push({
          'event': action,
          'ecommerce': {
            'add': {
              'products': res
            }
          }
        });
        /*
        ga('ec:addProduct', res[0]);
        ga('ec:setAction', action);
        ga('send', 'event', $(document).find('title').text(), desc, res[0].name);
        */
      }
		}
	});
}

  function gkdEctTrackCheckout(step, desc) {
    if (typeof jQuery != 'undefined') {
      $.ajax({
        url: 'index.php?route=geekodev/analytics/getTrackData',
        type: 'post', dataType: 'json', cache: false,
        data: {cart:1},
        success: function(res) {
          if (typeof res[0] !== 'undefined') {
            gkaLayer.push({
              'event': 'checkout',
              'ecommerce': {
                'checkout': {
                  'actionField': {'step': step},
                  'products': res
                }
              }
            });
          }
          /*
          for(var i=0; i<res.length; i++) {
            if (typeof res[i] !== 'undefined') {
              ga('ec:addProduct', res[i]);
            }
          }
          ga('ec:setAction', 'checkout', {'step':step, 'option':desc});
          ga('send', 'pageview');
          */
        }
      });
    }
  }

if (typeof jQuery != 'undefined') {
  $(document).delegate('#button-confirm', 'click', function(){
    gkdEctTrackCheckout(3, 'Checkout confirm'); 
  });
}