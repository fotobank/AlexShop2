/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	// Define changes to default configuration here. For example:
	 config.language = 'ru';
	// config.uiColor = '#AADC6E';
	// config.removeButtons = 'Underline,Subscript,Superscript';
    config.toolbar = [
    {name: 'tools', items: [ 'Maximize' ] }, 
    {name: 'styles', items: [ 'Source','Format','FontSize','Styles' ] }, 
    {name: 'basicstyles', items: [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
    {name: 'colors', items: [ 'TextColor','BGColor' ] },
    {name: 'paragraph', items: [ 'NumberedList','BulletedList','-','ShowBlocks','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
    {name: 'links', items: [ 'Link','Unlink','Anchor' ] }, 
    {name: 'insert', items: [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
    {name: 'document', items: [ 'DocProps','Preview','Print','-','Templates' ] }, 
    {name: 'clipboard', items: [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] }, 
    {name: 'editing', items: [ 'Find','Replace','-','SelectAll','-','SpellChecker' ] }
    ];
	config.filebrowserBrowseUrl = '/includes/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '/includes/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = '/includes/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = '/includes/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '/includes/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = '/includes/kcfinder/upload.php?type=flash';
	config.enterMode = CKEDITOR.ENTER_BR;
    config.baseFloatZIndex = 1000010;
    config.allowedContent = true;
	config.protectedSource.push(/<i[^>]*><\/i>/g);
	config.entities = false;
};
