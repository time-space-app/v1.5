/*
	Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
	For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function(config) {
	config.toolbar = 'Admin';
	config.toolbar_Basic = [
		['Source','NewPage','Preview'],
		['SelectAll','Cut','Copy','Paste','PasteText','PasteFromWord'],
		['Undo','Redo'],
		['Bold','Italic','Strike','HorizontalRule','-','NumberedList','BulletedList'],
		['Outdent','Indent','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Font', 'FontSize', 'TextColor'],
		['Maximize']
	];

	config.toolbar_Admin = [
		['Source','NewPage','Preview'],
		['SelectAll','Cut','Copy','Paste','PasteText','PasteFromWord'],
		['Undo','Redo'],
		['Image','Flash','Table'],
		['Link','Unlink'],
		['Bold','Italic','Strike','HorizontalRule','-','NumberedList','BulletedList'],
		['Outdent','Indent','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Font', 'FontSize', 'TextColor'],
		['Maximize']
	];	

	config.language = 'en';
	config.font_names = 'MS Mincho;MS Gothic;굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana';

	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.fillEmptyBlocks = false;
	config.autoParagraph = false;
	config.height = '400px';
	config.resize_dir = 'vertical';
	config.toolbarCanCollapse = false;	
	config.removePlugins = 'contextmenu';
};

CKEDITOR.on("instanceReady", function(ev) {
	ev.editor.dataProcessor.writer.indentationChars = "";
	ev.editor.dataProcessor.writer.setRules('p', {
		indent : false,
		breakBeforeOpen : true,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : true
	});
	ev.editor.dataProcessor.writer.setRules('li', {
		indent : false,
		breakBeforeOpen : true,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : true
	});
	ev.editor.dataProcessor.writer.setRules('div', {
		indent : false,
		breakBeforeOpen : true,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : true
	});
	ev.editor.dataProcessor.writer.setRules('br', {
		indent : false,
		breakBeforeOpen : false,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : false
	});
});
CKEDITOR.dtd.$removeEmpty['span'] = 0;