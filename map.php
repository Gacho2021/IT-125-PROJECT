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
window.QFM = {
  mapLocal: JSON.parse( '["02", "15", "72"]' ),
  controlLocations: [],
  controlsAdded: false,
  mapWorking: false,
  geoview: '',
  tooltip: null,
  infowindow: null
};

$QF(function($) {
  $( document ).on( 'click', '#' + QF.cssPrefix + 'infowindow-controls button[data-zoom]', function( e ) {
    e.preventDefault();
    //e.stopPropagation();

    var
      $this    = $(this),
      parentid = $this.attr( 'data-parentid' );

    QFM.infowindow.close( );
    QFM.setMapLevel( $this.attr( 'data-level' ) );
    QFM.setMapLocate( $this.attr( 'data-mapview' ) );
    QFM.setGeoLocate( $this.attr( 'data-zoom' ) );

    if ( QFM.mapLocal.indexOf( parentid ) > -1 ) {
      QFM.geolocate( parentid );
    } else {
      QFM.geolocate( );
    }
  });

  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'infowindow-controls button[data-add]', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    QFM.choroplethMap.closeInfoPopup();

    var
      add   = ( parseInt( $(this).attr( 'data-action' ) ) != -1 ),
      geoid = $(this).attr( 'data-geoid' ),
      gdSet = $(this).attr( 'data-dataset' ),
      pdSet = $QF( 'nav.' + QF.cssPrefix + 'topnav', '#qfcontent' ).attr( 'data-primedataset' );

    if ( gdSet == pdSet ) {
      if ( add && QF.atMaxGeos() ) {
        QFS.maxGeo();
      } else {
        QFM.setMapLevel( $(this).attr( 'data-level' ) );
        QFS.load( $(this).attr( 'data-add' ), QF.view, true );
      }
    } else {
      QFS.dSetChange( geoid );
    }

  });
});