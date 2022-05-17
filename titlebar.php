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

$QF(function($){
  $( document ).on( 'click', 'div.' + QF.cssPrefix + 'titlebar a.' + QF.cssPrefix + 'back', function( e ) {
    e.preventDefault();
    e.stopPropagation();

    var
      D = new Date();

    D.setTime( D.getTime() + (24*60*60*1000) );

    document.cookie = QF.cssPrefix + 'backLocation=' + window.location.href + '; expires=' + D.toGMTString() + '; path=' + QF.approot;

    window.location.href = $( this ).attr( 'href' );
  });
});