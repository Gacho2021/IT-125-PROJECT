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

function _instanceof(left, right) { if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) { return !!right[Symbol.hasInstance](left); } else { return left instanceof right; } }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!_instanceof(instance, Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

$QF(function ($) {
  var ENABLE3D = false;
  /**
   * If you change VINTAGE and VINTAGEXX, and/or GISSERV you
   * MUST update "assets/js/mapbox/v1.3.1/census.style.js"
   **/
  var VINTAGE = '2018';
  var VINTAGEXX = '18';
  var GISSERV = 'https://gis.data.census.gov/arcgis/rest/services/Hosted/VT_';
  //var GISSERV = 'https://gis.data.test.census.gov/arcgis/rest/services/Hosted/VT_';
  var GLAYERS = {
    layers: ['State/1/'+VINTAGEXX, 'County/0/'+VINTAGEXX, 'Place/'+VINTAGEXX, 'Place/10', 'CountySubdivision/0/'+VINTAGEXX]
  };
  var MAPCENTER = [-98, 38.88];
  var MAPTARGET = 'qf-map-base';
  var MAPSNAP   = 5;
  var LOADBAR   = 'qf-map-loadbar';
  var DFLTCLR1 = 'lightgrey';
  var DFLTCLR2 = 'black';
  var DFLTCLR3 = 'red';
  var DFLTCLR4 = 'white';
  var DFLTRGBA0 = 'rgba(0,0,0,0)';
  var DFLTRGBA1 = 'rgba(255,0,0,1)';
  var MINZOOM = 3;
  var STCTYBR = 6;
  var CTYPLBR = 9;
  var OPACITY0 = 1.0;
  var OPACITY1 = 0.5;
  var OPACITY2 = 0.7;
  var OPACITY3 = 0.2;
  var OPACITY4 = 0.0;
  var DFLTWIDTH0 = 0;
  var DFLTWIDTH1 = 2;
  var JAMVALREG = /[0-9]+[+-]$/;
  var FLAGPREFIX = 'qf-flag-';
  var NOTEPREFIX = 'qf-note-';
  var IMAGEBASEDIR = '/quickfacts/assets/images/';
  var QUANTCLRS = JSON.parse('{"values":["#dffbff","#8aedfa","#59bcc9","#2b8e9b","#006370"],"flags":["#1f77b4","#ff7f0e","#9467bd","#8c564b","#e377c2","#7f7f7f","#bcbd22","#17becf"]}');
  var FACTYEARS = JSON.parse('{"0":2010,"1":2012,"2":2015,"3":2016,"4":2017,"5":2018,"6":2019}');
  var COMFILTER = 'largest';
  var HALFWAY2AK = 650; // in miles from WA
  var HALFWAY2HI = 1235.5; // in miles from CA
  var HALFWAY2PR = 575; // in miles from FL
  var TIPVIZTIME = 10; // in seconds
  var TIPCHANGE  = 400 // in millaseconds
  var TIPNEWLINE = String.fromCharCode(10,10);

  var tinyQueue =
  /*#__PURE__*/
  (function() {
    function tinyQueue() {
      var data =
        arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
      var compare =
        arguments.length > 1 && arguments[1] !== undefined
          ? arguments[1]
          : centerOfMass.defaultCompare;

      _classCallCheck(this, tinyQueue);

      this.data = data;
      this.length = this.data.length;
      this.compare = compare;

      if (this.length > 0) {
        for (var i = (this.length >> 1) - 1; i >= 0; i--) {
          this._down(i);
        }
      }
    }

    _createClass(tinyQueue, [
      {
        key: "push",
        value: function push(item) {
          this.data.push(item);
          this.length++;

          this._up(this.length - 1);
        }
      },
      {
        key: "pop",
        value: function pop() {
          if (this.length === 0) return undefined;
          var top = this.data[0];
          var bottom = this.data.pop();
          this.length--;

          if (this.length > 0) {
            this.data[0] = bottom;

            this._down(0);
          }

          return top;
        }
      },
      {
        key: "peek",
        value: function peek() {
          return this.data[0];
        }
      },
      {
        key: "_up",
        value: function _up(pos) {
          var data = this.data,
            compare = this.compare;
          var item = data[pos];

          while (pos > 0) {
            var parent = (pos - 1) >> 1;
            var current = data[parent];
            if (compare(item, current) >= 0) break;
            data[pos] = current;
            pos = parent;
          }

          data[pos] = item;
        }
      },
      {
        key: "_down",
        value: function _down(pos) {
          var data = this.data,
            compare = this.compare;
          var halfLength = this.length >> 1;
          var item = data[pos];

          while (pos < halfLength) {
            var left = (pos << 1) + 1;
            var best = data[left];
            var right = left + 1;

            if (right < this.length && compare(data[right], best) < 0) {
              left = right;
              best = data[right];
            }

            if (compare(best, item) >= 0) break;
            data[pos] = best;
            pos = left;
          }

          data[pos] = item;
        }
      }
    ]);

    return tinyQueue;
  })();

  var createIcon =
  /*#__PURE__*/
  function () {
    function createIcon(map, geo, mnemonic) {
      _classCallCheck(this, createIcon);

      var self = this;

      this.toggle = false;
      this.map = map;
      this.geo = geo;
      this.mnemonic = mnemonic;
      this.position = geo.jump2icon;
      this.added = undefined;
      this.icon = document.createElement('div');
      this.geoStyle = {
        fillColor: this.geo.data[this.mnemonic].quantile,
        strokeColor: QF.isSelectedGeo(this.geo.geoid) ? DFLTCLR3 : DFLTCLR2,
        fillOpacity: OPACITY1
      };
      this.idleOnce = function() {
        choroplethMap.gotoGeoid(self.geo.geoid);
      }

      var iconSize = parseInt('96');
      var iSize = QF.view == 'dashboard' ? Math.floor(iconSize * 0.75) : iconSize;
      var id = QF.cssPrefix + 'icon-' + this.geo.geoid,
          c1ass = QF.cssPrefix + 'icon-jump2',
          c1assM = QF.cssPrefix + 'icon-map mapboxgl-ctrl',
          iframe = document.createElement('iframe'),
          ifra00 = document.createElement('iframe'),
          overlay = document.createElement('div');
      var style = {
          backgroundColor: 'transparent',
          border: 'none',
          overflow: 'hidden',
          width: iSize + 'px',
          height: iSize + 'px'
        },
        styleIcon = {
          width: iSize + 10 + 'px',
          height: iSize + 10 + 'px',
          margin: '10px',
          padding: '5px',
          border: '1px solid #000000',
          backgroundColor: '#d3d3d3'
        };

      overlay.geo = this.geo;

      this.icon.appendChild(iframe);
      this.icon.appendChild(ifra00);
      this.icon.appendChild(overlay);

      Object.deepAssign(this.icon, {
        className: c1assM
      });
      Object.deepAssign(this.icon.style, style, styleIcon);
      Object.deepAssign(iframe, {
        src: QF.approot + 'geo/svg/' + this.geo.geoid
      });
      Object.deepAssign(iframe.style, style, {
        position: 'absolute',
        display: ''
      });
      Object.deepAssign(iframe.title, 'Zoom to ' + this.geo.fullName);
      Object.deepAssign(ifra00, {
        src: QF.approot + 'geo/svg/00'
      });
      Object.deepAssign(ifra00.style, style, {
        position: 'absolute',
        display: 'none'
      });
      Object.deepAssign(ifra00.title, 'Zoom to US 48 contiguous states');
      Object.deepAssign(overlay.style, style, {
        position: 'absolute',
        cursor: 'pointer'
      });
      Object.deepAssign(overlay, {
        id: id,
        className: c1ass,
        toggle: false,
        title: 'Zoom to ' + this.geo.fullName
      });

      overlay.addEventListener('click', function () {
        choroplethMap.closeInfoPopup();

        if (!self.toggle) {
          var
            title    = 'Zoom to US 48 contiguous states',
            centroid = [self.geo.centroid.lng, self.geo.centroid.lat];

          self.map.flyTo({
            center: centroid,
            zoom: MINZOOM
          }).once('idle', self.idleOnce);

          Object.deepAssign(ifra00.style, {
            display: ''
          });
          Object.deepAssign(iframe.style, {
            display: 'none'
          });
          Object.deepAssign(self, {
            toggle: true,
            title: title
          });
        } else {
          var
            title = 'Zoom to ' + self.geo.title;

          choroplethMap.setLevel('nation');

          self.map.off('idle', self.idleOnce).flyTo({
            center: MAPCENTER,
            zoom: MINZOOM
          });

          Object.deepAssign(ifra00.style, {
            display: 'none'
          });
          Object.deepAssign(iframe.style, {
            display: ''
          });
          Object.deepAssign(self, {
            toggle: false,
            title: title
          });
        }
      });
      overlay.addEventListener('iconReset', function () {
        var title = 'Zoom to ' + self.geo.title;

        Object.deepAssign(ifra00.style, {
          display: 'none'
        });
        Object.deepAssign(iframe.style, {
          display: ''
        });
        Object.deepAssign(self, {
          toggle: false,
          title: title
        });

        overlay.previousSibling.previousSibling.dispatchEvent(iconLoad);
      });
      overlay.addEventListener('iconSet', function () {
        var title = 'Zoom to US 48 contiguous states';

        Object.deepAssign(ifra00.style, {
          display: ''
        });
        Object.deepAssign(iframe.style, {
          display: 'none'
        });
        Object.deepAssign(self, {
          toggle: true,
          title: title
        });

        overlay.previousSibling.previousSibling.dispatchEvent(iconLoad);
      });
      iframe.addEventListener('load', function () {
        $(this).contents().find('.main').css({
          'stroke': self.geoStyle.strokeColor,
          'fill': self.geoStyle.fillColor,
          'fill-opacity': OPACITY1
        });
      });

      document.getElementById(MAPTARGET).addEventListener('click', function (e) {
        methods.resetIcons(e);
      });
    }

    _createClass(createIcon, [{
      key: "getPosition",
      value: function getPosition() {
        return this.position;
      }
    }, {
      key: "isAdded",
      value: function isAdded() {
        return this.added;
      }
    }, {
      key: "onAdd",
      value: function onAdd(map) {
        this.added = true;
        return this.icon;
      }
    }, {
      key: "onRemove",
      value: function onRemove() {
        this.added = false;

        if (this.icon.parentNode) {
          this.icon.parentNode.removeChild(this.icon);
        }
      }
    }]);

    return createIcon;
  }();

  var toggleMCDPlace =
  /*#__PURE__*/
  function () {
    function toggleMCDPlace(map) {
      _classCallCheck(this, toggleMCDPlace);

      var self = this;
      this.map = map;
      this.added = undefined;
      this.mcdsShown = false;
      this.displayTip = true;
      this.tipText = 'Swap map view between Townships and Places.';
      this.placeLabel = 'PLCs';
      this.placeTitle = 'Showing Places';
      this.mcdLabel = 'TWPs';
      this.mcdTitle = 'Showing Towns & Townships';
      this._container = document.createElement('div');
      this._button = document.createElement('button');
      this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
      this._button.className = 'mapboxgl-ctrl';
      this._button.textContent = this.mcdLabel;

      this._container.setAttribute('style', 'width:60px;');
      if (this.displayTip) {
        this._container.setAttribute('aria-label', 'NEW!');
        this._container.setAttribute('data-balloon-pos', 'left');
        this._container.setAttribute('data-balloon-length', 'small');
        this._container.setAttribute('data-balloon-visible', '');
      }
      this._button.setAttribute('style', 'width:100%; margin:0;');
      this._button.setAttribute('type', 'button');
      this._button.setAttribute('aria-label', this.mcdTitle);

      this._container.appendChild(this._button);

      this._button.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();
        var level = null;

        if (!self.mcdsShown) {
          self.mcdsShown = true;
          self.showMCDs();
          level = 'cousub';
        } else {
          self.mcdsShown = false;
          self.showPlaces();
          level = 'place';
        }

        methods.quantilesDisplay(false);
        methods.setMapLevel(level);

        choroplethMap.closeInfoPopup();

        if (choroplethMap.getInfo(true)) {
          methods.setQuantiles(choroplethMap.getQuantiles());
        }
      };
    }

    _createClass(toggleMCDPlace, [{
      key: "isAdded",
      value: function isAdded() {
        return this.added;
      }
    }, {
      key: "onAdd",
      value: function onAdd(map) {
        var self = this;
        this.added = true;

        if (this.displayTip) {
          setTimeout(function(){ self.hideTip(); }, TIPVIZTIME * 1000);
        }

        return this._container;
      }
    }, {
      key: "onRemove",
      value: function onRemove() {
        this.added = false;

        this._container.parentNode.removeChild(this._container);
      }
    }, {
      key: "hideTip",
      value: function hideTip() {
        var self = this;

        this.displayTip = false;
        this._container.removeAttribute('data-balloon-visible');
        // IE support
        setTimeout(function(){
          var tip = self.mcdsShown
                  ? self.tipText + TIPNEWLINE + self.mcdTitle
                  : self.tipText + TIPNEWLINE + self.placeTitle;

          self._container.setAttribute('data-balloon-length', 'large');
          self._container.setAttribute('aria-label', tip);
        }, TIPCHANGE);
      }
    }, {
      key: "showMCDs",
      value: function showMCDs() {
        this.mcdsShown = true;

        this._button.textContent = this.mcdLabel;
        //this._button.setAttribute('title', this.mcdTitle);
        this._button.setAttribute('aria-label', this.mcdTitle);

        if (!this.displayTip) {
          this._container.setAttribute('aria-label', this.tipText + TIPNEWLINE + this.mcdTitle);
        }

        this.map.setLayoutProperty('CountySubdivision/0/'+VINTAGEXX, 'visibility', 'visible');
        this.map.setLayoutProperty('CountySubdivision/label/CountySubdivision/'+VINTAGEXX, 'visibility', 'visible');
        this.map.setLayoutProperty('CountySubdivision/line/'+VINTAGEXX, 'visibility', 'visible');

        this.map.setLayoutProperty('Place/10', 'visibility', 'none');
        this.map.setLayoutProperty('Place/label/Place/10', 'visibility', 'none');
        this.map.setLayoutProperty('Place/line/10', 'visibility', 'none');
        this.map.setLayoutProperty('Place/'+VINTAGEXX, 'visibility', 'none');
        this.map.setLayoutProperty('Place/label/Place/'+VINTAGEXX, 'visibility', 'none');
        this.map.setLayoutProperty('Place/line/'+VINTAGEXX, 'visibility', 'none');
      }
    }, {
      key: "showPlaces",
      value: function showPlaces() {
        this.mcdsShown = false;

        this._button.textContent = this.placeLabel;
        //this._button.setAttribute('title', this.placeTitle);
        this._button.setAttribute('aria-label', this.placeTitle);

        if (!this.displayTip) {
          this._container.setAttribute('aria-label', this.tipText + TIPNEWLINE + this.placeTitle);
        }

        this.map.setLayoutProperty('CountySubdivision/0/'+VINTAGEXX, 'visibility', 'none');
        this.map.setLayoutProperty('CountySubdivision/label/CountySubdivision/'+VINTAGEXX, 'visibility', 'none');
        this.map.setLayoutProperty('CountySubdivision/line/'+VINTAGEXX, 'visibility', 'none');

        //if (QF.getMaxyear() == 2010) {
        if ( MVC.decennial.indexOf( QF.getFacts()[0] ) >= 0 ) {
          this.map.setLayoutProperty('Place/10', 'visibility', 'visible');
          this.map.setLayoutProperty('Place/label/Place/10', 'visibility', 'visible');
          this.map.setLayoutProperty('Place/line/10', 'visibility', 'visible');
          this.map.setLayoutProperty('Place/'+VINTAGEXX, 'visibility', 'none');
          this.map.setLayoutProperty('Place/label/Place/'+VINTAGEXX, 'visibility', 'none');
          this.map.setLayoutProperty('Place/line/'+VINTAGEXX, 'visibility', 'none');
        } else {
          this.map.setLayoutProperty('Place/10', 'visibility', 'none');
          this.map.setLayoutProperty('Place/label/Place/10', 'visibility', 'none');
          this.map.setLayoutProperty('Place/line/10', 'visibility', 'none');
          this.map.setLayoutProperty('Place/'+VINTAGEXX, 'visibility', 'visible');
          this.map.setLayoutProperty('Place/label/Place/'+VINTAGEXX, 'visibility', 'visible');
          this.map.setLayoutProperty('Place/line/'+VINTAGEXX, 'visibility', 'visible');
        }
      }
    }]);

    return toggleMCDPlace;
  }();

  var toggleLoadAllGeos =
  /*#__PURE__*/
  function () {
    function toggleLoadAllGeos(map) {
      _classCallCheck(this, toggleLoadAllGeos);

      var self = this;
      this._defaultTitle  = 'Only geographies within parent States are clickable';
      this._selectedTitle = 'All available geographies within QuickFacts are clickable';
      this._defaultImage  = IMAGEBASEDIR+'switch-off.svg';
      this._selectedImage = IMAGEBASEDIR+'switch-on.svg';

      this.map = map;
      this.added = undefined;
      this.geos = false;
      this.displayTip = true;
      this.tipText = 'By default clickable geographies are limited to the parent State of the user selected geographies. Toggle this control to enable all geographies within QuickFacts.';
      this._container = document.createElement('div'); 
      this._button = document.createElement('button');
      this._image = document.createElement('img');
      this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
      this._button.className = 'mapboxgl-ctrl';
      this._button.textContent = '';

      this._container.setAttribute('style', 'width:60px; background:transparent;');
      if (this.displayTip) {      
        this._container.setAttribute('aria-label', 'NEW!');
        this._container.setAttribute('data-balloon-pos', 'left');
        this._container.setAttribute('data-balloon-length', 'small');
        this._container.setAttribute('data-balloon-visible', '');
      }

      this._button.setAttribute('style', 'width:100%; margin:0; white-space:nowrap; display:inline-block; line-height:1px; position:relative;');
      this._button.setAttribute('type', 'button');
      this._button.setAttribute('aria-label', this._defaultTitle);
      this._image.setAttribute('src', this._defaultImage);
      this._image.setAttribute('alt', this._defaultTitle);
      this._image.setAttribute('style', 'position:absolute; left:0; top:-15px; height:60px;');

      this._button.appendChild(this._image);
      this._container.appendChild(this._button);

      this._button.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!self.geos) {
          self.addAll();
        } else {
          self.removeAll();
        }

        //choroplethMap.appendURLS();
        //choroplethMap.appendURLS().appendJSON().reDraw();
        methods.geolocate(false);
      };
    }

    _createClass(toggleLoadAllGeos, [{
      key: "isAdded",
      value: function isAdded() {
        return this.added;
      }
    }, {
      key: "onAdd",
      value: function onAdd(map) {
        var self = this;
        this.added = true;

        if (this.displayTip) {
          setTimeout(function(){ self.hideTip(); }, TIPVIZTIME * 1000);
        }

        return this._container;
      }
    }, {
      key: "onRemove",
      value: function onRemove() {
        this.added = false;

        this._container.parentNode.removeChild(this._container);
      }
    }, {
      key: "hideTip",
      value: function hideTip() {
        var self = this;

        this.displayTip = false;
        this._container.removeAttribute('data-balloon-visible');
        // IE support
        setTimeout(function(){
          var tip = self.geos
                  ? self.tipText + TIPNEWLINE + self._selectedTitle
                  : self.tipText + TIPNEWLINE + self._defaultTitle;

          self._container.setAttribute('data-balloon-length', 'xlarge');
          self._container.setAttribute('aria-label', tip);
        }, TIPCHANGE);
      }
    }, {
      key: "addAll",
      value: function addAll() {
        this.geos = true;

        if (!this.displayTip) {
          this._container.setAttribute('aria-label', this.tipText + TIPNEWLINE + this._selectedTitle);
        }

        this._button.setAttribute('aria-label', this._selectedTitle);
        this._image.setAttribute('src', this._selectedImage);
        this._image.setAttribute('alt', this._selectedTitle);        
      }
    }, {
      key: "removeAll",
      value: function removeAll() {
        this.geos = false;

        choroplethMap.info.allGeoids = [];
        choroplethMap.fillColor = [];

        if (!this.displayTip) {
          this._container.setAttribute('aria-label', this.tipText + TIPNEWLINE + this._defaultTitle);
        }

        this._button.setAttribute('aria-label', this._defaultTitle);
        this._image.setAttribute('src', this._defaultImage);
        this._image.setAttribute('alt', this._defaultTitle);        
      }
    }]);

    return toggleLoadAllGeos;
  }();

  var togglePitch =
  /*#__PURE__*/
  function () {
    function togglePitch(map) {
      _classCallCheck(this, togglePitch);

      var self = this;
      this.map = map;
      this.added = undefined;
      this.tilted = false;
      this._container = document.createElement('div');
      this._button = document.createElement('button');
      this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
      this._button.className = 'mapboxgl-ctrl';
      this._button.textContent = '3D';

      this._button.setAttribute('class', 'mapboxgl-ctrl-icon');
      this._button.setAttribute('type', 'button');
      this._button.setAttribute('title', 'Toggle Pitch');
      this._button.setAttribute('aria-label', 'Toggle Pitch');
      this._container.appendChild(this._button);

      this._button.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!self.tilted) {
          self.toggle3D();
        } else {
          self.toggle2D();
        }
      };
    }

    _createClass(togglePitch, [{
      key: "isAdded",
      value: function isAdded() {
        return this.added;
      }
    }, {
      key: "onAdd",
      value: function onAdd(map) {
        this.added = true;
        return this._container;
      }
    }, {
      key: "onRemove",
      value: function onRemove() {
        this.added = false;

        this._container.parentNode.removeChild(this._container);
      }
    }, {
      key: "toggle3D",
      value: function toggle3D() {
        this.tilted = true;

        this._button.textContent = '2D';
        this.map.easeTo({pitch: 45, bearing: -25});
      }
    }, {
      key: "toggle2D",
      value: function toggle2D() {
        this.tilted = false;

        this._button.textContent = '3D';
        this.map.easeTo({pitch: 0, bearing: 0});
      }
    }]);

    return togglePitch;
  }();

  var toggleInfoAside =
  /*#__PURE__*/
  function () {
    function toggleInfoAside(id, int, width, speed) {
      _classCallCheck(this, toggleInfoAside);

      var self = this;
      this.interval = int;
      this.targetWidth = width;
      this.speed = speed;
      this.move = undefined;
      this.open = true;
      this.displayTip = true;
      this.tipText = 'List of all selected geographies.';

      this.info = document.getElementById(id);
      this.geos = this.info.getElementsByTagName('div')[0];
      this.bttn = this.info.getElementsByTagName('div')[2];
      this.icon = this.bttn.getElementsByTagName('span')[0];
      this.size = this.geos.offsetWidth;

      if (this.displayTip) {      
        this.bttn.setAttribute('aria-label', 'NEW!');
        this.bttn.setAttribute('data-balloon-pos', 'right');
        this.bttn.setAttribute('data-balloon-length', 'small');
        this.bttn.setAttribute('data-balloon-visible', '');

        setTimeout(function(){ self.hideTip(); }, TIPVIZTIME * 1000);
      }      

      this.bttn.onclick = function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (typeof self.move == 'undefined') {
          if (self.open) {
            self.icon.setAttribute('class', 'icon-right-open');
            self.move = setInterval(self.hide.bind(self), self.interval);
          } else {
            self.icon.setAttribute('class', 'icon-left-open');
            self.move = setInterval(self.show.bind(self), self.interval);
          }
        }
      };
    }

    _createClass(toggleInfoAside, [{
      key: "show",
      value: function show() {
        if (this.size >= this.targetWidth) {
          clearInterval(this.move);
          this.move = undefined;
          this.open = true;
          this.size = this.targetWidth;
        } else {
          this.size += this.speed;
        }

        this.info.style.width = this.size + 'px';
      }
    }, {
      key: "hide",
      value: function hide() {
        if (this.size <= 0) {
          clearInterval(this.move);
          this.move = undefined;
          this.open = false;
          this.size = 0;
        } else {
          this.size -= this.speed;
        }

        this.info.style.width = this.size + 'px';
      }
    }, {
      key: "hideTip",
      value: function hideTip() {
        var self = this;

        this.displayTip = false;
        this.bttn.removeAttribute('data-balloon-visible');
        // IE support
        setTimeout(function(){
          self.bttn.setAttribute('data-balloon-length', 'large');
          self.bttn.setAttribute('aria-label', self.tipText);
        }, TIPCHANGE);
      }
    }, {
      key: "close",
      value: function close() {
        if (typeof this.move != 'undefined') {
          clearInterval(this.move);
        }

        this.move = undefined;
        this.open = false;
        this.size = 0;
        this.icon.setAttribute('class', 'icon-right-open');
        this.info.style.width = '0px';
      }
    }, {
      key: "open",
      value: function open() {
        if (typeof this.move != 'undefined') {
          clearInterval(this.move);
        }

        this.move = undefined;
        this.open = true;
        this.size = this.targetWidth;
        this.icon.setAttribute('class', 'icon-left-open');
        this.info.style.width = this.targetWidth + 'px';
      }
    }]);

    return toggleInfoAside;
  }();

  var mapChoropleth =
  /*#__PURE__*/
  function () {
    function mapChoropleth(id) {
      _classCallCheck(this, mapChoropleth);

      this.target = id;
      this.base = document.getElementById(this.target);
      this.loadbar = document.getElementById(LOADBAR);
      this.spinner = document.getElementById('spinner');
      this.initialLoad = false;
      this.loading = null;      
      this.map = undefined;
      this.json = {};
      this.info = {};
      this.quantiles = {};
      this.fillColor = {};
      this.stroke = {};
      this.line = {};
      this.width = {};
      this.opacity = {};
      this.icons = {};
      this.geoURLs = [];
      this.level = undefined;
      this.startLvl = undefined;
      this.mnemonic = undefined;
      this.toggle = undefined;
      this.loadall = undefined;
      this.togglePitch = undefined;
      this.infoPopup = new mapboxgl.Popup();
      this.imageURL = QF.approot + 'assets/images/diag-striping.png';
      this.imageBLU = QF.approot + 'assets/images/diag-striping-blue.png';
      this.imagePHP = QF.approot + 'assets/images/png.php?';
      return this;
    } // cedsci basemap layer (might have CORS issues)


    _createClass(mapChoropleth, [{
      key: "create",
      value: function create() {
        if (this.map) {
          this.map.remove();
        }

        var self = this;
        this.map = new mapboxgl.Map({
          container: this.target,
          style: QF.approot + 'assets/js/mapbox/v1.3.1/census.style.js',
          center: MAPCENTER,
          minZoom: MINZOOM,
          zoom: MINZOOM,
          bearingSnap: MAPSNAP
        });

        if (!ENABLE3D) {
          // disable map rotation using right click + drag
          this.map.dragRotate.disable();
          // disable map rotation using touch rotation gesture
          this.map.touchZoomRotate.disableRotation();        
        }

        //mapboxgl.workerUrl = QF.approot + 'assets/js/mapbox/v1.3.1/mapbox-gl-csp-worker.js';

        this.map.loadImage(this.imageURL, function (err, image) {
          if (err) {
            throw err;
          } else {
            self.map.addImage('striping', image);
          }          
        });

        this.map.loadImage(this.imageBLU, function (err, image) {
          if (err) {
            throw err;
          } else {
            self.map.addImage('stripingBlue', image);
          }          
        });

        for (var _i = 0, _Object$keys = Object.keys(QUANTCLRS); _i < _Object$keys.length; _i++) {
          var type = _Object$keys[_i];
          QUANTCLRS[type].forEach(function (color) {
            if (!self.map.hasImage(color)) {
              self.map.loadImage(self.imagePHP + color.substr(1), function (err, image) {
                if (err) {
                  throw err;
                } else {
                  self.map.addImage(color, image);
                }
              });
            }
          });
        }

        this.map.on('styleimagemissing', function(e) {

        });        

        return this;
      }
    }, {
      key: "addControls",
      value: function addControls() {
        var self = this;
        this.toggle = new toggleMCDPlace(this.map);
        this.loadall = new toggleLoadAllGeos(this.map);
        this.togglePitch = new togglePitch(this.map);

        if ( QF.view != 'dashboard' && (!QF.isIE() || QF.isEDGE()) ) {
          this.map.addControl(new mapboxgl.FullscreenControl({
            container: document.getElementsByClassName('qf-jsmap')[0]
          }), 'top-right');
        }

        this.map.addControl(new mapboxgl.NavigationControl({
          showCompass: ENABLE3D
        }), 'top-right');


        if(this.map.getZoom() >= STCTYBR){
          this.map.addControl(this.loadall, 'top-right');          
        }

        if (ENABLE3D) {
          this.map.addControl(this.togglePitch, 'top-right');
        }


        this.map.on('click', function (e) {
          var features  = self.map.queryRenderedFeatures([e.point.x, e.point.y], GLAYERS);

          if (features.length) {
            var available = self.geoidLoaded(features[0].properties.GEOID);
            if (available) {
              var geoid  = features[0].properties.GEOID,
                  json   = self.getJSON(geoid),
                  data   = self.getData(geoid),
                  COM    = self.getFeatureCOM(features[0]),
                  html   = '';

              if ( json && data) {
                var srcnote = self.sourceNoteIcon(data.vDataset, json.level);

                html += '<div id="' + QF.cssPrefix + 'tooltip-value">' + json.fullName + ':<br/><strong>';

                if (data.isnumeric || JAMVALREG.test(data.formated)) {
                  html += data.formated;
                } else {
                  html += '<a href="#' + FLAGPREFIX + data.formated + '">' + data.formated + '</a>';
                }

                html += '</strong>';

                if (srcnote !== null) {
                  html += srcnote;
                }

                if (data.footnote) {
                  var valNum = $('a[data-code="' + data.footnote + '"]').text();
                  html += '<sup><a href="#' + NOTEPREFIX + data.footnote + '">' + valNum + '</a></sup>';
                } // buttons


                html += '<div class="' + QF.cssPrefix + 'infowindow-controls">';

                if (QF.isSelectedGeo(geoid)) {
                  html += '<button data-action="-1" data-geoid="' + geoid + '" data-dataset="' + data.vDataset + '" data-add="' + QF.removeGeomUrl(json.shortName) + '" data-fullname="' + json.fullName + '" data-level="' + json.level + '">' + QF.removeIcon(true) + 'Remove</button>';
                } else if (!QF.atMaxGeos()) {
                  html += '<button data-action="+1" data-geoid="' + geoid + '" data-dataset="' + data.vDataset + '" data-add="' + QF.addGeomUrl(json.shortName) + '" data-fullname="' + json.fullName + '" data-level="' + json.level + '">' + QF.addIcon(true) + 'Add</button>';
                } else {
                  html += '<button data-action="0" data-geoid="' + geoid + '" data-dataset="' + data.vDataset + '" data-add="' + QF.addGeomUrl(json.shortName) + '" data-fullname="' + json.fullName + '" data-level="' + json.level + '">' + QF.addIcon(true) + 'Add</button>';
                }

                html += '</div>'; // buttons

                html += '</div>';
              } else if(self.loadall.geos) {
                html += '<div id="' + QF.cssPrefix + 'tooltip-value">' + available.fullName + ':';

                html += '<div class="' + QF.cssPrefix + 'infowindow-controls">';
                if (!QF.atMaxGeos()) {
                  html += '<button data-action="+1" data-geoid="' + geoid + '" data-dataset="' + available.dataset + '" data-add="' + QF.addGeomUrl(available.shortName) + '" data-fullname="' + available.fullName + '" data-level="' + available.level + '">' + QF.addIcon(true) + 'Add</button>';
                } else {
                  html += '<button data-action="0" data-geoid="' + geoid + '" data-dataset="' + available.dataset + '" data-add="' + QF.addGeomUrl(available.shortName) + '" data-fullname="' + available.fullName + '" data-level="' + available.level + '">' + QF.addIcon(true) + 'Add</button>';
                }
                html += '</div>'; // buttons
                
                html += '</div>';
              }

              //self.map.fitBounds(COM.bounds);
              self.infoPopup.setLngLat(e.lngLat).setHTML(html).addTo(self.map);
            } // end if (available)
          }
        });
        this.map.on('zoomstart', function () {
          var zoom = self.map.getZoom();

          self.closeInfoPopup();

          if (zoom < STCTYBR) {
            self.startLvl = 'state';
          } else if (zoom < CTYPLBR) {
            self.startLvl = 'county';
          } else if (self.toggle.mcdsShown) {
            self.startLvl = 'cousub';
          } else {
            self.startLvl = 'place';
          }
        });
        this.map.on('zoomend', function () {
          var
            zoom    = self.map.getZoom(),
            mapInfo = document.getElementById('qf-map-info'),
            icons   = (mapInfo) ? mapInfo.firstElementChild.firstElementChild.getElementsByTagName('object') : [];       

          for (var _i2 = 0, _Object$keys2 = Object.keys(self.icons); _i2 < _Object$keys2.length; _i2++) {
            var geoid = _Object$keys2[_i2];

            if (zoom < STCTYBR && !self.icons[geoid].isAdded()) {
              self.map.addControl(self.icons[geoid], self.icons[geoid].getPosition());
            } else if (zoom >= STCTYBR && self.icons[geoid].isAdded()) {
              self.map.removeControl(self.icons[geoid]);
            }
          }

          if (zoom >= CTYPLBR && !self.toggle.isAdded()) {
            self.map.addControl(self.toggle, 'top-right');
          } else if (zoom < CTYPLBR && self.toggle.isAdded()) {
            self.map.removeControl(self.toggle);
          }

          if (zoom >= STCTYBR && !self.loadall.isAdded()) {
            self.map.addControl(self.loadall, 'top-right');
          } else if (zoom < STCTYBR && self.loadall.isAdded()) {
            self.map.removeControl(self.loadall);
          }
          

          if (zoom < STCTYBR) {
            self.level = 'state';
          } else if (zoom < CTYPLBR) {
            self.level = 'county';
          } else if (self.toggle.mcdsShown) {
            self.toggle.showMCDs();
            self.level = 'cousub';
          } else {
            self.toggle.showPlaces();
            self.level = 'place';
          }

          for (var i = icons.length - 1; i >= 0; i--) {
            var
              css = self.level == icons[i].getAttribute('data-level') ? icons[i].getAttribute('data-css-full') : icons[i].getAttribute('data-css-empty');

            icons[i].setAttribute('data-css', css);
            icons[i].dispatchEvent(iconLoad);
          }

          methods.setMapLevel(self.level);

          if (self.getInfo(true)) {
            methods.setQuantiles(self.getQuantiles());
          } else {
            methods.quantilesDisplay(false);
          }

          if (self.level != self.startLvl) {
            self.reDraw();
          }
        });
        this.map.on('pitchend', function(){
          var
            pitch = self.map.getPitch();

          if (pitch < MAPSNAP * 2) {
            self.togglePitch.toggle2D();
          } else if( !self.togglePitch.tilted ) {
            self.togglePitch.toggle3D();
          }
        });
        this.map.on('data', function () {
          clearTimeout(this.loading);

          self.loadbar.style.display = 'block';

          if (!self.initialLoad) {
            self.spinner.style.display = 'block';
          }
        });
        this.map.on('idle', function () {
          self.testIcons();      
          this.loading = setTimeout(function(){
            self.loadbar.style.display = 'none';

            if (!self.initialLoad) {
              self.spinner.style.display = 'none';
              self.initialLoad = true
            }
          }, 2000);
        });
        this.map.on('dragend', function() {
          self.testIcons();
        });

        return this;
      }
    }, {
      key: "testIcons",
      value: function testIcons() {
        var
          jump2icons = $('.' + QF.cssPrefix + 'icon-jump2');

        for (var i = jump2icons.length - 1; i >= 0; i--) {
          var
            bnd = new mapboxgl.LngLatBounds(
              new mapboxgl.LngLat(jump2icons[i].geo.bounds.west, jump2icons[i].geo.bounds.south),
              new mapboxgl.LngLat(jump2icons[i].geo.bounds.east, jump2icons[i].geo.bounds.north)
            ),
            ctr = this.map.getCenter(),
            inb = this.inBounds(bnd, ctr),
            dst = this.haversine(
              ctr.toArray(),
              bnd.getCenter().toArray(),
              'mi'
            );

          switch(jump2icons[i].geo.geoid) {
            case '15': // HI
              var rad = HALFWAY2HI;
              break;
            case '02': // AK
              var rad = HALFWAY2AK;
              break;
            case '72': // PR
            default:
              var rad = HALFWAY2PR;
              break;
          }

          jump2icons[i].dispatchEvent( inb || dst <= rad ? iconSet : iconReset );
        }
      }
    }, {
      key: "haversine",
      value: function haversine(lnglat1, lnglat2, unit) {
        if (typeof unit == 'undefined' || unit == 'km') {
          var R = 6371; // Radius of the earth in km
        } else if (unit=='mi') {
          var R = 3950; // Radius of the earth in miles
        }

        var
          dLat = this.deg2rad(lnglat2[1]-lnglat1[1]),
          dLon = this.deg2rad(lnglat2[0]-lnglat1[0]); 

        var
          a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(this.deg2rad(lnglat1[1])) * Math.cos(this.deg2rad(lnglat2[1])) * 
            Math.sin(dLon/2) * Math.sin(dLon/2),
          c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)),
          d = R * c;

        return d;
      }
    }, {
      key: "deg2rad",
      value: function deg2rad(deg) {
        return deg * (Math.PI/180);
      }
    }, {
      key: "inBounds",
      value: function inBounds(bounds, lnglat) {
        var
          lng,
          multLng = (lnglat.lng - bounds._ne.lng) * (lnglat.lng - bounds._sw.lng);

        if (bounds._ne.lng > bounds._sw.lng) {
            lng = multLng < 0;
        } else {
            lng = multLng > 0;
        }

        var lat = (lnglat.lat - bounds._ne.lat) * (lnglat.lat - bounds._sw.lat) < 0;

        return lng && lat;
      }
    }, {
      key: "toggleInfoPopup",
      value: function toggleInfoPopup() {
        if (!this.infoPopup) {
          return false;
        } else if (this.infoPopup.isOpen()) {
          this.infoPopup.remove();
        } else {
          this.infoPopup.addTo(this.map);
        }

        return this;
      }
    }, {
      key: "closeInfoPopup",
      value: function closeInfoPopup() {
        if (!this.infoPopup) {
          return false;
        } else {
          this.infoPopup.remove();
        }

        return this;
      }
    }, {
      key: "render",
      value: function render() {
        // legacy function

        this.reDraw();

        return this;
      }
    }, {
      key: "reDraw",
      value: function reDraw() {
        var self = this,
            layer0 = undefined,
            layer1 = undefined,
            active = Object(QF.getGeoids());

        this.closeInfoPopup();

        geoLayers.forEach(function(params) {
          try {

            // if the value is in an array then use the value in array. else use a default
            params[0].paint['fill-color'] = ['case', ['has', ['get', 'GEOID'], ['literal', self.fillColor[self.mnemonic]]], ['get', ['get', 'GEOID'], ['literal', self.fillColor[self.mnemonic]]], DFLTCLR1];
            params[0].paint['fill-outline-color'] = ['case', ['has', ['get', 'GEOID'], ['literal', self.stroke]], ['get', ['get', 'GEOID'], ['literal', self.stroke]], DFLTCLR2]; //DFLTCLR4
            params[0].paint['fill-pattern'] = ['case', ['has', ['get', 'GEOID'], ['literal', self.fillColor[self.mnemonic]]], ['get', ['get', 'GEOID'], ['literal', self.fillColor[self.mnemonic]]], 'striping'];
            
            params[2].paint['line-color']   = ['case', ['has', ['get', 'GEOID'], ['literal', self.line]], ['get', ['get', 'GEOID'], ['literal', self.line]], DFLTRGBA0];

            layer0 = self.map.getLayer(params[0].id);
            layer1 = self.map.getLayer(params[1].id);
            layer2 = self.map.getLayer(params[2].id);

            if (layer0) {
              self.map.setPaintProperty(params[0].id, 'fill-color', params[0].paint['fill-color']);
              self.map.setPaintProperty(params[0].id, 'fill-outline-color', params[0].paint['fill-outline-color']);
              self.map.setPaintProperty(params[0].id, 'fill-pattern', params[0].paint['fill-pattern']);
            } else {
              self.map.addLayer(params[0]);
            }

            if (!layer1) {
              self.map.addLayer(params[1]);
            }

            if (layer2) {
              self.map.setPaintProperty(params[2].id, 'line-color', params[2].paint['line-color']);
            } else {
              self.map.addLayer(params[2]);
            }

            if (layer0) {
              this.map.triggerRepaint();
            }
          } catch (err) {}
        });
        return this;
      }
    }, {
      key: "sourceNoteIcon",
      value: function sourceNoteIcon(dataset, level, returnHTML) {
        if (typeof this.info == 'undefined' || typeof this.info.sourcenotes[this.mnemonic] == 'undefined') {
          return null;
        }

        if (typeof returnHTML == 'undefined') {
          returnHTML = true;
        }

        var div = document.createElement('div'),
            span = document.createElement('span'),
            a = document.createElement('a'),
            txt1 = document.createTextNode(String.fromCodePoint(0xe840)),
            txt2 = document.createTextNode(String.fromCodePoint(0xe83f));

        span.appendChild(txt1);
        a.appendChild(txt2);
        div.appendChild(span);
        div.appendChild(a);
        div.setAttribute('class', QF.cssPrefix + 'sourcenote');
        a.setAttribute('title', this.info.sourcenotes[this.mnemonic][dataset][level]);
        return returnHTML ? div.outerHTML : div;
      }
    }, {
      key: "centerOnGeo",
      value: function centerOnGeo(center) {
        var geoid = QF.getGeoids()[0];
        var self  = this;

        this.closeInfoPopup();

        switch (this.level) {
          case 'nation':
            break;
          case 'state':
            break;

          case 'county':
            break;

          case 'cousub':
            this.toggle.showMCDs();
            break;

          case 'place':
            this.toggle.showPlaces();
            break;
        }

        if (center) {
          if (geoid == '00') {
            this.map.flyTo({
              center: MAPCENTER,
              zoom: MINZOOM
            });
          } else {
            if (typeof this.json[geoid] !== 'undefined') {
              var
                center = [this.json[geoid].centroid.lng, this.json[geoid].centroid.lat],
                bounds = [
                           [this.json[geoid].bounds.west,this.json[geoid].bounds.south],
                           [this.json[geoid].bounds.east,this.json[geoid].bounds.north]
                         ];

              switch (this.level) {
                case 'nation':
                  this.map.flyTo({
                    center: MAPCENTER,
                    zoom: MINZOOM
                  });
                break;
                case 'state':
                  this.map.fitBounds(
                    bounds,
                    {
                      maxZoom: STCTYBR - 1
                    }
                  );
                  break;

                case 'county':
                  this.map.fitBounds(
                    bounds,
                    {
                      maxZoom: CTYPLBR - 1
                    }
                  );
                  break;

                case 'cousub':
                  this.map.fitBounds(
                    bounds,
                    {
                      maxZoom: CTYPLBR + 1
                    }
                  );
                  break;

                case 'place':
                  this.map.fitBounds(
                    bounds,
                    {
                      maxZoom: CTYPLBR + 1
                    }
                  );
                  break;
              }

            } else {
              this.map.flyTo({
                center: MAPCENTER,
                zoom: MINZOOM
              });
            }


          }
        }

        QF.spinnerDisplay(false);
        return this;
      }
    }, {
      key: "gotoGeoid",
      value: function gotoGeoid(geoid, event) {
        if (typeof geoid == 'undefined') {
          return false;
        }
        if (typeof event == 'undefined') {
          event = 'click';
        }

        var
          COM = this.getLMCenter(geoid);

        if (COM && event) {
          var
            data = {
              point:  this.map.project(COM.center),
              lngLat: COM.center
            };

          //  this.map.fitBounds(COM.bounds);

          this.map.fire(event, data);
        }

        return this;
      }
    }, {
      key: "getLMCenter",
      value: function getLMCenter(geoid) {
        var
          bounds  = [
            this.map.project([-188, 17]),
            this.map.project([-64, 72])
          ],
          options = {
            layers: JSON.parse(JSON.stringify(GLAYERS.layers)),
            filter: ['==', 'GEOID', geoid]
          },
          geo = this.map.queryRenderedFeatures(bounds, options);

        if (!geo.length) {
          return false;
        }

        return this.getFeatureCOM(geo[0]);
      }
    }, {
      key: "getFeatureCOM",
      value: function getFeatureCOM( feature ) {
        switch(feature.geometry.type) {
          case 'MultiPolygon':
            var
              coords = feature.geometry.coordinates,
              labels = [],
              bounds = new mapboxgl.LngLatBounds();

            for (var i1 = coords.length - 1; i1 >= 0; i1--) {
              var
                bound = new mapboxgl.LngLatBounds();

              for (var i2 = coords[i1].length - 1; i2 >= 0; i2--) {
                bound.extend(coords[i1][i2]);
                bounds.extend(coords[i1][i2]);
              }

              labels.push({
                center: centerOfMass.polylabel(coords[i1], 1),
                bounds: bound.toArray() 
              });
            }

            var
              center = bounds.getCenter().toArray(),
              select = labels.reduce(function(prev, curr) {
                switch (COMFILTER) {
                  case 'closest': 
                    return (centerOfMass.latLngDistance(curr.center, center) < centerOfMass.latLngDistance(prev.center, center) ? curr : prev);
                  case 'largest':
                  default:
                    return (centerOfMass.boundsVolume(curr.bounds) > centerOfMass.boundsVolume(prev.bounds) ? curr : prev);
                }
              }),
              label  = select;
            break;
          case 'Polygon':
          default:
            var
              coords = feature.geometry.coordinates,
              bounds = new mapboxgl.LngLatBounds();

            for (var i1 = coords.length - 1; i1 >= 0; i1--) {
              bounds.extend(coords[i1]);
            }              

            var
              label = {
                center: centerOfMass.polylabel(coords, 1),
                bounds: bounds.toArray() 
              };
            break;  
        }

        return label;
      }
    }, {
      key: "getMap",
      value: function getMap() {
        return this.map;
      }
    }, {
      key: "appendURLS",
      value: function appendURLS(geoid) {
        if (typeof geoid == 'undefined') {
          geoid = QF.getGeoids().join(',')
        }

        var arr = [QF.approot + 'geo/json', geoid, this.mnemonic];

        if (this.loadall.geos) {
          arr.push('lag');
        }

        this.geoURLs = arr.join('/');

        return this;
      }
    }, {
      key: "appendJSON",
      value: function appendJSON( center ) {
        var deferreds = [],
            self = this;

        if (typeof center == 'undefined') {
          center = true;
        }

        deferreds.push($.getJSON(this.geoURLs, function (json) {
          if (json.status == 200) {
            self.setInfo(json.info).setJSON(json.data);
          }
        }));

        $.when(deferreds).done(function () {
          self.reDraw().centerOnGeo(center);

          if (self.getInfo(true)) {
            methods.setQuantiles(self.getQuantiles());
          } else {
            methods.quantilesDisplay(false);
          }

          QFM.mapWorking = false;
        });
        return this;
      }
    }, {
      key: "setJSON",
      value: function setJSON(json) {
        var self = this,
            div  = [],
            divKeys = [],
            selectGeo = QF.getGeoids()[0],
            mapInfo = document.getElementById('qf-map-info');

        if (mapInfo) {
          var mapInfoFFC = mapInfo.firstElementChild.firstElementChild;

          while (mapInfoFFC.firstChild) {
            mapInfoFFC.removeChild(mapInfoFFC.firstChild);
          }
        }


        if (typeof this.fillColor[this.mnemonic] == 'undefined') {
          this.fillColor[this.mnemonic] = {};
        }

        for (var _i3 = 0, _Object$keys3 = Object.keys(json); _i3 < _Object$keys3.length; _i3++) {
          var _geoid = _Object$keys3[_i3];
          this.json[_geoid] = Object.deepAssign(json[_geoid], this.json[_geoid]);

          if (selectGeo == _geoid) {
            this.level = json[_geoid].level;
          }
        }

        for (var _i6 = 0, _Object$keys6 = Object.keys(this.info.allGeoids); _i6 < _Object$keys6.length; _i6++) {
          var _geoid = _Object$keys6[_i6];
          this.fillColor[this.mnemonic][_geoid] = 'stripingBlue';
        }

        for (var _i4 = 0, _Object$keys4 = Object.keys(this.json); _i4 < _Object$keys4.length; _i4++) {
          var
            _geoid    = _Object$keys4[_i4],
            thisJson  = this.json[_geoid],
            thisData  = thisJson.data[this.mnemonic],
            jump2icon = this.json[_geoid].jump2icon,
            hasGeo    = QF.isSelectedGeo(_geoid);

          if (typeof thisData == 'undefined') {
            continue;
          }

          this.fillColor[this.mnemonic][_geoid] = thisData.quantile;
          this.stroke[_geoid] = hasGeo ? DFLTCLR3 : DFLTCLR2;
          this.line[_geoid] = hasGeo ? DFLTRGBA1 : DFLTRGBA0;

          if (thisJson.jump2icon && QF.view == 'map') {
            if (typeof this.icons[_geoid] == 'undefined') {
              this.icons[_geoid] = new createIcon(this.map, thisJson, this.mnemonic);
              this.map.addControl(this.icons[_geoid], thisJson.jump2icon);
            } else {
              this.icons[_geoid].geoStyle = {
                fillColor: this.fillColor[this.mnemonic][_geoid],
                strokeColor: this.stroke[_geoid]
              };
            }
          }


          if ((hasGeo && mapInfo) || _geoid=='00') {
            div['1'+_geoid] = document.createElement('div');
            divKeys.push('1'+_geoid);

            var svg = document.createElement('object'),
                spn = document.createElement('span'),
                str = document.createElement('strong'),
                lnk = QF.urlParser(QF.bubbleUpGeomUrl(thisJson.shortName)),
                col = document.createElement('div'),
                off = QF.urlParser(QF.removeGeomUrl(thisJson.shortName)),
                txt = document.createTextNode(thisJson.fullName),
                rmv = document.createTextNode(String.fromCodePoint(0xe82a)),
                src = self.sourceNoteIcon(thisData.vDataset, thisJson.level, false);

            if (thisData.isnumeric || JAMVALREG.test(thisData.formated)) {
              var val = document.createTextNode(thisData.formated);
            } else {
              var val = document.createElement('a'),
                  valtxt = document.createTextNode(thisData.formated);

              val.setAttribute('href', '#' + FLAGPREFIX + thisData.formated);
              val.appendChild(valtxt);
            }

            svg.setAttribute('type', 'image/svg+xml');
            svg.setAttribute('data', QF.approot + 'geo/svg/' + _geoid);
            svg.setAttribute('data-css', JSON.stringify({
              'stroke': this.stroke[_geoid],
              'fill': ( thisJson.level == this.level ) ? thisData.quantile : DFLTCLR4,
              'fill-opacity': OPACITY1
            }));
            svg.setAttribute('data-css-full', JSON.stringify({
              'stroke': this.stroke[_geoid],
              'fill': thisData.quantile,
              'fill-opacity': OPACITY1
            }));
            svg.setAttribute('data-css-empty', JSON.stringify({
              'stroke': this.stroke[_geoid],
              'fill': DFLTCLR4,
              'fill-opacity': OPACITY1
            }));
            svg.setAttribute('data-level', thisJson.level);

            lnk.setAttribute('title', thisJson.fullName);
            lnk.setAttribute('data-level', thisJson.level);
            lnk.setAttribute('data-centroid', JSON.stringify([thisJson.centroid.lng, thisJson.centroid.lat]));
            lnk.setAttribute('data-bounds', JSON.stringify([[thisJson.bounds.west, thisJson.bounds.south],[thisJson.bounds.east, thisJson.bounds.north]]));

            off.setAttribute('class', 'qf-map-remove removegeo');
            off.setAttribute('title', 'Remove ' + thisJson.fullName);

            lnk.appendChild(svg);
            str.appendChild(val);
            spn.appendChild(txt);
            col.appendChild(spn);
            col.appendChild(str);
            lnk.appendChild(col);
            off.appendChild(rmv);

            div['1'+_geoid].appendChild(lnk);

            if (src) {
              div['1'+_geoid].appendChild(src);
            }

            if (thisData.footnote) {
              var fnt = document.createElement('a'),
                  sup = document.createElement('sup'),
                  fnttxt = document.createTextNode($('a[data-code="' + thisData.footnote + '"]').text());
              fnt.setAttribute('href', '#' + NOTEPREFIX + thisData.footnote);
              fnt.appendChild(fnttxt);
              sup.appendChild(fnt);
              div['1'+_geoid].appendChild(sup);
            }

            if (hasGeo) {
              div['1'+_geoid].appendChild(off);
            }

            svg.addEventListener('load', function () {
              var css = this.getAttribute('data-css');
              $(this).contents().find('.main').css(JSON.parse(css));
            });
            lnk.addEventListener('click', function (e) {
              e.preventDefault();
              e.stopPropagation();
              var level    = this.getAttribute('data-level'),
                  centroid = JSON.parse(this.getAttribute('data-centroid')),
                  bounds   = JSON.parse(this.getAttribute('data-bounds'));

              if (level=='nation') {
                self.map.flyTo({
                  center: MAPCENTER,
                  zoom: MINZOOM
                });
              } else {
                switch (level) {
                  case 'state':
                    var zoom = STCTYBR - 1;
                    break;

                  case 'county':
                    var zoom = CTYPLBR - 1;
                    break;

                  case 'cousub':
                    self.toggle.showMCDs();
                    var zoom = CTYPLBR + 1;
                    break;

                  case 'place':
                    self.toggle.showPlaces();
                    var zoom = CTYPLBR + 1;
                    break;
                }

                self.map.fitBounds(
                  bounds,
                  {
                    maxZoom: zoom
                  }
                );
              }
              /*
              self.map.flyTo({
                center: centroid,
                zoom: zoom
              });
              /**/
            });
          }
        }

        if ( mapInfo && divKeys.length ) {
          divKeys.sort(function(a, b) { return b - a });

          for (var _i5 = divKeys.length - 1; _i5 >= 0; _i5--) {
            mapInfoFFC.appendChild(div[divKeys[_i5]]);
          }
        }

        return this;
      }
    }, {
      key: "getJSON",
      value: function getJSON(geoid) {
        return (typeof this.json[geoid] != 'undefined') ? this.json[geoid] : null;
      }
    }, {
      key: "setInfo",
      value: function setInfo(info) {
        this.level  = info.levels[0];
        this.info   = info;
        return this;
      }
    }, {
      key: "getInfo",
      value: function getInfo(check) {
        if (typeof check != 'undefined') {
          if (check) {
            return typeof this.info != 'undefined';
          } else {
            return typeof this.info == 'undefined';
          }
        } else {
          return this.info;
        }
      }
    }, {
      key: "getData",
      value: function getData(geoid) {
        return ( typeof this.json[geoid] != 'undefined' )
            ? this.json[geoid].data[this.mnemonic]
            : null;
      }
    }, {
      key: "geoidLoaded",
      value: function geoidLoaded(geoid) {
        if ( this.loadall.geos ) {
          return ( typeof this.info.allGeoids[geoid] != 'undefined' )
              ? this.info.allGeoids[geoid]
              : false;
        } else {
          return Object.keys(this.json).indexOf(geoid) !== -1;
        }
      }
    }, {
      key: "setMnemonic",
      value: function setMnemonic(mnemonic) {
        this.mnemonic = mnemonic;
        return this;
      }
    }, {
      key: "getMnemonic",
      value: function getMnemonic() {
        return this.mnemonic;
      }
    }, {
      key: "setLevel",
      value: function setLevel(level) {
        this.level = level;
      }
    }, {
      key: "getLevel",
      value: function getLevel() {
        return this.level;
      }
    }, {
      key: "getQuantiles",
      value: function getQuantiles() {
        return this.info.quantiles.global;
      }
    }]);

    return mapChoropleth;
  }();


  var
    dataZIndex = 0,
    maxBounds  = '{"south":24.520833,"west":-124.785,"north":49.384472,"east":-66.949778}',
    iconSize   = parseInt('96'),
    deaultZoom = parseInt('3'),
    deaultLat  = parseFloat('39.095963127902'),
    deaultLng  = parseFloat('-102.56835975'),
    geoLabels  = JSON.parse('{"PR":{"nation":{"S":"United States","P":"United States"},"state":{"S":"Puerto Rico","P":"Puerto Rico"},"county":{"S":"Municipio","P":"Municipios"},"place":{"S":"Zona Urbana \/ Comunidad","P":"Zonas Urbanas \/ Comunidades"},"cousub":{"S":"Barrio","P":"Barrios"}},"US":{"nation":{"S":"United States","P":"United States"},"state":{"S":"United States","P":"United States"},"county":{"S":"County","P":"Counties"},"place":{"S":"Place","P":"Places"},"cousub":{"S":"County Subdivision","P":"County Subdivisions"}}}');

  var geoLayers = [[{
    id: 'State/1/'+VINTAGEXX,
    type: 'fill',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_040_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'State',
    minzoom: MINZOOM,
    maxzoom: STCTYBR,
    layout: {},
    paint: {
      'fill-color': DFLTCLR1,
      'fill-opacity': OPACITY1,
      'fill-outline-color': 'white'
    }
  }, {
    id: 'State/label/ST/'+VINTAGEXX,
    type: 'symbol',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_040_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}.pbf']
    },
    minzoom: MINZOOM,
    maxzoom: STCTYBR,
    'source-layer': 'State/label',
    layout: {
      'text-font': ['Arial Bold'],
      'text-size': {
        stops: [[3, 12], [4, 14.66666]]
      },
      'text-field': '{_name}',
      'text-optional': true
    }
  }, {
    id: 'States/line',
    type: 'line',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_040_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'State',
    minzoom: MINZOOM,
    maxzoom: STCTYBR,
    layout: {
      'line-cap': 'round',
      'line-join': 'round'
      },
    paint: {
      'line-opacity': OPACITY0,
      'line-color': DFLTRGBA0,
      'line-width': DFLTWIDTH1
    }
  }], [{
    id: 'County/0/'+VINTAGEXX,
    type: 'fill',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_050_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'County',
    minzoom: STCTYBR,
    maxzoom: CTYPLBR,
    layout: {},
    paint: {
      'fill-color': DFLTCLR1,
      'fill-opacity': OPACITY1,
      'fill-outline-color': DFLTCLR2
    }
  }, {
    id: 'County/label/County/'+VINTAGEXX,
    type: 'symbol',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_050_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}.pbf']
    },
    'source-layer': 'County/label',
    minzoom: STCTYBR,
    maxzoom: CTYPLBR,
    layout: {
      'text-font': ['Arial Bold'],
      'text-size': {
        stops: [[3, 12], [4, 14.66666]]
      },
      'text-field': '{_name}',
      'text-optional': true
    }
  }, {
    id: 'County/line',
    type: 'line',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_050_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'County',
    minzoom: STCTYBR,
    maxzoom: CTYPLBR,
    layout: {
      'line-cap': 'round',
      'line-join': 'round'
      },
    paint: {
      'line-opacity': OPACITY0,
      'line-color': DFLTRGBA0,
      'line-width': DFLTWIDTH1
    }
  }], [{
    id: 'Place/'+VINTAGEXX,
    type: 'fill',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'Place',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none'
    },
    paint: {
      'fill-color': DFLTCLR1,
      'fill-opacity': OPACITY1,
      'fill-outline-color': DFLTCLR2
    }
  }, {
    id: 'Place/label/Place/'+VINTAGEXX,
    type: 'symbol',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}.pbf']
    },
    'source-layer': 'Place/label',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none',
      'text-font': ['Arial Bold'],
      'text-size': {
        stops: [[3, 12], [4, 14.66666]]
      },
      'text-field': '{_name}',
      'text-optional': true
    }
  }, {
    id: 'Place/line/'+VINTAGEXX,
    type: 'line',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'Place',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none',
      'line-cap': 'round',
      'line-join': 'round'
    },
    paint: {
      'line-opacity': OPACITY0,
      'line-color': DFLTRGBA0,
      'line-width': DFLTWIDTH1
    }    
  }], [{
    id: 'Place/10',
    type: 'fill',
    source: {
      type: 'vector',
      tiles: [GISSERV + '2010_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'Place',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none'
    },
    paint: {
      'fill-color': DFLTCLR1,
      'fill-opacity': OPACITY1,
      'fill-outline-color': DFLTCLR2
    }
  }, {
    id: 'Place/label/Place/10',
    type: 'symbol',
    source: {
      type: 'vector',
      tiles: [GISSERV + '2010_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}.pbf']
    },
    'source-layer': 'Place/label',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none',
      'text-font': ['Arial Bold'],
      'text-size': {
        stops: [[3, 12], [4, 14.66666]]
      },
      'text-field': '{_name}',
      'text-optional': true
    }
  }, {
    id: 'Place/line/10',
    type: 'line',
    source: {
      type: 'vector',
      tiles: [GISSERV + '2010_160_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'Place',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none',
      'line-cap': 'round',
      'line-join': 'round'
    },
    paint: {
      'line-opacity': OPACITY0,
      'line-color': DFLTRGBA0,
      'line-width': DFLTWIDTH1
    } 
  }], [{
    id: 'CountySubdivision/0/'+VINTAGEXX,
    type: 'fill',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_060_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'CountySubdivision',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none'
    },
    paint: {
      'fill-color': DFLTCLR1,
      'fill-opacity': OPACITY1,
      'fill-outline-color': DFLTCLR2
    }
  }, {
    id: 'CountySubdivision/label/CountySubdivision/'+VINTAGEXX,
    type: 'symbol',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_060_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}.pbf']
    },
    'source-layer': 'CountySubdivision/label',
    minzoom: CTYPLBR,
    layout: {
      'visibility': 'none',
      'text-font': ['Arial Bold'],
      'text-size': {
        stops: [[3, 12], [4, 14.66666]]
      },
      'text-field': '{_name}',
      'text-optional': true
    }
  }, {
    id: 'CountySubdivision/line/'+VINTAGEXX,
    type: 'line',
    source: {
      type: 'vector',
      tiles: [GISSERV + VINTAGE + '_060_00_PY_D1/VectorTileServer/tile/{z}/{y}/{x}']
    },
    'source-layer': 'CountySubdivision',
    minzoom: CTYPLBR,
    layout: {
      'line-cap': 'round',
      'line-join': 'round'
    },
    paint: {
      'line-opacity': OPACITY0,
      'line-color': DFLTRGBA0,
      'line-width': DFLTWIDTH1
    }    
  }]],
    quantiles = {},
    iconReset = new CustomEvent('iconReset'),
    iconSet   = new CustomEvent('iconSet'),
    iconLoad  = new CustomEvent('load', { 'bubbles': true }),
    choroplethMap = new mapChoropleth(MAPTARGET).create().addControls();


  var methods = {
    setMapLevel: function setMapLevel(level) {
      $('div.' + QF.cssPrefix + 'jsmap').attr('data-level', level);
      choroplethMap.setLevel(level);
    },
    resetIcons: function resetIcons(e) {
      var jump2icons = $('.' + QF.cssPrefix + 'icon-jump2');

      if (typeof e == 'undefined') {
        choroplethMap.testIcons();
      } else if (/^qf\-icon/.test(e.target.id) || /^qf\-zoom/.test(e.target.id)) {
        for (var i = jump2icons.length - 1; i >= 0; i--) {
          if (jump2icons[i].id != e.target.id) {
            jump2icons[i].dispatchEvent(iconReset);
          }
        }
      }
    },
    getMapLevel: function getMapLevel(level) {
      return $('div.' + QF.cssPrefix + 'jsmap').attr('data-level');
    },
    setMapLocate: function setMapLocate(url) {
      $('div.' + QF.cssPrefix + 'jsmap').attr('data-mapview', url);
    },
    getMapLocate: function getMapLocate() {
      return $('div.' + QF.cssPrefix + 'jsmap').attr('data-mapview');
    },
    setGeoLocate: function setGeoLocate(url) {
      $('div.' + QF.cssPrefix + 'jsmap').attr('data-geoview', url);
    },
    getGeoLocate: function getGeoLocate() {
      return $('div.' + QF.cssPrefix + 'jsmap').attr('data-geoview');
    },
    geolocate: function geolocate(center) {
      if (QFM.mapWorking) {
        return;
      }

      if (typeof center == 'undefined') {
        center = true;
      }

      var mnemonic = QF.getFacts()[0];
      QF.spinnerDisplay(true);
      QFM.mapWorking = true;
      QFM.geoview = methods.getGeoLocate() + '/' + mnemonic;
      choroplethMap.setMnemonic(mnemonic);
      methods.quantilesDisplay(false);

      if ( choroplethMap.loadall.geos ) {
        QFM.geoview += '/lag'; 
      }

      $.getJSON(QFM.geoview, function (json) {
        if (json.status != 200) {
          alert('There is no data for the selected fact for your selected location');
          QFM.mapWorking = false;
          methods.setMapLocate(QF.approot + 'map/US/');
          methods.setGeoLocate(QF.approot + 'geo/json/US/');
          methods.geolocate(true);
          return false;
        }

        choroplethMap.setInfo(json.info).setJSON(json.data).testIcons();
      }).done(function () {
        choroplethMap.appendURLS().appendJSON(center).reDraw();
        QFM.mapWorking = false;
      });
    },
    quantilesDisplay: function quantilesDisplay(on) {
      var quantiles = $('div[data-color]', 'div.' + QF.cssPrefix + 'quantile');
      on ? quantiles.show() : quantiles.hide();
    },
    setQuantiles: function setQuantiles(quantiles, activeLevel) {
      if (_typeof(quantiles) != 'object') {
        return null;
      }

      if (typeof activeLevel == 'undefined') {
        activeLevel = choroplethMap.getLevel();
      }

      if (activeLevel == 'nation') {
        activeLevel = 'state';
      }

      $.each(quantiles, function (mnemonic, typeGroup) {
        $.each(typeGroup, function (type, levelGroup) {
          var $mnemonic = $('div[data-mnemonic="' + mnemonic + '"]'),
              $type     = $('div.' + QF.cssPrefix + type, $mnemonic),
              $colors   = $('div[data-color]', $type),
              unit      = $mnemonic.attr('data-unit'),
              precision = $mnemonic.attr('data-precision');

          $colors.hide();
          $.each(levelGroup, function (level, color) {
            if (level != activeLevel) {
              return;
            }

            $.each(color, function (color, minmax) {
              var $color = $('div[data-color="' + color + '"]', $type);
              $color.show();

              if (_typeof(minmax) === 'object') {
                var $min = $('span.' + QF.cssPrefix + 'min', $color),
                    $max = $('span.' + QF.cssPrefix + 'max', $color);
                $min.text(QF.nFormat(minmax.min, precision, unit));
                $max.text(QF.nFormat(minmax.max, precision, unit));
              } else {
                $('span:last-child', $color).text(minmax);
              }
            });
          });
        });
      });

      $( '#' + window.QF.cssPrefix + 'map-quantile', '#qfcontent' ).empty().append( $( 'div.' + QF.cssPrefix + 'quantile', '#qfcontent' ).clone() );
    },    
    init: function init() {
      var speed = QF.isIE() ? 16 : 8;

      if (QF.view == 'map') {
        new toggleInfoAside('qf-map-info', 1, 270, speed).close();
      }

      $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function (e) {
        var
          $title    = $( '#' + window.QF.cssPrefix + 'map-title', '#qfcontent' ),
          $factbar  = $( 'div.' + window.QF.cssPrefix + 'factbar', '#qfcontent' );

        if (document.fullscreenElement || document.msFullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement) {
          $title.empty().append( $factbar.clone() );
        } else {
          $title.empty()
        }
      });

      $(document).on('fullscreenerror webkitfullscreenerror mozfullscreenerror MSFullscreenError', function (e) {});

       methods.geolocate(true);
    },
    ohSnap: function ohSnap(msg, target, status) {
      var $target = $(target);
      $target.empty().html(msg);
    }
  };
  var centerOfMass = {
    defaultCompare: function defaultCompare(a, b) {
      return a < b ? -1 : a > b ? 1 : 0;
    },
    polylabel: function polylabel(polygon, precision, debug) {
        precision = precision || 1.0;

        // find the bounding box of the outer ring
        var minX, minY, maxX, maxY;
        for (var i = 0; i < polygon[0].length; i++) {
            var p = polygon[0][i];
            if (!i || p[0] < minX) minX = p[0];
            if (!i || p[1] < minY) minY = p[1];
            if (!i || p[0] > maxX) maxX = p[0];
            if (!i || p[1] > maxY) maxY = p[1];
        }

        var width = maxX - minX;
        var height = maxY - minY;
        var cellSize = Math.min(width, height);
        var h = cellSize / 2;

        if (cellSize === 0) return [minX, minY];

        // a priority queue of cells in order of their "potential" (max distance to polygon)
        var cellQueue = new tinyQueue(undefined, centerOfMass.compareMax);

        // cover polygon with initial cells
        for (var x = minX; x < maxX; x += cellSize) {
            for (var y = minY; y < maxY; y += cellSize) {
                cellQueue.push(new centerOfMass.Cell(x + h, y + h, h, polygon));
            }
        }

        // take centroid as the first best guess
        var bestCell = centerOfMass.getCentroidCell(polygon);

        // special case for rectangular polygons
        var bboxCell = new centerOfMass.Cell(minX + width / 2, minY + height / 2, 0, polygon);
        if (bboxCell.d > bestCell.d) bestCell = bboxCell;

        var numProbes = cellQueue.length;

        while (cellQueue.length) {
            // pick the most promising cell from the queue
            var cell = cellQueue.pop();

            // update the best cell if we found a better one
            if (cell.d > bestCell.d) {
                bestCell = cell;
            }

            // do not drill down further if there's no chance of a better solution
            if (cell.max - bestCell.d <= precision) continue;

            // split the cell into four cells
            h = cell.h / 2;
            cellQueue.push(new centerOfMass.Cell(cell.x - h, cell.y - h, h, polygon));
            cellQueue.push(new centerOfMass.Cell(cell.x + h, cell.y - h, h, polygon));
            cellQueue.push(new centerOfMass.Cell(cell.x - h, cell.y + h, h, polygon));
            cellQueue.push(new centerOfMass.Cell(cell.x + h, cell.y + h, h, polygon));
            numProbes += 4;
        }

        return [bestCell.x, bestCell.y];
    },
    compareMax: function compareMax(a, b) {
        return b.max - a.max;
    },
    Cell: function Cell(x, y, h, polygon) {
        this.x = x; // cell center x
        this.y = y; // cell center y
        this.h = h; // half the cell size
        this.d = centerOfMass.pointToPolygonDist(x, y, polygon); // distance from cell center to polygon
        this.max = this.d + this.h * Math.SQRT2; // max distance to polygon within a cell
    },
    // signed distance from point to polygon outline (negative if point is outside)
    pointToPolygonDist: function pointToPolygonDist(x, y, polygon) {
        var inside = false;
        var minDistSq = Infinity;

        for (var k = 0; k < polygon.length; k++) {
            var ring = polygon[k];

            for (var i = 0, len = ring.length, j = len - 1; i < len; j = i++) {
                var a = ring[i];
                var b = ring[j];

                if ((a[1] > y !== b[1] > y) &&
                    (x < (b[0] - a[0]) * (y - a[1]) / (b[1] - a[1]) + a[0])) inside = !inside;

                minDistSq = Math.min(minDistSq, centerOfMass.getSegDistSq(x, y, a, b));
            }
        }

        return (inside ? 1 : -1) * Math.sqrt(minDistSq);
    },
    // get polygon centroid
    getCentroidCell: function getCentroidCell(polygon) {
        var area = 0;
        var x = 0;
        var y = 0;
        var points = polygon[0];

        for (var i = 0, len = points.length, j = len - 1; i < len; j = i++) {
            var a = points[i];
            var b = points[j];
            var f = a[0] * b[1] - b[0] * a[1];
            x += (a[0] + b[0]) * f;
            y += (a[1] + b[1]) * f;
            area += f * 3;
        }
        if (area === 0) return new centerOfMass.Cell(points[0][0], points[0][1], 0, polygon);
        return new centerOfMass.Cell(x / area, y / area, 0, polygon);
    },
    // get squared distance from a point to a segment
    getSegDistSq: function getSegDistSq(px, py, a, b) {

        var x = a[0];
        var y = a[1];
        var dx = b[0] - x;
        var dy = b[1] - y;

        if (dx !== 0 || dy !== 0) {

            var t = ((px - x) * dx + (py - y) * dy) / (dx * dx + dy * dy);

            if (t > 1) {
                x = b[0];
                y = b[1];

            } else if (t > 0) {
                x += dx * t;
                y += dy * t;
            }
        }

        dx = px - x;
        dy = py - y;

        return dx * dx + dy * dy;
    },
    latLngDistance: function latLngDistance(latlon1, latlon2) {
      if ((latlon1[0] == latlon2[0]) && (latlon1[1] == latlon2[1])) {
        return 0;
      }

      var
        radlat1  = Math.PI * latlon1[0]/180
        radlat2  = Math.PI * latlon2[0]/180,
        theta    = latlon1[1]-latlon2[1],
        radtheta = Math.PI * theta/180;
        dist     = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);

      if (dist > 1) {
        dist = 1;
      }

      dist = Math.acos(dist);
      dist = dist * 180/Math.PI;
      dist = dist * 60 * 1.1515;

      return dist;
    },
    boundsVolume: function boundsVolume(bounds) {
      var
        x1 = bounds[0][0]+180,
        x2 = bounds[1][0]+180,
        y1 = bounds[0][1]+90,
        y2 = bounds[1][1]+90,
        X  = Math.abs(Math.max(x1,x2) - Math.min(x1,x2)),
        Y  = Math.abs(Math.max(y1,y2) - Math.min(y1,y2));

      return X * Y;
    }
  };

  window.QFM = {};
  window.QFM.setMapLevel   = methods.setMapLevel;
  window.QFM.getMapLevel   = methods.getMapLevel;
  window.QFM.setMapLocate  = methods.setMapLocate;
  window.QFM.getMapLocate  = methods.getMapLocate;
  window.QFM.setGeoLocate  = methods.setGeoLocate;
  window.QFM.getGeoLocate  = methods.getGeoLocate;
  window.QFM.geolocate     = methods.geolocate;
  // javascript:QFM.get('12');void(0);
  window.QFM.choroplethMap = choroplethMap;
  window.QFM.get = choroplethMap.gotoGeoid;
  methods.init();
});

