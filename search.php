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
window.QFS = {
  animate: false,
  mouseOutDelay: null,
  limit: parseInt( '29' ),
  source: function ( request, response ) {
    $QF.ajax ( {
      url: QF.approot + 'search/json/',
      dataType: 'jsonp',
      data: {
        type: 'geo',
        search: request.term
      },
      success: function( json ) {
        response( json.data.filter( QFS.filter ).slice(0, QFS.limit) );
      }
    } );
  },
  select: function ( e, ui ) {
    e.preventDefault();
    e.stopPropagation();

    var
      dSet = $QF( 'nav.' + QF.cssPrefix + 'topnav', '#qfcontent' ).attr( 'data-primedataset' ),
      load = QF.addGeomUrl( ui.item.id );

    if ( typeof ui.item.dataSet != 'undefined' ) {
      if ( ui.item.dataSet == dSet ) {
        if ( QF.atMaxGeos() ) {
          QFS.maxGeo();
        } else {
          QFS.load( load, QF.view, true );
        }
      } else {
        QFS.dSetChange( ui.item.id, QF.view, true );
      }
    }
  },
  filter: function( itm ) {
    return !QF.isSelectedGeo( itm.geoid );
  },
  open: function( e, ui ) {
    $QF(this).data( 'is_open', true );
  },
  close: function ( e, ui ) {
    $QF(this).data( 'is_open', false );
  },
  response: function ( e, ui ) {

  },
  load: function ( url, view, sync2View ) {
    if ( typeof view == 'undefined' ) {
      view = QF.view;
    }
    if ( typeof sync2View == 'undefined' ) {
      sync2View = true;
    }

    switch ( view ) {
      case 'table':
        QF.loadTable( url );
        break;
      case 'map':
        QF.loadMap( url, sync2View );
        break;
      case 'chart':
        QF.loadChart( url, true );
        break;
      case 'dashboard':
        QF.loadDashboard( url );
        break;
    }
  },
  initSearch: function () {
    var
      $content = $QF( '#qfcontent' ),
      $drop    = $QF( 'div.' + QF.cssPrefix + 'nav-dropdown' ),
      $search  = $QF( '#' + QF.cssPrefix + 'search-box' ),
      $more    = $QF( 'div.' + QF.cssPrefix + 'more-drop' );

    if ( $drop.length ) {
      $drop.hide();
    }

    $more.hide();

    if ( $search.length ) {
      $search.autocomplete ( {
        minLength: 2,
        autoFocus: true,
        appendTo:  $content,
        source:    QFS.source,
        select:    QFS.select,
        open:      QFS.open,
        close:     QFS.close,
        response:  QFS.response
      } );

      /**
       * Determines whether an item should actually be represented as a divider instead
       * of a menu item. By default any item that contains just spaces and/or dashes is
       * considered a divider.
       *
       * This function is designed to override this behavior.
       */
      $search.data('uiAutocomplete').menu._isDivider = function( item ) { return false; };
    }
  },
  dSetChange: function ( geoid, view, sync2View ) {
    var
      $dSmall = $QF( '#qfcontent #dialog-small' );


    $dSmall.dialog(
      'option',
      'buttons',
      [{
        text: 'OK',
        showText: true,
        icons: {
          primary: 'ui-icon-check'
        },
        click: function() {
          $QF( this ).dialog( 'close' );
          load = [
            QF.approot + QF.model,
            QF.view,
            $QF( this ).data( 'geoid' ),
            QF.getFacts().join()
          ].join( '/' );

          QFS.load( load, view, sync2View );
        }
      },{
        text: 'Cancel',
        showText: true,
        icons: {
          primary: 'ui-icon-close'
        },
        click: function() {
          $QF( this ).dialog( 'close' );
        }
    }]);

    $dSmall.data( 'geoid', geoid ).load( QF.approot + 'template/datasets' ).dialog( 'open' );
  },
  maxGeo: function ( ) {
    var
      $dSmall = $QF( '#qfcontent #dialog-small' );

    $dSmall.dialog(
      'option',
      'buttons',
      [{
        text: 'OK',
        showText: true,
        icons: {
          primary: 'ui-icon-check'
        },
        click: function() {
          $QF( this ).dialog( 'close' );
        }
    }]);
    $dSmall.load( QF.approot + 'template/geolimit' ).dialog( 'open' );
  }
};

