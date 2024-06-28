"use strict";

    let creatorId = $("#userName").val();

    $(function() {

        //datepicker

        $(".datepicker").pickadate({

            selectMonths: true, // Creates a dropdown to control month

            selectYears: 15 // Creates a dropdown of 15 years to control year

        });



    });

    // select question type

    $(document).on("change", ".question_type", function() {

        $(".select_area").each(function(index, selector) {

            $(selector).addClass("d-none");

        })

        var value = $(this).val();

        $("#" + value).removeClass("d-none");
        if(value === 'passage') {
            $('#add-passage-mcq').click();
            // $('#passage-form').append($('#passage-card').html())
        } else {
            $('#passage-form').html('')
        }

    });

    $(document).on("click", '#add-passage-mcq', function(){
        
        let seqNum = $('#passage-form .card').length+1;
        let passage_card = $('#passage-card').html();

        passage_card = $('#sequence', passage_card).html(seqNum).end()[0].outerHTML;
        passage_card = $('.card-header:first', passage_card).attr({"data-target": `#collapse${seqNum}`}).end()[0].outerHTML
        passage_card = $('.collapse:first', passage_card).attr({"id": `collapse${seqNum}`}).end()[0].outerHTML
        passage_card = $('.question1-error', passage_card).attr({"class": `question${seqNum}-error`}).end()[0].outerHTML

        if(seqNum == 1) {
            passage_card = $('.remove-mcq', passage_card).remove().end()[0].outerHTML
        }
        $('#passage-form').append($(passage_card));

        $('#passage-form .accordion:last').find('textarea').each(function(index, element){
            $(this).attr('id', $(this).attr('id')+'-'+seqNum)
        });

        initalizeTextAreaWithCKEditor()
    });

    $(document).on("click", ".remove-mcq", function() {
        let seqNum = $('#passage-form .card').length + 1;
        let remSeq = $(this).closest('.card').find("#sequence").text()
        $(this).closest('.card').remove();

        $('#passage-form .card').each(function(index, card) {
            const seqNum = index+1;
            $(`textarea[name=question${seqNum}]`, card).closest('.card').html()
            $('#sequence', card).html(seqNum)
            $('.card-header:first', card).attr({"data-target": `#collapse${seqNum}`})
            $('.collapse:first', card).attr({"id": `collapse${seqNum}`})
            $('textarea[name=question1]', card).attr({"name": `question${seqNum}`, "id": `question${seqNum}`})
            $('.question1-error', card).attr({"class": `question${seqNum}-error`})
        })
    })


    function getEllipsis(command, characters) {
        for (var i = command.length; i >= 0; i--) {
            if (command.substring(0, i).length < characters) {
                if (i < command.length) {
                    command = command.substring(0, i) + "...";
                }
                return command;
            }
        }
    }
    
    $(document).on('hidden.bs.collapse', '#passage-form .accordion', function() {
        let idSelector = $('textarea[id^=passage-question]', this).attr('id')
       
        let content = getEllipsis(CKEDITOR.instances[idSelector].document.getBody().getText().trim(), 50);
        let originalData = 'Multi choice';
        content.length > 0 ? $('.title-content', this).text(content) : $('.title-content', this).text(originalData);
    })

    //scratch paid clear

    $(document).on("click", ".clear-btn", function() {
        $("#clear-data").html(" ");
    });

    const yearsTags = [];
    for (let year = 2005; year <= new Date().getFullYear(); year++) {
        yearsTags.push(year);
    }

    //previous year tag

    $(`input[name="year1"], input[name="year2"], input[name="year3"], input[name="year4"], input[name="year5"], input[name="year6"]`).amsifySuggestags({
        suggestions: yearsTags,
        whiteList: true
    });

    // Turn off automatic editor creation first.
    CKEDITOR.disableAutoInline = true;

/***********************************  Methods Starts *********************************/

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



let removeButtons = "Styles,TextColor,BGColor,ShowBlocks,Maximize,About,Link,Unlink,Flash,Anchor,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language";

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



var config = {

    extraPlugins: "ckeditor_wiris, uploadimage, autogrow, urluploading",

    toolbarGroups,

    removeButtons,

    removePlugins: "elementspath, exportpdf",

    height: 80,

    autoGrow_minHeight: 80,

    autoGrow_maxHeight: 250,

    toolbarCanCollapse : true,

    toolbarStartupExpanded: false,

    uploadUrl: $('#IMAGE_UPLOAD_URL').val(),

    extraAllowedContent: mathElements.join(" ") + "(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)",

    font_defaultLabel : 'Arial',

    fontSize_defaultLabel : '12px',

    filebrowserUploadMethod: 'form',

    filebrowserUploadUrl: $('#IMAGE_UPLOAD_URL').val(),

};

CKEDITOR.inline("clear-data", config);



/**

 * @methods to add Rich Text editor in place of Text area

 */

function ckeditorPlace(ids) {

    $.each(ids, function (index, element) {

        config.uiColor = "#dddddd";

        if($(`#${element}`).attr("data-color")) {

            config.uiColor = `#${$(`#${element}`).attr("data-color")}`;

        }

        config.editorplaceholder = "Enter " + $(`#${element}`).attr("placeholder");

        if($(`#${element}`).html() != undefined){

            CKEDITOR.replace(element, config);

        }

    });

}



/**

 * @event oon load page create multiple text area to editor

 */

function initalizeTextAreaWithCKEditor () {

    let idsArray = [];

    $("textarea").each(function(index, element){
        if(!$(element).parents('#passage-card').hasClass('d-none')) {
            idsArray.push($(element).attr("id"));
        }

    });

    ckeditorPlace(idsArray);
}

(function() {

    initalizeTextAreaWithCKEditor();

}());



/**

 * @methods on cursor position changes in fill ups

 */

$.fn.getCursorPosition = function () {

    var el = $(this).get(0);

    var pos = 0;

    var posEnd = 0;

    if ("selectionStart" in el) {

        pos = el.selectionStart;

        posEnd = el.selectionEnd;

    } else if ("selection" in document) {

        el.focus();

        var Sel = document.selection.createRange();

        var SelLength = document.selection.createRange().text.length;

        Sel.moveStart("character", -el.value.length);

        pos = Sel.text.length - SelLength;

        posEnd = Sel.text.length;

    }

    return [pos, posEnd];

};



/**

 * @methods set cursor position in fill ups

 */

$.fn.setCursorPosition = function (start, end) {

    $(this).prop("selectionStart", start);

    $(this).prop("selectionEnd", end);

}



/**

 * @methods to counting total blank space in fillups question

 */

