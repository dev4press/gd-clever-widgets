/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global ajaxurl*/
var gdclw_widgets;

;(function($, window, document, undefined) {
    gdclw_widgets = {
        s: "",
        nonce: "",
        page: 1,
        init: function() {
            $(document).on("change", ".gdclw-auto-save", function(){
                gdclw_widgets.save($(this));
            });

            $(document).on("click", ".gdclw-post-search-result", function(){
                var id = $(this).data("post"),
                    title = $(this).find(".item-title").html(),
                    tab = $(this).closest(".d4plib-tab-content").find(".gdclw-post-info");

                $(".widefat", tab).val(id);
                $(".cell-right span", tab).html(title);
            });

            $(document).on("keyup keydown click", ".gdclw-post-search .widefat", function(){
                var s = $(this).val();

                if (s !== gdclw_widgets.s) {
                    gdclw_widgets.s = s;
                    gdclw_widgets.nonce = $(this).data("nonce");
                    gdclw_widgets.query($(this).closest("table").find(".gdclw-post-search-results"));
                }
            });

            $(document).on("click", ".gdclw-term a", function(e){
                e.preventDefault();

                $(this).closest(".gdclw-term-single").remove();
            });

            $(document).on("click", ".gdclw-operator", function(){
                var operator = $(this).html(),
                    hidden = $(this).prev(),
                    name = hidden.attr("name");

                if (operator === "+") {
                    $(this).html("-");
                    name = name.replace("[in]", "[out]");
                } else {
                    $(this).html("+");
                    name = name.replace("[out]", "[in]");
                }

                hidden.attr("name", name);
            });

            $(document).on("click", ".gdclw-author-search .widefat:not(.gdclw-search-on)", function(){
                var ix = $(this);

                ix.addClass("gdclw-search-on");
                ix.suggest(ajaxurl + "?action=gdclw_author_search", {
                    multiple: false,
                    onSelect: function() {
                        ix.next().click();
                    }
                });
            });

            $(document).on("click", ".gdclw-term-search .widefat:not(.gdclw-search-on)", function(){
                var ix = $(this),
                    tax = ix.data("tax");

                ix.addClass("gdclw-search-on");
                ix.suggest(ajaxurl + "?action=ajax-tag-search&tax=" + tax, {
                    multiple: false,
                    onSelect: function() {
                        ix.next().click();
                    }
                });
            });

            $(document).on("click", ".gdclw-author-search .button-secondary, .gdclw-term-search .button-secondary", function(){
                var term = $(this).prev().val();

                if (term !== '') {
                    var item = $(this).parent().next().clone();

                    item.find("input").val(term);
                    item.find(".gdclw-term span").html(term);
                    item.show();

                    $(this).closest("table").find(".gdclw-term-list").append(item);
                }
            });
        },
        query: function(el) {
            var i, row, query = {
                action : 'wp-link-ajax',
                page : gdclw_widgets.page,
                '_ajax_linking_nonce' : gdclw_widgets.nonce
            };

            if (gdclw_widgets.s !== "") {
                query.search = gdclw_widgets.s;
            }

            $.post(ajaxurl, query, function(r){
                $(el).html("");

                for (i = 0; i < r.length; i++) {
                    row = '<div class="gdclw-post-search-result" data-post="' + r[i].ID + '">';
                    row+= '<span class="item-title">' + r[i].title + '</span><span class="item-info">' + r[i].info + '</span>';
                    row+= '</div>';

                    $(el).append(row);
                }
            }, 'json');
        },
        save: function(el) {
            el.closest("form").find(".widget-control-actions input.button").click();
        }
    };

    gdclw_widgets.init();
})(jQuery, window, document);
