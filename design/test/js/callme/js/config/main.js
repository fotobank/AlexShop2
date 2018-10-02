{
	"button": {
		"show": true,
		"text": "Request a callback"
	},
	"fields": [
		{
			"type": "text",
			"name": "Your Name",
			"placeholder": "Type your name",
			"required": true,
			"sms": true
		},
		{
			"type": "email",
			"name": "Your E-mail",
			"placeholder": "Type your e-mail",
			"required": false,
			"sms": true
		},
		{
			"type": "tel",
			"mask": "(999) 999-9999",
			"name": "Phone Number",
			"required": false,
			"sms": true
		},
		{
			"type": "textarea",
			"name": "Comments",
			"placeholder": "Comments, questions...",
			"required": false,
			"sms": true
		},
		{
			"type": "select",
			"name": "Question",
			"sms": true,
			"options": [
				"Get details",
				"Make an order"
			]
		},
		{
			"type": "checkbox",
			"name": "Gift case",
			"required": true,
			"sms": true
		}
	],
	"form": {
		"template": "default",
		"title": "Request a callback",
		"button": "Call me", 
		"align": "center",
		"welcome": "Fill in the form and we'll call you back as soon as possible"
	},
	"alerts": {
		"yes": "Yes",
		"no": "No",
		"process": "Sending request...",
		"success": "Your request was successfully sent",
		"fails": {
			"required": "Please fill in all required fields",
			"sent": "Previous message was sent less than a minute ago"
		}
	},
	"captcha": {
		"show": true,
		"title": "Captcha",
		"error": "Captcha is wrong"
	},
	"license": {
		"key": "422033305436423430283020423433305122272633304820421830205426",
		"show": true
	},
	"mail": {
		"referrer": "Page referrer",
		"url": "URL",
		"linkAttribute": "Link attribute",
		"smtp": false
	},
	"animationSpeed": 150,
	"sms": {
		"send": false,
		"captions": true,
		"cut": true
	}
}
