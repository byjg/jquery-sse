---
sidebar_position: 1
---

# Getting Started

A lightweight jQuery Plugin for Server-Sent Events (SSE) EventSource Polyfill.

## Overview

This plugin tries to use the native EventSource object if it's supported by the browser. If there is no native support, the request is made by Ajax requests (polling). You do not need to change the server side nor the client side.

:::info
If you are looking for an SSE Polyfill library without jQuery dependency, try [yaj-sse](https://github.com/byjg/yaj-sse). The yaj-sse is a port from version 0.1.4 of jQuery SSE.
:::

## Dependencies

- jQuery

## Installation

### Direct Download

Just download the repository and point to the jQuery plugin:

```html
<script src="jquery.sse.js"></script>
```

or use the minified version:

```html
<script src="jquery.sse.min.js"></script>
```

### Bower

```bash
bower install jquery-sse
```

### jsDelivr CDN

You can also use jsDelivr CDN to include the library:

```html
<script src="https://cdn.jsdelivr.net/npm/jquery-sse@latest/jquery.sse.min.js"></script>
```

## Quick Start

### Client Side

```javascript
var sse = $.SSE('http://example.com/sse-server.php', {
    onMessage: function(e){
        console.log("Message");
        console.log(e);
    }
});
sse.start();
```

### Server Side

```php
echo "data: My Message\n";
echo "\n";
```
