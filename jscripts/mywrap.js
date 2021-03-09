$(function() {
    'use strict';

    // Add custom styling
    $('<style type="text/css">' +
      '    .sceditor-button-wrap div {' +
      '        background: url(images/mywrap/wrapper_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapscb div {' +
      '        background: url(images/mywrap/box_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapinfo div {' +
      '        background: url(images/mywrap/info_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wraptip div {' +
      '        background: url(images/mywrap/tip_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapimportant div {' +
      '        background: url(images/mywrap/important_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapalert div {' +
      '        background: url(images/mywrap/alert_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wraphelp div {' +
      '        background: url(images/mywrap/help_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapdownload div {' +
      '        background: url(images/mywrap/download_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wraptodo div {' +
      '        background: url(images/mywrap/todo_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapclear div {' +
      '        background: url(images/mywrap/clear_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wrapem div {' +
      '        background: url(images/mywrap/em_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wraphi div {' +
      '        background: url(images/mywrap/hi_16x16.png) no-repeat;' +
      '    }' +
      '    .sceditor-button-wraplo div {' +
      '        background: url(images/mywrap/lo_16x16.png) no-repeat;' +
      '    }' +
      '</style>').appendTo('body');

    $.sceditor.plugins.bbcode.bbcode.set('wrap', {
        allowsEmpty: true,
        isInline: false,
		tags: {
			div: {
				'data-mywrap-style': null
			}
		},
        format: function($element, content) {
            var style = $element.data('mywrap-style');
            console.log($element);
            console.log(style);
            return '[wrap' + (((typeof style != 'undefined') && (style.length > 0) && (style != 'undefined')) ? ' style=' + style : '') +
                   ']' + content + '[/wrap]';
        },
        html: function(token, attrs, content) {
            return '<div id="wrapc" data-mywrap-style="' + attrs.style +
                   '" style="position: relative; background: white; margin: .25em .05em 0 0; border: 1px solid #ccc; padding: 10px;' +
                   '-moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;">' + content + '</div>';
        },
        breakStart: true,
        breakEnd: true
    });

    $.sceditor.command.set('wrap',{
        _dropDown: function(editor, caller) {
            var $content = $(
                '<div>' +
                '    <a class="sceditor-button sceditor-button-wrapscb" unselectable="on" title="Simple centered box">' +
                '        <div unselectable="on">Simple centered box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapinfo" unselectable="on" title="Info box">' +
                '        <div unselectable="on">Info box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wraptip" unselectable="on" title="Tip box">' +
                '        <div unselectable="on">Tip box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapimportant" unselectable="on" title="Important box">' +
                '        <div unselectable="on">Important box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapalert" unselectable="on" title="Alert box">' +
                '        <div unselectable="on">Alert box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wraphelp" unselectable="on" title="Help box">' +
                '        <div unselectable="on">Help box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapdownload" unselectable="on" title="Download box">' +
                '        <div unselectable="on">Download box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wraptodo" unselectable="on" title="Todo box">' +
                '        <div unselectable="on">Todo box</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapclear" unselectable="on" title="Clear floats">' +
                '        <div unselectable="on">Clear floats</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wrapem" unselectable="on" title="Especially emphasised">' +
                '        <div unselectable="on">Especially emphasised</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wraphi" unselectable="on" title="Highlighted">' +
                '        <div unselectable="on">Highlighted</div>' +
                '    </a>' +
                '    <a class="sceditor-button sceditor-button-wraplo" unselectable="on" title="Less significant">' +
                '        <div unselectable="on">Less significant</div>' +
                '    </a>' +
                '</div>'
            );

            setTimeout(function() {
                $content.find('#wrap').focus();
            }, 100);

            $content.find('.sceditor-button-wrapscb').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round box 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapinfo').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round info 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wraptip').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round tip 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapimportant').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round important 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapalert').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round alert 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wraphelp').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round help 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapdownload').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round download 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wraptodo').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="center round todo 60%"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapclear').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="clear"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wrapem').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="em"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wraphi').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="hi"]');
                e.preventDefault();
            });

            $content.find('.sceditor-button-wraplo').click(function(e) {
                InsertMyWrapSnippet(editor, '[wrap style="lo"]');
                e.preventDefault();
            });

            editor.createDropDown(caller, "insertwrap", $content);
        },
        exec:      function(caller){
            $.sceditor.command.get('wrap')._dropDown(this, caller);
        },
        txtExec:   function(caller){
            $.sceditor.command.get('wrap')._dropDown(this, caller);
        },
        tooltip: 'Wrap'
    });

    function InsertMyWrapSnippet(editor, snippet) {
        editor.insert(snippet, '[/wrap]');
        editor.closeDropDown(true);
    };
});