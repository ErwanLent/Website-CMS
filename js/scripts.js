$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });

  var page = getUrlVars()["page"];

  /*=====================================================================================
    Rich Editor
  =======================================================================================*/

  // Start editor
  var elements = document.querySelectorAll('.editable'),
    editor = new MediumEditor(elements);

  // Elastic text areas
  $('.content-input').elastic();

  /*=====================================================================================
    Publishing Controls
  =======================================================================================*/

  // On publish
  $('#publish').click(function() {

    if ($('.message-bar').is(':visible'))
    {
      $('.message-bar').slideToggle();
    }

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
            finishAnimation(data);
        });

        break;
      case "media":
        // Content to update
        var firstTitle = $('#first-title').val();
        var firstContent = $('.editable').html();

        // Post updated content
        $.post( "php/publish.php", { 
            page : page,
            firstTitle : firstTitle,
            firstContent : firstContent
          }).done(function( data ) {
            finishAnimation(data);
        });
        break;
      default:
        // Content to update
        var content = $('.editable').html();

        // Post updated content
        $.post( "php/publish.php", { 
            page : page,
            updatedContent : content
          }).done(function( data ) {
            finishAnimation(data);
        });
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

function finishAnimation(response)
{
  var animationSpeed = 2500;
  
  if (response == 'true')
  {
    // Success
    setTimeout(function() {
      $('.loader').fadeOut(function() {
        $('.loading-overlay').fadeOut(function() {
          $('body').css('overflow', 'auto');
          $('.message-bar').css('background-color', 'green');
          $('.message-bar').html('Update published.');
          $('.message-bar').slideToggle();
        });
      });
    }, animationSpeed);

  }
  else
  {
    // Failure
    setTimeout(function() {
      $('.loader').fadeOut(function() {
        $('.loading-overlay').fadeOut(function() {
          $('body').css('overflow', 'auto');
          $('.message-bar').css('background-color', 'red');
          $('.message-bar').html('An error occurred.');
          $('.message-bar').slideToggle();
        });
      });
    }, animationSpeed);
  }
}