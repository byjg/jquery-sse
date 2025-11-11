---
sidebar_position: 4
---

# Examples

## Basic Example

### Client Side

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
    onMessage: function(e){
        console.log("Message:", e.data);
    }
});
sse.start();
```

### Server Side (PHP)

```php
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

echo "data: Hello from server\n";
echo "\n";
flush();
?>
```

## Custom Events Example

### Client Side

```javascript
var sse = $.SSE('sse-server.php', {
    onMessage: function(e) {
        console.log('Default message:', e.data);
    },
    events: {
        userLogin: function(e) {
            console.log('User logged in:', e.data);
        },
        notification: function(e) {
            console.log('Notification:', e.data);
        }
    }
});
sse.start();
```

### Server Side (PHP)

```php
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Send a custom event
echo "event: userLogin\n";
echo "data: {\"username\": \"john\", \"time\": \"2024-01-01 10:00:00\"}\n";
echo "\n";

// Send a default message (no event name)
echo "data: Regular message\n";
echo "\n";

// Send another custom event
echo "event: notification\n";
echo "data: You have 3 new messages\n";
echo "\n";

flush();
?>
```

## Authentication Example

Using custom headers for authentication:

```javascript
var sse = $.SSE('secure-sse-server.php', {
    headers: {
        'Authorization': 'Bearer YOUR_ACCESS_TOKEN',
        'X-API-Key': 'your-api-key'
    },
    onMessage: function(e) {
        console.log('Authenticated message:', e.data);
    },
    onError: function(e) {
        console.log('Authentication error');
    }
});
sse.start();
```

## Event ID and Retry Example

### Server Side (PHP)

```php
<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Set retry time to 5 seconds
echo "retry: 5000\n";

// Send message with ID
echo "id: " . time() . "\n";
echo "data: Message at " . date('H:i:s') . "\n";
echo "\n";

flush();
?>
```

### Client Side

The client will automatically send the last event ID in the `Last-Event-ID` header:

```javascript
var sse = $.SSE('sse-server.php', {
    onMessage: function(e) {
        console.log('Message:', e.data);
        console.log('Last Event ID:', e.lastEventId);
    }
});
sse.start();
```

## Complete Example with All Features

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
    // Connection opened
    onOpen: function(e) {
        console.log('Connection established');
        $('#status').text('Connected');
    },

    // Connection closed
    onEnd: function(e) {
        console.log('Connection closed');
        $('#status').text('Disconnected');
    },

    // Connection error
    onError: function(e) {
        console.error('Connection error');
        $('#status').text('Error');
    },

    // Default message handler
    onMessage: function(e) {
        console.log('Message:', e.data);
        $('#messages').append('<div>' + e.data + '</div>');
    },

    // Options
    options: {
        forceAjax: false
    },

    // Custom headers
    headers: {
        'Authorization': 'Bearer token123'
    },

    // Custom events
    events: {
        userJoined: function(e) {
            $('#users').append('<li>' + e.data + '</li>');
        },
        userLeft: function(e) {
            $('#users li:contains("' + e.data + '")').remove();
        },
        notification: function(e) {
            alert('Notification: ' + e.data);
        }
    }
});

// Start listening
sse.start();

// Stop on button click
$('#stopButton').click(function() {
    sse.stop();
});
```

## Running the Examples Locally

The repository includes example files you can run locally.

### Using Docker

Start the web server:

```bash
docker run -it --rm -p 8080:80 -v $PWD:/var/www/html byjg/php:7.4-fpm-nginx
```

Open your browser:

```
http://localhost:8080/examples/sse-client.html
```

### Using PHP Built-in Server

```bash
php -S localhost:8080
```

Then open:

```
http://localhost:8080/examples/sse-client.html
```
