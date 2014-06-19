var animationSpeed = 2500;

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
    $("html, body").animate({ scrollTop: 0 }, "slow");
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
            finishAnimation(data, "Page successully published.");
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
            finishAnimation(data, "Page successully published.");
        });
        break;
      case "new":
        // Content to update
        var newTitle = $('#new-title').val();
        var newContent = $('.editable').html();

        // Post updated content
        $.post( "php/publish.php", { 
            page : page,
            newTitle : newTitle,
            newContent : newContent
          }).done(function( data ) {
            finishAnimation(data, "Page successully created.");
            setTimeout(function(){
              window.location = "admin.php?page=" + encodeURIComponent(newTitle);
            }, animationSpeed + 300);
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
            finishAnimation(data, "Page successully published.");
        });
        break;
    }
  });

$('#delete').click(function() {

    if ($('.message-bar').is(':visible'))
    {
      $('.message-bar').slideToggle();
    }

    $('body').css('overflow', 'hidden');
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $('.loading-overlay').fadeIn(function() {
        $('.loader').show();
    });

    $.post( "php/publish.php", { 
        page : "delete",
        pageTitle : page
      }).done(function( data ) {
        console.log(data);
        finishAnimation(data, "Page successully deleted");

        setTimeout(function(){
          window.location = "admin.php?page=home";
        }, animationSpeed + 300);
    });

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

function finishAnimation(response, successMessage)
{

  if (response == 'true')
  {
    // Success
    setTimeout(function() {
      $('.loader').fadeOut(function() {
        $('.loading-overlay').fadeOut(function() {
          $('body').css('overflow', 'auto');
          $('.message-bar').css('background-color', 'green');
          $('.message-bar').html(successMessage);
          $('.message-bar').slideToggle();
        });
      });
    }, animationSpeed);
  }
  else
  {
    console.log(response);
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