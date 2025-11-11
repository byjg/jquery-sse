---
sidebar_position: 6
---

# API Reference

## $.SSE(url, settings)

Creates a new Server-Sent Events instance.

### Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `url` | string | Yes | The URL endpoint that will send SSE events |
| `settings` | object | No | Configuration object with callbacks, options, headers, and events |

### Returns

Returns an SSE instance object with the following methods and properties:

| Property/Method | Type | Description |
|----------------|------|-------------|
| `start()` | function | Start the SSE connection |
| `stop()` | function | Stop the SSE connection |
| `instance` | object | The underlying EventSource or Ajax instance |
| `type` | string | Connection type: `'event'` (native) or `'ajax'` (fallback) |

## Settings Object

### Callbacks

#### onOpen(event)

Called when the connection is established for the first time.

```javascript
onOpen: function(e) {
    console.log('Connection opened', e);
}
```

**Parameters:**
- `event` (object): The event object from EventSource or synthetic event from Ajax

#### onEnd(event)

Called when the connection is closed.

```javascript
onEnd: function(e) {
    console.log('Connection closed', e);
}
```

**Parameters:**
- `event` (object): The event object

#### onError(event)

Called when an error occurs.

```javascript
onError: function(e) {
    console.error('Connection error', e);
}
```

**Parameters:**
- `event` (object): The error event object

#### onMessage(event)

Called when a message is received without a custom event name.

```javascript
onMessage: function(e) {
    console.log('Data:', e.data);
    console.log('ID:', e.lastEventId);
    console.log('Origin:', e.origin);
}
```

**Parameters:**
- `event` (object): The message event object
  - `data` (string): The message data
  - `lastEventId` (string): The ID of the last event
  - `origin` (string): The origin URL
  - `returnValue` (boolean): Always `true`

### Options

Configuration options for the SSE connection.

```javascript
options: {
    forceAjax: false
}
```

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `forceAjax` | boolean | `false` | Force Ajax polling even if EventSource is supported |

### Headers

Custom HTTP headers to send with the request.

```javascript
headers: {
    'Authorization': 'Bearer token',
    'X-Custom-Header': 'value'
}
```

:::warning
Providing custom headers automatically enables Ajax mode, as native EventSource doesn't support custom headers.
:::

### Events

Custom event handlers for named server events.

```javascript
events: {
    eventName: function(e) {
        console.log('Custom event:', e.data);
    }
}
```

**Event Handler Parameters:**
- `event` (object): The message event object (same structure as `onMessage`)

## Instance Methods

### start()

Starts the SSE connection. Can be called after creating the instance or after calling `stop()`.

```javascript
var sse = $.SSE('sse-server.php', {
    onMessage: function(e) {
        console.log(e.data);
    }
});

sse.start();
```

**Returns:** `boolean`
- `true`: Connection started successfully
- `false`: Connection is already running

**Behavior:**
1. Checks if an instance already exists
2. Determines whether to use native EventSource or Ajax fallback based on:
   - Browser support for EventSource
   - `forceAjax` option
   - Presence of custom headers
3. Initializes the appropriate connection method

### stop()

Stops the SSE connection and cleans up resources.

```javascript
sse.stop();
```

**Returns:** `boolean`
- `true`: Connection stopped successfully
- `false`: No active connection to stop

**Behavior:**
1. Checks if an instance exists
2. Closes the connection (EventSource) or stops Ajax polling
3. Calls the `onEnd` callback
4. Cleans up instance and type properties

## Instance Properties

### instance

The underlying connection object:
- For native EventSource: The EventSource instance
- For Ajax fallback: An object containing polling state

```javascript
console.log(sse.instance);
```

### type

The connection type being used:
- `'event'`: Using native EventSource
- `'ajax'`: Using Ajax fallback
- `null`: No active connection

```javascript
console.log(sse.type);  // 'event' or 'ajax'
```

## Server Message Format

### Basic Message

```
data: message content

```

### Message with Event Name

```
event: customEventName
data: message content

```

### Message with ID

```
id: unique-message-id
data: message content

```

### Message with Retry

```
retry: 3000
data: message content

```

### Multi-line Data

```
data: line 1
data: line 2
data: line 3

```

### Complete Message Example

```
id: 123
event: notification
retry: 5000
data: {"user": "john", "message": "Hello"}

```

## Internal Properties

The following properties are used internally and should not be modified:

- `_url`: The SSE endpoint URL
- `_remoteHost`: The remote host (used for Ajax mode)
- `_settings`: The merged settings object
- `_start`: Reference to the original start method

## Minification

To minify the library for production:

```bash
apt install uglifyjs

uglifyjs --compress 'drop_console,drop_debugger' --mangle -r '$,require,exports,_' -o jquery.sse.min.js jquery.sse.js
```
