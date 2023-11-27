tinymce_defaults={
    imageupload_url: '/image-uploader',
    menubar: false,
    toolbar_items_size: 'small',
    language: 'ru',
    skin: 'hydra',
    plugins: "paste,imageupload,link,emoticons,save,autoresize,image,noneditable",
    toolbar1: 'imageupload  image | emoticons | bold italic underline | alignleft aligncenter alignright | link unlink | save',
    min_height: 77,
    relative_urls: false,
    autoresize_min_height: 77,
    autoresize_max_height: 300,
    autoresize_bottom_margin: 0,
    noneditable_leave_contenteditable: true,
    auto_focus: true,
    forced_root_block: '',
    paste_auto_cleanup_on_paste: true,
    paste_remove_styles: true,
    paste_remove_styles_if_webkit: true,
    paste_strip_class_attributes: true
};
function sendOnCtrlEnter(e){
    var keynum;
    if (window.event) {
        keynum = e.keycode
    }
    else if (e.which) {
        keynum = e.which
    }
    if ((e.ctrlKey == 1) || (e.altKey == 1)) {
        switch (keynum) {
            case 13:  /* enter key */
                $('.mce-form-submit button').click();
                return false;
                break;
        }
    }
}
function sendOnEnter(e){
    var keynum;
    if (window.event) { keynum = e.keycode }
    else if (e.which) { keynum = e.which }
    if ((e.ctrlKey != 1) && (e.altKey != 1) && (e.shiftKey != 1)) {
        switch (keynum) {
            case 13:
                $('.mce-form-submit button').click();
                return false;
                break;
        }
    }
}
function addSubmitBtn(evt){
    var toolbar = $(evt.target.editorContainer)
        .find('>.mce-container-body >.mce-toolbar-grp');
    var editor = $(evt.target.editorContainer)
        .find('>.mce-container-body >.mce-edit-area');
    toolbar.detach().insertAfter(editor);
}
function editorSetup(ed){
    ed.on('keydown',sendOnCtrlEnter);
    ed.on('init', addSubmitBtn);
}
function chatEditorSetup(ed){
    ed.on('keydown',sendOnEnter);
    ed.on('init', addSubmitBtn);
}
tinymce.baseURL='/javascripts/tinymce';
if($('textarea.editor').length) tinymce.init($.extend({}, tinymce_defaults, {selector: 'textarea.editor',setup:editorSetup}));
if($('textarea.static-editor').length) tinymce.init($.extend({}, tinymce_defaults, {selector: 'textarea.static-editor',toolbar1: 'imageupload  image | emoticons | bold italic underline | link unlink | save',autoresize_max_height: 77,setup:editorSetup}));
if($('textarea.chat-editor').length) tinymce.init($.extend({}, tinymce_defaults, {selector: 'textarea.chat-editor',toolbar1: 'imageupload  image | emoticons | bold italic underline | link unlink | save',autoresize_max_height: 77,setup:chatEditorSetup}));