{
	"button": {
		"show": true,
		"text": "Short form"
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
			"type": "tel",
			"mask": "(999) 999-9999",
			"name": "Phone Number",
			"required": true,
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
		"template": "fb",
		"title": "Request a callback",
		"button": "Request",
		"align": "right",
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
		"key": "0",
		"show": false
	},
	"mail": {
		"referrer": "Page referrer",
		"url": "URL",
		"linkAttribute": "Link attribute",
		"smtp": true
	},
	"animationSpeed": 150,
	"sms": {
		"send": true,
		"captions": true,
		"cut": true
	}
}
