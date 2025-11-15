# jQuery SSE

[![Build Status](https://github.com/byjg/jquery-sse/actions/workflows/build.yml/badge.svg?branch=master)](https://github.com/byjg/jquery-sse/actions/workflows/build.yml)
[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg-success.svg)](http://opensource.byjg.com)
[![GitHub source](https://img.shields.io/badge/Github-source-informational?logo=github)](https://github.com/byjg/jquery-sse/)
[![GitHub license](https://img.shields.io/github/license/byjg/jquery-sse.svg)](https://opensource.byjg.com/opensource/licensing.html)
[![GitHub release](https://img.shields.io/github/release/byjg/jquery-sse.svg)](https://github.com/byjg/jquery-sse/releases/)
[![](https://data.jsdelivr.com/v1/package/npm/jquery-sse/badge)](https://www.jsdelivr.com/package/npm/jquery-sse)

A lightweight jQuery Plugin for Server-Sent Events (SSE) EventSource Polyfill.
This plugin tries to use the native EventSource object if it's supported by the browser.
If there is no native support, the request is made by Ajax requests (polling).
You do not need to change the server side nor the client side.

*If you are looking for an SSE Polyfill library without jQuery dependency
try [yaj-sse](https://github.com/byjg/yaj-sse). The yaj-sse is a port
from version 0.1.4 of jQuery SSE.*

## Quick Start

### Client Side

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
    onMessage: function(e){
        console.log("Message"); console.log(e);
    }
});
sse.start();
```

### Server Side

```php
echo "data: My Message\n";
echo "\n";
```

## Documentation

For comprehensive documentation, please refer to the following guides:

1. **[Getting Started](docs/getting-started.md)** - Installation, dependencies, and quick start guide
2. **[Usage](docs/usage.md)** - Constructor, methods (start, stop), and basic usage
3. **[Configuration](docs/configuration.md)** - Event callbacks, options, headers, and custom events
4. **[Examples](docs/examples.md)** - Code examples for common use cases and running examples locally
5. **[Known Limitations and Quirks](docs/quirks.md)** - Browser compatibility, Ajax fallback limitations, and debugging tips
6. **[API Reference](docs/api-reference.md)** - Complete API documentation with all methods and properties
7. **[References and Resources](docs/references.md)** - External resources, specifications, and related projects

## Features

- Automatic detection and use of native EventSource when available
- Seamless fallback to Ajax polling when EventSource is not supported
- Support for custom events
- Custom HTTP headers support (automatically uses Ajax mode)
- Automatic reconnection with configurable retry intervals
- Event IDs and Last-Event-ID tracking
- Simple jQuery-style API

## Installation

### Direct Download

```html
<script src="jquery.sse.min.js"></script>
```

### Bower

```bash
bower install jquery-sse
```

### jsDelivr CDN

```html
<script src="https://cdn.jsdelivr.net/npm/jquery-sse@latest/jquery.sse.min.js"></script>
```

## Browser Support

- ✅ Chrome 6+
- ✅ Firefox 6+
- ✅ Safari 5+
- ✅ Opera 11+
- ✅ Edge 79+
- ❌ Internet Explorer (uses Ajax fallback automatically)

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues on GitHub.

## License

This project is licensed under the MIT License. See the [LICENSE](https://opensource.byjg.com/opensource/licensing.html) file for details.

----
[Open source ByJG](http://opensource.byjg.com)
