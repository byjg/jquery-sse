# jQuery SSE 

## Description

A lightweigth jQuery Plugin for Server-Sent Events (SSE) EventSource Polyfill. 
This plugin try to use the native EventSource object if it supported by the browser.
If there is no native support the request is made by ajax requests (polling).
You do not need to change the server side nor the client side.

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

Just download the repository and point to the jQuery plugin:

```html
<script src="jquery.sse.js" ></script>
```

or

```html
<script src="jquery.sse.min.js" ></script>
```

You can also install using bower:

```bash
bower install jquery-sse
```

## Usage:

#### Constructor

```
var sse = $.SSE(url, settings);
```

* url: URL for the server will be sent the events to this page;
* settings: The events and options for the SSE instance

#### Settings List

All the options:

```
var sseObject = $.SSE('sse-server.php', {
    onOpen: function (e) {},
    onEnd: function (e) {},
    onError: function (e) {},
    onMessage: function (e) {},
    options: {},
    headers: {},
    events: {}
});
```

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

* **forceAjax**: Uses ajax even if the EventSource object is supported natively;


**Custom Events**

Fired when the server set the event and match with the key

For example, if you have a custom event called `myEvent` you may use the follow code:

```javascript
events: {
    myEvent: function(e) {
        console.log('Custom Event');
        console.log(e);
    }
}
```

Server side:

```php
echo "event: myEvent\n";   // Must match with events in the HTML.
echo "data: My Message\n";
echo "\n";
```

**Custom Headers**

You can send custom headers to the request.

```javascript
headers: {
    'Authorization', 'Bearer 1a234fd4983d'
}
```

Note: As the EventSource does not support send custom headers to the request,
the object will fallback automatically to 'forceAjax=true', even this it is not set.


#### Methods

**start**

Start the EventSource communication

```javascript
sse.start();
```

**stop**

Stop the EventSource communication

```javascript
sse.stop();
```


## Quirks

The ajax does not support the streaming as the event source supports. In that case we recommend
create a server without streaming and set the "retry" to determine query frequency;

Example Server Side:

```php
echo "retry: 3000\n";
echo "data: My Message\n";
echo "\n";
```

## Minify

```
uglifyjs --compress 'drop_console,drop_debugger' --mangle -r '$,require,exports,_' -o jquery.sse.min.js jquery.sse.js
```

## References

* http://www.w3.org/TR/2009/WD-eventsource-20091029/
* https://developer.mozilla.org/en-US/docs/Server-sent_events/Using_server-sent_events
* http://html5doctor.com/server-sent-events/
* http://www.html5rocks.com/en/tutorials/eventsource/basics/



