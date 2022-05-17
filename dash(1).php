div.qf-dashboard {
  height: 1105px;
}

div.qf-dashboard div.qf-facttable {
  position: relative;
  width: 629px;
  border: none;
  height: 1105px;
  overflow-x: hidden;
  overflow-y: auto;
  float: left;
}
div.qf-dashboard div.qf-facttable table {
  width: 100%;
  min-width: 0;
}

div.qf-dashboard div.qf-jsmap,
div.qf-dashboard div.qf-jsmap #qf-map-base {
  width: 629px;
  height: 400px;
}

div.qf-dashboard div.qf-jsmap {
  float: right;
}

div.qf-dashboard div.qf-quantile {
  width: 629px;
  height: 125px;
  float: right;
}
div.qf-dashboard div.qf-quantile div.qf-flags,
div.qf-dashboard div.qf-quantile div.qf-values {
  display: block;
  white-space: normal;
}
div.qf-dashboard div.qf-quantile div.qf-flags div,
div.qf-dashboard div.qf-quantile div.qf-values div {
  display: inline-block;
  padding: 2px;
}
div.qf-dashboard div.qf-quantile span.qf-min {
  margin-right: 2px;
}
div.qf-dashboard div.qf-quantile span.qf-max {
  margin-left: 2px;
}

div.qf-dashboard div.qf-chart {
  width: 629px;
  float: right;
}

div.qf-dashboard div.qf-chart div.qf-graph-scroll {
  height: 500px;
}

div.qf-dashboard div.qf-chart div.qf-scale, div.qf-chart div.qf-graph-bar {
  width: 430px !important;
}

div.qf-dashboard div.qf-facttable table:not(#selectedFacts) tbody tr.qf-header th:first-child {
  min-width: 350px;
}

div.qf-dashboard::after {
  content: ".";
  visibility: hidden;
  display: block;
  height: 0;
  clear: both;
}