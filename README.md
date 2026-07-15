# Web-backend-project

A web project pairing a client-side application with a hands-on server-side security audit.

## What's inside

- **`client-main/`** — the front-end client: a static site (`index.html`, `assets`) that talks to the backend
- **`serverside-security-audit/`** — a security review/audit of the server side of the project

## Why it's set up this way

The project isn't just "build a backend" — it deliberately pairs the implementation with an audit of that implementation, treating security review as part of the delivery rather than an afterthought.

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

This was built as coursework, so some pieces (auth flow, data handling, etc.) may be intentionally simplified or, in places, intentionally left insecure to support the audit exercise — check the `serverside-security-audit` folder for details on what was reviewed and found.
