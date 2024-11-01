/*
 * Cookies 
 */
/* global hljs, $_ */

var COOKIE = (function () {

    /* Partie privée */
    function getVal(offset) {
        var endStr = document.cookie.indexOf(";", offset);
        if (endStr === -1)
            endStr = document.cookie.length;
        return unescape(document.cookie.substring(offset, endStr));
    }

    /* Partie publique */
    var self = {};

    // Ajouter/modifier un cookie
    self.set = function (name, value) {
        var argv = self.set.arguments;
        var argc = self.set.arguments.length;
        var expires = (argc > 2) ? argv[2] : null;
        var path = (argc > 3) ? argv[3] : null;
        var domain = (argc > 4) ? argv[4] : null;
        var secure = (argc > 5) ? argv[5] : false;
        document.cookie = name + "=" + escape(value) +
                ((expires === null) ? "" : ("; expires=" + expires.toGMTString())) +
                ((path === null) ? "" : ("; path=" + path)) +
                ((domain === null) ? "" : ("; domain=" + domain)) +
                ((secure === true) ? "; secure" : "");
    };
    // Récupérer un cookie
    self.get = function (name) {
        var arg = name + "=";
        var alen = arg.length;
        var clen = document.cookie.length;
        var i = 0;
        while (i < clen) {
            var j = i + alen;
            if (document.cookie.substring(i, j) === arg)
                return getVal(j);
            i = document.cookie.indexOf(" ", i) + 1;
            if (i === 0)
                break;
        }
        return null;
    };

    return self;
})();

/** 
 * Hilight JS
 */
CODE_HILIGHT = {
    /**
     * 
     * @type String : id du link css
     */
    _link: $_.id('syng_hightlightCss-css'),
    /**
     * 
     * @type @exp;location@pro;pathname
     */
    _pathName: location.pathname,
    /**
     * 
     * @param String cookieName
     * @returns Void
     */
    init: function (cookieName) {
        hljs.initHighlightingOnLoad(); /* initialisation de la lib Hilight.js */
        if (null !== cookieName) {
            this._link.setAttribute('href', cookieName);
        }
    },
    /**
     * Mettre a jour le nom du thème
     * 
     * @param String nom
     * @returns Void
     */
    changeCssPath: function (nom) {
        this._link.setAttribute('href', nom);
        console.log(nom);
        this.addCookie(nom);
    },
    /**
     * 
     * @param {type} path
     * @returns {undefined}
     */
    addCookie: function (path) {
        var myDomain = '/';
        var date_exp = new Date();
        date_exp.setTime(date_exp.getTime() + (365 * 24 * 3600 * 1000));  // Durée de vie de 365 jours

        COOKIE.set("syntaxHighlightingStyles", path, date_exp, myDomain);
    }
};

CODE_HILIGHT.init(COOKIE.get("syntaxHighlightingStyles")); /* Hilight JS */

hljs.initHighlightingOnLoad(); /* initialisation de la lib Hilight.js */