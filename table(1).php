/**
 * table fragment formatting
 */
div.qf-facttable {
  border: 1px solid #f1f3f5;
  overflow: hidden;
  background: #ffffff;
}
div.qf-facttable table {
  min-width: 850px;
  max-width: 1258px;
  font-size: 12px;
  line-height: 15px;
  border-collapse: collapse;
  margin: 0 auto;
}
div.qf-facttable div.qf-persist-lock {
  display: relative;
}
div.qf-facttable div.qf-persist-anchor {
  height: 0;
}
div.qf-facttable table.qf-persist {
  position: fixed;
  top: 0;
  z-index: 90;
  margin: 0 auto;
}
div.qf-facttable table.qf-persist-lock {
  position: absolute;
  bottom: 0;
  z-index: 90;
  margin: 0 auto;
}

div.qf-facttable table *,
div.qf-facttable table *:before,
div.qf-facttable table *:after {
  box-sizing: border-box;
}

div.qf-facttable table caption {
  background: #5d727c;
  color: #fff;
  font-size: 14px;
  line-height: 24px;
  font-weight: bold;
  text-transform: uppercase;
  text-align: left;
  padding: 4px 9px;
  caption-side: top !important;
}
div.qf-facttable table caption:before {
  color: #fff;
  font-size: 20px;
  line-height: 24px;
  margin-right: 10px;
}
div.qf-facttable table tbody tr td,
div.qf-facttable table tbody tr th {
  color: #000000;
  border-bottom: 1px solid #ffffff;
}
div.qf-facttable table tbody tr td:first-child,
div.qf-facttable table tbody tr th:first-child {
  width: 350px;
}
div.qf-facttable table tbody tr td {
  padding: 4px 3px;
}
div.qf-facttable table tbody tr td:first-child {
  cursor: pointer;
}
div.qf-facttable table tbody tr.qf-header td,
div.qf-facttable table tbody tr.qf-header th {
  background: #e5f4f6;
}
div.qf-facttable table tbody tr.qf-header th {
  color: #4b636e;
  font-weight: bold;
}
div.qf-facttable table tbody[data-topic]:not([data-topic=""]) tr.fact:not(.qf-persist) td:first-child {
  background-position: top left;
  background-repeat: repeat-y;
  padding-left: 8px;
}
div.qf-facttable table tbody tr.qf-header:not(.qf-persist) th {
  color: #000000;
  background: #d6dde1;
}
/* # must be encoded tp %23 */
div.qf-facttable table tbody[data-topic]:not([data-topic=""]) tr.fact:not(.qf-persist) td:first-child {
  background-image: url(images/bar-dedede.svg);
}
div.qf-facttable table tbody tr.qf-header th:first-child {
  padding: 5px;
  font-size: 13px !important;
  text-align: left;
  font-weight: bold;
}
div.qf-facttable table tbody tr.fact.selected {
  color: #000000;
  background: #b2dfe4;
  font-weight: bold;
}
div.qf-facttable table tbody tr.fact:nth-child(even):not(.selected) td,
div.qf-facttable table tbody tr.fact:nth-child(even):not(.selected) th {
  background: #f1f3f5;
}
div.qf-facttable table tbody tr.fact:focus:nth-child(even):not(.selected) td,
div.qf-facttable table tbody tr.fact:focus:nth-child(even):not(.selected) th,
div.qf-facttable table tbody tr.fact:hover:nth-child(even):not(.selected) td,
div.qf-facttable table tbody tr.fact:hover:nth-child(even):not(.selected) th {
  color: #fff;
  background: #0095a8;
}
div.qf-facttable table tbody tr.fact:nth-child(odd):not(.selected) td,
div.qf-facttable table tbody tr.fact:nth-child(odd):not(.selected) th {
  background: #ffffff;
}
div.qf-facttable table tbody tr.fact:focus:nth-child(odd):not(.selected) td,
div.qf-facttable table tbody tr.fact:focus:nth-child(odd):not(.selected) th,
div.qf-facttable table tbody tr.fact:hover:nth-child(odd):not(.selected) td,
div.qf-facttable table tbody tr.fact:hover:nth-child(odd):not(.selected) th {
  color: #fff;
  background: #0095a8;
}
div.qf-facttable table tbody tr.fact:hover:not(.selected) td a,
div.qf-facttable table tbody tr.fact:hover:not(.selected) td a abbr,
div.qf-facttable table tbody tr.fact:hover:not(.selected) td span a.headnote {
  color: #fff !important;
}
div.qf-facttable table tbody tr[data-mnemonic="fips"] td {
  border-top: 1px solid #000000;
}
div.qf-facttable table tbody tr.fact.locked td:first-child {
  padding-left: 23px;
}
div.qf-facttable table tbody tr td:not(:first-child) {
  text-align: right;
}
div.qf-facttable table tbody tr th:not(:first-child),
div.qf-facttable table tbody tr td:not(:first-child) {
  width: 140px;
  padding: 0 5px 0 0;
  border-left: 5px solid #ffffff;
}
div.qf-facttable table tbody tr td a[class^="icon-"],
div.qf-facttable table tbody tr td a[class*=" icon-"] {
  display: table-cell;
}
div.qf-facttable table tbody tr td a[class^="icon-"]:before,
div.qf-facttable table tbody tr td a[class^="icon-"]:active:before,
div.qf-facttable table tbody tr td a[class^="icon-"]:visited:before,
div.qf-facttable table tbody tr td a[class*=" icon-"]:before,
div.qf-facttable table tbody tr td a[class*=" icon-"]:active:before,
div.qf-facttable table tbody tr td a[class*=" icon-"]:visited:before {
  /*position: relative;
  top: 50%;
  transform: perspective(1px) translateY(-50%);*/
  color: #999999;
  text-decoration: none;
  font-size: 14px;
}
div.qf-facttable table tbody tr.selected td a[class^="icon-"]:focus:before,
div.qf-facttable table tbody tr.selected td a[class^="icon-"]:hover:before,
div.qf-facttable table tbody tr.selected td a[class*=" icon-"]:focus:before,
div.qf-facttable table tbody tr.selected td a[class*=" icon-"]:hover:before {
  color: #ff7043;
}
div.qf-facttable table tbody tr.selected td a[class^="icon-"]:before,
div.qf-facttable table tbody tr.selected td a[class^="icon-"]:before,
div.qf-facttable table tbody tr.selected td a[class*=" icon-"]:before,
div.qf-facttable table tbody tr.selected td a[class*=" icon-"]:before {
  color: #0095a8;
}
div.qf-facttable table tbody tr:not(.selected) td a[class^="icon-"]:focus:before,
div.qf-facttable table tbody tr:not(.selected) td a[class^="icon-"]:hover:before,
div.qf-facttable table tbody tr:not(.selected) td a[class*=" icon-"]:focus:before,
div.qf-facttable table tbody tr:not(.selected) td a[class*=" icon-"]:hover:before {
  color: #ff7043;
}
div.qf-facttable table tbody tr td a[disabled]:before {
  color: #cccccc !important;
}
div.qf-facttable table tbody tr td a.headnote {
  color: #0095a8;
  margin-left: 1em;
  text-decoration: none;
}
div.qf-facttable table tbody tr td:first-child > span {
  display: table-cell;
}
div.qf-facttable table tbody tr td span[class^="icon-"],
div.qf-facttable table tbody tr td span[class*=" icon-"] {
  position: relative;
  display: inline-block;
  top: 0%;
  font-size: 90%;
  line-height: 100%;
}
div.qf-facttable table tbody tr td span[class^="icon-"]:before,
div.qf-facttable table tbody tr td span[class*=" icon-"]:before {
  position: relative;
  color: #cccccc;
}
div.qf-facttable table tbody tr td span[class^="icon-"] a.note,
div.qf-facttable table tbody tr td span[class*=" icon-"] a.note {
  display: inline-block;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: perspective(1px) translateX(-50%) translateY(-50%);
  color: #f99000;
  text-decoration: none;
  font-size: 70%;
  line-height: 100%;
  font-weight: bold;
}
div.qf-facttable table tbody tr td sup a.qf-note {
  display: inline-block;
  color: #0095a8;
  text-decoration: none;
  vertical-align: super;
  font-size: 12px;
  line-height: 100%;
  font-weight: bold;
}
div.qf-facttable table tbody tr td a,
div.qf-facttable table tbody tr td a abbr {
  color: inherit;
  border-bottom: none !important;
  cursor: inherit !important;
  text-decoration: none !important;
}
div.qf-facttable table tbody tr th #qf-topic-select {
  width: 200px !important;
  height: 28px !important;
  margin: 0.5em !important;
  border: none;
  font-weight: bold;
  display: table-cell;
  border: 1px solid #0095a8;
}
div.qf-facttable table tbody tr th #qf-browse-more {
  margin-left: 0.5em;
  display: inline-block;
}
div.qf-facttable table tbody tr th #qf-topic-select option {
  color: #000000;
  font-size: 12px;
  line-height: 28px;
  font-weight: normal;
}