function runloop() {

    let str = CKEDITOR.instances["fnb-input"].getData();

    let newStr = str.replace(/(<([^>]+)>|&nbsp;)/ig,"")

    let strMatch = newStr.match(/[_]{2,}/g);

    let arrLength = 0;

    let strArr = {};

    let inputLength = 0;

    if(strMatch != null) {

        arrLength = strMatch.length;

    }

    if ($(`input`).length > 0) {

        inputLength = $(`input`).length;

    }

    if (arrLength > 0) {

        for (let counter = 0; counter < arrLength; counter++) {

            if($(`.input-${counter}`).length > 0){

                $(`.input-${counter}`).val($(`.input-${counter}`).val());

            } else {

                $(".add-inputs").append(`<div class="col-md-12"><div class="form-group"><div class="" id="optionFibId${counter}">

                <textarea class="fillups form-control mb-8 input-${counter}" id="input-${counter}" data-id="${counter}" placeholder="Answer ${counter+1}" data-color="dddddd"></textarea>

                    </div></div><span class="input-error${counter}"></span></div>`);

                ckeditorPlace([`input-${counter}`]);

            }

        }

    }

    if(inputLength > 0) {

        for (let removeCounter = arrLength; removeCounter < inputLength; removeCounter++) {

            if(removeCounter >= arrLength) {

                $(`.input-${removeCounter}`).remove();

                $(`#optionFibId${removeCounter}`).remove();

            }

        }

    }



}



/**

 * @methods to set MCQ Options

 */

function getMcqOptions(){

    let option = [];

    let arrayDuplicateOptions = [];

    let isTrue = false;

    $("textarea[name=option]").each(function(index, selector){

        var optionId = index+1;

        isTrue = $(selector).parents("div.well2").find("input[type=radio]").is(":checked");

        var optTitle = CKEDITOR.instances[`option${optionId}`].getData();

        option.push({

            id: optionId,

            isCorrect: isTrue,

            optionText: optTitle,

            images: []

        });

        if($(optTitle).find('img').length > 0){

            arrayDuplicateOptions.push(optTitle);

        }

    });



    if(!checkDuplicateOptionsOnSave(arrayDuplicateOptions)){

        return false;

    }

    return option;

}



function checkDuplicateOptionsOnSave(oldArray){

    var uniqueArray = [];

    var error = 0;

    // Loop through array values

    for(var i = 0; i < oldArray.length; i++){

        if(uniqueArray.indexOf(oldArray[i].trim()) === -1) {

            uniqueArray.push(oldArray[i].trim());

        } else {

            error += 1;

        }

    }

    if(error > 0){

        msgToast("error", error + " duplicate options found. Please remove duplicate options");

        return false;

    }

    return true;

}



/**

 * @methods to get Fill up options

 */

function getFillUpOptions(){

    let option = [];

    let isTrue = true;

    $(".fillups").each(function(index, selector){

        let dataId = $(selector).attr('id');

        var optTitle = CKEDITOR.instances[`${dataId}`].getData();

        var optionId = index+1;

        option.push({

            id: optionId,

            isCorrect: isTrue,

            optionText: optTitle,

            images: []

        });

    });

    return option;

}



/**

 * @methods to get True False options

 */

function trueOrFalseOptions(){

    let option = [];

    let isTrue = true;

    $(".trueorfalse").each(function(index, selector){

        var optionId = index+1;

        var isTrue = $(selector).is(":checked");

        var optTitle = $(selector).val();

        option.push({

            id: optionId,

            isCorrect: isTrue,

            optionText: optTitle,

            images: []

        });

    });

    return option;

}



/**

 * @methods to Generate Unique ID

 */

function generateGUID() {

    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(c) {

        let r = (Math.random() * 16) | 0,

            v = c == "x" ? r : (r & 0x3) | 0x8;

        return v.toString(16);

    });

}



/**

 * @methods to Add Subject, Topics, Subtopics Tags

 */

function selectTopicTags(){

    let tags = [];

    var id = "";

    var string = "";

    if($("select[name=subtopics] option:selected").val() != ""){

        id = $("select[name=subtopics] option:selected").val();

        string = $("select[name=subtopics] option:selected").text();

        tags.push({

            id: id,

            topicName: string,

            topicType: 3

        });

    }

    if($("select[name=topics] option:selected").val() != "") {

        id = $("select[name=topics] option:selected").val();

        string = $("select[name=topics] option:selected").text();

        tags.push({

            id: id,

            topicName: string,

            topicType: 2

        });

    }

    if($("select[name=subjects] option:selected").val() != ""){

        id = $("select[name=subjects] option:selected").val();

        string = $("select[name=subjects] option:selected").text();

        tags.push({

            id: id,

            topicName: string,

            topicType: 1

        });

    }

    return tags;

}



/**

 * @methods to Validate MCQ Form data

 */

