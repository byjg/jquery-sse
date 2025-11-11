---
sidebar_position: 3
---

# Configuration

## Settings Object

All available settings:

```javascript
var sse = $.SSE('sse-server.php', {
    onOpen: function (e) {},
    onEnd: function (e) {},
    onError: function (e) {},
    onMessage: function (e) {},
    options: {},
    headers: {},
    events: {}
});
```

## Event Callbacks

### onOpen

Fired when the connection is opened for the first time.

```javascript
onOpen: function(e){
    console.log("Connection opened");
    console.log(e);
}
```

:::note
This callback is only triggered once when the connection is first established, not on reconnections.
:::

### onEnd

Fired when the connection is closed and the client will no longer listen for server events.

```javascript
onEnd: function(e){
    console.log("Connection ended");
    console.log(e);
}
```

### onError

Fired when a connection error occurs.

```javascript
onError: function(e){
    console.log("Connection error occurred");
    console.log(e);
}
```

### onMessage

Fired when a message without an event name is received.

```javascript
onMessage: function(e){
    console.log("Message received:", e.data);
}
```

**Event object properties:**
- `data`: The message data
- `lastEventId`: The ID of the last event received
- `origin`: The origin of the message
- `returnValue`: Always `true`

## Options

Configure the behavior of the SSE instance:

```javascript
options: {
    forceAjax: false
}
```

### forceAjax

- **Type:** `boolean`
- **Default:** `false`

Forces the use of Ajax polling even if the EventSource object is natively supported by the browser.

```javascript
var sse = $.SSE('sse-server.php', {
    options: {
        forceAjax: true
    },
    onMessage: function(e){
        console.log(e.data);
    }
});
```

## Custom Headers

Send custom headers with the request:

```javascript
headers: {
    'Authorization': 'Bearer 1a234fd4983d',
    'X-Custom-Header': 'value'
}
```

:::warning Important
EventSource does not support custom headers. When you provide custom headers, the plugin will automatically fallback to `forceAjax=true`, even if it's not explicitly set.
:::

**Example:**

```javascript
var sse = $.SSE('sse-server.php', {
    headers: {
        'Authorization': 'Bearer 1a234fd4983d'
    },
    onMessage: function(e){
        console.log(e.data);
    }
});
```

## Custom Events

Define handlers for custom server-sent events:

```javascript
events: {
    myEvent: function(e) {
        console.log('Custom Event received');
        console.log(e.data);
    },
    anotherEvent: function(e) {
        console.log('Another event');
        console.log(e.data);
    }
}
```

### Client Side Example

```javascript
var sse = $.SSE('sse-server.php', {
    events: {
        myEvent: function(e) {
            console.log('Custom Event:', e.data);
        }
    }
});
sse.start();
```

### Server Side Example

The event name must match the key in the `events` object:

```php
echo "event: myEvent\n";
echo "data: My Message\n";
echo "\n";
```

### SSE Message Format

Server-sent events follow this format:

```
event: eventName
data: message content
id: unique-id
retry: 3000

```

- **event**: Optional event name (if omitted, triggers `onMessage`)
- **data**: The message content
- **id**: Optional unique identifier
- **retry**: Optional reconnection time in milliseconds
- Two newlines (`\n\n`) signal the end of a message
