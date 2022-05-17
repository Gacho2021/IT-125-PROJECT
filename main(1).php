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
 * $('#qf-loadedcss').css('content')
 */
window.QF = {
  srcNotes: undefined,
  cssPrefix: 'qf-',
  approot: '/quickfacts/',
  symbolDOL: '$',
  symbolPCT: '%',
  cssWidthMax: parseInt( '1258' ),
  maxFactCount: parseInt( '1' ),
  maxGeoCount: parseInt( '6' ),
  templateBaseDir: '/quickfacts/assets/templates/',
  censusAtTag: '@uscensusbureau',
  appTitle: 'QuickFacts',
  model: window.MVC.model,
  view: window.MVC.view,
  device: window.MVC.device,
  loading: false,
  unique: function ( value, index, self ) {
    return self.indexOf(value) === index;
  },
  getFacts: function () {
    return $QF( 'nav[data-mnemonics]' ).first().attr( 'data-mnemonics' ).split(',').filter( window.QF.unique );
  },
  addFact: function ( mnemonic ) {
    var
      facts = window.QF.getFacts();

    facts.unshift( mnemonic );

    $QF( 'nav[data-mnemonics]' ).first().attr( 'data-mnemonics', facts.filter( window.QF.unique ).slice(0, QFS.limit).join() );
  },
  getGeos: function () {
    return $QF( 'nav[data-shortnames]' ).first().attr( 'data-shortnames' ).split(',').filter( window.QF.unique );
  },
  getGeoids: function () {
    return $QF( 'nav[data-geoids]' ).first().attr( 'data-geoids' ).split(',').filter( window.QF.unique );
  },
  getMaxyear: function () {
    return $QF( 'nav[data-maxyear]' ).first().attr( 'data-maxyear' ).split(',').filter( window.QF.unique );
  },
  addGeomUrl: function ( geo ) {
    var
      geos  = window.QF.getGeos(),
      facts = window.QF.getFacts();

    geos.unshift( geo );

    return [
      window.QF.approot + window.QF.model,
      window.QF.view,
      geos.slice( 0, window.QF.maxGeoCount ).join(),
      facts.join()
    ].join( '/' );
  },
  removeGeomUrl: function ( geo ) {
    var
      geos  = window.QF.getGeos(),
      facts = window.QF.getFacts();

    geos.splice( geos.indexOf( geo ), 1 );

    return [
      window.QF.approot + window.QF.model,
      window.QF.view,
      geos.slice( 0, window.QF.maxGeoCount ).join(),
      facts.join()
    ].join( '/' );
  },
  bubbleUpGeomUrl: function ( geo ) {
    var
      geos  = window.QF.getGeos(),
      facts = window.QF.getFacts();

    geos.splice( geos.indexOf( geo ), 1 );
    geos.unshift( geo );

    return [
      window.QF.approot + window.QF.model,
      window.QF.view,
      geos.slice( 0, window.QF.maxGeoCount ).join(),
      facts.join()
    ].join( '/' );
  },
  isSelectedGeo: function ( geo ) {
    return ( window.QF.getGeoids().indexOf( geo ) != -1 );
  },
  atMaxGeos: function(){
    return ( window.QF.getGeos().length >= window.QF.maxGeoCount );
  },
  atMaxFacts: function(){
    return ( window.QF.getFacts().length >= window.QF.maxFactCount );
  },
  loadTable: function ( url ) {
    if ( window.QF.loading ) {
      return
    } else {
      window.QF.loading = true;
      window.QF.spinnerDisplay( true );
    }

    var
      $data  = null,
      title  = null,
      $topic = $QF('#' + window.QF.cssPrefix + 'topic-select', '#qfcontent' ),
      sTopic = $topic.val(),
      hash   = window.QF.urlParser( url ).hash;

    $QF.get(
      url,
      { 'ajax':'true' },
      function( data ) {
        $data = $QF('<div />').html( data ),
        title = $data.find( 'title' ).text();

        $QF( 'div.' + window.QF.cssPrefix + 'titlebar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'titlebar' ) );
        $QF( 'nav.' + window.QF.cssPrefix + 'topnav', '#qfcontent' ).replaceWith( $data.find( 'nav.' + window.QF.cssPrefix + 'topnav' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'viewbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'viewbar' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'facttable', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'facttable' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'footnotes', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'footnotes' ) );

        history.pushState ( { title:title, url:url }, title, url );

        $data = null;
      },
      'html'
    ).done ( function ( ) {
      window.QF.adjustHeaderHeight();
      window.QF.initPersistent();

      QFS.initSearch();

      if ( typeof QFA != 'undefined' ) {
        QFA.update( url, title );
      }

      var
        $topic = $QF( '#' + window.QF.cssPrefix + 'topic-select', '#qfcontent' );

      $topic.val( sTopic ).children( 'option[value="' + sTopic + '"]' ).prop('selected', true);
      $topic.trigger( 'change' );
    } ).done ( function ( ){
      if ( hash ) {
        $QF( window ).scrollTop( $QF( 'a[id="' + hash.substring( 1 ) + '"]' ).offset().top );
      }

      window.QF.loading = false;
      window.QF.spinnerDisplay();
    } );
  },
  loadMap: function ( url, sync2View ) {
    if ( window.QF.loading ) {
      return
    } else {
      window.QF.loading = true;
      window.QF.spinnerDisplay( true );
    }
    if ( typeof url == 'undefined' ) {
      url = QFM.getMapLocate() + '/' + window.QF.getFacts().join();
    }

    var
      $data  = null,
      title  = null;


    $QF.get(
      url,
      { 'ajax':'true' },
      function( data ) {
        $data = $QF('<div />').html( data ),
        title = $data.find( 'title' ).text();

        $QF( 'div.' + window.QF.cssPrefix + 'titlebar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'titlebar' ) );
        $QF( 'nav.' + window.QF.cssPrefix + 'topnav', '#qfcontent' ).replaceWith( $data.find( 'nav.' + window.QF.cssPrefix + 'topnav' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'viewbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'viewbar' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'factbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'factbar' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'quantile', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'quantile' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'footnotes', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'footnotes' ) );

        QFM.setMapLevel( $data.find( 'div.' + window.QF.cssPrefix + 'jsmap' ).attr( 'data-level' ) );

        history.pushState ( { title:title, url:url }, title, url );

        $data = null;
      },
      'html'
    ).done ( function ( ) {
      if ( sync2View ) {
        var
          map = window.QF.approot + window.QF.view + '/' + window.QF.getGeos().join(),
          geo  = window.QF.approot + 'geo/json/' + window.QF.getGeos().join();

        QFM.setMapLocate( map );
        QFM.setGeoLocate( geo );
      }
      QFM.geolocate( sync2View );
      QFS.initSearch( );

      if ( typeof QFA != 'undefined' ) {
        QFA.update( url, title );
      }

    } ).done ( function ( ){
      window.QF.loading = false;
    } );
  },
  loadChart: function ( url, updateUrl, chartOnly ) {
    if ( window.QF.loading ) {
      return
    } else {
      window.QF.loading = true;
      window.QF.spinnerDisplay( true );
    }
    if ( typeof updateUrl == 'undefined') {
      var updateUrl = true;
    }
    if ( typeof chartOnly == 'undefined' ) {
      var chartOnly = false;
    }

    var
      $data  = null,
      title  = null,
      $topic = $QF('#' + window.QF.cssPrefix + 'topic-select', '#qfcontent' ),
      sTopic = $topic.val();

    $QF.get(
      url,
      { 'ajax':'true' },
      function( data ) {
        $data = $QF('<div />').html( data ),
        title = $data.find( 'title' ).text();

        if ( !chartOnly ) {
          $QF( 'div.' + window.QF.cssPrefix + 'titlebar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'titlebar' ) );
          $QF( 'nav.' + window.QF.cssPrefix + 'topnav', '#qfcontent' ).replaceWith( $data.find( 'nav.' + window.QF.cssPrefix + 'topnav' ) );
          $QF( 'div.' + window.QF.cssPrefix + 'viewbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'viewbar' ) );
          $QF( 'div.' + window.QF.cssPrefix + 'factbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'factbar' ) );
          $QF( 'div.' + window.QF.cssPrefix + 'footnotes', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'footnotes' ) );
        }

        $QF( 'div.' + window.QF.cssPrefix + 'chart', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'chart' ) );

        if ( updateUrl ) {
          history.pushState ( { title:title, url:url }, title, url );
        }

        $data = null;
      },
      'html'
    ).done ( function ( ) {
      window.QF.adjustHeaderHeight();
      window.QF.initPersistent();

      QFS.initSearch();
      QFC.initChart();

      if ( typeof QFA != 'undefined' ) {
        QFA.update( url, title );
      }

      $topic.val( sTopic ).children( 'option[value="' + sTopic + '"]' ).prop('selected', true);
      $topic.trigger( 'change' );
    } ).done ( function ( ){
      window.QF.loading = false;
      window.QF.spinnerDisplay();
    } );;
  },
  loadDashboard: function ( url ) {
    if ( window.QF.loading ) {
      return
    } else {
      window.QF.loading = true;
      window.QF.spinnerDisplay( true );
    }

    var
      $data  = null,
      title  = null,
      $topic = $QF('#' + window.QF.cssPrefix + 'topic-select', '#qfcontent' ),
      sTopic = $topic.val(),
      hash   = window.QF.urlParser( url ).hash;

    $QF.get(
      url,
      { 'ajax':'true' },
      function( data ) {
        $data = $QF('<div />').html( data ),
        title = $data.find( 'title' ).text();

        $QF( 'div.' + window.QF.cssPrefix + 'titlebar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'titlebar' ) );
        $QF( 'nav.' + window.QF.cssPrefix + 'topnav', '#qfcontent' ).replaceWith( $data.find( 'nav.' + window.QF.cssPrefix + 'topnav' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'viewbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'viewbar' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'factbar', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'factbar' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'facttable', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'facttable' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'chart', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'chart' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'quantile', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'quantile' ) );
        $QF( 'div.' + window.QF.cssPrefix + 'footnotes', '#qfcontent' ).replaceWith( $data.find( 'div.' + window.QF.cssPrefix + 'footnotes' ) );

        QFM.setMapLevel( $data.find( 'div.' + window.QF.cssPrefix + 'jsmap' ).attr( 'data-level' ) );

        history.pushState ( { title:title, url:url }, title, url );

        $data = null;
      },
      'html'
    ).done ( function ( ) {
      var
        map = window.QF.approot + window.QF.view + '/' + window.QF.getGeos().join(),
        geo = window.QF.approot + 'geo/json/' + window.QF.getGeos().join();

      QFM.setMapLocate( map );
      QFM.setGeoLocate( geo );
      QFM.geolocate( );

      QFS.initSearch( );

      if ( typeof QFA != 'undefined' ) {
        QFA.update( url, title );
      }

      window.QF.adjustHeaderHeight();
      window.QF.initPersistent();

      $topic.val( sTopic ).children( 'option[value="' + sTopic + '"]' ).prop('selected', true);
      $topic.trigger( 'change' );
    } ).done ( function ( ){
      window.QF.loading = false;
      window.QF.spinnerDisplay();
      QFD.updateChart();
    } );;
  },
  adjustHeaderHeight: function ( ) {
    if( $QF( window ).width() < window.QF.cssWidthMax ) {
      return;
    }

    var
      $header  = $QF('tr.' + window.QF.cssPrefix + 'persist', '#qfcontent'),
      $ftable  = $QF('table.type:eq(1)', '#qfcontent'),
      height   = 0;
      oheight  = 0;

    $header.each(function() {
      height  = Math.max.apply( Math, $QF( this ).find( 'span' ).map( function(){ return $QF( this ).height(); } ));
      oheight = Math.max.apply( Math, $QF( this ).find( 'span' ).map( function(){ return $QF( this ).outerHeight(); } ));
    });

    $header.height( oheight ).find( 'th' ).height( height );
  },
  initPersistent:function ( ) {
  },
  urlParser: function ( url ){
    var parser = document.createElement( 'a' );
    parser.href = url;
    return parser;
  },
  nFormat: function ( num, precision, unit ) {
    switch ( unit ) {
      case 'ABS':
        return window.QF.formatNum ( Math.abs( num ), precision );
      case 'AVG':
        return window.QF.formatNum ( num, precision );
      case 'DOL':
        return window.QF.formatNum ( num, precision, window.QF.symbolDOL );
      case 'THS':
        return window.QF.formatNum ( num, precision, window.QF.symbolDOL );
      case 'MIN':
        return window.QF.formatNum ( num, precision );
      case 'PCT':
        return window.QF.formatNum ( num, precision ) + window.QF.symbolPCT;
      case 'RTE':
        return window.QF.formatNum ( num, precision );
      case 'SQM':
        return window.QF.formatNum ( num, precision );
      case 'STR':
        return num;
    }
  },
  formatNum: function ( num, precision, prefix ) {
    var
      N     = Math.abs( num ).toString(),
      regex = /(\d+)(\d{3})(\.\d+)?/,
      isneg = ( num < 0 );

    if ( !prefix ) {
      prefix = '';
    }

    while ( regex.test( N ) ) {
      N = N.replace( regex, '$1,$2$3');
      /*
      N = N.replace( regex, function( match, p1, p2, p3){
        return p1 + ',' + p2 + p3.substring(0, precision + 1);
      });
      //**/
    }

    numS  = isneg ? '-':'';
    numS += prefix;
    numS += N;

    return numS;
  },
  sourceNoteIcon: function ( mnemonic, dataset, level ) {
    if ( typeof QF.srcNotes[ mnemonic ] == 'undefined' ) {
      return null;
    }

    var
      $d = $QF( '<div/>', {'class':window.QF.cssPrefix + 'sourcenote'} ),
      $s = $QF( '<span/>' ).html( String.fromCodePoint(0xe840) ),
      $a = $QF( '<a/>', {'title': QF.srcNotes[ mnemonic ][ dataset][ level ] } ).html( String.fromCodePoint(0xe83f) );

    $d.append( $s );
    $d.append( $a );
    return $d;
  },
  addIcon: function ( returnHTML ) {
    if ( typeof returnHTML == 'undefined' ) {
      returnHTML = false;
    }

    var icons = $QF( '<span/>', {'class':window.QF.cssPrefix + 'font-icon'}).html( String.fromCodePoint(0xe823) );

    return returnHTML ? icons.prop('outerHTML') : icons;
  },
  removeIcon: function ( returnHTML ) {
    if ( typeof returnHTML == 'undefined' ) {
      returnHTML = false;
    }

    var icons = $QF( '<span/>', {'class':window.QF.cssPrefix + 'font-icon'} ).html( String.fromCodePoint(0xe82a) );

    return returnHTML ? icons.prop('outerHTML') : icons;
  },
  spinnerDisplay: function ( show ) {
    if ( typeof show === 'undefined' ) {
      show = false
    }

    var
      $spinner = $QF( '#spinner' );

    show
      ? $spinner.show()
      : $spinner.hide();
  },
  isIE: function() {
    return (typeof document.documentMode != 'undefined');
  },
  isEDGE: function() {
    return (typeof document.documentMode != 'undefined') && /Edge\//.test(navigator.userAgent);
  }
};


$QF( function ($) {
  var
    $dialog = $( '#qfcontent #dialog' ),
    $dSmall = $( '#qfcontent #dialog-small' );

  $dialog.dialog({
    appendTo: '#qfcontent',
    autoOpen: false,
    resizable: false,
    draggable: false,
    modal: true,
    fluid: true,
    width: Math.min( $(window).width()*0.9, 890 ),
    minHeight: 400,
    maxHeight: 600,
    maxWidth: 890,
    classes: {
      'ui-dialog': '' + window.QF.cssPrefix + 'fixed-dialog'
    },
    buttons: [
      {
        text: 'Close',
        showText: true,
        icons: {
          primary: 'ui-icon-close'
        },
        click: function() {
          $( this ).dialog( 'close' );
        }
      }
    ]
  });
  $dSmall.dialog({
    appendTo: '#qfcontent',
    autoOpen: false,
    resizable: false,
    draggable: false,
    modal: true,
    fluid: true,
    width: Math.min( $(window).width()*0.9, 400 ),
    height: 'auto',
    maxWidth: 400,
    maxHeight: 200,
    title: 'Please Note!',
    classes: {
      'ui-dialog': '' + window.QF.cssPrefix + 'fixed-dialog'
    }
  });

  window.QF.adjustHeaderHeight();
  window.QF.initPersistent();
  window.QF.spinnerDisplay();
  window.QFA.update(null, null, 'Page Load');

  $( document ).on( 'click', '#qfcontent a.quicklink', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    var
      $this = $(this),
      title = $this.attr( 'data-title' ),
      href  = $this.attr( 'href' ),
      winH  = $( window ).height() * 0.8;

    $dialog.dialog( 'option', 'title', title + ' Quicklinks');
    $dialog.dialog( 'option', 'height', winH );
    $dialog.dialog( 'option', 'maxHeight', winH );
    $dialog.dialog( 'option', 'position', { my: "center", at: "center", of: window } );
    $dialog.load( href, function( response, status, xhr ) {
      $dialog.find( 'a[href]' ).attr('target', '_blank');
      $dialog.dialog( 'open' );
    });
  });

  $( document ).on( 'click', '#qfcontent a.addgeo', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    //*
    var
      dSet  = $QF( 'nav.' + window.QF.cssPrefix + 'topnav', '#qfcontent' ).attr( 'data-primedataset' ),
      sName = $(this).attr( 'data-shortname' ),
      tDSet = $(this).attr( 'data-dataset' ),
      load  = $(this).attr( 'href' );

    if ( tDSet == dSet ) {
      if ( window.QF.atMaxGeos() ) {
        QFS.maxGeo();
      } else {
        QFS.load( load, window.QF.view, true );
      }
    } else {
      QFS.dSetChange( sName );
    }
    //**/
  });

  $( document ).on( 'click', '#qfcontent a.removegeo', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    //*
    var
      load  = $(this).attr( 'href' );

    QFS.load( load, window.QF.view, true );
  });

  window.onpopstate = function ( e ) {
    if(e && e.state) {
      location.reload();
    }
  }

  $.fn.flashBG = function( color, duration, easing ) {
    var
      T   = this,
      bg  = typeof color != 'undefined' ? color : '#ff7043',
      D   = typeof duration != 'undefined' ? duration : 1500,
      E   = typeof easing != 'undefined' ? easing : 'swing',
      obg = T.css( 'background-color' );

    if ( typeof T.data('flashLocked') == 'undefined' ) {
      T.data( 'flashLocked', false );
    }

    if ( T.data( 'flashLocked' ) === false ) {
      T.data( 'flashLocked', true );

      T.stop().css('background-color', bg ).animate(
        {'background-color': obg},
        D,
        E,
        function(){
          T.data( 'flashLocked', false );
        }
      );
    }
  };
} );

// polyfill
if (!String.prototype.repeat) {
  String.prototype.repeat = function(count) {
    'use strict';
    if (this == null) {
      throw new TypeError('can\'t convert ' + this + ' to object');
    }
    var
      str = '' + this;

    count = +count;
    if (count != count) {
      count = 0;
    }
    if (count < 0) {
      throw new RangeError('repeat count must be non-negative');
    }
    if (count == Infinity) {
      throw new RangeError('repeat count must be less than infinity');
    }

    count = Math.floor(count);

    if (str.length == 0 || count == 0) {
      return '';
    }

    // Ensuring count is a 31-bit integer allows us to heavily optimize the
    // main part. But anyway, most current (August 2014) browsers can't handle
    // strings 1 << 28 chars or longer, so:
    if (str.length * count >= 1 << 28) {
      throw new RangeError('repeat count must not overflow maximum string size');
    }

    var rpt = '';
    for (;;) {
      if ((count & 1) == 1) {
        rpt += str;
      }
      count >>>= 1;
      if (count == 0) {
        break;
      }
      str += str;
    }
    // Could we try:
    // return Array(count + 1).join(this);
    return rpt;
  }
}

if ( !String.prototype.padEnd ) {
  String.prototype.padEnd = function( count, pad ) {
    var
      str = '' + this,
      cnt = count - str.length;

    if ( cnt < 0 ) {
      return str;
    }

    if ( !pad ) {
      pad='0';
    }

    return str + pad.repeat( count - str.length );
  }
}

if ( !String.prototype.padStart ) {
  String.prototype.padStart = function( count, pad ) {
    var
      str = '' + this,
      cnt = count - str.length;

    if ( cnt < 0 ) {
      return str;
    }

    if ( !pad ) {
      pad='0';
    }

    return pad.repeat( count - str.length ) + str;
  }
}

if (!String.fromCodePoint) {
  (function() {
    var defineProperty = (function() {
      // IE 8 only supports `Object.defineProperty` on DOM elements
      try {
        var object = {};
        var $defineProperty = Object.defineProperty;
        var result = $defineProperty(object, object, object) && $defineProperty;
      } catch(error) {}
      return result;
    }());
    var stringFromCharCode = String.fromCharCode;
    var floor = Math.floor;

    var fromCodePoint = function() {
      var MAX_SIZE = 0x4000;
      var codeUnits = [];
      var highSurrogate;
      var lowSurrogate;
      var index = -1;
      var length = arguments.length;
      if (!length) {
        return '';
      }
      var result = '';
      while (++index < length) {
        var codePoint = Number(arguments[index]);
        if (
          !isFinite(codePoint) ||       // `NaN`, `+Infinity`, or `-Infinity`
          codePoint < 0 ||              // not a valid Unicode code point
          codePoint > 0x10FFFF ||       // not a valid Unicode code point
          floor(codePoint) != codePoint // not an integer
        ) {
          throw RangeError('Invalid code point: ' + codePoint);
        }
        if (codePoint <= 0xFFFF) { // BMP code point
          codeUnits.push(codePoint);
        } else { // Astral code point; split in surrogate halves
          // http://mathiasbynens.be/notes/javascript-encoding#surrogate-formulae
          codePoint -= 0x10000;
          highSurrogate = (codePoint >> 10) + 0xD800;
          lowSurrogate = (codePoint % 0x400) + 0xDC00;
          codeUnits.push(highSurrogate, lowSurrogate);
        }
        if (index + 1 == length || codeUnits.length > MAX_SIZE) {
          result += stringFromCharCode.apply(null, codeUnits);
          codeUnits.length = 0;
        }
      }
      return result;
    };
    if (defineProperty) {
      defineProperty(String, 'fromCodePoint', {
        'value': fromCodePoint,
        'configurable': true,
        'writable': true
      });
    } else {
      String.fromCodePoint = fromCodePoint;
    }
  }());
}