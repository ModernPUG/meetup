requirejs(['jquery', 'underscore', 'backbone'], function($, _, Backbone) {

	'use strict';

	var
	init = function() {

		


	},
	// 그냥 상태 찍어주는 함수.
	status = function() {
		$.ajax({
			type: 'GET',
			url: 'http://localhost:8010/status'
		}).then(function(data) {
			var text = $('<pre>').html(data);
			$('#app').append(text);
		});
	},

	// 일반적인 Ajax에서 로그인
	normalLogin = function() {
		$.ajax({
			type: 'POST',
			url: 'http://localhost:8010/login',
			xhrFields: {
				withCredentials: true
			},
			crossDomain: true
		}).then(function(data) {
			var text = $('<pre>').html(data);
			$('#app').append(text);
		});
	},
	normalMe = function() {
		$.ajax({
			type: 'GET',
			url: 'http://localhost:8010/me',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true
		}).then(function(data) {
			var text = $('<pre>').html(data);
			$('#app').append(text);
		});
	},

	// CrossDomain으로 NonCookie기반의 세션으로 로그인
	corsLogin = function() {
		$.ajax({
			type: 'POST',
			url: 'http://localhost:8010/cors/login'
		}).then(function(data) {
			var text = $('<pre>').html(data);
			$('#app').append(text);
		});
	},
	corsMe = function(sessionId) {
		$.ajax({
			type: 'GET',
			url: 'http://localhost:8010/cors/me?pug_session=' + sessionId
		}).then(function(data) {
			var text = $('<pre>').html(data);
			$('#app').append(text);
		});
	};

	init();

});

