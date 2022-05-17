/* https://caniuse.com/#search=color-adjust */
div.qf-chart {
  -webkit-print-color-adjust: exact !important;
  print-color-adjust: exact !important;
  color-adjust: exact !important;
}
div.qf-chart div.qf-graph-geo,
div.qf-chart div.qf-graph-header {
  position: relative;
}
div.qf-chart div.qf-graph-header {
  height: 20px;
  padding: 5PX 0;
}
div.qf-chart div.qf-graph-header {
  margin-top: 10px;
}
div.qf-chart div.qf-graph-geo {
  min-height: 37px;
}
div.qf-chart div.qf-graph-geo:nth-child(even) {
  background: #f1f3f5;
}
div.qf-chart div.qf-graph-geo.selected {
  background: #b2dfe4;
}
div.qf-chart div.qf-graph-geo.selected:nth-child(even) {
  background: #99d4dc;
}
div.qf-chart div.qf-graph-geo:hover {
  background: #dbe6ec;
}

div.qf-chart div.qf-graph-scroll {
  max-height: 600px;
  overflow-y: auto;
}


div.qf-chart div.qf-graph-header,
div.qf-chart div.qf-graph-bar div,
div.qf-chart div.qf-graph-header div.qf-geobox {
  font-size: 10px !important;
}
div.qf-chart div.qf-geobox,
div.qf-chart div.qf-graph-bar,
div.qf-chart div.qf-graph-value,
div.qf-chart div.qf-scale {
  position: absolute;
  min-height: 20px;
  top: 0;
}
div.qf-chart div.qf-geobox {
  left: 0;
  margin-right: 20px;
  width: 140px !important;
}
div.qf-chart div.qf-scale,
div.qf-chart div.qf-graph-bar {
  left: 160px;
  width: 1060px;
}
div.qf-chart div.qf-graph-bar,
div.qf-chart div.qf-graph-value {
  top: 50%;
  transform: perspective(1px) translateY(-50%);
}
div.qf-chart div.qf-graph-bar div {
  position: absolute;
  display: block;
}
div.qf-chart div.qf-graph-bar div:first-child {
  padding-left: 3px;
  z-index: 4;
  height: 18px;
  line-height: 18px;
}
div.qf-chart div.qf-graph-bar div:last-child {
  z-index: 3;
  height: 20px;
  line-height: 20px;
}

div.qf-chart div.qf-graph-bar div.qf-positive:last-child {
  background: #0095a8;
  box-shadow: inset 0 0 0 1000px #0095a8;
}
div.qf-chart div.qf-graph-bar div.qf-negative:last-child,
div.qf-chart div.qf-graph-bar div.qf-max-negative:last-child {
  background: #bc5c5c;
  box-shadow: inset 0 0 0 1000px #bc5c5c;
}

div.qf-chart div.qf-scale {
  border-top: 1px solid #c3d3de;
}

div.qf-chart div.qf-tickmarks div {
  height: 3px;
  width: 1px;
  background: #c3d3de;
}

div.qf-chart div.qf-values,
div.qf-chart div.qf-tickmarks {
  display: block;
  position: absolute;
  height: 20px;
  top: 0;
  left: 0
}
div.qf-chart div.qf-values div {
  margin-top: 5px;
  transform: perspective(1px) translateX(-50%);
}

div.qf-chart div.qf-values div,
div.qf-chart div.qf-tickmarks div {
  position: absolute;
  display: inline-block;
}

/* make empy div visible */
div.qf-chart div.qf-tickmarks div:after,
div.qf-chart div.qf-graph-bar div:last-child:after {
  content: '.';
  visibility: hidden;
}
div.qf-chart div.qf-graph-bar a.flag {
  font-size: 14px;
}
div.qf-chart div.qf-graph-bar div[data-isnumeric="1"] {
  display: none;
}
div.qf-chart div.qf-graph-bar:hover div[data-isnumeric="1"] {
  background: #ffffff;
  display: inline-block;
  padding: 0 10px;
  box-shadow: 2px 2px 10px #888888;
}
div.qf-chart > div:not([data-zeroleft="0"]) div.qf-graph-bar:hover div.qf-positive[data-isnumeric="1"],
div.qf-chart > div:not([data-zeroleft="0"]) div.qf-graph-bar:hover div.qf-max-negative[data-isnumeric="1"] {
  border: 1px solid #0095a8;
  transform: perspective(1px) translateX(-100%);
}
div.qf-chart > div:not([data-zeroleft="0"]) div.qf-graph-bar:hover div.qf-negative[data-isnumeric="1"],
div.qf-chart > div:not([data-zeroleft="0"]) div.qf-graph-bar:hover div.qf-max-negative[data-isnumeric="1"] {
  border: 1px solid #bc5c5c;
}
div.qf-chart > div[data-zeroleft="0"] div.qf-graph-bar:hover div.qf-positive[data-isnumeric="1"] {
  border: 1px solid #0095a8;
}

/*
div.qf-chart div.qf-graph-bar div[data-isnumeric="1"] {
  background: #ffffff;
  border: 1px solid transparent;
  display: inline-block;
  padding: 0 10px;
}
div.qf-chart > div:not([data-zeroleft="0"]) div.qf-graph-bar div.qf-positive[data-isnumeric="1"] {
  transform: perspective(1px) translateX(-100%);
}
*/