( function ( $ ) {
  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'view[data-toggled]', function( e ) {
    e.preventDefault();
    e.stopPropagation();
    var
      $icon  = $(this),
      $sibl  = $( 'div.' + QF.cssPrefix + 'icon[data-toggled="on"]' ).not( $icon ),
      $divO  = $( 'div.' + QF.cssPrefix + 'nav-dropdown', $icon ),
      $divI  = $( 'div.' + QF.cssPrefix + 'nav-geolist', $divO ),
      $span  = $( 'span.' + QF.cssPrefix + 'nav-geo', $divI ),
      $divL  = $( 'div.' + QF.cssPrefix + 'nav-left', $divO ),
      $divR  = $( 'div.' + QF.cssPrefix + 'nav-right', $divO ),
      $nav   = $( 'nav.' + QF.cssPrefix + 'topnav' ),
      navO   = $nav.offset(),
      navH   = $nav.outerHeight( true ),
      navW   = $nav.outerWidth( true ),
      navL   = navO.left,
      iconO  = $icon.offset(),
      iconW  = $icon.outerWidth(),
      iconR  = iconO.left + iconW,
      divRW  = $divR.outerWidth( true ),
      divOW  = $divO.outerWidth( true ),
      top    = navO.top + navH - 2,
      span   = iconR - navL,
      divIW  = 0,
      index  = $icon.attr( 'data-index' );

    $sibl.each( function(){
      $(this).click();
    } );

    if ( $icon.attr('data-toggled') == 'off' ) {
      $icon.attr('data-toggled','on');
      $icon.css({'color':'#ff7043','background-color':'#405773'});

      $divO.css({'width':navW}).show();

      $span.each( function ( idx ) {
        var
          W = Math.ceil($(this).outerWidth());

        divIW += W;
      } );

      $divI.width( divIW );

      var
        $aV   = $span.eq( index ),
        right = ($aV.position().left + $aV.outerWidth( true )) - divIW + divRW;
        limit = 0 - (divIW - divOW) - divRW;

      if ( divIW > navW ) {
        $divL.show().on( 'click', function( e ) {
          e.stopPropagation();

          var
            index = $icon.attr( 'data-index' ),
            $sGeo = $('span.' + QF.cssPrefix + 'nav-geo', $(this).parent()).filter(':visible');

          if ( $sGeo.length && index > 0 ) {
            index--;
            var
              right = ($sGeo.eq( index ).position().left + $sGeo.eq( index ).outerWidth( true )) - divIW + divRW;

            $sGeo.eq( index ).flashBG();
            $divI.css('right', Math.max(right,limit) );
            $icon.attr( 'data-index', index );
          }
        } );
        $divR.show().on( 'click', function( e ) {
          e.stopPropagation();

          var
            index = $icon.attr( 'data-index' ),
            $sGeo = $('span.' + QF.cssPrefix + 'nav-geo', $(this).parent()).filter(':visible');

          if( $sGeo.length && index < $span.length - 1 ){
            index++;
            var
              right = ($sGeo.eq( index ).position().left + $sGeo.eq( index ).outerWidth( true )) - divIW + divRW;

            $sGeo.eq( index ).flashBG();
            $divI.css('right', Math.max(right,limit) );
            $icon.attr( 'data-index', index );
          }

        } );

        $divO.offset( { top:top, left:navL } );
        $divI.css( { top:0, right:Math.max(right,limit) } );
      } else {
        $divO.width( divIW );
        $divL.hide();
        $divR.hide();
        $divO.offset( { top:top, left:iconR - Math.min(divIW, span) } );
        $divI.css( { top:0, right:0 } );
      }
    } else if ( $icon.attr('data-toggled') == 'on') {
      $icon.attr('data-toggled','off');
      $icon.css({'color':'','background-color':'#405773'});

      $divL.off('click');
      $divR.off('click');
      $divO.hide();
    }
    //**/
  });


  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'nav-dropdown a', function( e ) {
    e.stopPropagation();

    var
      load = $(this).attr('href'),
      view = $(this).parents('div.' + QF.cssPrefix + 'icon[data-view]').attr('data-view');

    if ( view == QF.view ) {
      e.preventDefault();
      QFS.load( load, view, true );
    }
  });


  $( document ).on( 'change', '#qfcontent #' + QF.cssPrefix + 'fact-select select', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    var $topic = $('#' + window.QF.cssPrefix + 'topic-select', '#qfcontent' );

    if ($topic && $topic.val() != 'all') {
      var optgroup = $('option:selected', this).parent('optgroup').attr('label');
      $topic.val( optgroup ).change()
    }

    QF.addFact( $('option:selected', this).attr('data-mnemonic') );

    QFS.load( $(this).val( ), QF.view, false );
  });


  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'more[data-toggled]', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    var
      $this  = $(this),
      $icons = $( 'div.' + QF.cssPrefix + 'icon[data-toggled="on"]' ).not( $this ),
      $more  = $( 'div.' + QF.cssPrefix + 'more-drop', $this ),
      iconO  = $this.offset(),
      iconH  = $this.outerHeight( true ),
      iconW  = $this.outerWidth( true ),
      moreW  = $more.outerWidth( true ),
      left   = Math.floor( iconO.left + iconW - moreW ),
      top    = Math.floor( iconO.top + iconH - 3 ),
      on     = ( $this.attr('data-toggled') == 'on' );

    $icons.each( function(){
      $(this).click();
    });

    if ( on ) {
      $this.attr('data-toggled', 'off');
      $more.hide();
    } else {
      var
        url = [
        QF.approot + QF.model,
        'gogov',
        QF.getGeos().slice( 0, QF.maxGeoCount ).join(),
        QF.getFacts().join()
      ].join( '/' );

      $this.attr('data-toggled', 'on');
      $more.show();
      $more.offset( { top:top, left:left } );

      $QF.get(
        url,
        function( data ) {
          $QF( 'a[href*="%%shorturl%%"]', $this ).each( function () {
            $QF( this ).attr( 'href', $QF( this ).attr( 'href' ).replace( '%%shorturl%%', data ) );
          });
        },
        'text'
      );

    }
  });


  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'more-drop div', function( e ) {
    e.stopPropagation();

    var
      $this  = $(this);

    if ( $this.hasClass( QF.cssPrefix + 'more-print' ) ) {
      e.preventDefault();
      window.print();
    }

    if ( $this.hasClass( QF.cssPrefix + 'more-facebook' ) ) {
      e.preventDefault();

      var txt = $( '#' + QF.cssPrefix + 'fact-select option.selected' ).text();

      FB.ui({
        method: 'share',
        //quote:  $this.attr('data-title'),
        quote:  txt + ' ' + QF.censusAtTag + ' ' + QF.appTitle,
        href:   $('meta[property="og:url"]').attr('content')
      }, function(response){

      });
    }

    if ( $this.hasClass( QF.cssPrefix + 'more-embed' ) ) {
      e.preventDefault();

      var
        $dialog = $( '#qfcontent #dialog' ),
        href    = QF.approot + 'embed';

      $dialog.dialog( 'option', 'title', 'Embed QuickFacts');
      $dialog.dialog( 'option', 'height', 380 );
      $dialog.dialog( 'option', 'position', { my: "center", at: "center", of: window } );
      $dialog.load( href, function(){ $dialog.dialog( 'open' ); });
    }

  });



  QFS.initSearch();
})($QF);
