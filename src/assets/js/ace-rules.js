// your-custom-mode.js
ace.define('ace/mode/custom', ['require', 'exports', 'module', 'ace/lib/oop', 'ace/mode/text', 'ace/mode/text_highlight_rules'], function (require, exports, module) {
    var oop = require('ace/lib/oop');
    var TextMode = require('ace/mode/text').Mode;
    var TextHighlightRules = require('ace/mode/text_highlight_rules').TextHighlightRules;

    var CustomHighlightRules = function () {
        this.$rules = {
            start: [
                {
                    token: 'custom-tag',
                    regex: /\{\{site_name\}\}/
                },
                {
                    token: 'custom-tag',
                    regex: /\{\{custom_tag\}\}/
                },
                {
                    token: 'custom-tag',
                    regex: /\{\{another_tag\}\}/
                },
                // Add more custom tags here using the same format:
                // { token: 'custom-tag', regex: /YOUR_REGEX_PATTERN/ },
                {
                    defaultToken: 'text'
                }
            ]
        };
    };

    oop.inherits(CustomHighlightRules, TextHighlightRules);

    var Mode = function () {
        this.HighlightRules = CustomHighlightRules;
    };
    oop.inherits(Mode, TextMode);

    (function () {
        this.$id = 'ace/mode/custom';
    }).call(Mode.prototype);

    exports.Mode = Mode;
});
