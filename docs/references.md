---
sidebar_position: 7
---

# References and Resources

## Official Specifications

- [W3C EventSource Specification (2009)](http://www.w3.org/TR/2009/WD-eventsource-20091029/)
  - The original W3C working draft for Server-Sent Events

## Documentation and Tutorials

### MDN Web Docs

- [Using Server-Sent Events](https://developer.mozilla.org/en-US/docs/Server-sent_events/Using_server-sent_events)
  - Comprehensive guide from Mozilla Developer Network
  - Includes browser compatibility information
  - Client and server implementation examples

### HTML5 Tutorials

- [HTML5 Doctor: Server-Sent Events](http://html5doctor.com/server-sent-events/)
  - Beginner-friendly introduction to SSE
  - Real-world use cases

- [HTML5 Rocks: Stream Updates with Server-Sent Events](http://www.html5rocks.com/en/tutorials/eventsource/basics/)
  - In-depth tutorial on EventSource basics
  - Performance considerations
  - Comparison with other real-time technologies

## Related Projects

### JavaScript Libraries

- [yaj-sse](https://github.com/byjg/yaj-sse)
  - SSE Polyfill without jQuery dependency
  - Port from version 0.1.4 of jQuery SSE
  - Lightweight and framework-agnostic

### Server Implementations

#### PHP
```php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
echo "data: message\n\n";
flush();
```

#### Node.js
```javascript
res.writeHead(200, {
    'Content-Type': 'text/event-stream',
    'Cache-Control': 'no-cache',
    'Connection': 'keep-alive'
});
res.write('data: message\n\n');
```

#### Python (Flask)
```python
from flask import Response, stream_with_context

def event_stream():
    yield 'data: message\n\n'

@app.route('/stream')
def stream():
    return Response(event_stream(), mimetype='text/event-stream')
```

## Browser Support

### Native EventSource Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 6+ | ✅ Full support |
| Firefox | 6+ | ✅ Full support |
| Safari | 5+ | ✅ Full support |
| Opera | 11+ | ✅ Full support |
| Edge | 79+ | ✅ Full support (Chromium) |
| IE | All | ❌ No support |

### Polyfill Coverage

jQuery SSE provides automatic fallback for browsers without native support using Ajax long-polling.

## Alternative Technologies

### WebSockets
- **Pros**: Full-duplex communication, lower latency
- **Cons**: More complex, requires special server support
- **Use case**: Real-time bidirectional communication (chat, gaming)

### Server-Sent Events (SSE)
- **Pros**: Simple HTTP-based, automatic reconnection, event IDs
- **Cons**: Unidirectional (server to client only)
- **Use case**: Live updates, notifications, news feeds

### Long Polling
- **Pros**: Works everywhere, simple
- **Cons**: Higher overhead, more resource intensive
- **Use case**: Fallback for older browsers

## Community and Support

### GitHub Repository

- [jquery-sse](https://github.com/byjg/jquery-sse)
  - Source code
  - Issue tracker
  - Pull requests welcome

### NPM Package

- [jquery-sse on npm](https://www.npmjs.com/package/jquery-sse)
  - Installation via npm
  - Version history

### jsDelivr CDN

- [jquery-sse on jsDelivr](https://www.jsdelivr.com/package/npm/jquery-sse)
  - CDN statistics
  - Usage analytics

## License

This project is licensed under the MIT License. See the [LICENSE](https://opensource.byjg.com/opensource/licensing.html) file for details.

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues on GitHub.

### Development Setup

```bash
# Clone the repository
git clone https://github.com/byjg/jquery-sse.git

# Install dependencies (if any)
npm install

# Run examples
docker run -it --rm -p 8080:80 -v $PWD:/var/www/html byjg/php:7.4-fpm-nginx
```

## Credits

Created and maintained by [João Gilberto Magalhães (JG)](https://github.com/byjg)

Part of [Open Source ByJG](http://opensource.byjg.com)
