---
sidebar_position: 5
---

# Known Limitations and Quirks

## Ajax Fallback Limitations

### No Streaming Support

The Ajax fallback does not fully support streaming in the same way native EventSource does. While the plugin attempts to handle progressive responses using the `onprogress` event, this behavior may vary across browsers.

:::tip Recommendation
When using the Ajax fallback (either forced or due to lack of native support), create a server without streaming and use the `retry` directive to control polling frequency.
:::

### Example: Non-Streaming Server

**Server Side (PHP):**

```php
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Set retry interval to 3 seconds
echo "retry: 3000\n";

// Send single message
echo "data: Current time is " . date('H:i:s') . "\n";
echo "\n";

flush();

// Exit immediately (no streaming)
exit;
?>
```

**Client Side:**

```javascript
var sse = $.SSE('sse-server.php', {
    options: {
        forceAjax: true  // Force Ajax mode
    },
    onMessage: function(e) {
        console.log('Message received:', e.data);
        // Client will automatically reconnect after 3 seconds
    }
});
sse.start();
```

## Browser Compatibility

### Native EventSource Support

Not all browsers support the native EventSource API:

- ✅ Chrome 6+
- ✅ Firefox 6+
- ✅ Safari 5+
- ✅ Opera 11+
- ❌ Internet Explorer (all versions)
- ✅ Edge 79+ (Chromium-based)

The plugin automatically detects support and falls back to Ajax when necessary.

## Custom Headers Limitation

### Automatic Ajax Fallback

When you provide custom headers, the plugin automatically uses Ajax polling instead of native EventSource, because the EventSource API does not support custom headers.

```javascript
// This will use Ajax even if EventSource is available
var sse = $.SSE('sse-server.php', {
    headers: {
        'Authorization': 'Bearer token'
    },
    onMessage: function(e) {
        console.log(e.data);
    }
});
```

## Cross-Origin Requests

### CORS Configuration Required

For cross-origin requests, the server must send appropriate CORS headers:

```php
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Last-Event-ID, Cache-Control, Authorization');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

echo "data: Cross-origin message\n";
echo "\n";
?>
```

## Message Parsing

### Line Break Requirements

Messages must end with double line breaks (`\n\n`). Single line breaks within data are preserved:

```php
// Correct: Multi-line data
echo "data: Line 1\n";
echo "data: Line 2\n";
echo "data: Line 3\n";
echo "\n";  // Double line break to end message
```

### Comment Lines

Lines starting with a colon (`:`) are treated as comments and ignored:

```php
echo ": This is a comment\n";
echo "data: This is data\n";
echo "\n";
```

## Performance Considerations

### Retry Interval

Setting an appropriate retry interval is important for performance:

- **Too short**: Increases server load and network traffic
- **Too long**: Delays message delivery

```php
// Recommended: 1-5 seconds for most applications
echo "retry: 3000\n";
```

### Connection Management

Always stop the SSE connection when it's no longer needed:

```javascript
// Stop when navigating away
$(window).on('beforeunload', function() {
    sse.stop();
});

// Stop when element is removed
$('#container').on('remove', function() {
    sse.stop();
});
```

## Debugging Tips

### Check Connection Type

You can check which connection type is being used:

```javascript
var sse = $.SSE('sse-server.php', {
    onOpen: function() {
        console.log('Connection type:', sse.type);
        // Output: 'event' (native) or 'ajax' (fallback)
    }
});
```

### Monitor Reconnections

Track reconnection attempts:

```javascript
var sse = $.SSE('sse-server.php', {
    onOpen: function() {
        console.log('Connection opened');
    },
    onError: function() {
        console.log('Connection error, will retry...');
    }
});
```
