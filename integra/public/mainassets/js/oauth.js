 function onLoadGoogleCallback(){
    gapi.load('auth2', function() {
      auth2 = gapi.auth2.init({
        client_id: google_client_id,
        cookiepolicy: 'single_host_origin',
        scope: 'profile'
      });

    auth2.attachClickHandler(element, {},
      function(googleUser) {

        var url_action  = $("#oauth-google").data('url');
        var element     = $('body');

        $.ajax({
            url:url_action,
            method:   "POST",
            data: {token:googleUser.getAuthResponse().id_token},
            beforeSend: function(){
              blockMessage(element,"Please Wait Authentication . . . ","#fff");
            }
          })
          .done(function(response){
            $(element).unblock();
            window.location.href = response.results;
            return;
          })
          .fail(function(response) {
              var response = response.responseJSON;
              $(element).unblock();

              sweetAlert({
                title:'Opps!',
                text:response.message,
                type:"error",
              });
           })

        }, function(error) {          
          if(error.error=="popup_closed_by_user"){
            return false;
          }
          sweetAlert({
            title:'Failed!',
            text:'Sorry Google authentication failed',
            type:"error",
          });
        }
      );
    });

    element = document.getElementById('oauth-google');
  }


window.fbAsyncInit = function() {
    FB.init({
      appId      : fb_app_id,
      cookie     : true,  // enable cookies to allow the server to access 
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });
  }

function loginFacebook(){

  var url_action  = $("#oauth-facebook").data('url');
  var element     = $('body');

   FB.login(function(response) {
    if (response.status === 'connected') {
      $.ajax({
          url:url_action,
          method:"POST",
          data:{token:response.authResponse.accessToken},
          beforeSend: function(){
            blockMessage(element,"Please Wait Authentication . . . ","#fff");
          }
        })
        .done(function(response){
          $(element).unblock();
          window.location.href = response.results;
          return;
        })
        .fail(function(response) {
          var response = response.responseJSON;
          $(element).unblock();

           sweetAlert({
                title:'Opps!',
                text:response.message,
                type:"error",
              });
         })

    } else if (response.status === 'not_authorized') {
       sweetAlert({
          title:'Opps!',
          text:'Sorry Facebook app authentication failed',
          type:"error",
        });
      return;

    } else {
      sweetAlert({
          title:'Opps!',
          text:'Opps! PLease Log In To Your Facebook Account First',
          type:"warning",
        });
      return;

    }
    }, {scope: 'public_profile,email'}
   );
}

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
