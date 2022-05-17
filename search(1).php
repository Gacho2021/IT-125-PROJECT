/**
 * nav fragment formatting
 */
nav.qf-topnav {
  background: #112e51;
  text-align: right;
  height: 64px;
}
nav.qf-topnav div.qf-icon {
  display: inline-block;
  width: 82px;
  height: 64px;
  text-align: center;
  font-size: 11px;
  text-transform: uppercase;
}
nav.qf-topnav div.qf-icon div {
  display: block;
  position: relative;
  left: 50%;
  top: 50%;
  transform: perspective(1px) translateX(-50%) translateY(-50%);
  width: 60px;
}
nav.qf-topnav div.qf-icon div a[class^="icon-"]:before,
nav.qf-topnav div.qf-icon div a[class*=" icon-"]:before {
  font-size: 28px;
  z-index: 3 !important;
}
nav.qf-topnav div.qf-icon div a {
  display: block;
  text-decoration: none;
  color: #ffffff;
}
nav.qf-topnav div.qf-icon div a:hover {
  text-decoration: none !important;
  color: #b2dfe4 !important;
}
nav.qf-topnav div.qf-icon div a span {
  display: block;
  position: relative;
  clear: both;
  white-space: nowrap;
}
nav.qf-topnav div.qf-icon:not(.qf-clear) div a:focus,
nav.qf-topnav div.qf-icon:not(.qf-clear) div a:hover {
  color: #66bfca;
}
nav.qf-topnav div.qf-more,
nav.qf-topnav div.qf-view {
  background: #405773;
}
nav.qf-topnav div.qf-view:hover {
  color: #66bfca;
  background: #4b636e;
}
nav.qf-topnav div.qf-view div a[class^="icon-"]:before,
nav.qf-topnav div.qf-view div a[class*=" icon-"]:before {
  color: #ffffff;
}
nav.qf-topnav div.qf-view div [class^="icon-"]:focus:before,
nav.qf-topnav div.qf-view div [class*=" icon-"]:focus:before {
  color: #66bfca;
}
nav.qf-topnav div.qf-view div [class^="icon-"]:hover:before,
nav.qf-topnav div.qf-view div [class*=" icon-"]:hover:before {
  color: #b2dfe4;
}
nav.qf-topnav div.qf-view div a.selected,
nav.qf-topnav div.qf-view div a.selected:before,
nav.qf-topnav div.qf-view div a.selected:focus:before {
  color: #66bfca;
}
nav.qf-topnav div.qf-view div a.selected:hover:before {
  color: #b2dfe4;
}
nav.qf-topnav div.qf-view div span.count {
  position: absolute;
  top: 0;
  right: -5px;
  width: 23px;
  height: 23px;
  line-height: 23px;
  transform: perspective(1px) translateX(-25%) translateY(-25%);
}
nav.qf-topnav div.qf-view div span.num {
  color: #66bfca;
  font-size: 10px;
  font-weight: bold;
}
nav.qf-topnav div.qf-view div span.top {
  font-family: "icon-th" !important;
  color: #ffffff;
  font-size: 23px;
}
nav.qf-topnav div.qf-view div span.bottom {
  font-family: "icon-th" !important;
  color: #112e51;
  font-size: 23px;
}
nav.qf-topnav #qf-nav-search {
  display: inline-block;
  position: relative;
  width: 300px;
  height: 64px;
  float: left;
}
nav.qf-topnav #qf-nav-search input {
  display: inline-block;
  position: absolute;
  z-index: 2;
  top: 50%;
  left: 10px;
  transform: perspective(1px) translateY(-50%);
  width: 256px;
  height: 24px;
  color: #000000;
  font-size: 12px;
  text-align: left;
  padding: 1px 0 1px 24px;
  border: 1px solid #ffffff;
  background: #ffffff url(images/search-icon.svg) no-repeat left center;
}
nav.qf-topnav #qf-fact-select {
  display: inline-block;
  position: relative;
  width: 160px;
  height: 64px;
  float: left;
}
nav.qf-topnav #qf-fact-select select {
  display: inline-block;
  position: absolute;
  z-index: 1;
  top: 50%;
  left: 10px;
  transform: perspective(1px) translateY(-50%);
  height: 28px;
  width: 160px;
  color: #000000;
  border: 1px solid #ffffff;
  font-size: 13px;
  font-weight: bold;
}
nav.qf-topnav #qf-fact-select select optgroup {
  color: #4b636e;
}
nav.qf-topnav #qf-fact-select select option {
  font-size: 12px;
  color: #000000;
  font-weight: normal;
}
nav.qf-topnav #qf-fact-select select option.selected {
  background: #b2dfe4;
}
nav.qf-topnav #qf-fact-select select optgroup[disabled] option {
  color: gray !important;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown {
  display: none;
  position: absolute;
  overflow: hidden;
  width: 1260px;
  height: 65px;
  right: 0;
  bottom: 0;
  z-index: 10000;
  transform: none;
  top: auto;
  left: auto;
  background: #4b636e;
  z-index: 9;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div {
  position: absolute;
  right: 0;
  transform: none;
  left: auto;
  text-align: right;
  z-index: 10001;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist {
  width: 300%;
  height: 65px;
  top: 0;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-left,
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-right {
  border: none;
  color: #ffffff;
  background: #4b636e;
  font-family: "icon-th" !important;
  font-size: 28px;
  line-height: 65px;
  text-align: center;
  top: 0;
  width: 65px;
  height: 65px;
  z-index: 10002;
  cursor: pointer;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-left:hover,
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-right:hover {
  border: none;
  font-size: 28px;
  color: #0095a8;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-left {
  right: auto;
  left: 0;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-right {
  right: 0;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo {
  position: initial;
  border: none;
  font-size: 12px;
  display: inline-block;
  color: #ffffff;
  background: #405773;
  text-align: left;
  padding: 0;
  margin: 0;
  height: 65px;
  text-overflow: ellipsis;
  text-transform: none;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo:not(:first-child) {
  border-left: 5px solid #112e51;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a {
  border: none;
  display: inline-block;
  height: 65px;
  font-size: 12px;
  line-height: 65px;
  white-space: nowrap;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a.qf-nav-selected {
  padding: 0 10px;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a.qf-nav-view {
  padding: 0 5px 0 10px;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a.qf-nav-view:hover {
  color: #0095a8;
  text-decoration: underline;
}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a.qf-nav-remove {
  color: #0095a8;
  height: 65px;
  text-align: center;
  margin: 0 10px 0 5px;

}
nav.qf-topnav div.qf-view div.qf-nav-dropdown div.qf-nav-geolist span.qf-nav-geo a.qf-nav-remove span {
  display: inline-block;
  font-family: "icon-th" !important;
  background: #ffffff;
  font-size: 14px;
  line-height: 8px;
}

nav.qf-topnav div.qf-icon div.qf-more-drop {
  display: none;
  position: absolute;
  transform: none;
  background: #ffffff;
  right: 0;
  bottom: 0;
  height: 65px;
  width: 390px;
  border: 1px solid #0095a8;
  z-index: 9;
}
nav.qf-topnav div.qf-icon div.qf-more-drop div {
  position: static;
  display: inline-block;
  transform: none;
  widows: 65px;
  height: 65px;
}
nav.qf-topnav div.qf-icon div.qf-more-drop a {
  position: relative;
  top: 50%;
  transform: perspective(1px) translateY(-50%);
}
nav.qf-topnav div.qf-icon div.qf-more-drop a,
nav.qf-topnav div.qf-icon div.qf-more-drop a:before {
  color: #0095a8;
}


div.qf-dialog-embed h2 {
  color: #0095a8;
  font-size: 14px;
  margin: 5px;
}
div.qf-dialog-embed h3 {
  color: #112e51;
  font-size: 13px;
  margin: 5px;
}
div.qf-dialog-embed textarea {
  width: 836px;
  border: 1px solid #999999;
  padding: 10px;
}



