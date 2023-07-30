(function (factory, window) {
    // define an AMD module that relies on 'leaflet'
    if (typeof define === 'function' && define.amd) {
        define(['leaflet'], factory);

        // define a Common JS module that relies on 'leaflet'
    } else if (typeof exports === 'object') {
        module.exports = factory(require('leaflet'));
    }

    // attach your plugin to the global 'L' variable
    if (typeof window !== 'undefined' && window.L) {
        factory(window.L);
    }
}(function (L) {

    // source: https://github.com/consbio/Leaflet.Range/blob/master/L.Control.Range-min.js
    L.Control.Range = L.Control.extend({
        options: {
            position: 'topright',
            min: null,
            max: null,
            value: null,
            step: null,
            orient: null,
            iconClass: 'leaflet-range-icon',
            icon: true
        },
        onAdd: function(map) {
            var container = L.DomUtil.create('div', 'leaflet-range-control leaflet-bar ' + this.options.orient);
            if (this.options.icon) {
                L.DomUtil.create('span', this.options.iconClass, container);
            };
            var text = L.DomUtil.create('div', '', container);
            text.id = "range_label";
            text.innerHTML = "<strong id='range_text'> " + this.options.value + " Km Radius</strong>";

            var slider = L.DomUtil.create('input', '', container);
            slider.type = 'range';
            slider.setAttribute('orient', this.options.orient);
            slider.id = "range_slider";
            slider.min = this.options.min * 1000;
            slider.max = this.options.max * 1000;
            slider.step = this.options.step * 1000;
            slider.value = this.options.value;

            L.DomEvent.on(slider, 'mousedown mouseup click touchstart', L.DomEvent.stopPropagation);

            /* IE11 seems to process events in the wrong order, so the only way to prevent map movement while dragging the
             * slider is to disable map dragging when the cursor enters the slider (by the time the mousedown event fires
             * it's too late becuase the event seems to go to the map first, which results in any subsequent motion
             * resulting in map movement even after map.dragging.disable() is called.
             */
            L.DomEvent.on(slider, 'mouseenter', function(e) {
                map.dragging.disable()
            });
            L.DomEvent.on(slider, 'mouseleave', function(e) {
                map.dragging.enable();
            });

            L.DomEvent.on(slider, 'change', function(e) {
                this.fire('change', {value: e.target.value});
            }.bind(this));

            L.DomEvent.on(slider, 'input', function(e) {
                this.fire('input', {value: e.target.value});
            }.bind(this));

            this._slider = slider;
            this._container = container;

            return this._container;
        },

        setValue: function(value) {
            this.options.value = value;
            this._slider.value = value;
        },

    });

    L.Control.Range.include(L.Evented.prototype)


    L.control.range = function (options) {
        return new L.Control.Range(options);
    };

}, window));
