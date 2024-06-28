let toolbarGroups = [{
        "name": "basicstyles",
        "groups": ["basicstyles","spellchecker","list", "indent", "blocks", "align", "bidi", "paragraph"]
    },
    {
        "name": "links",
        "groups": ["links"]
    },
    {
        "name": "paragraph",
        "groups": ["list", "blocks"]
    },
    {
        "name": "document",
        "groups": ["mode"]
    },
    {
        "name": "insert",
        "groups": ["insert"]
    },
    {
        "name": "styles",
        "groups": ["styles"]
    },
    {
        "name": "about",
        "groups": ["about", "tools", "others"]
    }
];

let removeButtons = "Styles,TextColor,BGColor,ShowBlocks,Maximize,About,Link,Unlink,Flash,Anchor,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language";

let mathElements = [
    "math",
    "maction",
    "maligngroup",
    "malignmark",
    "menclose",
    "merror",
    "mfenced",
    "mfrac",
    "mglyph",
    "mi",
    "mlabeledtr",
    "mlongdiv",
    "mmultiscripts",
    "mn",
    "mo",
    "mover",
    "mpadded",
    "mphantom",
    "mroot",
    "mrow",
    "ms",
    "mscarries",
    "mscarry",
    "msgroup",
    "msline",
    "mspace",
    "msqrt",
    "msrow",
    "mstack",
    "mstyle",
    "msub",
    "msup",
    "msubsup",
    "mtable",
    "mtd",
    "mtext",
    "mtr",
    "munder",
    "munderover",
    "semantics",
    "annotation",
    "annotation-xml"
];

// CKEDITOR.plugins.addExternal("ckeditor_wiris", "https://ckeditor.com/docs/ckeditor4/4.16.0/examples/assets/plugins/ckeditor_wiris/", "plugin.js");

var config = {
    extraPlugins: "ckeditor_wiris, uploadimage, autogrow",
    toolbarGroups,
    removeButtons,
    removePlugins: "elementspath,easyimage,cloudservices",
    height: 80,
    autoGrow_minHeight: 80,
    autoGrow_maxHeight: 250,
    toolbarCanCollapse : true,
    toolbarStartupExpanded: false,
    extraAllowedContent: mathElements.join(" ") + "(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)",
    font_defaultLabel : 'Arial',
    fontSize_defaultLabel : '12px',
    uiColor : "#dddddd",
    editorplaceholder: enterAnswerText
};

/**
 * @methods to add Rich Text editor in place of Text area
 */
function createCkeditor(id, uploadUrl= "") {
    config.uploadUrl = uploadUrl;
    CKEDITOR.replace(id, config);
}


/**
 * @methods to add Rich Text editor in place of Text area
 */
function studentCkeditor(id) {

    let toolbarGroups = [{
            "name": "basicstyles",
            "groups": ["basicstyles","spellchecker","list", "blocks", "align", "bidi", "paragraph"]
        },
        {
            "name": "links",
            "groups": ["links"]
        },
        {
            "name": "paragraph",
            "groups": ["list", "blocks"]
        },
        {
            "name": "styles",
            "groups": ["styles"]
        },
        {
            "name": "about",
            "groups": ["about", "tools", "others"]
        }
    ];

    var config = {
        extraPlugins: "ckeditor_wiris, autogrow",
        toolbarGroups,
        removeButtons,
        removePlugins: "elementspath,easyimage,cloudservices",
        height: 80,
        autoGrow_minHeight: 80,
        autoGrow_maxHeight: 250,
        toolbarCanCollapse : true,
        toolbarStartupExpanded: false,
        extraAllowedContent: mathElements.join(" ") + "(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)",
        font_defaultLabel : 'Arial',
        fontSize_defaultLabel : '12px',
        uiColor : "#dddddd",
        editorplaceholder: enterAnswerText
    };

    CKEDITOR.replace(id, config);
}