var themes_mode = {
	'light' : {
		'background_color' : '#fff',
		'text_color' : '#000'
	},
	'night' : {
		'background_color' : '#000',
		'text_color' : '#fff'
	},
	'beige' : {
		'background_color' : '#f5f5dc',
		'text_color' : '#000'
	}
}

var font_size_selector = $('#font_size_selector');
var font_family_selector = $('#font_family_selector');
var theme_mode_selector = $('#theme_mode_selector');

font_size_selector.change(function(){
	var val = font_size_selector.val();
	console.log(val);
	window.reader.rendition.themes.fontSize(val);
});

font_family_selector.change(function(){
	var val = font_family_selector.val();
	window.reader.rendition.themes.font(val);
});

theme_mode_selector.change(function(){
	var val = theme_mode_selector.val();
	$('#main').css("background-color", themes_mode[val]['background_color']);
	window.reader.rendition.themes.override('color', themes_mode[val]['text_color']);
	$('.icon-menu').css('color', themes_mode[val]['text_color']);
    $('.icon-bookmark').css('color', themes_mode[val]['text_color']);
    $('.icon-bookmark-empty').css('color', themes_mode[val]['text_color']);
    $('.icon-cog').css('color', themes_mode[val]['text_color']);
    $('.icon-resize-full').css('color', themes_mode[val]['text_color']);
    $('.arrow').css('color', themes_mode[val]['text_color']);
    $('#metainfo').css('color', themes_mode[val]['text_color']);
});
