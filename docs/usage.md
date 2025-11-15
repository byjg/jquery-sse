---
sidebar_position: 2
---

# Usage

## Constructor

Create a new SSE instance:

```javascript
var sse = $.SSE(url, settings);
```

### Parameters

- **url** (string): URL for the server that will send the events to this page
- **settings** (object): The events and options for the SSE instance

### Example

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
    onMessage: function(e){
        console.log("Message received:", e.data);
    }
});
```

## Methods

### start()

Start the EventSource communication.

```javascript
sse.start();
```

**Returns:** `true` if started successfully, `false` if already running

**Behavior:**
- Automatically detects if native EventSource is available
- Falls back to Ajax polling if:
  - EventSource is not supported by the browser
  - `forceAjax` option is set to `true`
  - Custom headers are provided (EventSource doesn't support custom headers)

### stop()

Stop the EventSource communication.

```javascript
sse.stop();
```

**Returns:** `true` if stopped successfully, `false` if not running

**Behavior:**
- Closes the connection
- Triggers the `onEnd` callback
- Cleans up the instance