function mcqValidation(){

    var questionTitle = CKEDITOR.instances[`question1`].getData();

    var error = 0;

    if(questionTitle.length == 0 && $(questionTitle).find('img').length == 0){

        $(".question1-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".question1-error").html("");

        error += false;

    }



    $("textarea[name=option]").each(function(index, selector){

        var optionId = $(selector).attr("id");

        var isTrue = $(selector).parents("div.input-group").find("input[type=radio]").is(":checked");

        var optTitle = CKEDITOR.instances[`${optionId}`].getData();

        if(optTitle.length == 0 && $(optTitle).find('img').length == 0) {

            $(`.${optionId}-error`).html(`<span>${enterOption} ${(index+1)}</span>`);

            error += true;

        } else {

            $(`.${optionId}-error`).html("");

            error += false;

        }

    });

    if(error > 0){

        return false;

    }

    return true;

}



/**

 * @methods to Validate Fill up Form data

 */

function fibValidation(){

    let isBlankAdded = false;

    let error = 0;

    let questionTitle = CKEDITOR.instances[`fnb-input`].getData();

    if(questionTitle.length == 0){

        $(".fnb-input-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".fnb-input-error").html("");

        error += false;

    }



    $("div.add-inputs").find("p.text-danger").remove();

    $(".fillups").each(function(index,value){

        isBlankAdded = true;

        var dataId = $(value).attr('id');

        var dataVal = CKEDITOR.instances[`${dataId}`].getData();

        if(dataVal == ""){

            $(`span.input-error${index}`).html(`<p class="text-danger">${enterAnswer} ${index+1}</p>`);

            error += true;

        }

    });

    if(!isBlankAdded){

        msgToast("warning", addAtleastOneBlank);

        error += true;

    }

    if(error > 0){

        return false;

    }

    return true;

}



/**

 * @methods to Validate True False Form data

 */

function trueFalseValidation(){

    var questionTitle = CKEDITOR.instances[`TrueFalseQue`].getData();

    var error = 0;

    if(questionTitle.length == 0){

        $(".TrueFalseQue-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".TrueFalseQue-error").html("");

        error += false;

    }



    var isChecked = false;

    $(".trueorfalse").each(function(index,value){

        if($(value).is(":checked")){

            isChecked = true;

        }

    });

    if(!isChecked){

        msgToast("warning",selectTrueFalse);

        return false;

    }

    if(error > 0){

        return false;

    }

    return true;

}



function shortQuestionValidation(){

    var questionTitle = CKEDITOR.instances[`shortQuestions`].getData();

    var answerTitle = CKEDITOR.instances[`shortAnswer`].getData();

    var error = 0;

    if(questionTitle.length == 0){

        $(".shortQuestions-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".shortQuestions-error").html("");

        error += false;

    }



    if(answerTitle.length == 0){

        $(".shortAnswer-error").html(`<span>${enterAnswer}</span>`);

        error += true;

    } else {

        $(".shortAnswer-error").html("");

        error += false;

    }

    if(error > 0){

        return false;

    }

    return true;

}



function longQuestionValidation(){

    var questionTitle = CKEDITOR.instances[`longQuestion`].getData();

    var answerTitle = CKEDITOR.instances[`longAnswer`].getData();

    var error = 0;

    if(questionTitle.length == 0){

        $(".longQuestion-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".longQuestion-error").html("");

        error += false;

    }



    if(answerTitle.length == 0){

        $(".longAnswer-error").html(`<span>${enterAnswer}</span>`);

        error += true;

    } else {

        $(".longAnswer-error").html("");

        error += false;

    }

    if(error > 0){

        return false;

    }

    return true;

}


function shortQuestionWithMultiCorrectValidation(){
    var questionTitle = CKEDITOR.instances[`matQuestions`].getData();
    var extendedSolution = CKEDITOR.instances[`mat-extendedsolution`].getData();
    var answerTitle = $(`#shortMCAAnswer`).val();
    var error = 0;
    if(questionTitle.length == 0){
        $(".matQuestions-error").html(`<span>${enterQuestion}</span>`);
        error += true;
    } else {
        $(".matQuestions-error").html("");
        error += false;
    }

    if(answerTitle.length == 0){
        $(".shortAnswer-error").html(`<span>${enterAnswer}</span>`);
        error += true;
    } else {
        $(".shortAnswer-error").html("");
        error += false;
    }

    if($('.answervariations').find('.variation-row').length > 0) {
        $('[id^=mta-variation-]').each(function() {
            let idSelector = $(this).attr('id');
            let count = $(this).data('count');
            // let ans = CKEDITOR.instances[idSelector].getData();
            let ans = $(this).val();
            if(ans.length <= 0) {
                $(`.mta-variations-error-${count}`).html(`<span>${enterAnswer}</span>`);
                error += true;
            } else {
                $(".mta-variations-error-").html("");
                error += false;
            }
        })
    }

    if (inputsHaveDuplicateValues('.mta-variations')) {
        // Duplicate value found
        error += true;
        msgToast("error", 'Duplicate value. Please check answers and remove duplicacy');
    } else {
        // No duplicate found
        error += false;
    }

    if(extendedSolution.length == 0){
        $(".extended-solution-error").html(`<span>Enter Extended Solution</span>`);
        error += true;
    } else {
        $(".extended-solution-error").html("");
        error += false;
    }

    if(error > 0){
        return false;
    }

    return true;

}

function inputsHaveDuplicateValues(classElement) {
    var hasDuplicates = false;
    var arrInp = [];
    var set = new Set();
    $(classElement).each(function () {
        $(this).val().length > 0 && arrInp.push($(this).val());
    });

    for (let element of arrInp) {
        if (set.has(element)) {
            return true;
        } else {
            set.add(element);
        }
    }
    return false
}


/**

 * @methods to validate form data

 */

function formValidation(dataId){

    if(dataId == `${multiChoice}-form`){

        if(mcqValidation()){

            var optionChecked = false;

            $("input[name=flat-radio]:visible").each(function(index,value){

                if($(value).is(":checked")){

                    optionChecked = true;

                }

            });

            if(!optionChecked){

                msgToast("warning", selectOption);

                return false;

            }

            return true;

        }

        return false;

    }



    if(dataId == `${fillInTheBlank}-form`){

        return fibValidation();

    }



    if(dataId == `${trueOrFalse}-form`){

        return trueFalseValidation();

    }



    if(dataId == `${shortQuestion}-form`){

        return shortQuestionValidation();

    }



    if(dataId == `${longQuestion}-form`){

        return longQuestionValidation();

    }

    if(dataId == `${shortQuestionWMCA}-form`){

        return shortQuestionWithMultiCorrectValidation();

    }

    return true;

}



/**

 * @methods to Validate Selected Filters

 */

function filterValidations(){

    var question_type = $("select[name=question_type] option:selected").val();

    var boards = $("select[name=boards] option:selected").val();

    var grades = $("select[name=grades] option:selected").val();

    var source = $("input[name=source]").val();

    var topics = $("select[name=topics] option:selected").val();

    var subjects = $("select[name=subjects] option:selected").val();

    var subtopics = $("select[name=subtopics] option:selected").val();

    var difficulty_level = $("select[name=difficulty_level] option:selected").val();

    var error = false;

    if(question_type == ""){

        $("select[name=question_type]").addClass("required-error");

        error += true;

    } else {

        $("select[name=question_type]").removeClass("required-error");

        error += false;

    }



    if(boards == ""){

        $("select[name=boards]").addClass("required-error");

        error += true;

    } else {

        $("select[name=boards]").removeClass("required-error");

        error += false;

    }



    if(grades == ""){

        $("select[name=grades]").addClass("required-error");

        error += true;

    } else {

        $("select[name=grades]").removeClass("required-error");

        error += false;

    }



    if(source == ""){

        $("input[name=source]").addClass("required-error");

        error += true;

    } else {

        $("input[name=source]").removeClass("required-error");

        error += false;

    }



    if(subjects == ""){

        $("select[name=subjects]").addClass("required-error");

        error += true;

    } else {

        $("select[name=subjects]").removeClass("required-error");

        error += false;

    }



    if(topics == ""){

        $("select[name=topics]").addClass("required-error");

        error += true;

    } else {

        $("select[name=topics]").removeClass("required-error");

        error += false;

    }



    if(subtopics == "" && $("#s_questionId").val() != ""){

        $("select[name=subtopics]").addClass("required-error");

        error += true;

    } else {

        $("select[name=subtopics]").removeClass("required-error");

        error += false;

    }



    if(difficulty_level == ""){

        $("select[name=difficulty_level]").addClass("required-error");

        error += true;

    } else {

        $("select[name=difficulty_level]").removeClass("required-error");

        error += false;

    }



    if(error > 0){

        return false;

    }

    return true;

}



/**

 * @methods to Get current date and time

 */

function getDateTime(){

    var date = new Date();



    var day = (date.getDate() < 10 ? "0" : "") + date.getDate();

    var month = (date.getMonth() < 9 ? "0" : "") + (date.getMonth() + 1);

    var year = date.getFullYear();



    var hours = ((date.getHours() % 12 || 12) < 10 ? "0" : "") + (date.getHours() % 12 || 12);

    var minutes = (date.getMinutes() < 10 ? "0" : "") + date.getMinutes();

    var meridiem = date.getSeconds();



    var currentDateTime = year + "-" + month + "-" + day +"T"+ hours + ":" + minutes + ":" + meridiem + ".193Z";

    return currentDateTime;

}



/**

 * @methods to create MCQ Option previews

 */

function previewOption(){

    var optionHtml = "";

    setTimeout(() => {

        $("textarea[name=option]").each(function(index, value){

            var optionId = index+1;

            var isTrue = $(value).parents("div.well2").find("input[type=radio]").is(":checked");

            var checked = "";

            var optionTitle = CKEDITOR.instances[`option${optionId}`].getData();

            if(optionTitle.length > 0 || $(optionTitle).find('img').length > 0){

                optionHtml += `<div class="custom-control custom-radio">

                    <input type="radio" id="customRadio${optionId}" name="customRadio" class="custom-control-input" ${checked}>

                    <label class="custom-control-label disabled" for="customRadio${optionId}">

                        <ul class="answer-list">

                            <li>${optionTitle}</li>

                        </ul>

                    </label>

                </div>`;

            }

        });

        $(".option_place").html(optionHtml);

        MathJax.typeset();

    }, 2000);

}



function previewFillUpsOption(){

    let optionHtml = "";

    $("textarea.fillups").each(function(index, value){

        var optionId = index+1;

        var optionTitle = CKEDITOR.instances[`input-${index}`].getData();

        if($(optionTitle).find('img').length > 0){

            optionHtml += `<ul class="answer-list ml-4"><li>Answer ${index+1}: </li><li>${optionTitle}</li></ul>`;

        }

    });

    $(".option_place").html(optionHtml);

}



/**

 * @methods to create Question Preview

 */

function previewQuestion(textBoxId){

    setTimeout(() => {

        var questionTitle = CKEDITOR.instances[textBoxId].getData();

        if(questionTitle.length > 0 || $(questionTitle).find('img').length > 0){

            $(".preview").removeClass("d-none");

            $(".question_place").html($.trim(questionTitle));

            MathJax.typeset();

        } else {

            $(".preview").addClass("d-none");

        }

    }, 2000);

}



function showAnswer(textBoxId){

    setTimeout(() => {

        var questionTitle = CKEDITOR.instances[textBoxId].getData();

        if(questionTitle.length > 0 || $(questionTitle).find('img').length > 0){

            $(".option_place").html(`<div class="ml-4"><label>Solution: </label>${$.trim(questionTitle)}</div>`);

            MathJax.typeset();

        }

    }, 2000);

}

function showAnswerWithoutEditor(textBoxId){
    $(".preview").addClass("d-none");

    setTimeout(() => {
        var selector = '#'+textBoxId;
        var questionTitle = $(selector).val();
        $(".preview").removeClass("d-none");
        $(".option_place").html(`<div class="ml-4"><label>Answer: </label>${$.trim(questionTitle)}</div>`);

    }, 2000);

}

function showAnswerVariations(textBoxId){
    $(".preview").addClass("d-none");

    setTimeout(() => {
        $(".solution_variation_place").html('');
        $(".preview").removeClass("d-none");
        let counter = 0;
        $('[id^=mta-variation-]').each(function(e, i) {
            counter++;
            let answerVariation = $(this).val();
            if(answerVariation.length > 0) {
                $(".solution_variation_place").append(`<div class="ml-4"><label>Answer Variation ${counter}: </label> ${$.trim(answerVariation)}</div>`);
            }
        })

    }, 2000);

}

/**

 * @methods to create True false option preview

 */

function trueorfalse(){

    var optionHtml = "";

    optionHtml += `<div class="custom-control custom-radio">

            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">

            <label class="custom-control-label disabled" for="customRadio1">

                <ul class="answer-list">

                    <li>a)&nbsp;</li> <li>True</li>

                </ul>

            </label>

        </div>`;

    optionHtml += `<div class="custom-control custom-radio">

            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">

            <label class="custom-control-label disabled" for="customRadio2">

                <ul class="answer-list">

                    <li>b)&nbsp;</li> <li>False</li>

                </ul>

            </label>

        </div>`;

    $(".option_place").html(optionHtml);

}



/**

 * @methods to check third party image url

 *

 */

function checkImageUrl(){

    let errorUrl = false;

    $(".question_place img").each(function(index, element){

        var imageUrl = $(element).attr("src");

        if(imageUrl.indexOf(defaultUrl) == -1){

            msgToast('warning', copiedContentError);

            errorUrl = true;

        }

    });

    $(".option_place img").each(function(index, element){

        var imageUrl = $(element).attr("src");

        if(imageUrl.indexOf(defaultUrl) == -1){

            msgToast('warning', copiedContentError);

            errorUrl = true;

        }

    });

    return errorUrl;

}



/**

 * @methods to check duplicate options string

 */

function checkDuplicateOptions(oldArray){

    var allOfTheAbove = "All of the above";

    var noneOfTheAbove = "None of the above";

    var uniqueArray = [];

    let newArray = new Array();



    // Add All of the above option to last

    let nonestr = "";

    let allstr = "";

    $.each(oldArray, function(key, data) {

        data = data.replace(/^(([(][a-zA-Z0-9]{1,3}[)]\s)|([\[][a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z]{1,3}[)]\s)|([a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z0-9]{1,3}[.][\]]\s)|([\[][a-zA-Z0-9]{1,3}[.][\]]\s)|([a-zA-Z0-9]{1,3}[.]\s)|([a-zA-Z0-9]{1,3}[.][)]\s)|[(]([a-zA-Z0-9]{1,3}[.][)]\s)|([a-zA-Z0-9]{1,3}[)]\s))/g, "");



        if(data.toLowerCase().trim() == allOfTheAbove.toLowerCase().trim())  {

            allstr = allOfTheAbove;

            delete oldArray[key];

        } else if(data.toLowerCase().trim() == noneOfTheAbove.toLowerCase().trim()){

            nonestr = noneOfTheAbove;

            delete oldArray[key];

        } else {

            newArray.push(data);

        }

    });



    allstr != "" ? newArray.push(allstr) : "";

    nonestr != "" ? newArray.push(nonestr): "";

    var error = 0;

    // Loop through array values

    for(var i = 0; i < newArray.length; i++){

        if(uniqueArray.indexOf(newArray[i].trim()) === -1) {

            uniqueArray.push(newArray[i].trim());

        } else {

            error += true;

        }

    }

    if(error > 0){

        msgToast("error", error + " duplicate options found and removed");

    }

    return uniqueArray;

}



/**

 * @methods Set question format to submit db

 */

function setQuestionFormat(questionTitle, answerTitle, answerVariation, hintTitle, extendedSolitionTitle, yearsTitle, optionData){

    let GUID = $("#s_questionId").val();

    let selectedSubtopics = null;

    if($("select[name=subtopics] option:selected").val() != ""){

        selectedSubtopics = {

            id: $("select[name=subtopics] option:selected").val(),

            subTopicName: $("select[name=subtopics] option:selected").text(),

        }

    }

    let responseData = {

        id: (GUID) ? GUID : generateGUID(),

        questionTypeId: $("select[name=question_type] option:selected").data("id"),

        questionText: questionTitle,

        questionImages: [],

        askedYears: yearsTitle,

        difficultyLevel: $("select[name=difficulty_level] option:selected").val(),

        board: {

            id: $("select[name=boards] option:selected").val(),

            boardName: $("select[name=boards] option:selected").text(),

        },

        grade: {

            id: $("select[name=grades] option:selected").val(),

            gradeName: $("select[name=grades] option:selected").text()

        },

        subject: {

          id: $("select[name=subjects] option:selected").val(),

          subjectName: $("select[name=subjects] option:selected").text()

        },

        topic: {

          id: $("select[name=topics] option:selected").val(),

          topicName: $("select[name=topics] option:selected").text()

        },

        subTopic: selectedSubtopics,

        openTags: [],

        answerBlock: {

            answer: answerTitle,

            hint: hintTitle,

            additionalAnswers: answerVariation,

            extendedSolution: extendedSolitionTitle,

            options: optionData

        },

        reviewers: [],

        noOfApproval: 0,

        questionStatus: {

            statusId: '8O0WXwZz',

            statusName: "Unapproved",

            description: "Unapproved"

        },

        creationTimeStamp: new Date(),

        creatorId: creatorId,

        questionSource: {

            contentProviderId: 'tw_tutorWand'
        
        },

        source: $("input[name=source]").val()

    };

    return JSON.stringify(responseData);

}



/**

 * @methods to Submit ajax form data

 */

function ajaxSubmit(templateData) {

    $.ajax({

        timeout: 10000,

        type: "POST",

        url: $("#submitUrl").val(),

        data: { templateData: templateData },

        dataType: "json",

        headers: {

            "X-CSRF-TOKEN": $("input[name=_token]").val()

        },

        success: function (response) {

            if(response.status){

                msgToast('success', `${response.msg}`);

                location.href = $("#redirectUrl").val();

            } else {

                var saveTxt = `<i class="hvr-buzz-out fa fa-save"></i> Save`;

                $(".submitButton").removeClass("disabled");

                msgToast('error', `${response.msg}`);

                $(".submitButton").html(saveTxt);

                return false;

            }

        },

        error: function(error){

            var saveTxt = `<i class="hvr-buzz-out fa fa-save"></i> Save`;

            $(".submitButton").removeClass("disabled");

            $(".submitButton").html(saveTxt);

            msgToast('warning', "Session timeout");

            return false;

        }

    });

}



function resetFilters(selecttype){

    var htmlGrades = `<option value=""> Select grade </option>`;

    var htmlSubject = `<option value=""> Select subject </option>`;

    var htmlTopic = `<option value=""> Select topic </option>`;

    var htmlSubtopic = `<option value=""> Select subtopic </option>`;

    switch (selecttype) {

        case "boardId":

            $(".grades").html(`${htmlGrades}`).val("").attr({"disabled" : true});

            $(".subjects").html(`${htmlSubject}`).val("").attr({"disabled" : true});

            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});

            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});

        break;

        case "gradeId":

            $(".subjects").html(`${htmlSubject}`).val("").attr({"disabled" : true});

            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});

            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});

        break;

        case "subjectId":

            $(".topics").html(`${htmlTopic}`).val("").attr({"disabled" : true});

            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});

        break;

        case "topicId":

            $(".subtopics").html(`${htmlSubtopic}`).val("").attr({"disabled" : true});

        break;

    }

}



