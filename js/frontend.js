/*jslint regexp: true, nomen: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdclw_data*/
var gd_clw_core;

;(function($, window, document, undefined) {
    gd_clw_core = {
        init: function() {},
        converter: {
            lock: false,
            update: true,
            mem:  {
                rates: {},
                units: {}
            },
            save: {
                units: function(id) {
                    var type = $(".clw-converter-type", "#clw-" + id).val();

                    if (!gd_clw_core.converter.mem.units.hasOwnProperty(id)) {
                        gd_clw_core.converter.mem.units[id] = {__type__: type};
                    } else {
                        gd_clw_core.converter.mem.units[id].__type__ = type;
                    }

                    if (!gd_clw_core.converter.mem.units[id].hasOwnProperty(type)) {
                        gd_clw_core.converter.mem.units[id][type] = {};
                    }

                    gd_clw_core.converter.mem.units[id][type] = gd_clw_core.converter.save.get(id);

                    gd_clw_core.converter.save.store("units");
                },
                get: function(id) {
                    return {
                        f: $(".clw-converter-from", "#clw-" + id).val(),
                        t: $(".clw-converter-to", "#clw-" + id).val(),
                        i: $(".clw-converter-input", "#clw-" + id).val()
                    };
                },
                store: function(name) {
                    Cookies.set(gdclw_data.converter.cookie_prefix + name, gd_clw_core.converter.mem[name], { expires: 365, path: "/" });
                }
            },
            switch: function(id) {
                gd_clw_core.converter.lock = true;

                var type = $(".clw-converter-type", "#clw-" + id).val(),
                    list = gdclw_data.converter.units[type].list,
                    $m = this.mem;

                $(".clw-converter-from", "#clw-" + id).removeOption(/./);
                $(".clw-converter-to", "#clw-" + id).removeOption(/./);

                $(".clw-converter-from", "#clw-" + id).addOption(list, false);
                $(".clw-converter-to", "#clw-" + id).addOption(list, false);

                if ($m.units[id] && $m.units[id][type]) {
                    $.each($m.units[id][type], function(idx, val) {
                        var key = "";

                        if (idx === "f") { key = "from"; }
                        if (idx === "t") { key = "to"; }
                        if (idx === "i") { key = "input"; }

                        if (key !== "") {
                            $(".clw-converter-" + key, "#clw-" + id).val(val);
                        }
                    });
                }

                gd_clw_core.converter.lock = false;

                gd_clw_core.converter.convert(id);
            },
            replace: function(id) {
                gd_clw_core.converter.lock = true;

                var from = $(".clw-converter-from", "#clw-" + id).val(),
                    to = $(".clw-converter-to", "#clw-" + id).val();

                $(".clw-converter-from", "#clw-" + id).val(to);
                $(".clw-converter-to", "#clw-" + id).val(from);

                gd_clw_core.converter.lock = false;

                this.convert(id);
            },
            convert: function(id) {
                if (gd_clw_core.converter.lock) { return; }

                var type = $(".clw-converter-type", "#clw-" + id).val(), rate = 1, wait = false,
                    from = $(".clw-converter-from", "#clw-" + id).val(), unitFrom,
                    to = $(".clw-converter-to", "#clw-" + id).val(), unitTo;

                if (from !== to) {
                    if (type === "currency_google" || type === "currency") {
                        if (this.mem.rates.hasOwnProperty(from + to)) {
                            rate = this.mem.rates[from + to];
                        } else if (this.mem.rates.hasOwnProperty(to + from)) {
                            rate = this.mem.rates[to + from] !== 0 ? 1 / this.mem.rates[to + from] : 0;
                        } else {
                            wait = true;
                            gd_clw_core.converter.lock = true;

                            $.ajax({
                                url: gdclw_data.ajax, type: "POST", dataType: "json",
                                cache: false, data: {
                                    action: "gdclw_convert_currency_google",
                                    from: from, to: to},
                                success: function(json) {
                                    if (json.status === "ok") {
                                        $.each(json.values, function(idx, val){
                                            gd_clw_core.converter.mem.rates[idx] = val;
                                        });
                                    }

                                    gd_clw_core.converter.lock = false;
                                    gd_clw_core.converter.convert(id);
                                }
                            });
                        }
                    } else {
                        unitFrom = gdclw_data.converter.units[type].convert[from];
                        unitTo = gdclw_data.converter.units[type].convert[to];

                        if (type !== "temperature") {
                            rate = unitFrom / unitTo;
                        }
                    }
                }

                if (wait) {
                    $(".clw-converter-output", "#clw-" + id).html("...");
                } else {
                    var input = $(".clw-converter-input", "#clw-" + id).val(),
                        output = 0;

                    if (input === "") {
                        input = 0;
                    }

                    if (type === "temperature" && from !== to) {
                        output = (input - unitFrom.offset) / unitFrom.ratio;
                        output = output * unitTo.ratio + unitTo.offset;
                    } else {
                        output = input * rate;
                    }

                    $(".clw-converter-output", "#clw-" + id).html(output);

                    if (gd_clw_core.converter.update) {
                        this.save.units(id);
                    }
                }
            },
            loader: function() {
                var $m = this.mem;

                $(".clw-units-converter").each(function(){
                    var id = $(this).attr("id").substr(4),
                        type = $(".clw-converter-type", this).val(),
                        $block = this;

                    if ($m.units[id]) {
                        type = $m.units[id]["__type__"];

                        gd_clw_core.converter.update = false;

                        if ($(".clw-converter-type", this).containsOption(type)) {
                            $(".clw-converter-type", this).val(type);
                        } else {
                            type = $(".clw-converter-type", this).val();
                        }

                        gd_clw_core.converter.switch(id);

                        if ($m.units[id][type]) {
                            $.each($m.units[id][type], function(idx, val) {
                                var key = "";

                                if (idx === "f") { key = "from"; }
                                if (idx === "t") { key = "to"; }
                                if (idx === "i") { key = "input"; }

                                if (key !== "") {
                                    $(".clw-converter-" + key, $block).val(val);
                                }
                            });
                        }

                        gd_clw_core.converter.update = true;
                    } else {
                        gd_clw_core.converter.switch(id);
                    }

                    gd_clw_core.converter.convert(id);
                });
            },
            history: function() {
                if (Cookies.get(gdclw_data.converter.cookie_prefix + "units")) {
                    this.mem.units = Cookies.getJSON(gdclw_data.converter.cookie_prefix + "units");
                }
            },
            handlers: function() {
                $(".clw-units-converter .clw-converter-type").change(function() {
                    var id = $(this).closest(".clw-units-converter").attr("id").substr(4);

                    gd_clw_core.converter.switch(id);
                });

                $(".clw-units-converter .clw-converter-from, .clw-units-converter .clw-converter-to").change(function() {
                    var id = $(this).closest(".clw-units-converter").attr("id").substr(4);

                    gd_clw_core.converter.convert(id);
                });

                $(".clw-units-converter .clw-converter-input").bind("change keyup", function() {
                    var id = $(this).closest(".clw-units-converter").attr("id").substr(4);

                    gd_clw_core.converter.convert(id);
                });

                $(".clw-units-converter .clw-middle-replace").click(function() {
                    var id = $(this).closest(".clw-units-converter").attr("id").substr(4);

                    gd_clw_core.converter.replace(id);
                });
            }
        },
        navigator: {
            animate: function(li, method, speed, idx) {
                setTimeout(function() {
                    if (method === "slideDown") {
                        li.slideDown(speed)
                    } else if (method === "fadeIn") {
                        li.fadeIn(speed);
                    } else {
                        li.show();
                    }
                }, (speed / 4) * idx);
            },
            static: function() {
                $(document).on("click", ".clw-li-item a.clw-item", function(e){
                    $(this).prev().find("a").click();
                });
            },
            init: function() {
                $(document).on("click", "li.clw-li-expander a", function(e){
                    e.preventDefault();

                    var clw_data = $(this).attr("href").substr(1).split("|"),
                        clw_animate = clw_data[7], clw_speed = clw_data[8];

                    clw_data[0] = parseInt(clw_data[0]);
                    clw_data[1] = parseInt(clw_data[1]);
                    clw_data[2] = parseInt(clw_data[2]);
                    clw_data[3] = parseInt(clw_data[3]) + clw_data[2];

                    if (clw_data[3] >= clw_data[1]) {
                        if (clw_data[3] > clw_data[1] && clw_data[0] > clw_data[1]) {
                            var _loader = $(this).parent().next();
                            $(this).parent().remove();
                            _loader.fadeIn(clw_speed / 4);

                            $.ajax({
                                dataType: "html", type: "POST",
                                url: gdclw_data.ajax + "?action=gdclw_navigator_request",
                                data: {
                                    _nonce: gdclw_data.nonce,
                                    widget: clw_data[4],
                                    level: clw_data[5],
                                    offset: clw_data[1],
                                    value: clw_data[6],
                                    current: gdclw_data.navigator.page,
                                    current_url: gdclw_data.navigator.url
                                },
                                success: function(html) {
                                    var _new_items = _loader.parent(), _counter = clw_data[1];
                                    _loader.replaceWith(html);

                                    _new_items.find("li.clw-li-item:hidden:lt(" + clw_data[2] + ")").each(function(idx){
                                        gd_clw_core.navigator.animate($(this), clw_animate, clw_speed, idx);
                                        _counter++;
                                    });

                                    if (_counter === clw_data[0]) {
                                        _new_items.find("li.clw-li-expander").fadeOut(clw_speed * 1.2).attr("aria-hidden", "true");
                                    }
                                }
                            });
                        } else {
                            if ((clw_data[3] > clw_data[1]) || (clw_data[3] === clw_data[1] && clw_data[1] === clw_data[0])) {
                                $(this).parent().fadeOut(clw_speed * 1.2);
                            }
                        }
                    }

                    $(this).attr("href", "#" + clw_data.join("|"));

                    $(this).parent().parent().find("li.clw-li-item.clw-li-level-" + clw_data[5] + ":hidden:lt(" + clw_data[2] + ")").each(function(idx){
                        gd_clw_core.navigator.animate($(this), clw_animate, clw_speed, idx);
                    });
                });

                $(document).on("click", "span.clw-item-toggle a", function(e) {
                    if ($(this).parent().hasClass("clw-item-toggle-parent")) {
                        window.location.href = $(this).attr("href");
                    }

                    e.preventDefault();

                    $(this).parent().toggleClass("clw-item-toggle-open");

                    var ul = $(this).parent().next().next();

                    if ($(this).parent().hasClass("clw-item-toggle-open")) {
                        $(this).attr("aria-pressed", "true");

                        ul.slideDown("500").attr("aria-hidden", "false");

                        if (!$(this).hasClass("clw-loading")) {
                            $(this).addClass("clw-loading");

                            var options = $(this).attr("href").substr(1).split("|");

                            $.ajax({
                                dataType: "html", type: "POST",
                                url: gdclw_data.ajax + "?action=gdclw_navigator_request",
                                data: {
                                    _nonce: gdclw_data.nonce,
                                    widget: options[0],
                                    level: options[1],
                                    offset: 0,
                                    value: options[2],
                                    current: gdclw_data.navigator.page,
                                    current_url: gdclw_data.navigator.url
                                },
                                success: function(html) {
                                    ul.html(html);

                                    if (ul.find(".clw-li-expander a").length > 0) {
                                        ul.find(".clw-li-expander a").click();
                                    } else {
                                        ul.find("li.clw-li-item:hidden").each(function(idx){
                                            gd_clw_core.navigator.animate($(this), options[3], options[4], idx);
                                        });
                                    }
                                }
                            });
                        }
                    } else {
                        $(this).attr("aria-pressed", "false");

                        ul.slideUp(200).attr("aria-hidden", "true");
                    }
                });
            }
        }
    };

    gd_clw_core.init();

    if (gdclw_data.modules.navigator) {
        gd_clw_core.navigator.init();

        if (gdclw_data.navigator.static) {
            gd_clw_core.navigator.static();
        }
    }

    if (gdclw_data.modules.converter) {
        gd_clw_core.converter.history();
        gd_clw_core.converter.loader();
        gd_clw_core.converter.handlers();
    }
})(jQuery, window, document);