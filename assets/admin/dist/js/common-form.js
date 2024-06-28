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

    // $(document).on("change", ".question_type", function() {
    //     $(".select_area").each(function(index, selector) {
    //         $(selector).addClass("d-none");
    //     })
        
    //     let value = $(this).val();
    //     if(value.includes('passage') === true) {
    //         $("#passage").removeClass("d-none");
    //         $('#add-passage-mcq').click();
    //         console.log('here')
    //     } else {
    //         $("#" + value).removeClass("d-none");
    //         $('#passage-form').html('')
    //     }
    // });

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
        $(this).closest('.accordion').remove();

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
        for (let i = command.length; i >= 0; i--) {
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



let config = {

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
        // Ths will remove the conflict
        let editorInstance = CKEDITOR.instances[element];
        if (editorInstance) {
            editorInstance.destroy();
        }

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

    let el = $(this).get(0);

    let pos = 0;

    let posEnd = 0;

    if ("selectionStart" in el) {

        pos = el.selectionStart;

        posEnd = el.selectionEnd;

    } else if ("selection" in document) {

        el.focus();

        let Sel = document.selection.createRange();

        let SelLength = document.selection.createRange().text.length;

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

        let optionId = index+1;

        isTrue = $(selector).parents("div.well2").find("input[type=radio]").is(":checked");

        let optTitle = CKEDITOR.instances[`option${optionId}`].getData();

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

    let uniqueArray = [];

    let error = 0;

    // Loop through array values

    for(let i = 0; i < oldArray.length; i++){

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

        let optTitle = CKEDITOR.instances[`${dataId}`].getData();

        let optionId = index+1;

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

        let optionId = index+1;

        let isTrue = $(selector).is(":checked");

        let optTitle = $(selector).val();

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

    let id = "";

    let string = "";

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

    let questionTitle = CKEDITOR.instances[`question1`].getData();

    let error = 0;

    if(questionTitle.length == 0 && $(questionTitle).find('img').length == 0){

        $(".question1-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".question1-error").html("");

        error += false;

    }

    

    $("textarea[name=option]").each(function(index, selector){

        let optionId = $(selector).attr("id");

        let isTrue = $(selector).parents("div.input-group").find("input[type=radio]").is(":checked");

        let optTitle = CKEDITOR.instances[`${optionId}`].getData();

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

        let dataId = $(value).attr('id');

        let dataVal = CKEDITOR.instances[`${dataId}`].getData();

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

    let questionTitle = CKEDITOR.instances[`TrueFalseQue`].getData();

    let error = 0;

    if(questionTitle.length == 0){

        $(".TrueFalseQue-error").html(`<span>${enterQuestion}</span>`);

        error += true;

    } else {

        $(".TrueFalseQue-error").html("");

        error += false;

    }



    let isChecked = false;

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

    let questionTitle = CKEDITOR.instances[`shortQuestions`].getData();

    let answerTitle = CKEDITOR.instances[`shortAnswer`].getData();

    let error = 0;

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

    let questionTitle = CKEDITOR.instances[`longQuestion`].getData();

    let answerTitle = CKEDITOR.instances[`longAnswer`].getData();

    let error = 0;

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
    let questionTitle = CKEDITOR.instances[`matQuestions`].getData();
    let extendedSolution = CKEDITOR.instances[`mat-extendedsolution`].getData();
    let answerTitle = $(`#shortMCAAnswer`).val();
    
    let error = 0;
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
    let hasDuplicates = false;
    let arrInp = [];
    let set = new Set();
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

            let optionChecked = false;

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

    // unseen passage validations
    if(dataId.indexOf('unseen-passage_') != -1){
        return unseenPassageValidation(dataId);
    }

    if(dataId == `multi-select-form`){
        return multipleSelectValidation();
    }

    if(dataId == `multiple-blanks-form`){
        return multipleBlankValidation()
    }
    return true;

}



/**

 * @methods to Validate Selected Filters

 */

function filterValidations(){

    let question_type = $("select[name=question_type] option:selected").val();

    let boards = $("select[name=boards] option:selected").val();

    let grades = $("select[name=grades] option:selected").val();

    let source = $("input[name=source]").val();

    let topics = $("select[name=topics] option:selected").val();

    let subjects = $("select[name=subjects] option:selected").val();

    let subtopics = $("select[name=subtopics] option:selected").val();

    let difficulty_level = $("select[name=difficulty_level] option:selected").val();

    let error = false;

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

    let date = new Date();



    let day = (date.getDate() < 10 ? "0" : "") + date.getDate();

    let month = (date.getMonth() < 9 ? "0" : "") + (date.getMonth() + 1);

    let year = date.getFullYear();



    let hours = ((date.getHours() % 12 || 12) < 10 ? "0" : "") + (date.getHours() % 12 || 12);

    let minutes = (date.getMinutes() < 10 ? "0" : "") + date.getMinutes();

    let meridiem = date.getSeconds();



    let currentDateTime = year + "-" + month + "-" + day +"T"+ hours + ":" + minutes + ":" + meridiem + ".193Z";

    return currentDateTime;

}



/**

 * @methods to create MCQ Option previews

 */

function previewOption(){
    let optionHtml = "";

    if($('button.submitButton').attr('data-id') !== 'multi-select-form') {
        setTimeout(() => {

            $("textarea[name=option]").each(function(index, value){

                let optionId = index+1;

                let isTrue = $(value).parents("div.well2").find("input[type=radio]").is(":checked");

                let checked = "";

                let optionTitle = CKEDITOR.instances[`option${optionId}`].getData();

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

}



function previewFillUpsOption(){
    let optionHtml = "";

    $("textarea.fillups").each(function(index, value){

        let optionId = index+1;

        let optionTitle = CKEDITOR.instances[`input-${index}`].getData();

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

        let questionTitle = CKEDITOR.instances[textBoxId].getData();

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

        let questionTitle = CKEDITOR.instances[textBoxId].getData();

        if(questionTitle.length > 0 || $(questionTitle).find('img').length > 0){

            $(".option_place").html(`<div class="ml-4"><label>Solution: </label>${$.trim(questionTitle)}</div>`);

            MathJax.typeset();

        }

    }, 2000);

}

function showAnswerWithoutEditor(textBoxId){
    $(".preview").addClass("d-none");
    setTimeout(() => {
        let selector = '#'+textBoxId;
        let questionTitle = $(selector).val();
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

    let optionHtml = "";

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

        let imageUrl = $(element).attr("src");

        if(imageUrl.indexOf(defaultUrl) == -1){

            msgToast('warning', copiedContentError);

            errorUrl = true;

        }

    });

    $(".option_place img").each(function(index, element){

        let imageUrl = $(element).attr("src");

        if(imageUrl.indexOf(defaultUrl) == -1){

            msgToast('warning', copiedContentError);

            errorUrl = true;

        }

    });

    /** Code check passage image */
    $('div[class^="question-passage-preview-"]').each((ind, selec) => {
        $(selec).find('img').each(function(index, element){
            let imageUrl = $(element).attr("src");
            if(imageUrl.indexOf(defaultUrl) == -1){
                msgToast('warning', copiedContentError + 'for passage');
                errorUrl = true;
            }
        });
    })

    /** Code check passage question image */
    $('div[class^="question-preview-"]').each((ind, selec) => {
        $(selec).find('img').each(function(index, element){
            let imageUrl = $(element).attr("src");
            if(imageUrl.indexOf(defaultUrl) == -1){
                msgToast('warning', copiedContentError + 'for question ' + ind);
                errorUrl = true;
            }
        });
    })

    /** Code check passage option image */
    $('div[class^="question-option-preview-"]').each((ind, selec) => {
        $(selec).find('img').each(function(index, element){
            let imageUrl = $(element).attr("src");
            if(imageUrl.indexOf(defaultUrl) == -1){
                msgToast('warning', copiedContentError + ' for options');
                errorUrl = true;
            }
        });
    })
    return errorUrl;

}



/**

 * @methods to check duplicate options string

 */

function checkDuplicateOptions(oldArray){

    let allOfTheAbove = "All of the above";

    let noneOfTheAbove = "None of the above";

    let uniqueArray = [];

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

    let error = 0;

    // Loop through array values

    for(let i = 0; i < newArray.length; i++){

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

            contentProviderId: $('#contentProviderId').val()
        
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
        timeout: 30000,
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
                let saveTxt = `<i class="hvr-buzz-out fa fa-save"></i> Save`;
                $(".submitButton").removeClass("disabled");
                msgToast('error', `${response.msg}`);
                $(".submitButton").html(saveTxt);
                return false;
            }
        },
        error: function(error){
            let saveTxt = `<i class="hvr-buzz-out fa fa-save"></i> Save`;
            $(".submitButton").removeClass("disabled");
            $(".submitButton").html(saveTxt);
            msgToast('warning', "Session timeout");
            console.log(error)
            return false;
        }

    });

}



function resetFilters(selecttype){

    let htmlGrades = `<option value=""> Select grade </option>`;

    let htmlSubject = `<option value=""> Select subject </option>`;

    let htmlTopic = `<option value=""> Select topic </option>`;

    let htmlSubtopic = `<option value=""> Select subtopic </option>`;

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

    let counter = $(this).parents("div").find(".mcq_options").length + 1;

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

 * @event of smart paste all option

 */

$(document).on("paste", "#smart_paste", function(e) {

    let index = 0;

    let replacetext = e.originalEvent.clipboardData.getData( "Text" ).replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");

    let testtext = replacetext.split("$$");

    let inputLength = $(`textarea[name="name[]"]`).length;

    if(testtext.length > 0){

        let count = 0;

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

    let type = $(this).data("type");

    let selecttype = $(this).data("selecttype");

    let value = $(this).val();

    let boardId = $(".boards option:selected").val();

    let gradeId = $(".grades option:selected").val();

    let subjectId = $(".subjects option:selected").val();

    let topicId = $(".topics option:selected").val();

    let subtopicId = $(".subtopics option:selected").val();



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

    let id = $(this).data("rowid");

    $(`#${id}`).remove();

    $("#fnb-input").val("");

    previewOption();

});

/**
 * @event to remove Passage options
 */
 $(document).on("click", ".removePassageOption", function(){
    const event = $(this)
    const parentSelector = $(this).closest('.putNewOption');
    let id = $(this).data("rowid");
    let sno = parseInt(id.split('-')[1])
    $(`#${id}`).remove();
    $(event).closest('.row').remove()

    // Reset all options
    let count = 5;
    $(parentSelector).find('.row').each(function(index, row) {
        let textareaId = $(row).find('textarea').attr('id')
        let editorInstance = CKEDITOR.instances[textareaId];
        if (editorInstance) {
            editorInstance.destroy();
            $(row).attr('id', 'optionid'+count);
            $(row).find('input[type="radio"]').attr({name: "passage-radio-mcq-"+sno, value: count });
            $(row).find('input[type="radio"]').attr({id: "passage-radio-mcq"+count+"-"+sno, value: count });
            $(row).find('label').attr('for', 'passage-radio-mcq'+count+"-"+sno);
            $(row).find('label').text('Select correct option '+count);
            $(row).find('textarea').attr({'placeholder': 'Option '+count, 'name': 'passage_options'+count+'[]', 'id': 'passage-option'+count+'-'+sno});
            $(row).find('.error').attr('class', 'option'+count+'-error error');
            $(row).find('.removePassageOption').attr('data-rowid', 'passage-option'+count+"-"+sno);
            count++;
        }
    })
    initalizeTextAreaWithCKEditor();
    previewPassageOption(id.replace(/(\d+)(-\d+)/, (_, number, rest) => `${parseInt(number) - 1}${rest}`))
});

/**
 * @event to remove Passage Checkbox options
 */
$(document).on("click", ".removePassageCheckboxOption", function(){
    const event = $(this)
    const parentSelector = $(this).closest('.putNewCheckboxOption');

    // Show Add more options
    $(event).closest('.existing-option').find('.addNewCheckboxOption').show();

    let id = $(event).data("rowid");
    let sno = parseInt(id.split('-')[1])
    $(`#${id}`).remove();
    $(event).closest('.row').remove()

    // Reset all options
    let count = 4;
    $(parentSelector).find('.row').each(function(index, row) {
        let textareaId = $(row).find('textarea').attr('id')
        let editorInstance = CKEDITOR.instances[textareaId];
        if (editorInstance) {
            editorInstance.destroy();
            $(row).attr('id', 'optionid'+count);
            $(row).find('input[type="checkbox"]').attr({name: "passage-checkbox-mcs"+count+"-"+sno, value: count });
            $(row).find('label').attr('for', 'passage-checkbox-mcs'+count+"-"+sno);
            $(row).find('label').text('Select correct option '+count);
            $(row).find('textarea').attr({'placeholder': 'Option '+count, 'name': 'passage_options'+count+'[]', 'id': 'passage-option'+count+'-'+sno});
            $(row).find('.error').attr('class', 'option'+count+'-error error');
            $(row).find('.removePassageCheckboxOption').attr('data-rowid', 'passage-option'+count+'-'+sno);
            count++;
        }
    })
    initalizeTextAreaWithCKEditor()
    // previewOption();
    let textBoxId = $('.existing-option').find('textarea:first').attr('id')
    previewPassageOption(textBoxId) 
});

/**

 * @event to add Blank Space in Fillup questions

 */

$(document).on("click", "#add-blank", function () {

    let cursorPos = $("#fnb-input").prop("selectionStart");

    let editor = CKEDITOR.instances["fnb-input"];

    let v = $("#fnb-input").val();

    let textBefore = v.substring(0, cursorPos);

    let textAfter = v.substring(cursorPos, v.length);



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

    const value = $(this).val();
    const questionTypeId = $(this).find(':selected').data('id')
    if(value === 'multi-select' || value === 'multiple-blanks') { // For MSQ and multiple blanks
        $("#other-types").removeClass("d-none");
        const sno = 0;
        $.ajax({
            timeout: 10000,
            type: "POST",
            url: $('#get-template-url').val(),
            data: {sno: sno, questionType: questionTypeId, isPassage: false},
            dataType: "html",
            headers: {
                "X-CSRF-TOKEN": $("input[name=_token]").val()
            },
            success: function (response) {
                $('#other-types').html(response)
                initalizeTextAreaWithCKEditor()

                $(`input[name="msq_year"]`).amsifySuggestags({
                    suggestions: yearsTags,
                    whiteList: true
                });
                
                // reset preview
                // CKEDITOR.instances['passage1'].getData().length <= 0 && $(`.question-passage-preview-${sno}`).html('')
                // $(`.question-preview-${sno}`).html('')
                // $(`.question-option-preview-${sno}`).html('')
            },
            error: function(error){
            }
        })

    } else if(value.includes('passage') === true) { // For unseen-passage
        $("#passage").removeClass("d-none");
        $("#other-types").addClass("d-none");

        const matches = $(this).val().match(/\d+$/);
        $('#passage-card').html('');
        if (matches) {
            for (let i = 0; i < parseInt(matches[0]); i++) {
                $('#passage-card').append(`<div class="question-section-${i} question-section" data-id="${i}">
                    <button type="button" class='btn btn-info' id="add-question-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="hvr-buzz-out fa fa-plus"></i> Add New Question ${i+1}</button>
                    <div class="dropdown-menu" aria-labelledby="add-question-type" style="height: auto">
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="529kWMwg" href="javascript:void(0)">Multi choice</a>
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="kc8fmydg" href="javascript:void(0)">Multi select</a>
                        <!-- <a data-id="${i}" class="dropdown-item passage-question-type" data-type="4NcrZAcU" href="javascript:void(0)">True or false</a>
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="Tqg3XB1M" href="javascript:void(0)">Fill in the blanks</a>
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="HH9Tu7BZ" href="javascript:void(0)">Short question</a>
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="nOFiSUZ8" href="javascript:void(0)">Long question</a>
                        <a data-id="${i}" class="dropdown-item passage-question-type" data-type="mq4g17ie" href="javascript:void(0)">SPR</a> -->
                    </div>
                    <div class="question-type-section"></div>
                    <div class="question-passage-preview-${i}"></div>
                    <div class="question-preview-${i} row"></div>
                    <div class="question-option-preview-${i}"></div>
                </div>`)
            }
        }
    } else { // for others
        $("#" + value).removeClass("d-none");
        $('#passage-form').html('')
        $("#other-types").addClass("d-none");
    }

    let id = $(".question_type option:selected").attr("data-id");
    $(".submitButton").attr({ "data-id":  `${value}-form`});
    $("div.preview").addClass("d-none");
    $(".question_place").html("");
    $(".option_place").html("");
    showPreview(value);
});



/**

 * @event on load page

 */

$(document).ready(function(){

    let selected_questionType = ($("#s_questionTypeId").val()) ? $("#s_questionTypeId").val() : "529kWMwg";

    $(".select_area").each(function(index, selector) {

        $(selector).addClass("d-none");

    })

    if(selected_questionType != ""){

        let value = $("select.question_type").find(`option[data-id=${selected_questionType}]`).val();

        $(".submitButton").attr({ "data-id":  `${value}-form`});

        $("#" + value).removeClass("d-none");

    }



    $(".select_area").each(function (index, selector) {

        $(selector).addClass("d-none");

    })

    let value = $(".question_type").val();

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

        /** Check for option duplications */
        let textareaValues = []; // Array to store textarea values
        let hasDuplicates = false;
        $(".mcq_options").each(function() {
            let selectorId = $(this).attr('id') 
            let value = CKEDITOR.instances[selectorId].getData(); // Get the value and remove any leading/trailing spaces

            // Check if the value already exists in the textareaValues array
            if (textareaValues.indexOf(value) !== -1) {
                hasDuplicates = true;
                return false; // Break out of the loop if duplicates are found
            }

            textareaValues.push(value); // Add the value to the array
        });

        // Check if duplicates were found and display a message
        if (hasDuplicates) {
            msgToast("error", `Duplicate answer choices are not allowed.`);
            optionData = false
        }


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

    if(dataId == `multi-select-form`){
        questionTitle = CKEDITOR.instances[`multiple-select-question`].getData();
        extendedSolitionTitle = CKEDITOR.instances[`passage-extendedsolution`].getData();
        hintTitle = CKEDITOR.instances[`msq-hint`].getData();
        optionData = getMsqOptions();
        yearsTitle = $('input[name=msq_year]').val() != "" ? $('input[name=msq_year]').val().split(',') : [];
        if(!optionData){
            $(".submitButton").removeClass("disabled");
            $(".submitButton").html(saveTxt);
            return false;
        }
    }

    if(dataId == `multiple-blanks-form`){
        questionTitle = CKEDITOR.instances[`multiple-blanks-input-0`].getData();
        extendedSolitionTitle = CKEDITOR.instances[`extendedsolution-0`].getData();
        hintTitle = '';
        optionData = getMBOptions();
        if(!optionData){
            $(".submitButton").removeClass("disabled");
            $(".submitButton").html(saveTxt);
            return false;
        }
    }

    let jsonData={};
    if(dataId.indexOf('unseen-passage_') !== -1 && submitError) {
        jsonData = setPassageFormat()
    } else if(submitError) {
        jsonData = setQuestionFormat(questionTitle, answerTitle, answerVariation, hintTitle, extendedSolitionTitle, yearsTitle, optionData);
    }
    ajaxSubmit(jsonData);
});



/**

 * @event on select True or False option

 */

$(document).on("change",".trueorfalse", function(){
    trueorfalse();
});



CKEDITOR.on("instanceReady", function(event) {
    let questionPreviewArray = ["question1", "longQuestion", "shortQuestions", "TrueFalseQue", "fnb-input", "multiple-select-question", "multiple-blanks-input-0"];
    let optionPreviewArray = ["option1", "option2", "option3", "option4"];
    event.editor.on("blur", function (ev) {

        if($.inArray(ev.editor.name.trim(), questionPreviewArray) != -1){
            previewQuestion(ev.editor.name);
        }

        if(ev.editor.name == "longAnswer" || ev.editor.name == "shortAnswer"){
            showAnswer(ev.editor.name);
        }

        // Fill in the blanks and multiple blanks
        if(ev.editor.name.indexOf('multiple-blanks-') != -1) {
            previewMultipleBlanksOption()
            ev.editor.name.indexOf('multiple-blanks-input-') != -1 && addRemoveAnswerForMultipleBlank(ev.editor.name, 0)
        } else if(ev.editor.name.indexOf('input-') != -1) {
            previewFillUpsOption();
        }

        if(ev.editor.name == "passage1") {
            !$('.preview').hasClass('d-none') && $('.preview').addClass('d-none') //This will hide other type preview
            CKEDITOR.instances[ev.editor.name].getData().length && $('.question-passage-preview-0').html(`<hr/><div><h3>Preview</h3></div>${CKEDITOR.instances[ev.editor.name].getData()}`)
        }

        if(ev.editor.name.indexOf('passage-question-') != -1 || ev.editor.name.indexOf('passage-true-or-false-question-') !== -1) {
            previewPassageQuestion(ev.editor.name)

            if(ev.editor.name.indexOf('passage-true-or-false-question-') !== -1) {
                trueOrFalsePassage(ev.editor.name)
            }
        }

        if(ev.editor.name.indexOf('passage-option') != -1) { // Passage Options
            previewPassageOption(ev.editor.name)
        }

        if(ev.editor.name.indexOf('passage-checkbox-mcs') != -1) { //Multiple Select Options
            // Preview for options for Multiple Select Questions
            previewPassageOption(ev.editor.name)
        }
    });


    event.editor.on("change", function (ev) {
        if($.inArray(ev.editor.name.trim(), questionPreviewArray) != -1){
            previewQuestion(ev.editor.name);
        }

        if(ev.editor.name == "longAnswer" || ev.editor.name == "shortAnswer"){
            showAnswer(ev.editor.name);
        }

        if(ev.editor.name.indexOf('passage-fnb-input-') != -1) {
            // code to remove answer if delete the blanks
            let textContent = ev.editor.document.getBody().getText();
            const elem = $(`#${ev.editor.name}`);
            const pattern = /(?:\b|\S)(_{2,})\b/g;
            const sno = parseInt($(elem).attr('id').match(/\d+/)[0])
            const matches = textContent.match(pattern);
            const count = matches ? matches.length : 0;
            const getAnsweredCount = parseInt($(`#passage-fill-in-the-blank-form-${sno}`).find('.counts-of-answers').val()) || 0
            if(count === getAnsweredCount) {
                $(`.passage-input-${sno}-${getAnsweredCount}`).remove();
                $(`#optionFibId-${sno}-${getAnsweredCount}`).remove();
                $(`#passage-fill-in-the-blank-form-${sno}`).find('.counts-of-answers').val(parseInt($(`#passage-fill-in-the-blank-form-${sno}`).find('.counts-of-answers').val()) - 1)
            }
            
            // Show FIB question preview
            previewPassageQuestion(ev.editor.name)
            
        }else if(ev.editor.name.indexOf('multiple-blanks-') != -1) {
            previewMultipleBlanksOption()
            ev.editor.name.indexOf('multiple-blanks-input-') != -1 && addRemoveAnswerForMultipleBlank(ev.editor.name, 0)
        } else if(ev.editor.name.indexOf('input-') != -1) {
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

    let position = $(this).getCursorPosition();

    let deleted = "";

    let val = CKEDITOR.instances["fnb-input"].getData();

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
        if(ev.editor.name.indexOf('multiple-blanks-option-') != -1) {
            // Do nothing just handling preview for multiple blank
        } else if(ev.editor.name.indexOf('option') != -1) {
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
        let replacetext = copiedText.replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");
        let testtext = replacetext.split("$$");
        let inputLength = $(`textarea[name="name[]"]`).length;
        if(testtext.length > 0){
            testtext = checkDuplicateOptions(testtext);
            let count = 0;
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
                let datdId = $(value).attr('id');
                ckeditorPlace([datdId]);
            });
        } else if($('.question_type').val() == shortQuestionWMCA){
            previewQuestion('matQuestions');
            showAnswerWithoutEditor('shortMCAAnswer');
            showAnswerVariations('mta-variation-');
        } else if($('.question_type').val() == 'multi-select'){
            window.location.pathname.indexOf('create') !== -1 && $('.question_type').trigger('change')
            $('#other-types').removeClass('d-none');
            
            $(`input[name="msq_year"]`).amsifySuggestags({
                suggestions: yearsTags,
                whiteList: true
            });

            /** Preview passages for MCQ and MSQ*/
            setTimeout(() => {
                CKEDITOR.instances['passage1'].getData().length && $('.question-passage-preview-0').html(`<hr/><div><h3>Preview</h3></div>${CKEDITOR.instances['passage1'].getData()}`)
                $('.accordion').find('textarea').each((ind, ta) => {
                    const elementSelectorId = $(ta).attr('id')
                    if(elementSelectorId.indexOf('passage-question-') !== -1) {
                        // console.log(elementSelectorId)
                        previewPassageQuestion(elementSelectorId)
                    } 
                    if(elementSelectorId.indexOf('passage-option') !== -1) {
                        // console.log(elementSelectorId)
                        previewPassageOption(elementSelectorId)
                    }
                })       
            }, 500);
        } else if($('.question_type').val() == 'multiple-blanks'){
            window.location.pathname.indexOf('create') !== -1 && $('.question_type').trigger('change')
            $('#other-types').removeClass('d-none');
            previewMultipleBlanksOption()
        } else {  
            $('.question_type').trigger('change')
            
            /** Preview passages for MCQ and MSQ */
            setTimeout(() => {
                CKEDITOR.instances['passage1'].getData().length && $('.question-passage-preview-0').html(`<hr/><div><h3>Preview</h3></div>${CKEDITOR.instances['passage1'].getData()}`)
                $('.accordion').find('textarea').each((ind, ta) => {
                    const elementSelectorId = $(ta).attr('id')
                    if(elementSelectorId.indexOf('passage-question-') !== -1) {
                        // console.log(elementSelectorId)
                        previewPassageQuestion(elementSelectorId)
                    } 
                    if(elementSelectorId.indexOf('passage-option') !== -1) {
                        // console.log(elementSelectorId)
                        previewPassageOption(elementSelectorId)
                    }
                })       
            }, 500);

        }
    }, 5000);
    toastr.options.titleClass = true;
    toastr.options.preventDuplicates = true;
});


$(document).on('click', '#add-answer-variation', function() {
    let count = $('.variation-row:last').find('.mta-variations').length ? Number($('.variation-row:last').find('.mta-variations').data('count'))+1 : 0;
   
    if($('.variation-row').find('.mta-variations').length < 9) {
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
        // let datdId = `mta-variation-${count}`;
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
    const previousValue = $(currentEvent).data('previous-value') || '';
    
    // Constants for validation
    let maxLength = 5;
    let is_valid = true;
    let max_limit_issue = false;
    let invalid_data = false;
    let notAllowedEventWithShift = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 187, 189, 190, 191, 192]
    let allowedEventKey = [8,9,16,37,38,39,40,45,46,47,48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,109,110,111,189,190,191];
    let isShiftPressed = e.shiftKey;
    if(notAllowedEventWithShift.includes(e.which) && isShiftPressed) {
        is_valid = false;
        invalid_data = true;
    } else if(allowedEventKey.includes(e.which)) {
        $(currentEvent).closest('.block').find('div[class^="mta-variations-error-"]').text('')
        $(currentEvent).closest('.block').find('div.shortAnswer-error').length && $(currentEvent).closest('.block').find('div[class="shortAnswer-error"]').text('')

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
            // check for negative decimal
            if(insertVal.substring(0, 1) === '-') {
                if(insertVal.length < 0 || insertVal.length > maxLength+1){
                    is_valid = false;
                    max_limit_issue = true;
                }
            } else if((parseFloat(insertVal)).toString().length < 0 || (parseFloat(insertVal)).toString().length > maxLength){
                is_valid = false;
                max_limit_issue = true;
            }

            // after decimal slash and negative not allowed
            if(is_slash){
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
                if(is_slash) {
                    let numbers = insertVal.split("/");
                    // Store values before and after the slash, then display them 
                    let beforeSlash = numbers[0]; 
                    let afterSlash = numbers[1];

                    if(beforeSlash.length + afterSlash.length > maxLength ) {
                        is_valid = false;
                        max_limit_issue = true;
                    }
                }
            } else {
                is_valid = false;
                invalid_data = true;
            }
        }

        // Validation 4: If it contains / value
        if(is_slash){
            if(is_negative) {
                if(insertVal.substring(0, 1) === '/') {
                    is_valid = false;
                    invalid_data = true;
                }
            } else if(insertVal.substring(0, 1) === '/') {
                is_valid = false;
                invalid_data = true;
            } else {
                let numbers = insertVal.split("/");
                // Store values before and after the slash, then display them 
                let beforeSlash = numbers[0]; 
                let afterSlash = numbers[1];

                if(beforeSlash.length + afterSlash.length >= maxLength ) {
                    is_valid = false;
                    max_limit_issue = true;
                }
            }

            // after decimal slash and negative not allowed
            if(is_decimal ){
                if(is_negative) {
                    is_valid = false;
                    invalid_data = true;
                }
                if(is_slash) {
                    is_valid = false;
                    invalid_data = true;
                }
            }
        }
    } else {
        is_valid = false;
        invalid_data = true;
    }

    if(!is_valid) {
        if(max_limit_issue) {
            $(currentEvent).closest('.block').find('div[class^="mta-variations-error-"]').text('Max limit exceed')
            $(currentEvent).closest('.block').find('div.shortAnswer-error').length && $(currentEvent).closest('.block').find('div.shortAnswer-error').text('Max limit exceed')
            const trimmedValue = insertVal.slice(0, maxLength);
            $(currentEvent).data('previous-value', trimmedValue);
            $(currentEvent).val(trimmedValue);
        } else if(invalid_data) {
            $(currentEvent).closest('.block').find('div[class^="mta-variations-error-"]').text('Invalid data')
            $(currentEvent).closest('.block').find('div.shortAnswer-error').length && $(currentEvent).closest('.block').find('div.shortAnswer-error').text('Invalid data')
            $(currentEvent).val(previousValue); // Revert to previous value
        }
    } else {
        $(currentEvent).data('previous-value', insertVal);
        $(currentEvent).closest('.block').find('div[class^="mta-variations-error-"]').text('')
        $(currentEvent).closest('.block').find('div.shortAnswer-error').length && $(currentEvent).closest('.block').find('div.shortAnswer-error').text('')
    }
})


$(document).on('focusout', '.mta-variations', function(e) {
    const event = $(this)
    let data = $(event).val()
    const charactersToRemove = ['.', '-', '/'];

    // Loop through the characters in reverse order
    for (let i = charactersToRemove.length - 1; i >= 0; i--) {
        const character = charactersToRemove[i];

        // Check if the inputString ends with the current character
        if (data.endsWith(character)) {
            // Remove the character from the end of the string
            data = data.slice(0, -1)
        }
    }

    data = addLeadingZeroIfNeededAndTrim(data);
    $(event).val(data)
})

function addLeadingZeroIfNeededAndTrim(inputString) {
    if (inputString.startsWith('.')) {
        inputString = '0' + inputString;
    }
  
    if (inputString.length > 5) {
        inputString = inputString.slice(0, 5);
    }
  
    return inputString;
}

// Helper function to count occurrences of a substring in a string
function countString(string, substring) {
    return (string.match(new RegExp(substring, 'g')) || []).length;
}

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

$(document).on('click', '.passage-question-type', function(e){
    const sno = $(this).data('id');
    const elem = $(this);
    const isPassage = $(this).attr('data-type') === 'multi-select' ? false : true
    
    $.ajax({
        timeout: 10000,
        type: "POST",
        url: $('#get-template-url').val(),
        data: {sno: sno, questionType: $(this).data('type'), isPassage: isPassage},
        dataType: "html",
        headers: {
            "X-CSRF-TOKEN": $("input[name=_token]").val()
        },
        success: function (response) {
            $(elem).closest('.question-section').find('.question-type-section').html(response)
            initalizeTextAreaWithCKEditor()
            $(elem).data('type') === 'fib' && triggerCKEditorOnChangeFIBQuestion()

            // reset preview
            CKEDITOR.instances['passage1'].getData().length <= 0 && $(`.question-passage-preview-${sno}`).html('')
            $(`.question-preview-${sno}`).html('')
            $(`.question-option-preview-${sno}`).html('')
        },
        error: function(error){
        }
    })
})


/**

 * @event to add Blank Space in passage Fillup questions

 */

$(document).on("click", "#passage-add-blank", function () {
    let sno = $(this).data('id')
    const event = $(this)
    let editorInstance = "passage-fnb-input-"+sno;
    let cursorPos = $("#"+editorInstance).prop("selectionStart") || 0;
    let editor = CKEDITOR.instances[editorInstance];
    let v = $("#passage-fnb-input-"+sno).val();
    let textBefore = v.substring(0, cursorPos);
    let textAfter = v.substring(cursorPos, v.length);
    $('#'+editorInstance).val(textBefore + " __________ " + textAfter);
    editor.insertHtml(" __________ ");
    addRemoveAnswerForFIBPassage(event, editorInstance, sno);
    $(event).closest('form').find('.counts-of-answers').val(parseInt($(event).closest('form').find('.counts-of-answers').val())+1)
});

/**
 * @methods to counting total blank space in fillups question at passage
 */

function addRemoveAnswerForFIBPassage(event, editorInstance, sno) {
    let str = CKEDITOR.instances[editorInstance].getData();
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
            if($(`.passage-input-${sno}-${counter}`).length > 0){
                $(`.passage-input-${sno}-${counter}`).val($(`.passage-input-${sno}-${counter}`).val());
            } else {
                $(`#passage-fill-in-the-blank-form-${sno}`).find(".add-inputs").append(`<div class="col-md-12"><div class="form-group"><div class="" id="optionFibId-${sno}-${counter}">
                <textarea class="fillups form-control mb-8 passage-input-${sno}-${counter}" id="passage-fib-option-${sno}-${counter}" data-id="${counter}" placeholder="Answer ${counter+1}" data-color="dddddd"></textarea>
                    </div></div><span class="input-error${counter}"></span></div>`);
                ckeditorPlace([`passage-fib-option-${sno}-${counter}`]);
            }
        }
    }
    // if(inputLength > 0) {
    //     for (let removeCounter = arrLength; removeCounter < inputLength; removeCounter++) {
    //         console.log(`removeCounter ${removeCounter}`)
    //         if(removeCounter >= arrLength) {
    //             $(`.passage-input-${sno}-${removeCounter}`).remove();
    //             $(`#optionFibId-${sno}-${removeCounter}`).remove();
    //         }
    //     }
    // }
}


/**
* @event Ckeditor on change FIB passage question values - Start
*/
function triggerCKEditorOnChangeFIBQuestion () {
    // Loop through all CKEditor instances
    for (let instanceName in CKEDITOR.instances) {
        // Check if the instance ID matches the desired pattern
        if (instanceName.startsWith('passage-fnb-input-')) {
            // Bind the change event to the CKEditor instance
            CKEDITOR.instances[instanceName].on('change', function(e) {
                const sno = parseInt(instanceName.match(/\d+/)[0])
                const event = $(`#${instanceName}`).closest(`#passage-fill-in-the-blank-form-${sno}`).find(`#passage-add-blank`)
                // Event handler code here
                addRemoveAnswerForFIBPassage(event, instanceName, sno);

                // Code to show preview
                let position = $(this).getCursorPosition();
                let deleted = "";
                let val = CKEDITOR.instances[instanceName].getData();
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
        }
    }
}

/**
 * @script to paste options on click paste button
 */
$(document).on('click', '.paste_me_in_passage', (e) => {
    const questionTypeId = $(e.target).closest('.accordion').data('type') 
    
    navigator.clipboard.readText()
    .then(copiedText => {
        let replacetext = copiedText.replace(/\n{1,}|\t{1,}|\s{2,}\s/g, "$$$$");
        let testtext = replacetext.split("$$");
        if(testtext.length > 0){
            testtext = checkDuplicateOptions(testtext);
            let count = 0;
            
            // Remove the options then paste the text in editor
            let removeOptions = $(e.target).closest('.card-body').find('.removePassageCheckboxOption').length 
                ? $(e.target).closest('.card-body').find('.removePassageCheckboxOption') 
                : $(e.target).closest('.card-body').find('.removePassageOption').length 
                ? $(e.target).closest('.card-body').find('.removePassageOption') 
                : 0;
            
            if (removeOptions.length) {
                removeOptions.each(function() {
                  $(this).click();
                });
            }

            // Code to add new options
            const diff = parseInt(testtext.length - $(e.target).closest('.card-body').find('.existing-option').find('textarea').length)
            if(diff) {
                for (let ind = 0; ind < diff; ind++) {
                    $(e.target).closest('.card-body').find('.addNewPassageOption').length && $(e.target).closest('.card-body').find('.addNewPassageOption').click();                      
                    
                    // This will allow to click till 10 options onlyt for Multiple select options
                    if (questionTypeId === 'kc8fmydg') { //for MSQ
                        if (ind < 7) {
                            $(e.target).closest('.card-body').find('.addNewCheckboxOption').click();                       
                        }
                    }
                }
            }

            let firstElementInstance = '';
            $.each(testtext, function(index, val) {
                if(val.length > 0 ){
                    count++;
                    let elementSelector = '';
                    let newValue = val.replace(/^(([(][a-zA-Z0-9]{1,3}[)]\s)|([\[][a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z]{1,3}[)]\s)|([a-zA-Z0-9]{1,3}[\]]\s)|([a-zA-Z0-9]{1,3}[.][\]]\s)|([\[][a-zA-Z0-9]{1,3}[.][\]]\s)|([a-zA-Z0-9]{1,3}[.]\s)|([a-zA-Z0-9]{1,3}[.][)]\s)|[(]([a-zA-Z0-9]{1,3}[.][)]\s)|([a-zA-Z0-9]{1,3}[)]\s))/g, "");
                    $(e.target).closest('.card-body').find('.existing-option').find('textarea').each((ind, ta) => {
                        elementSelector = $(ta).attr('id')
                        if(ind == index) {
                            if(ind === 0) {
                                firstElementInstance = elementSelector
                            }
                            CKEDITOR.instances[elementSelector].setData($.trim(newValue));
                        } 
                    })
                }
            });
            
            previewPassageOption(firstElementInstance)
            
        }
    })
    .catch(err => {
        console.log("Something went wrong", err);
    })
})


/**
 * @event to create new checkbox option in Passage
 */
$(document).on("click", ".addNewCheckboxOption", function(e){
    let counter = $(this).closest("div.existing-option").find(".passage_options").length + 1;
    let optionId = '';
    
    if(counter >= 10) {
        $(this).hide()
    }
    // if($(this).closest('.accordion').attr('data-type') === "kc8fmydg") {
    //     optionId = `passage-option${counter}`
    // } else {
    //     optionId = `passage-option${counter}-${sno}`
    // }

    let sno = $(e.target).data('id')
    $(this).closest("div.existing-option").find(".putNewCheckboxOption").append(`<div class="row" id="optionid${counter}-${sno}">
        <div class="col-md-12">
            <div class="well2">
                <input tabindex="1" type="checkbox" id="passage-checkbox-mcs${counter}-${sno}" name="passageanswer${counter}" value="${counter}">
                <label for="passage-checkbox-mcs${counter}-${sno}">Select correct option ${counter}</label>
                <a class="removePassageCheckboxOption float-right" data-rowid="optionid${counter}-${sno}">
                    <i class="material-icons text-danger">delete</i>
                </a>
                <div class="form-group">
                    <div class="">
                        <textarea class="form-control passage_options" placeholder="Option ${counter}" name="passage_options${counter}[]" id="passage-option${counter}-${sno}" data-color="dddddd"></textarea>
                    </div>
                    <div class="passage-option${counter}-error error"></div>
                </div>
            </div>
        </div>
    </div>`);

    $(`#passage-option${counter}-${sno}`).focus();

    ckeditorPlace([`passage-option${counter}-${sno}`]);

});


/**
 * @methods to create Passage Question Preview
 */

function previewPassageQuestion(textBoxId){
    let questionTitle = CKEDITOR.instances[textBoxId].getData();
    let sno = parseInt(textBoxId.match(/\d+/)[0])

    if(questionTitle.length > 0 || $(questionTitle).find('img').length > 0){
        let questionText = $.trim(questionTitle)
        questionText = `<div class="col-sm-1" style="padding-right: 0px !important; max-width: 40px;"><label>Q ${sno+1}.</label></div><div class="col-sm-11">${questionText}</div>`
        $(`.question-preview-${sno}`).html(questionText);
        MathJax.typeset();
    } else {
        $(`.question-preview-${sno}`).html('');
    }
}

function previewPassageOption(textBoxId) {
    
    let sno = parseInt(textBoxId.split('-')[2])
    let optionInstances = $(`#${textBoxId}`).closest('.existing-option').find(`textarea`);
    let questionType = $(`#${textBoxId}`).closest('.accordion').data('type');

    setTimeout(() => {
        let optionData = '<div class="option-list mt-2">';
        optionInstances.each((index, option) => {
            let elementInstance = $(option).attr('id')
            let optionText = $.trim(CKEDITOR.instances[elementInstance].getData());
            if(optionText.length > 0 || $(optionText).find('img').length > 0){
                if(questionType === 'mcq' || questionType === '529kWMwg'){
                    optionData += `<div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label disabled" for="customRadio1">${optionText}</label>
                    </div>`
                } else if(questionType === 'mcs'|| questionType === 'kc8fmydg'){
                    optionData += `<div class="custom-control custom-checkbox">
                        <input type="checkbox" id="customCheckbox1" name="customCheckbox" class="custom-control-input">
                        <label class="custom-control-label disabled" for="customRadio1">${optionText}</label>
                    </div>`
                }
                MathJax.typeset();
            } else {
                optionData += '';
            }
        })
        optionData += '</div>';

        let question_type = $("select[name=question_type] option:selected").val()
        if(question_type.indexOf('unseen-passage_') != -1) {
            $(`.question-option-preview-${sno}`).html(optionData);
        } else {
            $(`.option-list.option_place`).html(optionData);
        }
    }, 300);

}

/**
 * @event to create new option in Passage
 */

$(document).on("click", ".addNewPassageOption", function(e){
    let counter = $(this).closest("div.existing-option").find(".passage_options").length + 1;
    let sno = $(e.target).data('id')
    $(this).closest("div.existing-option").find(".putNewOption").append(`<div class="row" id="optionid${counter}-${sno}">
        <div class="col-md-12">
            <div class="well2">
                <input tabindex="1" type="radio" id="passage-radio-mcq${counter}-${sno}" name="passage-radio-mcq-${sno}">
                <label for="passage-radio-mcq${counter}-${sno}">Select correct option ${counter}</label>
                <a class="removePassageOption float-right" data-rowid="passage-option${counter}-${sno}">
                        <i class="material-icons text-danger">delete</i>
                </a>
                <div class="form-group">
                    <div class="">
                        <textarea class="form-control passage_options" placeholder="Option ${counter}" name="passage_options${counter}[]" id="passage-option${counter}-${sno}" data-color="dddddd"></textarea>
                    </div>
                    <div class="option${counter}-error error"></div>
                </div>
            </div>
        </div>
    </div>`);
    $(`#passage-option${counter}-${sno}`).focus();
    ckeditorPlace([`passage-option${counter}-${sno}`]);
});

/**

 * @methods to create True false option preview

 */

function trueOrFalsePassage(textBoxId){
    let optionHtml = "";
    let sno = parseInt(textBoxId.match(/\d+/)[0])
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
    $(`.question-option-preview-${sno}`).html(optionHtml);
}

/**
 * @method unseen passage validations
 */
function unseenPassageValidation(dataId) {
    let isValid = true;
    let errMsg = '';
    const maxQuestionLimit = parseInt(dataId.match(/\d+/)[0])

    // Check if passage is empty
    $(`.passage-error`).html(``);
    if(CKEDITOR.instances['passage1'].getData().length <= 0) {
        isValid = false;
    }
    !isValid && $(`.passage-error`).html(`<span>This field is required</span>`);

    if($('#passage').find('.accordion').length != maxQuestionLimit) {
        isValid = false;
        errMsg += `<li>Please select all questions</li>`;
        msgToast("error", `<ul>${errMsg}</ul>`);
        return false
    }

    // Check for all inputs otherwise show error
    $('.accordion').find('.error').html('')
    $('#passage').find('.accordion').each((index, acc) => {
        // check if textarea is non-empty
        $(acc).find('textarea').each((ind, selec) => {
            const elementSelector = $(selec).attr('id')
            const editorData = $.trim(CKEDITOR.instances[elementSelector].getData());
            if(editorData.length <= 0) {
                $(`#${elementSelector}`).closest('.row').find('.error').html(`<span>This field is required</span>`)
                isValid = false;
            }
        })

        if($(acc).find('.existing-option').length) {
            // check for answer duplications
            let optionTexts = [];
            let isDuplicate = false
            $(acc).find('.existing-option').find('textarea').each((tind, textareaElem) => {
                let elemInstance = $(textareaElem).attr('id')
                let optionInput = CKEDITOR.instances[elemInstance].document.getBody().getText().trim();
                if (optionTexts.indexOf(optionInput) !== -1) {
                    // Handle the duplicate option text
                    isDuplicate = optionInput.length && true
                } else {
                    // Add the option text to the array
                    optionTexts.push(optionInput);
                }
            })

            if(isDuplicate) {
                isValid = false;
                errMsg += `<li>Duplicate answer choices are not allowed for question ${index+1}.</li>`;
            }

            // check if radio validations
            let isRadioChecked = false;
            if($(acc).find('.existing-option').find('input[type="radio"]').length){
                $(acc).find('.existing-option').find('input[type="radio"]').each((rind, radioElem) => {
                    if($(radioElem).is(":checked")) {
                        isRadioChecked = true;
                        return false;
                    }
                })
                if(!isRadioChecked) {
                    isValid = false;
                    errMsg += `<li>Please select a correct answer for question ${index+1}.</li>`;
                }
            }

            // check if checkbox is selected
            if($(acc).find('.existing-option').find('input[type="checkbox"]').length){
                if ($(acc).find('.existing-option').find('input[type="checkbox"]:checked').length < 2) {
                    isValid = false;
                    errMsg += `<li>Please select at least two correct answer choices for question ${index+1}.</li>`;
                }
            }
        }    
    })
    if(!isValid) {
        msgToast("error", `<ul>${errMsg}</ul>`);
    }

    return isValid
}

/**

 * @methods Set question format to submit db

 */

function setPassageFormat(){
    let GUID = $("#s_questionId").val().length ? $("#s_questionId").val() : generateGUID();
    let selectedSubtopics = null;
    if($("select[name=subtopics] option:selected").val() != ""){
        selectedSubtopics = {
            id: $("select[name=subtopics] option:selected").val(),
            subTopicName: $("select[name=subtopics] option:selected").text(),
        }
    }

    const passageId = $(`textarea[name="passage"]`).attr('id')
    const passageData = CKEDITOR.instances[passageId].getData()
    let childrenQuestions = [];
    $('#passage').find('.accordion').each((index, accordion) => {
        if($(accordion).data('type') === 'mcq' || $(accordion).data('type') === '529kWMwg') { // This is multiple choice option
            const questionId = $(accordion).find('textarea').eq(0).attr('id')
            const question = CKEDITOR.instances[questionId].getData()
            const extendedSolutionId = $(accordion).find('textarea:last').attr('id')
            const extendedSolution = CKEDITOR.instances[extendedSolutionId].getData()

            let options = [];
            $(accordion).find('.existing-option').find('textarea').each((tind, ta) => {
                let optionText = CKEDITOR.instances[$(ta).attr('id')].getData()
                let isSelected = $(ta).closest('div.row').find('input[type="radio"]').is(":checked")
                options.push({
                    id: tind+1,
                    isCorrect: isSelected,
                    optionText: optionText,
                    images: []
                })
            })
            let questionObject = {
                answerBlock: {
                    answer: "",
                    hint: "",
                    additionalAnswers: null,
                    extendedSolution: extendedSolution,
                    options: options
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
                    contentProviderId: $('#contentProviderId').val()
                },
                source: $("input[name=source]").val(),
                questionTypeId: '529kWMwg',
                questionText: question,
                questionImages: [],
                askedYears: null,
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
                subTopic: {
                    id: $("select[name=subtopics] option:selected").val(),
                    subTopicName: $("select[name=subtopics] option:selected").text(),
                },
                openTags: []
            };
            if($(`#parent-questionid-${index}`).length){
                questionObject.parentQuestionId = $(`#parent-questionid-${index}`).val();
            }
            if($(`#questionid-${index}`).length){
                questionObject.id  = $(`#questionid-${index}`).val();
            }
            childrenQuestions.push(questionObject);
        }else if($(accordion).data('type') === 'mcs'  || $(accordion).data('type') === 'kc8fmydg') { // This is multiple select options
            const questionId = $(accordion).find('textarea').eq(0).attr('id')
            const questionTypeId = $(accordion).data('type')
            const question = CKEDITOR.instances[questionId].getData()
            const extendedSolutionId = $(accordion).find('textarea:last').attr('id')
            const extendedSolution = CKEDITOR.instances[extendedSolutionId].getData()

            let options = [];
            $(accordion).find('.existing-option').find('textarea').each((tind, ta) => {
                let optionText = CKEDITOR.instances[$(ta).attr('id')].getData()
                let isSelected = $(ta).closest('div.row').find('input[type="checkbox"]').is(":checked")
                options.push({
                    id: tind+1,
                    isCorrect: isSelected,
                    optionText: optionText,
                    images: []
                })
            })
            let questionObject = {
                answerBlock: {
                    answer: "",
                    hint: "",
                    additionalAnswers: null,
                    extendedSolution: extendedSolution,
                    options: options
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
                    contentProviderId: $('#contentProviderId').val()
                },
                source: $("input[name=source]").val(),
                questionTypeId: questionTypeId,
                questionText: question,
                questionImages: [],
                askedYears: null,
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
                subTopic: {
                    id: $("select[name=subtopics] option:selected").val(),
                    subTopicName: $("select[name=subtopics] option:selected").text(),
                },
                openTags: []
            };
            if($(`#parent-questionid-${index}`).length){
                questionObject.parentQuestionId = $(`#parent-questionid-${index}`).val();
            }
            if($(`#questionid-${index}`).length){
                questionObject.id  = $(`#questionid-${index}`).val();
            }
            childrenQuestions.push(questionObject);
        }
    })


    let responseData = {
        id: GUID,
        questionTypeId: $("select[name=question_type] option:selected").data("id"),
        questionText: passageData,
        questionImages: [],
        askedYears: null,
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
        subTopic: {
            id: $("select[name=subtopics] option:selected").val(),
            subTopicName: $("select[name=subtopics] option:selected").text(),
        },
        openTags: [],
        answerBlock: {
            answer: "",
            hint: "",
            additionalAnswers: null,
            extendedSolution: "",
            options: []
        },
        childrenQuestions: childrenQuestions,
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
            contentProviderId: $('#contentProviderId').val()
        },
        source: $("input[name=source]").val()
    };
    return JSON.stringify(responseData);
}

/**
 * @methods to set MSQ Options
 */
function getMsqOptions(){
    let option = [];
    let arrayDuplicateOptions = [];
    let isTrue = false;
    $(".existing-option").find("textarea").each(function(index, selector){
        let optionId = index+1;
        isTrue = $(selector).parents("div.well2").find("input[type=checkbox]").is(":checked");
        const selectorID= $(this).attr('id')
        let optTitle = CKEDITOR.instances[`${selectorID}`].getData();
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


/**
 * @method unseen passage validations
 */
function multipleSelectValidation() {
    let isValid = true;
    let errMsg = '';

    // Check for all inputs otherwise show error
    $('.accordion').find('.error').html('')

    // check if textarea is non-empty
    $('.accordion').find('textarea').each((ind, selec) => {
        const elementSelector = $(selec).attr('id')
        const editorData = $.trim(CKEDITOR.instances[elementSelector].getData());
        const excludedElementSelector = ['passage-extendedsolution', 'msq-hint'];
        if(editorData.length <= 0) {
            if(!excludedElementSelector.includes(elementSelector)) {
                $(`#${elementSelector}`).closest('.row').find('.error').html(`<span>This field is required</span>`)
                isValid = false;
                errMsg +=`<li>${$(selec).attr('placeholder')} is required</li>`
            }
        }
    })

    if($('.existing-option').length) {
        // check for answer duplications
        let optionTexts = [];
        let isDuplicate = false
        $('.existing-option').find('textarea').each((tind, textareaElem) => {
            let elemInstance = $(textareaElem).attr('id')
            let optionInput = CKEDITOR.instances[elemInstance].document.getBody().getText().trim();
            if (optionTexts.indexOf(optionInput) !== -1) {
                // Handle the duplicate option text
                isDuplicate = optionInput.length && true
            } else {
                // Add the option text to the array
                optionTexts.push(optionInput);
            }
        })
        
        if(isDuplicate) {
            isValid = false;
            errMsg += `<li>Duplicate answer choices are not allowed.</li>`;
        }

        // check if checkbox is selected
        if($('.existing-option').find('input[type="checkbox"]').length){
            if ($('.existing-option').find('input[type="checkbox"]:checked').length < 2) {
                isValid = false;
                errMsg += `<li>Please select at least two correct answer choices.</li>`;
            }
        }
    }    

    if(!isValid) {
        msgToast("error", `<ul>${errMsg}</ul>`);
    }

    return isValid
}


/**
 * @event to add Blank Space in Multiple Blank questions
 */

$(document).on("click", "#add-multiple-blank", function () {
    let sno = $(this).data('id')
    const event = $(this)
    let editorInstance = "multiple-blanks-input-"+sno;
    let cursorPos = $("#"+editorInstance).prop("selectionStart") || 0;
    let editor = CKEDITOR.instances[editorInstance];
    let v = $("#multiple-blanks-input-"+sno).val();
    let textBefore = v.substring(0, cursorPos);
    let textAfter = v.substring(cursorPos, v.length);

    let counter = $(`#multiple-blanks-form-${sno}`).find('.add-inputs').find('textarea').length
    if(counter > 6) {
        msgToast("error", `Max 3 blanks allowed`);
        return
    }
    $('#'+editorInstance).val(`${textBefore} __________ ${textAfter}`);
    editor.insertHtml(" __________ ");
    addRemoveAnswerForMultipleBlank(editorInstance, sno);
    previewMultipleBlanksOption()

    $(event).closest('form').find('.counts-of-answers').val(parseInt($(event).closest('form').find('.counts-of-answers').val())+1)
});

/**
 * @methods to counting total blank space in fillups question at passage
 */

function addRemoveAnswerForMultipleBlank(editorInstance, sno) {
    let str = CKEDITOR.instances[editorInstance].getData();
    let newStr = str.replace(/(<([^>]+)>|&nbsp;)/ig,"")
    let strMatch = newStr.match(/[_]{2,}/g);
    let arrLength = 0;
    if(strMatch != null) {
        arrLength = strMatch.length;
    }

    if(arrLength > 3) {
        msgToast("error", `Max 3 blanks allowed`);
        return
    }
    
    if (arrLength > 0) {
        for (let counter = 0; counter < arrLength; counter++) {
            let blankOptions = ``;
            let options = ``;
            for(let i=0; i < 3; i++){
                let inc = (counter * 3) + i;
                
                if($(`.multiple-blanks-option-${sno}-${inc}`).length > 0){
                    $(`.multiple-blanks-option-${sno}-${inc}`).val($(`.multiple-blanks-option-${sno}-${inc}`).val());
                } else {
                    blankOptions += `<div class="well pb-3" id="optionFibId-${sno}-${inc}">
                        <input tabindex="1" type="radio" id="passage-radio-mb${sno}-${inc}" name="passage-radio-mcq-${sno}-${counter+1}" >
                        <label for="passage-radio-mb${sno}-${inc}">(${numberToAlphabet(inc+1).toUpperCase()})</label>
                        <textarea class="fillups form-control mb-8 multiple-blanks-option-${sno}-${inc}" id="multiple-blanks-option-${sno}-${inc}" data-id="${inc}" placeholder="Answer ${numberToAlphabet(inc+1).toUpperCase()}" data-color="dddddd"></textarea>
                        <span class="input-error${inc} error"></span>
                    </div>`;

                    options = `<div class="col-md-12">
                        <div class="form-group option-group">
                            <p>Blank Option (${romanize(counter+1).toLowerCase()})</p>
                            ${blankOptions}
                        </div>
                    </div>`

                }
            }
            if(options.length > 0) {
                $(`#other-types`).find(".add-inputs").append(`${options}`);
                initalizeTextAreaWithCKEditor()
            }
        }
    }

    let inputLength = 0;
    if ($(`#other-types`).find(".add-inputs").find('textarea').length > 0) {
        inputLength = $(`#other-types`).find(".option-group").length;
    }
    if(inputLength > 0 && arrLength < inputLength) {
        $(`div.option-group:eq(${inputLength-1})`).remove()        
    }
}

function previewMultipleBlanksOption(){
    $('.preview').removeClass('d-none')

    // print question
    const questionData = CKEDITOR.instances[`multiple-blanks-input-0`].getData();
    $(".question_place").html(questionData);

    let optionHtml = "";
    $('#other-types').find("textarea.fillups").each(function(index, value){
        let instanceId = $(this).attr('id')
        let optionTitle = CKEDITOR.instances[`${instanceId}`].getData();
        let groupCount = index < 3 ? 'i' : index < 6 ? 'ii' : index < 9 ? 'iii' : '' ;
        optionHtml += (index%3===0) ? `<div class="col"> <p>Blank Option (${groupCount})</p>` : ``
        optionHtml += `<div><input tabindex="1" type="radio" disabled id="passage-rad-mb-${index}" name="passage-rad-mcq-${index}" />
        <label for="passage-rad-mb-${index}">${optionTitle ? optionTitle : ''}</label></div>`;        
        optionHtml += (index%3 === 2) ? `</div>` : ``
    });
    optionHtml = `<div class="row">${optionHtml}</div>`
    $(".option_place").html(optionHtml);
}

function multipleBlankValidation() {
    let isValid = true;
    let errMsg = '';

    // Check for all inputs otherwise show error
    $('.accordion').find('.error').html('')

    // check if textarea is non-empty
    $('.accordion').find('textarea').each((ind, selec) => {
        const elementSelector = $(selec).attr('id')
        const editorData = $.trim(CKEDITOR.instances[elementSelector].getData());
        const excludedElementPattern = /^extendedsolution-\d+$/;
        if(editorData.length <= 0) {
            if(!excludedElementPattern.test(elementSelector)) {
                $(`#${elementSelector}`).closest('.well').find('.error').html(`<span>This field is required</span>`)
                isValid = false;
                errMsg +=`<li>${$(selec).attr('placeholder')} is required</li>`
            }
        }
    })

    if($('.add-inputs').length) {
        // check for answer duplications
        $('.add-inputs').find('div.form-group.option-group').each((ind, divElem) => {
            let optionTexts = [];
            let isDuplicate = false
            let isAnyChecked = false
            $(divElem).find('textarea').each((tind, textareaElem) => {
                let elemInstance = $(textareaElem).attr('id')
                let optionInput = CKEDITOR.instances[elemInstance].document.getBody().getText().trim();
                if (optionTexts.indexOf(optionInput) !== -1) {
                    // Handle the duplicate option text
                    isDuplicate = optionInput.length && true
                } else {
                    // Add the option text to the array
                    optionTexts.push(optionInput);
                }
            })
            if(isDuplicate) {
                isValid = false;
                errMsg += `<li>Duplicate answer choices are not allowed at blank group ${ind}.</li>`;
            }
            
            $(divElem).find('input[type="radio"]').each((rind, radioElem) => {
                if ($(radioElem).is(":checked")) {
                    isAnyChecked = true
                }
            });

            if(!isAnyChecked) {
                isValid = false;
                errMsg += `<li>Please select at least one correct answer choices at blank group ${ind+1}.</li>`;
            }
        })
        
    }    

    if(!isValid) {
        msgToast("error", `<ul>${errMsg}</ul>`);
    }

    return isValid
}

/**
 * @methods to set Multiple Blank Options
 */
function getMBOptions(){
    let option = [];
    let arrayDuplicateOptions = [];
    let isTrue = false;
    $(".add-inputs").find("textarea").each(function(index, selector){
        let optionId = index+1;
        isTrue = $(selector).parents("div.well").find("input[type=radio]").is(":checked");
        const selectorID= $(this).attr('id')
        let optTitle = CKEDITOR.instances[`${selectorID}`].getData();
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

function romanize(num) {
    var lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1},roman = '',i;
    for ( i in lookup ) {
      while ( num >= lookup[i] ) {
        roman += i;
        num -= lookup[i];
      }
    }
    return roman;
}

function numberToAlphabet(num) {
    if (typeof num !== 'number' || num < 1 || num > 26) {
      throw new Error('Input must be a number between 1 and 26.');
    }
  
    // Convert the number to its corresponding ASCII code for lowercase letters (a=97)
    const asciiCode = 96 + num;
  
    // Convert the ASCII code to the alphabet character
    const alphabetChar = String.fromCharCode(asciiCode);
  
    return alphabetChar;
}