var
  QFM = window.QFM;


/**
 * doc examples: https://docs.mapbox.com/mapbox-gl-js/example
 * color-switcher example from mapbox: "https://docs.mapbox.com/mapbox-gl-js/example/color-switcher/""
 * protobuf geosjon: https://github.com/mapbox/geobuf
 * queryrenderedfeatures function: https://docs.mapbox.com/mapbox-gl-js/api#map#queryrenderedfeatures
 *
 *
 * https://docs.mapbox.com/mapbox-gl-js/example/toggle-layers/
 * https://docs.mapbox.com/mapbox-gl-js/example/updating-choropleth/
 * 
 * https://docs.mapbox.com/mapbox-gl-js/example/hover-styles/
 * https://gis.data.census.gov/arcgis/rest/services/Hosted/
 **/

/**
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
 */

if (typeof Object.deepAssign != 'function') {
  Object.deepAssign = function (target, varArgs) {
    // .length of function is 2
    'use strict';

    if (target == null) {
      // TypeError if undefined or null
      throw new TypeError('Cannot convert undefined or null to object');
    }

    var to = Object(target);

    for (var index = 1; index < arguments.length; index++) {
      var nextSource = arguments[index];

      if (nextSource != null) {
        // Skip over if undefined or null
        for (var nextKey in nextSource) {
          if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
            if (nextSource[nextKey] != null && _typeof(nextSource[nextKey]) == 'object') {
              this(to[nextKey], nextSource[nextKey]);
            } else {
              to[nextKey] = nextSource[nextKey];
            }
          }
        } // end for source

      } // end if source null

    } // end for args


    return to;
  };
}
/**
 * https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent
 */


(function () {
  if (typeof window.CustomEvent === "function") return false;

  function CustomEvent(event, params) {
    if (typeof params == 'undefined') {
      params = {
        bubbles: false,
        cancelable: false,
        detail: undefined
      };
    }

    var evt = document.createEvent('CustomEvent');
    evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
    return evt;
  }

  CustomEvent.prototype = window.Event.prototype;
  window.CustomEvent = CustomEvent;
})();