function showPreview(formId){

    $(".question_place").html("");

    $(".option_place").html("");

    if(formId == multiChoice) {

        previewQuestion('question1');

        previewOption();

    } else if(formId == longQuestion) {

        previewQuestion('longQuestion');

        showAnswer('longAnswer');

    } else if(formId == shortQuestion) {

        previewQuestion('shortQuestions');

        showAnswer('shortAnswer');

    } else if(formId == trueOrFalse) {

        previewQuestion('TrueFalseQue');

        trueorfalse();

    } else if(formId == fillInTheBlank) {

        previewQuestion('fnb-input');

    } else if(formId == shortQuestionWMCA) {

        previewQuestion('matQuestions');
        showAnswerWithoutEditor('shortMCAAnswer');
        showAnswerVariations('mta-variation-');

    }

}



/***********************************  Methods End *********************************/



/***********************************  Events Starts *********************************/



/**

 * @event to create new option in MCQ

 */

$(document).on("click", "#addNewOption", function(e){

    var counter = $(this).parents("div").find(".mcq_options").length + 1;

    $(".putNewOption").append(`<div class="row" id="optionid${counter}">

                                    <div class="col-md-12">

                                        <div class="well2">

                                        <input tabindex="1" type="radio" id="flat-radio-mcq${counter}" name="flat-radio">

                                        <label for="flat-radio-mcq${counter}">Select correct option ${counter}</label>

                                        <a class="removeMcqOption float-right" data-rowid="optionid${counter}">

                                                    <i class="material-icons text-danger">delete</i>

                                                </a>

                                        <div class="form-group">

                                            <div class="">

                                                <textarea class="form-control mcq_options" placeholder="Option ${counter}" name="option" id="option${counter}" data-color="dddddd"></textarea>

                                            </div>

                                            <div class="option${counter}-error error"></div>

                                        </div>

                                        </div>

                                    </div>

                                </div>`);

    $(`#option${counter}`).focus();

    ckeditorPlace([`option${counter}`]);

});


