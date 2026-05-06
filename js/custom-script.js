
$(document).ready(function () {
    $("#loader").hide();
    
});


function send_ajax_request( from_id, modal_id, reload_table, div_hide = '', div_show = '', div_append = "" ) {
	var frm = new FormData( $( '#' + from_id )[ 0 ] );
	var request_url = $( "#" + from_id + " input[name=url]" ).val();
	$.ajax
		( {
			type: "POST",
			url: 'ajax.php',
			data: frm,
			processData: false,
			contentType: false,
			beforeSend: function () {
				$( "#loader" ).show();
			},
			success: function ( data ) {
				$( "#loader" ).hide();
				//console.log(data);
				try {
					var obj = $.parseJSON( data );
					
					var msg_code = obj.msg_code;
					var msg = obj.msg;
					//console.log(obj);
					if ( msg_code != '00' ) {
						
						Swal.fire( {
							type: 'error',
							title: 'Error',
							text: msg
						} )
						
					}
					else {
						
						 if(msg_code == '00'){
                            Swal.fire({
                              type: 'success',
                              title: 'Success',
                              html: msg,
                              timer: 2000			
                            })
                            
						 if(reload_table == 'N')
						{
							$( '#' + modal_id ).modal( 'hide' );
							$("#"+from_id).trigger("reset");
							setTimeout( function () {
								  window.location.reload();
								
							}, 2000 );
							
						}
					}
					}
				}
				catch ( error ) {
					//console.log( 'error' );
					
					Swal.fire( {
						type: 'error',
						title: '!!Error!!',
						text: 'Invalid response received from server'
					} )
					
					//alert('Invalid response received from server');
				}
			},
			error: function ( jqXHR, exception ) {
				$( "#loading" ).hide();
				var msg = '';
				if ( jqXHR.status === 0 ) {
					msg = 'Not connect.\n Verify Network.';
				} else if ( jqXHR.status == 404 ) {
					msg = 'Requested page not found. [404]';
				} else if ( jqXHR.status == 500 ) {
					msg = 'Internal Server Error [500].';
				} else if ( exception === 'parsererror' ) {
					msg = 'Requested JSON parse failed.';
				} else if ( exception === 'timeout' ) {
					msg = 'Time out error.';
				} else if ( exception === 'abort' ) {
					msg = 'Ajax request aborted.';
				} else {
					msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				/*
				Swal.fire( {
					type: 'error',
					title: '!!Error!!',
					text: msg
				} )
				*/
				alert(msg);
			}
		} );
}
	// select column   Start
	$(document).on('submit', '#enquire_now', function (e) {
		e.preventDefault();
		send_ajax_request('enquire_now', 'contact_us', 'N') 
	});
	// select column  End
	// select column   Start
	$(document).on('submit', '#feedback_share', function (e) {
		e.preventDefault();
		send_ajax_request('feedback_share', 'feedback', 'N') 
	});
	// select column  End

$( document ).on( 'keyup blur', '.allowOnlyNumeric', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^0-9]/g, '' ) );
} );
$( '.allowOnlyNumeric' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^0-9]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowOnlyAlphabets', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z ]/g, '' ) );
} );
$( '.allowOnlyAlphabets' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z ]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowAlphaNumeric', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z0-9]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.nospace', function ( event ) {
	var node = $( this );
	node.val( node.val().replace(/ /g,'') );
} );
$( '.allowAlphaNumeric' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z0-9]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowOnlyNumericSpace', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^0-9 ]/g, '' ) );
} );
$( '.allowOnlyNumericSpace' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^0-9 ]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowAlphaNumericSpace', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z0-9 ]/g, '' ) );
} );
$( '.allowAlphaNumericSpace' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^a-zA-Z0-9 ]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowNumericFloat', function ( event ) {
	var node = $( this );
	node.val( node.val().replace( /[^0-9\.]/g, '' ) );
} );
$( '.allowNumericFloat' ).bind( 'input propertychange', function () {
	var node = $( this );
	node.val( node.val().replace( /[^0-9\.]/g, '' ) );
} );
$( document ).on( 'keyup blur', '.allowNumericAmount', function ( event ) {
	var node = $( this );
	//  node.val(node.val().replace(/[^0-9\s.]+|\.(?!\d)/g, ''));
	node.val( node.val().replace( /[^0-9\.]/g, '' ) );
} );
$( document ).on( 'blur', '.validateFloat', function ( event ) {
	var value = $( this ).val();
	var valid = ( value.match( /^-?\d*(\.\d+)?$/ ) )
	if ( !valid ) {
		$( this ).val( 0 );
	}
} );
$( document ).on( 'keyup blur', '.makeAlphabetsCapital', function ( event ) {
	this.value = this.value.toUpperCase();
} );
$( document ).on( 'keyup blur', '.removeChars', function ( event ) {
	var node = $( this );
	var stringToGoIntoTheRegex = $( this ).data( 'regex' );
	var regex = new RegExp( stringToGoIntoTheRegex, "g" );
	node.val( node.val().replace( regex, '' ) );
} );


$( document ).on( 'keyup blur', '.removeChars_enter', function ( event ) {
	if (Event.keyCode != 13)
	{
		var node = $( this );
		var stringToGoIntoTheRegex = $( this ).data( 'regex' );
		var regex = new RegExp( stringToGoIntoTheRegex, "g" );
		node.val( node.val().replace( regex, '' ) );
	}
} );

$( '.removeChars' ).bind( 'input propertychange', function () {
	var node = $( this );
	var stringToGoIntoTheRegex = $( this ).data( 'regex' );
	var regex = new RegExp( stringToGoIntoTheRegex, "g" );
	node.val( node.val().replace( regex, '' ) );
} );



$(document).on('blur', '.validateEmail', function (event) {
        var userinput = $(this).val();
        if (userinput != '') {
            var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            if (!pattern.test(userinput)) {
                alert('Enter a valid e-mail address');
				$(this).val("");
				$(this).focus();
            }
        }
    });
	
	

