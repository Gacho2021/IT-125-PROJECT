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
window.QFC = {
  initChart: function ( ) {
    var
      $box   = $QF('div.' + QF.cssPrefix + 'graph-geo', '#qfcontent'),
      height = 37;

    $box.each(function() {
      height = Math.max( height, $QF( this ).find('span').first().outerHeight() );
    });

    $box.height( height );
  }
};

$QF(function($) {
  $( document ).on( 'change', '#' + QF.cssPrefix + 'chart-toggle', function( e ) {
    e.stopPropagation();

    var
      url = $(this).attr( 'data-url' );

    QF.loadChart( url, true );
  });

  QFC.initChart();
});