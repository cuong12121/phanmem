/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.extraPlugins='simpleuploads,youtube';
	// Define changes to default configuration here. For example:
	//  config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// config.filebrowserUploadMethod = 'form';

	config.pasteFromWordRemoveFontStyles = true;
	config.allowedContent = true;
	config.disallowedContent = 'table[style]{*}; td[style]{*}; th[style]{*} script';
	config.extraAllowedContent = 'figure figcaption center blockquote svg cite id';

	config.filebrowserBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