/**

 * @event to create new option in Passage

 */

 $(document).on("click", ".addNewPassageOption", function(e){

    var counter = $(this).closest("div.existing-option").find(".passage_options").length + 1;

    $(this).closest("div.existing-option").find(".putNewOption").append(`<div class="row" id="optionid${counter}">

        <div class="col-md-12">

            <div class="well2">

            <input tabindex="1" type="radio" id="passage-radio-mcq${counter}" name="passage-radio">

            <label for="passage-radio-mcq${counter}">Select correct option ${counter}</label>

            <a class="removePassageOption float-right" data-rowid="optionid${counter}">

                        <i class="material-icons text-danger">delete</i>

                    </a>

            <div class="form-group">

                <div class="">

                    <textarea class="form-control passage_options" placeholder="Option ${counter}" name="passage_options${counter}[]" id="passage-option${counter}" data-color="dddddd"></textarea>

                </div>

                <div class="option${counter}-error error"></div>

            </div>

            </div>

        </div>

    </div>`);

    $(`#passage-option${counter}`).focus();

    ckeditorPlace([`passage-option${counter}`]);

});


/**

 * @event of smart paste all option

 */

$(document).on("paste", "#smart_paste", function(e) {

    var index = 0;

    var replacetext = e.originalEvent.clipboardData.getData( "Text" ).replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");

    var testtext = replacetext.split("$$");

    var inputLength = $(`textarea[name="name[]"]`).length;

    if(testtext.length > 0){

        var count = 0;

        $.each(testtext, function(index, val) {

            if(val.length > 1) {

                count++;

                let newValue = val.replace(/^(([(][a-zA-Z0-9]{1,3}[)]\s)|([\[][a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z]{1,3}[)]\s)|([a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z0-9]{1,3}[.][\]]\s)|([\[][a-zA-Z0-9]{1,3}[.][\]]\s)|([a-zA-Z0-9]{1,3}[.]\s)|([a-zA-Z0-9]{1,3}[.][)]\s)|[(]([a-zA-Z0-9]{1,3}[.][)]\s)|([a-zA-Z0-9]{1,3}[)]\s))/g, "");

                if($(`#option${count}`)[0]) {

                    $(`#option${count}`).val($.trim(newValue));

                    CKEDITOR.instances[`option${count}`].setData($.trim(newValue));

                } else if($(`#option${count}`)[0] == undefined) {

                    $(`.putNewOption`).append(`<div class="row" id="optionid${count}">

                                    <div class="col-md-12">

                                        <div class="well2">

                                        <input tabindex="1" type="radio" id="flat-radio-mcq${count}" name="flat-radio">

                                        <label for="flat-radio-mcq${count}">Select correct option ${count}</label>

                                        <a class="removeMcqOption float-right" data-rowid="optionid${count}">

                                            <i class="material-icons text-danger">delete</i>

                                        </a>

                                        <div class="form-group">

                                            <div class="input-group">

                                                <textarea class="form-control mcq_options" placeholder="Option ${count}" name="option" id="option${count}" onpaste="return true">${$.trim(newValue)}</textarea>

                                            </div>

                                            <div class="option${count}-error error"></div>

                                        </div>

                                        </div>

                                    </div>

                                </div>`);

                    ckeditorPlace([`option${count}`]);

                    CKEDITOR.instances[`option${count}`].setData($.trim(newValue));

                }

                previewOption();

            }

        });

    }

});



