/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'AddNews';
	config.removePlugins = 'elementspath';
	config.toolbar_AddNews =
	[
		['Save','Preview','-','Templates'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	    ['Maximize'],
	    '/',
		['Bold','Italic','Underline'],
		['NumberedList','BulletedList'],
		['Link','Unlink'],
		['SpecialChar'],

	]
};
