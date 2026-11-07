(function($){
  $.fn.extend({
  toggler: function(options) {
    var defaults = {
      onText: 'Enabled',
      offText: 'Disabled',
      bold: false,
      icons: true,
      onIcon: 'fa fa-check',
      offIcon: 'fa fa-times',
      onColor: '#57A155',
      offColor: '#D87261',
      mode: 'text',
      effect: 'slide',
    };
    
  
    return this.each(function() {
      var o = $.extend({}, defaults, options, $(this).data());
      var obj = $(this);    
      var items = $("li", obj);
      //obj.attr('type', 'hidden');
      obj.hide();

      if(obj.val() == 1) {
        var onDisabled = '';
        var offDisabled = 'display:none;';
      } else {
        var onDisabled = 'display:none;';
        var offDisabled = '';
      }
      
      
      
      // create main container and insert it in dom
      var html  = '';
      html += '<div class="form-control" style="position:relative;padding:0;overflow:hidden">';
      html +=   '<div data-type="on" style="'+onDisabled+getStyle(o, 1)+'">'+getText(o, 1)+'</div>';
      html +=   '<div data-type="on" style="'+offDisabled+getStyle(o, 0)+'">'+getText(o, 0)+'</div>';
      html += '</div>';
      
      html = $(html);
      
      obj.after(html);
      
      // create events
      html.on('click', function(){
        if (html.prev().val() == 1) {
          if (o.effect == 'slide') {
            html.children('[data-type=on]').slideToggle();
            html.children('[data-type=off]').slideToggle();
            html.children('[data-type=off]').detach().prependTo(html);
          } else {
            html.children('[data-type=on]').fadeOut();
            html.children('[data-type=off]').fadeIn();
          }
          
          var val = 0;
        } else {
          if (o.effect == 'slide') {
            html.children('[data-type=on]').slideToggle();
            html.children('[data-type=off]').slideToggle();
          } else {
            html.children('[data-type=on]').fadeIn();
            html.children('[data-type=off]').fadeOut();
          }
          
          var val = 1;
        }
        
        // assign value to real input and trigger change
        html.prev().val(val).trigger('change');
      });
    });
  }
});

// function to get style of each element
function getStyle(o, val) {
  var style = '';
  
  // set style values
  if (o.effect == 'fade') {
    style += 'width:100%;position:absolute;top:0;';
  }
  
  if (o.mode == 'background') {
    style += 'text-shadow: 1px 1px 1px #555;';
  }
  
  style += '-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:pointer;padding: 8px 13px;'

  if (o.bold) {
    style += 'font-weight:bold';
  }
  
  if (val == 1) {
    if (o.mode == 'text') {
      style += 'color:'+o.onColor;
    } else if (o.mode == 'background') {
      style += 'background:'+o.onColor;
    }
  } else {
    if (o.mode == 'text') {
      style += 'color:'+o.offColor;
    } else if (o.mode == 'background') {
      style += 'background:'+o.offColor;
    }
  }

  if (o.mode == 'background') {
    style += ';color:#fff';
  }
  
  return style;
}

// function to get formated text
function getText(o, val) {
  // use icons ?
  if (!o.icons) {
    var onIcon = offIcon = '';
  } else {
    var onIcon = '<i class="'+o.onIcon+'"></i> ';
    var offIcon = '<i class="'+o.offIcon+'"></i> ';
  }
  
  if (val == 1) {
    var text = onIcon + o.onText;
  } else {
    var text = offIcon + o.offText;
  }
  
  return text;
}
})(jQuery);