/**

 * @event on change filters value reset required class

 */

$(document).on("change", ".subtopics, .difficulty_level, .source, .boards, .grades, .subjects, .topics, .subtopics", function(){

    if($(this).val() != ""){

        $(this).removeClass("required-error");

    }

    if($(this).hasClass('boards')){
        if($('.boards option:selected').text() == 'SAT'){
            $(".question_type").children('option').hide();
            $(".question_type").children("option[value^='multi-choice']").show()
            $(".question_type").children("option[value^='short-question-with-multiple-correct-answers']").show()
            $('.question_type>option[value="multi-choice"]').prop('selected') ? $('.question_type>option[value="multi-choice"]').prop('selected', true) : $('.question_type>option[value="multi-choice"]').prop('selected', true);
            $('.question_type>option[value="short-question-with-multiple-correct-answers"]').prop('selected') ? $('.question_type>option[value="short-question-with-multiple-correct-answers"]').prop('selected', true) : $('.question_type>option[value="multi-choice"]').prop('selected', true);
            $('.question_type').trigger("change");
        } else {
            $(".question_type").children('option').show();
            $(".question_type").children("option[value^='short-question-with-multiple-correct-answers']").hide()
        }
    }

});



/**

 * @event on change filters to get subjects , topics and subtopics

 */

$(document).on("change", ".onChangeSelect", function(){

    var type = $(this).data("type");

    var selecttype = $(this).data("selecttype");

    var value = $(this).val();

    var boardId = $(".boards option:selected").val();

    var gradeId = $(".grades option:selected").val();

    var subjectId = $(".subjects option:selected").val();

    var topicId = $(".topics option:selected").val();

    var subtopicId = $(".subtopics option:selected").val();



    resetFilters(selecttype);

    

    if(boardId != ""){

        $.ajax({

            type: "GET",

            url: $("#selectFilterUrl").val(),

            data: { "type": type , "selecttype": selecttype, "boardId":boardId, "gradeId":gradeId, "subjectId": subjectId, "topicId": topicId , "subtopicId": subtopicId },

            dataType: "html",

            success: function (response) {

                $(`.${type}`).html(response);

                $(`.${type}`).attr({ "disabled": false });

            }

        });

    }

});



/**

 * @event to remove MCQ options

 */

$(document).on("click",".removeMcqOption", function(){

    var id = $(this).data("rowid");

    $(`#${id}`).remove();

    $("#fnb-input").val("");

    previewOption();

});

/**

 * @event to remove Passage options

 */
 $(document).on("click", ".removePassageOption", function(){

    var id = $(this).data("rowid");

    $(`#${id}`).remove();

    $("#fnb-input").val("");

    previewOption();

});


/**

 * @event to add Blank Space in Fillup questions

 */

$(document).on("click", "#add-blank", function () {

    var cursorPos = $("#fnb-input").prop("selectionStart");

    var editor = CKEDITOR.instances["fnb-input"];

    var v = $("#fnb-input").val();

    var textBefore = v.substring(0, cursorPos);

    var textAfter = v.substring(cursorPos, v.length);



    $("#fnb-input").val(textBefore + " __________ " + textAfter);

    editor.insertHtml(" __________ ");

    runloop();

});



/**

 * @event select question type

 */

$(document).on("change", ".question_type", function() {

    $(".select_area").each(function(index, value) {

        $(value).addClass("d-none");

    })

    var value = $(this).val();

    var id = $(".question_type option:selected").attr("data-id");

    $(".submitButton").attr({ "data-id":  `${value}-form`});

    $("#" + value).removeClass("d-none");

    $("div.preview").addClass("d-none");

    $(".question_place").html("");

    $(".option_place").html("");

    showPreview(value);

});



/**

 * @event on load page

 */

$(document).ready(function(){

    var selected_questionType = ($("#s_questionTypeId").val()) ? $("#s_questionTypeId").val() : "529kWMwg";

    $(".select_area").each(function(index, selector) {

        $(selector).addClass("d-none");

    })

    if(selected_questionType != ""){

        var value = $("select.question_type").find(`option[data-id=${selected_questionType}]`).val();

        $(".submitButton").attr({ "data-id":  `${value}-form`});

        $("#" + value).removeClass("d-none");

    }



    $(".select_area").each(function (index, selector) {

        $(selector).addClass("d-none");

    })

    var value = $(".question_type").val();

    $("#" + value).removeClass("d-none");

});



/**

 * @event for scratch paid clear

 */

$(document).on("click", ".clear-btn", function() {

    $("#clear-data").html(" ");

});



/**

 * @event to submit form button

 */

