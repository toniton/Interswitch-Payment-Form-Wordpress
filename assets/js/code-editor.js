'use strict';
 (function($){
    $(function(){
        if( $('#code_editor_page_css').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
                    mode: 'css',
                }
            );
            var editor = wp.codeEditor.initialize( $('#code_editor_page_css'), editorSettings );
        }
    });
 })(jQuery);