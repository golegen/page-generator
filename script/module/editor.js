/**
 * @desc: 编辑器基础功能类
 * @author: laserji
 * @mail: jiguang1984#gamil.com
 * @date: 2012-12-19
 */

define(['jquery','./conf'], function($, conf){


    return {
        edit:{
            saveSelection: function(){
                if(window.getSelection){
                    $.savedRange = window.getSelection().getRangeAt(0);
                }else if(document.selection){
                    $.savedRange = document.selection.createRange();
                }
            },
            restoreSelection: function(){
                if ($.savedRange != null) {
                    if (window.getSelection){
                        var s = window.getSelection();
                        if (s.rangeCount > 0)
                            s.removeAllRanges();
                        s.addRange($.savedRange);
                    }else if(document.createRange){
                        window.getSelection().addRange($.savedRange);
                    }else if(document.selection){
                        $.savedRange.select();
                    }
                }
            },
            getSelectedText: function(){
                if (document.getSelection) {    // all browsers, except IE before version 9
                    return document.getSelection().toString();
                }else if (document.selection) {   // Internet Explorer before version 9
                    return document.selection.createRange().text;
                }
            }
        },

        bold: function () {
            document.execCommand("bold", false, null);
        },

        italicize: function () {
            document.execCommand("italic", false, null);
        },

        underline: function () {
            document.execCommand("underline", false, null);
        },

        orderedList: function () {
            document.execCommand("InsertOrderedList", false, null);
        },

        unorderedList: function () {
            document.execCommand("InsertUnorderedList", false, null);
        },

        indent: function () {
            document.execCommand("indent", false, null);
        },

        insertHTML: function(html_source){
            document.execCommand("insertHTML", false, html_source);
        },

        outdent: function () {
            document.execCommand("outdent", false, null);
        },

        superscript: function () {
            document.execCommand("superscript", false, null);
        },

        subscript: function () {
            document.execCommand("subscript", false, null);
        },

        createLink: function () { /* This can be improved */
//        createLink: function (url) {

            var urlPrompt = prompt("Enter URL(当前页面打开):", "http://");
            document.execCommand("createLink", false, urlPrompt);

            /*var range = document.selection ? document.selection.createRange() : document.getSelection().getRangeAt(0);
            var text = document.selection ? document.selection.createRange().text : document.getSelection().toString();

            if(range.pasteHTML){
                range.select();
                range.pasteHTML('<a href="'+url+'" >'+text+'</a>');
            }else if(range.deleteContents && range.insertNode){
                range.deleteContents();
                range.insertNode($('<a href="'+url+'" >'+text+'</a>')[0]);
            }*/
        },

        createLinkTarget: function () { /* This can be improved */
            var urlPrompt = prompt("Enter URL(新页面打开):", "http://");
            var hyperlink = "javascript:window.open('" + urlPrompt + "')";
            document.execCommand("createLink", false, hyperlink);
        },

        insertImage: function () { /* This can be improved */
            var urlPrompt = prompt("Enter Image URL:", "http://");
            document.execCommand("InsertImage", false, urlPrompt);
        },

        formatBlock: function (block) {
            document.execCommand("FormatBlock", null, block);
        },

        forecolor: function(){
            var urlPrompt = prompt("Enter color (eg:#000):", "#");
            document.execCommand("forecolor", false, urlPrompt);
        },

        removeFormat: function () {
            document.execCommand("removeFormat", false, null);
        },

        copy: function () {
            document.execCommand("Copy", false, null);
        },

        paste: function () {
            document.execCommand("Paste", false, null);
        },

        undo: function () {
            document.execCommand("undo", false, null);
        },

        save: function (callback) {
            return this.each(function () {
                (callback)($(this).attr("id"), $(this).html());
            });
        }

    }
});