$(document).on("click",".submitButton", function(){

    let dataId = $(this).attr("data-id");

    let spinner = `<span class="spinner-border spinner-border-sm"></span> Save`;

    let saveTxt = `<i class="hvr-buzz-out fa fa-save"></i> Save`;

    let questionTitle = ""

    let answerTitle = "";

    let optionData = [];

    let extendedSolitionTitle = "";

    let yearsTitle = "";

    let hintTitle = "";

    $(this).addClass("disabled");

    $(this).html(spinner);

    let submitError = true;

    if (!formValidation(dataId)) {

        submitError = false;

        $(this).removeClass("disabled");

        $(this).html(saveTxt);

        return false;

    }

    if(!filterValidations()){

        msgToast("warning", selectFilterMsg);

        submitError = false;

        $(this).removeClass("disabled");

        $(this).html(saveTxt);

        return false;

    }

    if(checkImageUrl()){

        submitError = false;

        $(this).removeClass("disabled");

        $(this).html(saveTxt);

        return false;

    }

    let answerVariation = [];

    if(dataId == `${multiChoice}-form`){

        questionTitle = CKEDITOR.instances[`question1`].getData();

        extendedSolitionTitle = CKEDITOR.instances[`extendedsolution1`].getData();

        hintTitle = CKEDITOR.instances[`hint1`].getData();

        optionData = getMcqOptions();

        yearsTitle = $('input[name=year1]').val() != "" ? $('input[name=year1]').val().split(',') : [];

        if(!optionData){

            $(".submitButton").removeClass("disabled");

            $(".submitButton").html(saveTxt);

            return false;

        }

    }

    if(dataId == `${trueOrFalse}-form`){

        questionTitle = CKEDITOR.instances[`TrueFalseQue`].getData();

        extendedSolitionTitle = CKEDITOR.instances[`extendedsolution2`].getData();

        hintTitle = CKEDITOR.instances[`hint2`].getData();

        optionData = trueOrFalseOptions();

        yearsTitle = $('input[name=year2]').val() != "" ? $('input[name=year2]').val().split(',') : [];

    }

    if(dataId == `${fillInTheBlank}-form`){

        questionTitle = CKEDITOR.instances[`fnb-input`].getData();

        extendedSolitionTitle = CKEDITOR.instances[`extendedsolution3`].getData();

        hintTitle = CKEDITOR.instances[`hint3`].getData();

        optionData = getFillUpOptions();

        yearsTitle = $('input[name=year3]').val() != "" ? $('input[name=year3]').val().split(',') : [];

    }

    if(dataId == `${longQuestion}-form`){

        questionTitle = CKEDITOR.instances[`longQuestion`].getData();

        answerTitle = CKEDITOR.instances[`longAnswer`].getData();

        hintTitle = CKEDITOR.instances[`hint4`].getData();

        yearsTitle = $('input[name=year4]').val() != "" ? $('input[name=year4]').val().split(',') : [];

    }

    if(dataId == `${shortQuestion}-form`){

        questionTitle = CKEDITOR.instances[`shortQuestions`].getData();

        answerTitle = CKEDITOR.instances[`shortAnswer`].getData();

        hintTitle = CKEDITOR.instances[`hint5`].getData();

        yearsTitle = $('input[name=year5]').val() != "" ? $('input[name=year5]').val().split(',') : [];;

    }

    if(dataId == `${shortQuestionWMCA}-form`){

        questionTitle = CKEDITOR.instances[`matQuestions`].getData();

        answerTitle = $(`#shortMCAAnswer`).val();

        $('[id^=mta-variation-]').each(function() {
            let idSelector = $(this).attr('id');
            // answerVariation.push(CKEDITOR.instances[idSelector].getData());
            answerVariation.push($(this).val());
        })

        extendedSolitionTitle = CKEDITOR.instances[`mat-extendedsolution`].getData();

        hintTitle = CKEDITOR.instances[`hint6`].getData();

        yearsTitle = $('input[name=year6]').val() != "" ? $('input[name=year6]').val().split(',') : [];

        // Check duplications

    }

    if(submitError) {
        var jsonData = setQuestionFormat(questionTitle, answerTitle, answerVariation, hintTitle, extendedSolitionTitle, yearsTitle, optionData);
        ajaxSubmit(jsonData);
    }

});



/**

 * @event on select True or False option

 */

$(document).on("change",".trueorfalse", function(){

    trueorfalse();

});



CKEDITOR.on("instanceReady", function(event) {

    let questionPreviewArray = ["question1", "longQuestion", "shortQuestions", "TrueFalseQue", "fnb-input"];

    let optionPreviewArray = ["option1", "option2", "option3", "option4"];

    event.editor.on("blur", function (ev) {

        if($.inArray(ev.editor.name.trim(), questionPreviewArray) != -1){

            previewQuestion(ev.editor.name);

        }



        if(ev.editor.name == "longAnswer" || ev.editor.name == "shortAnswer"){

            showAnswer(ev.editor.name);

        }

        if(ev.editor.name.indexOf('input-') != -1) {

            previewFillUpsOption();

        }

    });



    event.editor.on("change", function (ev) {

        if($.inArray(ev.editor.name.trim(), questionPreviewArray) != -1){

            previewQuestion(ev.editor.name);

        }



        if(ev.editor.name == "longAnswer" || ev.editor.name == "shortAnswer"){

            showAnswer(ev.editor.name);

        }

        if(ev.editor.name.indexOf('input-') != -1) {

            previewFillUpsOption();

        }

    });

});



// Editor on change option preview

if($('#option4').html() != undefined){

    CKEDITOR.instances["option1"].on("change", function(e) {

        previewOption();

    });

    CKEDITOR.instances["option2"].on("change", function(e) {

        previewOption();

    });



    CKEDITOR.instances["option3"].on("change", function(e) {

        previewOption();

    });



    CKEDITOR.instances["option4"].on("change", function(e) {

        previewOption();

    });

}



// Editor on blur editor option preview

if($('#option4').html() != undefined){

    CKEDITOR.instances["option1"].on("blur", function(e) {

        previewOption();

    });

    CKEDITOR.instances["option2"].on("blur", function(e) {

        previewOption();

    });



    CKEDITOR.instances["option3"].on("blur", function(e) {

        previewOption();

    });



    CKEDITOR.instances["option4"].on("blur", function(e) {

        previewOption();

    });

}



/**

* @event Ckeditor on change values - Start

*/

CKEDITOR.instances["fnb-input"].on("change", function(e) {

    $(".preview").removeClass("d-none");

    runloop();

    var position = $(this).getCursorPosition();

    var deleted = "";

    var val = CKEDITOR.instances["fnb-input"].getData();

    $(".question_place").html(val);



    if (e.which != 8) {

        return true;

    }



    if (position[0] != position[1]) {

        return true;

    }



    if (position[0] <= 0) {

        return true;

    }



    let charToDelete = val.substr(position[0] - 1, 1);

    if (charToDelete == " ") {

        return true;

    }



    let nextChar = val.substr(position[0], 1);



    if (nextChar == " " || nextChar == "") {

        start = position[0];

        end = position[0];

        while (val.substr(start - 1, 1) != " " && start - 1 >= 0) {

            start -= 1;

        }

        

        e.preventDefault();

        $(this).setCursorPosition(start, end);

    }

});



CKEDITOR.on("instanceCreated", function (e) {

    e.editor.on("change", function (ev) {

        if(ev.editor.name.indexOf('option') != -1) {

            previewOption();

        }

    });

});



/**

 * @script to paste options on click paste button

 */

const readBtn = document.querySelector(".paste_me");

readBtn.addEventListener("click", () => {

    navigator.clipboard.readText()

    .then(copiedText => {

        $(".removeMcqOption").click();

        var replacetext = copiedText.replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");

        var testtext = replacetext.split("$$");

        var inputLength = $(`textarea[name="name[]"]`).length;

        if(testtext.length > 0){

            testtext = checkDuplicateOptions(testtext);

            var count = 0;

            $.each(testtext, function(index, val) {

                if(val.length > 0 ){

                    count++;

                    let newValue = val.replace(/^(([(][a-zA-Z0-9]{1,3}[)]\s)|([\[][a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z]{1,3}[)]\s)|([a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z0-9]{1,3}[.][\]]\s)|([\[][a-zA-Z0-9]{1,3}[.][\]]\s)|([a-zA-Z0-9]{1,3}[.]\s)|([a-zA-Z0-9]{1,3}[.][)]\s)|[(]([a-zA-Z0-9]{1,3}[.][)]\s)|([a-zA-Z0-9]{1,3}[)]\s))/g, "");

                    if($(`#option${count}`)[0]) {

                        $(`#option${count}`).val($.trim(newValue));

                        CKEDITOR.instances[`option${count}`].setData($.trim(newValue));

                    } else if($(`#option${count}`)[0] == undefined) {

                        $(`.putNewOption`).append(`<div class="row" id="optionid${count}"><div class="col-md-12"><div class="well2"><input tabindex="1" type="radio" id="flat-radio-mcq${count}" name="flat-radio"><label for="flat-radio-mcq${count}">Select correct option ${count}</label><a class="removeMcqOption float-right" data-rowid="optionid${count}"><i class="material-icons text-danger">delete</i></a><div class="form-group"><div class=""><textarea class="form-control mcq_options" placeholder="Option ${count}" name="option" id="option${count}" data-color="dddddd">${$.trim(newValue)}</textarea></div><div class="option${count}-error error"></div></div></div></div></div>`);

                        ckeditorPlace([`option${count}`]);

                        CKEDITOR.instances[`option${count}`].setData($.trim(newValue));

                    }

                    previewOption();

                }

            });

        }

    })

    .catch(err => {

        console.log("Something went wrong", err);

    })

});



