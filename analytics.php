/**
 * Note: you can get what current CSS is loaded by the browser with
 * $('#qf-loadedcss').css('content')

 * When a user selects:
 * - a place, eventName will equal “Place Selection” and selection will update
 *   with the place chosen. Only the most recent value selected will be present.
 *
 * - a fact, eventName will equal “Fact Selection” and factSelection will update
 *   with the fact chosen. Only the most recent value selected will be present.
 *
 * - a view, eventName will equal “View Selection” and viewSelection will update
 *   with the view chosen. Only the most recent value selected will be present.
 *
 * - a QuickLink, eventName will equal “QuickLink Selection” and quickLink will
 *   populate the active geography when the user selects the button to view the
 *   QuickLinks(Will replicate logic currently live). Only the most recent value
 *   selected will be present.
 *
 * - to download the content, eventName will equal “Download” and fileUrl will
 *   equal the URL of the download and fileName will equal the name of the download.
 *   Only the most recent value selected will be present.
 *
 * - to share the content, eventName will equal “Sharing Event” and sharingAction
 *   will populate with the method of the share (embed, twitter, facebook, pinterest).
 *   Only the most recent value selected will be present.
 *
 */
$QF(function($) {
  // map adding/removing a place
  $( document ).on( 'click', '#' + QF.cssPrefix + 'infowindow-controls button[data-add]', function( e ) {
    let action = $(this).attr('data-action') == '+1' ? 'add' : 'remove';

    document.body.dispatchEvent(
      new CustomEvent('QFA ' + e.type, {
        detail:{
          application: 'QuickFacts',
          eventName: 'Place Selection',
          action: action, // 'add' or 'remove'
          selection: $(this).attr('data-fullname' )
        }
      })
    );
  });

  // chart adding place
  $( document ).on( 'click', '#qfcontent a.addgeo', function( e ) {
    document.body.dispatchEvent(
      new CustomEvent('QFA ' + e.type, {
        detail:{
          application: 'QuickFacts',
          eventName: 'Place Selection',
          action: 'add',
          selection: $(this).attr('data-fullname' )
        }
      })
    );
  });

  // chart removing place
  $( document ).on( 'click', '#qfcontent a.removegeo', function( e ) {
    document.body.dispatchEvent(
      new CustomEvent('QFA ' + e.type, {
        detail:{
          application: 'QuickFacts',
          eventName: 'Place Selection',
          action: 'remove',
          selection: $(this).attr('title' )
        }
      })
    );
  });

  // search adding place
  $( document ).on( 'autocompleteselect', '#' + QF.cssPrefix + 'search-box', function( e, ui ) {
    document.body.dispatchEvent(
      new CustomEvent('QFA ' + e.type, {
        detail:{
          application: 'QuickFacts',
          eventName: 'Place Selection',
          action: 'add',
          selection: ui.item.label
        }
      })
    );
  });
});
//**/

window.QFA = {
  update: function ( url, title ) {
    const
      dcl = document.createEvent('Event'),
      ld  = document.createEvent('Event');

    dcl.initEvent('DOMContentLoaded', true, true);
    ld.initEvent('load', true, true);

    document.dispatchEvent(dcl);
    document.dispatchEvent(ld);
    
    console.log( 'QFA dcl and ld events dispached' );

    document.body.dispatchEvent(
      new CustomEvent('QFA Page Load', {
        detail:{
          application: 'QuickFacts',
          eventName: 'Page Load',
          action: 'load',
          selection: title
        }
      })
    );
  }
};