/**
 * AHAX JavaScript Class.
 */
AHAX = function (config) {
	// Config Settings
	this.supported_frameworks = ['jQuery'];
	this.framework = 'jQuery';
	this.url = null;
	
	// Constructor
	this.init = function(config) {
		this.setDefaultURL();
		
		// A string (url) may be passed instead of a config object.
		if(typeof config == 'string') {
			this.url = config;
		} else if(typeof config == 'object') {
			if(config.url) {
				this.url = config.url;
			}
			if(config.framework) {
				if(this.isFrameworkSupported(config.framework)) {
					this.framework = config.framework;
				} else {
					this.log('Unsupported framrwork supplied in config object: ' + config.framework);
				}
			}
		} else {
			this.log('Invalid constructor argument.');
		}			
	};

	

	// Make a POST ajax request.
	this.post = function(action, arguments, callback) {
	    if(typeof action != 'string' || action.length <= 0) {
			this.log('"action" argument is not a string or is empty.');
			return false;
		}
		var fnc = this['post_' + this.framework] || null;
		if(fnc === null) {
			this.log('Post method for current framework ( ' + this.framework + ' ) not found.');
			return false;
		}
		if(!this.isFrameworkAvailable(this.framework)) {
			this.log('Framework ( ' + this.framework + ' ) was unavailable at time of AHAX.post() call.');
			return false;
		};
		fnc(this.url, action, arguments, callback);
		return true;
	};
	
	/**
	 * Framework Wrapping Methods post_[framework](url, action, arguments, callback);
	 */
	
	// jQuery
	this.post_jQuery = function(url, action, arguments, callback) {
		var args = (typeof arguments == 'object') ? arguments : {};
		jQuery.extend(args, {action:action});
		jQuery.post(url, args, callback);
	};
	
	/**
	 * Misc Methods
	 */
	
	// Check if a framework is supported by AHAX
	this.isFrameworkSupported = function(framework) {
		for(key in this.supported_frameworks) {
			if(this.supported_frameworks[key] == 'framework') {
				return true;
			}
		}
		return false;
	};
	
	// Check if a framework is loaded at specific point in time.
	this.isFrameworkAvailable = function(framework) {
		switch(framework) {
			case 'jQuery':
				if(typeof jQuery != 'undefined') return true;
			default:
				return false;
		}
	};
	
	// console.log wrapper.
	this.log = function(string) {
		if(typeof console == 'object') {
			console.log('AHAX Log: ' + string);
		}
	};
	
	// Attempt to set the default value of the url from the AHAXConfig object.
	this.setDefaultURL = function() {
		if(typeof AHAXConfig == 'object' && AHAXConfig.url) {
			this.url = AHAXConfig.url;
		}
	}
	
	// Call the constuctor
	this.init(config);	
};