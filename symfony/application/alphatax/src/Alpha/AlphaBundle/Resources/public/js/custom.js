/* 
 * @created on 28 Aug 2014
 */
console.log("custom.js file injected");

$( document ).on( "click", "#add-new-cat", function(e) {
    e.stopImmediatePropagation();
    console.log("new category click event");
});



$(function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#cname" ),
      description = $( "#cdescription" ),
      allFields = $( [] ).add( name ).add( description ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "name", 3, 16 );
      valid = valid && checkLength( description, "description", 6, 80 );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Category name may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      valid = valid && checkRegexp( description, /^[a-z]([0-9a-z_\s])+$/i, "Description may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      
      if ( valid ) {
          
        $.ajax({
          type : "POST",
          url  : "/new-ajax",
          data : {
                                name        : name.val(),
                                desc       : description.val()
          },
          dataType : "json",
          beforeSend : function(){
          console.log(" :::: before_send ::::");
          console.log("name: "+name.val()+"desc : "+description.val());
          },
          timeout: 10000,
          success :function(response){
              console.log(" :::: success ::::");  
              console.log(response);
                if (response.data === "success") {
                    $("#message").addClass("alert alert-success").html("Category Saved Successfully ,Close this Popup to continue");
                    $("#cname").val('');
                    $("#cdescription").val('');
                }
              
          },
          error: function(x, t, m) {
               if(t==="timeout") {
                   alert("got timeout");
               } else {
                   alert(t);
               }
          } 
          }); //ajax over
          
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 450,
      width: 450,
      modal: true,
      closeOnEscape: false, // disable escape event on dialog
      buttons: {
        "Create a Category": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
          location.reload(true);
        }
      },
      beforeClose: function( event, ui ) {
        console.log("before close");
      },
      close: function() {
        console.log("close");
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
        location.reload(true);
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#add-new-cat" ).button().on( "click", function() {
        console.log("create-user clicked");
        dialog.dialog( "open" );
    });
    
  });

