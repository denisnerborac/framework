var app = {

	main_container: '#main-container',
	main_title_container: '.navbar-brand',
	page_title_container: '.blog-title',


	init: function() {

		if (GLOBAL_AJAX) {
			app.initGlobalAjax();
		}

	},

	initGlobalAjax: function() {

		$(document).delegate('a, button[type="submit"]', 'click', function(e) {

			var isLink = typeof($(this).attr('href')) !== 'undefined';
			var isFormButton = typeof($(this).closest('form').attr('action')) !== 'undefined';

			var url = isLink ? $(this).attr('href') : isFormButton ? $(this).closest('form').attr('action') : null;

			var method = 'GET';

			var form = null;
			if (isFormButton) {
				var form = $(this).closest('form');
				method = (typeof(form.attr('method')) !== 'undefined' ? form.attr('method') : 'POST').toUpperCase();
			}

			var data = isFormButton && form !== null ? form.serialize() : [];

			//console.log(location);

			if (url !== null && (url.indexOf('http') === -1 || url.indexOf(HTTP_ROOT) !== -1 || HTTP_ROOT.indexOf(url) !== -1)) {

				var target_active = null;
				if (typeof($(this).data('active')) !== 'undefined') {
					target_active = $($(this).data('active'));
				} else if ($(this).is('a')) {
					target_active = $(this);
				}


				if (target_active !== null) {
					if (target_active.closest('li').length > 0) {
						target_active = target_active.closest('li');
					}
					target_active.closest('.nav').find(target_active.prop('tagName')).removeClass('active');
					target_active.addClass('active');
				}

				app.getPage(url, method, data);
			}

			e.preventDefault();
			return false;
		});

		window.onpopstate = function(e){
			if(e.state){
				document.title = e.state.title;
				$(app.main_container).html(e.state.html);
			}
		};
	},

	getPage: function(url, method, data) {

		var method = (typeof(method) !== 'undefined' ? method : 'GET').toUpperCase();
		var data = (typeof(data) !== 'undefined' ? data : []);

		$.ajax({
			method: method,
			url: url,
			data: data,
			dataType: 'html'
		}).done(function(result) {
			if (typeof(result.error) === 'undefined') {
				$(app.main_container).html(result);
				var title = app.getPageTitle();
				document.title = title;
			    window.history.pushState({'html': result, 'title': title}, title, url+(method.toUpperCase() == 'GET' && typeof(data) === 'string' ? '?'+data : ''));
			}
			// TODO : display error
			return false;
		});
	},

	getPageTitle: function() {
		var title = '';
		if ($(app.main_title_container).length > 0 && typeof($(app.main_title_container).attr('title')) !== 'undefined') {
			title += $(app.main_title_container).attr('title')+' - ';
		}
		if ($(app.main_container+' '+app.page_title_container).length > 0) {
			title += $(app.main_container+' '+app.page_title_container).text();
		}
		return title;
	}
};

$(document).ready(function(){
	app.init();
});