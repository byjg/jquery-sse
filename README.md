# jQuery SSE 

## Description

A lightweigth jQuery Plugin for Server-Sent Events (SSE) EventSource Polyfill. 
This plugin do not overwrite the native EventSource object if it exists. 
If there is no native support the request is made by Ajax requests. 
The server implementation does not needed to change neither the client. 

## Example

Client Side

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
	onMessage: function(e){ 
		console.log("Message"); console.log(e); 
	}
});
sse.start();
```

Server Side

```php
echo "data: My Message\n";
echo "\n";
```

## Dependencies

* jQuery

## Install

Just download the repository and point the jQuery plugin:

```html
<script src="jquery.sse.js" ></script>
```

or

```html
<script src="jquery.sse.min.js" ></script>
```

*TODO*: install bower.

## Usage:

#### Constructor

```
var sse = $.SSE(url, settings);
```

* url: URL for the server will be sent the events to this page;
* settings: The events and options for the SSE instance

#### Settings List

**Event onOpen**

Fired when the connection is opened the first time;

```javascript
onOpen: function(e){ 
	console.log("Open"); console.log(e); 
},
```

**Event onEnd**

Fired when the connection is closed and the client will not listen for the server events;

```javascript
onEnd: function(e){ 
	console.log("End"); console.log(e); 
},
```

**Event onError**

Fired when the connection error occurs;

```javascript
onError: function(e){ 
	console.log("Could not connect"); 
},
```

**Event onMessage**

Fired when the a message without event is received

```javascript
onMessage: function(e){ 
	console.log("Message"); console.log(e); 
},
```

**Custom Options**

Define the options for the SSE instance

```javascript
options: {
	forceAjax: false
},
```

* **forceAjax**: If true will comunicate with the server only by ajax even if the EventSource object is supported natively;


**Custom Events**

Fired when the server set the event and match with the key

```javascript
	events: {
		customEvent: function(e) {
			console.log('Custom Event');
			console.log(e);
		}	
	}
});
```

Server side:

```php
echo "event: customEvent\n";   // Must match with events in the HTML.
echo "data: My Message\n";
echo "\n";
```

## Quirks

The ajax does not support the streaming as the event source supports. In that case we recommend create a server without streaming and set the "retry" to determine query frequency; 


## References

* http://www.w3.org/TR/2009/WD-eventsource-20091029/
* https://developer.mozilla.org/en-US/docs/Server-sent_events/Using_server-sent_events
* http://html5doctor.com/server-sent-events/
* http://www.html5rocks.com/en/tutorials/eventsource/basics/



