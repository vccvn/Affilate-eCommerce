function addCkeditor(selector) {
    var $e = $(selector);
    var id = $e.attr('id');
    var h = 500;
    if ($e.attr('height')) {
        h = $e.attr('height');
    }
    var editorMode = $e.attr('mode');
    if (!editorMode || editorMode == undefined) editorMode = 'clean';
    var toolbar = [
        {
            name: "basicstyles",
            groups: ["basicstyles"]
        },
        {
            name: 'paragraph',
            groups: ['list']

        },
        {
            name: "links",
            groups: ["links"]
        },
        {
            name: "styles",
            groups: ["styles"]
        },
        {
            name: 'colors',
            groups: ['TextColor', 'BGColor']
        },
        { name: 'document', groups: ['mode'] }
    ];
    var removeButtons = 'Underline,Strike,Subscript,Superscript,Styles,Specialchar,Save,NewPage,Preview,Print,Templates';
    if (editorMode == 'clean') {
        toolbar = [
            {
                name: "basicstyles",
                groups: ["basicstyles"]
            },
            {
                name: "styles",
                groups: ["styles"]
            },
            {
                name: "link",
                groups: ["links"]
            },
            {
                name: 'colors',
                groups: ['TextColor', 'BGColor']
            },
            { name: 'document', groups: ['mode'] }
        ];
        removeButtons = 'Underline,Strike,Subscript,Superscript,Styles,Specialchar,Save,NewPage,Preview,Print,Templates,Format,Font';
    }
    else if (editorMode == 'table') {
        toolbar = [
            {
                name: "basicstyles",
                groups: ["basicstyles"]
            },
            {
                name: 'colors',
                groups: ['TextColor', 'BGColor']
            },
            { name: 'table', groups: ['table'] }
        ];
        removeButtons = 'Underline,Strike,Subscript,Superscript,Styles,Specialchar,Save,NewPage,Preview,Print,Templates,Format,Font';
        // CKEDITOR.replace(id);
        var opt = {
            // Define the toolbar groups as it is a more accessible solution.
            // toolbarGroups: toolbar,
            language: 'vi',
            // uiColor: '#F7B42C',
            height: h,
            // toolbarCanCollapse: true,
            extraPlugins: 'colorbutton,sourcearea,table',
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: removeButtons,
            updateFormValue: 'onSubmit|onBlur|onUpdate',
            // updateFormValueDebounce: 400, // only if updateFormValue = 'onUpdate'

        };
        var _ck = ClassicEditor
            .create($e[0])
            .catch(error => {
                console.error(error);
            });

        return;
    }
    // CKEDITOR.editorConfig = function( config ) {
    //     config.extraPlugins = 'sourcearea';
    // };


    // CKEDITOR.replace(id);
    var _ck = ClassicEditor
        .create($e[0])
        .then(editor => {
            // console.log(editor)
            var editor_changed = false;

            editor.model.document.on('change:data', () => { editor_changed = true; });

            editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                if (!isFocused && editor_changed) {
                    editor_changed = false;
                    var data = editor.getData();
                    $e.val(data);
                }
            });
            setInterval(function () {
                var data = editor.getData();
                $e.val(data);
            }, 200);


            // editor.addCommand("mySimpleCommand", {
            //     exec(edt) {
            //         console.log(edt.getData());
            //     }
            // });

            // editor.ui.addButton('SuperButton', {
            //     label: "Click me",
            //     command: 'mySimpleCommand',
            //     toolbar: 'insert',
            //     icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
            // });
        })
        .catch(error => {
            console.error(error);
        });

}
jQuery(window).on('load', function () {

    var $mini = $('textarea.crazy-ckeditor');
    if ($mini.length) {

        $mini.each((i, e) => {
            addCkeditor(e);
        });


    }
})
