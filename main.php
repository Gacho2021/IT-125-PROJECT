@import url( 'print.css' ) print;
@import url( 'printLandscape.css' ) print and (orientation:landscape);
@import url( 'printPortrait.css' ) print and (orientation:portrait);

@import url( 'base.php' );
@import url( 'max.php' ) screen and (max-width:1258px);
@import url( 'min.php' ) screen and (min-width:1258px);
@import url( 'min700.php' ) screen and (min-width:701px) and (max-width:1257px);
@import url( 'max890.php' ) screen and (max-width:890px);
@import url( 'max790.php' ) screen and (max-width:790px);
@import url( 'max700.php' ) screen and (max-width:700px);
@import url( 'max390.php' ) screen and (max-width:390px);
@import url( 'max350.php' ) screen and (max-width:350px);

@import url( 'fontello.css' );
@import url( 'icon-th.css' );
@import url( 'animation.css' );
/* @import url( 'jquery.mobile-1.4.5.css' ); */
@import url( 'jquery-ui.min.css' );
@import url( 'jquery-ui.structure.min.css' );
@import url( 'jquery-ui.theme.min.css' );


#qfcontent *:not(.count) {
  font-family: Arial,​Helvetica,​sans-serif;
  box-sizing: border-box;
}

#qfcontent .ui-widget-content .ui-menu-item {
  background: #fff !important;
}

#qfcontent {
  min-height: 600px;
}

#qfcontent #spinner {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5) url('./images/spinner.svg') center center no-repeat;
  z-index: 3000;
  display: none;
}

div.uscb-main-container[style^="min-height"] {
  margin: 0 !important;
}

@media print {
  .ratingtool_div {
    display: none !important;
  }
}