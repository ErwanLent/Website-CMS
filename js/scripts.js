$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });

  var page = getUrlVars()["page"];

  /*=====================================================================================
    Rich Editor
  =======================================================================================*/

  // Start editor
  // var elements = document.querySelectorAll('#first-title'),
  //   editor = new MediumEditor(elements, {
  //     disableToolbar : true,
  //     forcePlainText : true
  // });

  // Elastic text areas
  $('.content-input').elastic();

  /*=====================================================================================
    Publishing Controls
  =======================================================================================*/

  // On publish
  $('#publish').click(function() {

    $('body').css('overflow', 'hidden');
    $('.loading-overlay').fadeIn(function() {
        $('.loader').show();
    });
    
    
    switch(page)
    {
      case "home":
        // Content to update
        var firstTitle = $('#first-title').val();
        var secondTitle = $('#second-title').val();
        var firstContent = $('#first-content').val();
        var secondContent = $('#second-content').val();

        // Post updated content
        $.post( "php/publish.php", { 
            page : page,
            firstTitle : firstTitle,
            secondTitle : secondTitle,
            firstContent : firstContent,
            secondContent : secondContent
          }).done(function( data ) {
            
            if (data == 'true')
            {
              // Success
              setTimeout(function() {
                $('.loader').fadeOut(function() {
                  $('.loading-overlay').fadeOut(function() {
                    $('body').css('overflow', 'auto');
                  });
                });
              }, 2000);

            }
            else
            {
              // Failure
              setTimeout(function() {
                
              }, 2000);
            }
        });

        break;
      case "media":
        break;
      default:
        break;
    }

  });

  // On Discard
  $('#discard').click(function() {
    location.reload();
  });

});

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}