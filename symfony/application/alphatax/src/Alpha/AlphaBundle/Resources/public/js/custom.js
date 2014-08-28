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
      
//      valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
//      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
        /*  
        $.ajax({
          type : "POST",
          url  : "destination.php",
          data : {
                                name        : "name",
                                email       : "email",
                                company     : "company",
                                phone       : "+91-9873252330",
                                country     : "country",
                                state       : "state",
          },
          dataType : "json",
          beforeSend : function(){
          console.log(" :::: before_send ::::");
          },
          timeout: 10000,
          success :function(response){
              console.log(" :::: success ::::");  
              console.log(response);
              $( "#users tbody" ).append( "<tr>" +
              "<td>" + name.val() + "</td>" +
              "<td>" + email.val() + "</td>" +
              "<td>" + password.val() + "</td>" +
              "</tr>" );
              dialog.dialog( "close" );
          },
          error: function(x, t, m) {
               if(t==="timeout") {
                   alert("got timeout");
               } else {
                   alert(t);
               }
          } 
          }); //ajax over
          */
         //remove me
//         $( "#users tbody" ).append( "<tr>" +
//              "<td>" + name.val() + "</td>" +
//              "<td>" + email.val() + "</td>" +
//              "<td>" + password.val() + "</td>" +
//              "</tr>" );
        console.log("name : "+name.val() +"  desc: "+description.val());
         
         dialog.dialog( "close" );
        
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
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      beforeClose: function( event, ui ) {
        console.log("before close");
      },
      close: function() {
        console.log("close");
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#create-user" ).button().on( "click", function() {
        console.log("create-user clicked");
        dialog.dialog( "open" );
    });
    
  });