$(document).ready(function(){

    setTimeout(() => {

        let questionText = $('#questionText').val();

        if(questionText){

            $(".preview").removeClass("d-none");

            $(".question_place").html(questionText);

        }

        if($('.question_type').val() == multiChoice){

            previewOption();

        } else if($('.question_type').val() == longQuestion){

            showAnswer('longAnswer');

        }else if($('.question_type').val() == shortQuestion){

            showAnswer('shortAnswer');

        } else if($('.question_type').val() == trueOrFalse){

            trueorfalse();

        } else if($('.question_type').val() == fillInTheBlank){

            $(".fillups").each(function(index,value){

                var datdId = $(value).attr('id');

                ckeditorPlace([datdId]);

            });

        } else if($('.question_type').val() == shortQuestionWMCA){

            // $(".mta-variations").each(function(index,value){

                // var datdId = $(value).attr('id');

                // ckeditorPlace([datdId]);

            // });

            // showAnswer('matAnswer');
            previewQuestion('matQuestions');
            showAnswerWithoutEditor('shortMCAAnswer');
            showAnswerVariations('mta-variation-');

        }

    }, 5000);

    toastr.options.titleClass = true;

    toastr.options.preventDuplicates = true;

});


$(document).on('click', '#add-answer-variation', function() {
    let count = $('.variation-row:last').find('.mta-variations').length ? Number($('.variation-row:last').find('.mta-variations').data('count'))+1 : 0;
   
    if($('.variation-row').find('.mta-variations').length < 10) {
        $('.answervariations').append(`<div class="row variation-row">
            <div class="col-md-12">
                <div class="form-group block">
                    <div class="form-group">
                        <label>Answer Variation*</label>
                        <!-- <textarea data-count="${count}" class="form-control mta-variations" name="variation_short_answer[]" placeholder="Answer Variation" id="mta-variation-${count}"></textarea> -->
                        <input type="text" data-count="${count}" class="form-control mta-variations" name="variation_short_answer[]" placeholder="Answer Variation*" id="mta-variation-${count}" />
                        <a class="remove-variations float-right" data-rowid="optionid${count}">
                            <i class="material-icons text-danger">delete</i>
                        </a>
                    </div>
                    <div class="mta-variations-error-${count} text-danger"></div>
                </div>
            </div>
        </div>`);
        // var datdId = `mta-variation-${count}`;
        // ckeditorPlace([datdId]);
        showPreview(shortQuestionWMCA);
    } else {
        msgToast("error", " Max 10 answer variations allowed");
    }

});

$(document).on('click', '.remove-variations', function() {
    $(this).closest('.variation-row').remove();
    showPreview(shortQuestionWMCA);
})

// Because of scope we are implementing this for SAT only considering this will come for SAT only
$(document).on('keyup', '.mta-variations', function(e) {
    let currentEvent = $(this);
    let insertVal = $(this).val();
    let maxLength = 5;
    let is_valid = true;
    let max_limit_issue = false;
    let invalid_data = false;
    // console.log(e.which, typeof e.which);
    let allowedEventKey = [8,9,16,37,38,39,40,45,46,47,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,109,110,111,189,190,191];
    if(allowedEventKey.includes(e.which)) {
        $(this).closest('.block').find('div[class^="mta-variations-error-"]').text('')
        
        if(insertVal.startsWith(".") || insertVal.startsWith("-")) {
            maxLength = 6;
        }
        
        const is_decimal = (insertVal.indexOf('.') > -1) ? true : false;
        const is_negative = (insertVal.indexOf('-') > -1) ? true : false;
        const is_slash = (insertVal.indexOf('/') > -1) ? true : false;

        // check single . occurence
        if(countString(insertVal, '.') > 1) {
            is_valid = false;
            invalid_data = true;
        }

        // check single - occurence
        if(countString(insertVal, '-') > 1) {
            is_valid = false;
            invalid_data = true;
        }

        // check single / occurence
        if(countString(insertVal, '/') > 1) {
            is_valid = false;
            invalid_data = true;
        }

        // Valdiation 1: if positive numeric only max length is 5
        if(!is_decimal && !is_slash && !is_negative) {
            if(insertVal.length > 5) {
                is_valid = false;
                max_limit_issue = true;
            }
            if (parseInt(insertVal) < 0 || parseInt(insertVal) > 99999) {
                is_valid = false;
                max_limit_issue = true;
            }
        }

        // Validation 2: If it contains decimal value
        if(is_decimal){
            if(insertVal.length < 0 || insertVal.length > maxLength){
                is_valid = false;
                max_limit_issue = true;
            }

            // after decimal slash and negative not allowed
            if(insertVal.indexOf('/') > -1){
                is_valid = false;
                invalid_data = true;
            }
        }

        // Validation 3: If it contains negative value
        if(is_negative){
            if(insertVal.substring(0, 1) === '-') {
                if(insertVal.length < 0 || insertVal.length > maxLength){
                    is_valid = false;
                    max_limit_issue = true;
                }
            } else {
                is_valid = false;
                invalid_data = true;
            }
        }

        // Validation 4: If it contains / value
        if(is_slash){
            if(insertVal.substring(0, 1) === '/') {
                is_valid = false;
                invalid_data = true;
            } else {
                let numbers = insertVal.split("/");
                // Store values before and after the slash, then display them 
                let beforeSlash = numbers[0]; 
                let afterSlash = numbers[1];

                if(beforeSlash.length + afterSlash.length > maxLength ) {
                    is_valid = false;
                    max_limit_issue = true;
                }
            }

            // after decimal slash and negative not allowed
            if(insertVal.indexOf('-') > -1 || insertVal.indexOf('.') > -1){
                is_valid = false;
                invalid_data = true;
            }
        }
    } else {
        is_valid = false;
        invalid_data = true;
    }


    if(!is_valid) {
        if(max_limit_issue) {
            $(this).closest('.block').find('div[class^="mta-variations-error-"]').text('Max limit exceed')
        }
        if(invalid_data) {
            $(this).closest('.block').find('div[class^="mta-variations-error-"]').text('Invalid data')
        }
        $(currentEvent).val(insertVal.slice(0, -1));
    }
})


$(document).on('change', '.mta-variations', function(e) {
    showPreview(shortQuestionWMCA);
});

CKEDITOR.instances['matQuestions'].on('change', function() {
    showPreview(shortQuestionWMCA);
})
// program to check the number of occurrence of a character

function countString(str, letter) {
    let count = 0;

    // looping through the items
    for (let i = 0; i < str.length; i++) {

        // check if the character is at that position
        if (str.charAt(i) == letter) {
            count += 1;
        }
    }
    return count;
}