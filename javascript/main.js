jQuery( document ).ready( function ( $ ) {
    $( '#signin-btn' ).click( function () {
        var data = { email: '', password: '' };
        data.email = $( '#email' ).val();
        data.password = $( '#password' ).val();
        $( '#signin-btn' ).prop( 'disabled', true );
        $.post( '/signin', data, function ( result ) {
            $( '#signin-btn' ).prop( 'disabled', false );
            if ( result.status == 'success' ) {
                window.location = '/dashboard';
            } else {
                console.log( result );
            }
        }, 'json' );
        return false;
    } );

    $( '.delete-chapter' ).click( function () {
        var chapterId = $( this ).attr( 'data-mongoid' );
        var containingRow = $( this ).parent().parent();
        if ( typeof chapterId !== 'undefined' && chapterId !== '' ) {
            $.ajax( {
                'url': '/chapter/' + chapterId,
                'type': 'DELETE',
                'success': function () {
                    containingRow.remove();
                    alert( 'Deleted successfully.' );
                }
            } );
        }
    } );

    $.getJSON( '/api/country', function( result ){
        $('#country').empty();
        $.each( result, function( key, value ) {
            $('#country').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
    });

    $.getJSON( '/api/branch', function( result ){
        $('#branch').empty();
        $.each( result, function( key, value ) {
            $('#branch').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
    });

    $.getJSON( '/api/chapter', function( result ){
        $('#primary_assignment').empty();
        $('#secondary_assignment').empty();
        $.each( result, function( key, value ) {
            $('#primary_assignment').append(
                '<option value="' + key + '">' + value + '</option>'
            );
            $('#secondary_assignment').append(
                '<option value="' + key + '">' + value + '</option>'
            );
        });
    });

    $('#perm_dor').datepicker({ dateFormat: "yy-mm-dd" });
    $('#brevet_dor').datepicker({ dateFormat: "yy-mm-dd" });
    $('#primary_date_assigned').datepicker({ dateFormat: "yy-mm-dd" });
    $('#secondary_date_assigned').datepicker({ dateFormat: "yy-mm-dd" });

    $('#branch').change(function(){
        var branch = $('#branch').val();
        $.getJSON( '/api/branch/' + branch + '/grade', function( result ){
            $('#permanent_rank').empty();
            $('#brevet_rank').empty();
            $.each( result, function( key, value ) {
                $('#permanent_rank').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
                $('#brevet_rank').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            });
        });
        $.getJSON( '/api/branch/' + branch + '/rate', function( result ){
            $('#rating').empty();
            $.each( result, function( key, value ) {
                $('#rating').append(
                    '<option value="' + key + '">' + value + '</option>'
                );
            });
        });
    });

} );
