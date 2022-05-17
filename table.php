/**
 * U.S. Census Bureau
 *
 * We have a machine-readable dataset discovery service. Visit our Discovery
 * Tool page to learn more.
 *
 * https://www.census.gov/data/developers/updates/new-discovery-tool.html
 *
 *
 * In alignment with the Digital Government Strategy, the Census Bureau is offering
 * the public wider access to key U.S. statistics. The Census application programming
 * interface (API) lets developers create custom apps to reach new users and makes
 * key demographic, socio-economic and housing statistics more accessible than
 * ever before. The Census Bureau’s API allows developers to design web and mobile
 * apps to explore or learn more about America's changing population and economy.
 *
 * https://www.census.gov/developers/
 */

/**
 * Note: you can get what current CSS is loaded by the browser with
 * $('#' + QF.cssPrefix + 'loadedcss').css('content')
 */
window.QFT = {
  selectTopic:function( val ){
    var
      $tbodyall = $QF( 'tbody:not([data-topic=""])', '#qfcontent' ),
      $tables   = $QF( 'table.type', '#qfcontent' );
      //$optgroup = $QF( '#' + QF.cssPrefix + 'fact-select optgroup', '#qfcontent' );

    $tables.show();

    if ( val == 'all' ) {
      $tbodyall.show();
      //$optgroup.prop('disabled', false);
    } else {
      $tbodyall.show().not('[data-topic="' + val + '"]').hide();
      //$optgroup.prop('disabled', false).not('[label="' + val + '"]').prop('disabled', true);
    }

    $tables.each( function( idx, elm ){
      var
        hide = ( $QF( 'tbody[data-topic]', this ).filter(":visible").length == 0 )

      if ( hide ) {
        $QF( this ).hide();
      } else {
        $QF( this ).show();
      }
    } );
  }
}

$QF(function($) {
  var
    $dialog      = $( '#qfcontent #dialog' );

  $( document ).on( 'click', '#qfcontent a.headnote', function( e ) {
    e.stopPropagation();
  });

  $( document ).on( 'click', '#qfcontent a.quickinfo', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    var
      $this = $(this),
      title = $this.attr( 'data-title' ),
      href  = $this.attr( 'href' ),
      winH  = $( window ).height() * 0.8;

    $dialog.dialog( 'option', 'title', title );
    $dialog.dialog( 'option', 'height', winH );
    $dialog.dialog( 'option', 'maxHeight', winH );
    $dialog.dialog( 'option', 'position', { my: "center", at: "center", of: window } );
    $dialog.load( href, function( response, status, xhr ) {
      if ( status == 'error' ) {
        $dialog.html(response);
      }

      $dialog.find( 'a[href]' ).attr('target', '_blank');
      $dialog.dialog( 'open' );
    });
  });

  $( document ).on( 'click', '#qfcontent tr.fact td:first-child', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    QFS.load( $(this).parent().attr( 'data-url' ) );
    //QF.loadTable( $(this).parent().attr( 'data-url' ) );
  });

  $( document ).on( 'change', '#qfcontent #' + QF.cssPrefix + 'topic-select', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    QFT.selectTopic( $(this).val( ) );
  });

  //*
  $( window ).on( 'scroll resize', function( e ){
   if( QF.device != 'desktop' || QF.view != 'table' || $( window ).width() < QF.cssWidthMax ) {
      return;
    }

    var
      $anchor = $( 'div.' + QF.cssPrefix + 'persist-anchor' ),
      $parent = $anchor.parent();
      $table  = $anchor.next( 'table' ),
      tHeight = $table.outerHeight(),
      wTop    = $(window).scrollTop(),
      dTop    = $anchor.offset().top,
      dBottom = dTop + $parent.height() - tHeight,
      dLeft   = $table.next( 'table' ).offset().left;

    if ( wTop > dTop && wTop < dBottom ) {
      $table.css( 'left', dLeft ).removeClass( QF.cssPrefix + 'persist-lock' ).addClass( QF.cssPrefix + 'persist' );
      $parent.removeClass( QF.cssPrefix + 'persist-lock' );
      $anchor.height( tHeight );
    } else if ( wTop >= dBottom ) {
      $table.css( 'left', dLeft ).removeClass( QF.cssPrefix + 'persist' ).addClass( QF.cssPrefix + 'persist-lock' );
      $parent.addClass( QF.cssPrefix + 'persist-lock' );
      $anchor.height( tHeight );
    } else {
      $table.css( 'left', dLeft ).removeClass( QF.cssPrefix + 'persist-lock' ).removeClass( QF.cssPrefix + 'persist' );
      $parent.removeClass( QF.cssPrefix + 'persist-lock' );
      $anchor.height( 0 );
    }
  });
  //**/
});
