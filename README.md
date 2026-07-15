# Web-backend-project

A Full-stack web project developed with Laravel.

## What's inside

- **`client-main/`** - the front-end client: a static site (`index.html`, `assets`) that talks to the backend
- **`serverside-security-audit/`** - Backend of the project

## Why it's set up this way

The project isn't just "build a backend" - it deliberately pairs the implementation with an audit of that implementation, treating security review as part of the delivery rather than an afterthought.

## Tech stack

- Blade templating (server side)
- HTML/CSS/JS (client side)

## Structure

```
client-main/
  index.html
  assets/
serverside-security-audit/
```

## Notes

This was built as coursework, so some pieces (auth flow, data handling, etc.) may be intentionally simplified or, in places, intentionally left insecure.
