if(typeof jQuery != 'undefined') {
	AHAX = function (url) {
		this.url = typeof url == 'string' ? url : '/wp-content/plugins/ahax/request.php';
		
		this.post = function(action, arguments, callback) {
		    var args = (typeof arguments == 'object') ? arguments : {};
			jQuery.extend(args, {action:action});
			jQuery.post(this.url, args, callback);
		};	
	}
}
