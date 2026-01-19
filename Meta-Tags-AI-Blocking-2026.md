# Meta Tags & X-Robots-Tag: Block AI Crawlers & Training

> Complete guide to blocking AI bots using meta tags, HTTP headers, and server configurations

**Updated: 2026-01-07**

---

## Table of Contents

- [Meta Robots Tags (HTML)](#1-meta-robots-tags-html)
- [Bot-Specific Meta Tags](#2-bot-specific-meta-tags)
- [X-Robots-Tag HTTP Headers](#3-x-robots-tag-http-headers)
- [TDM Reservation](#4-tdm-text--data-mining-reservation)
- [Content Signals](#5-content-signals)
- [Rate Limiting](#6-rate-limiting)
- [Honeypot Traps](#7-honeypot-traps)
- [JSON-LD Licensing](#8-json-ld-licensing)
- [Server Configurations](#9-server-configurations)
- [Terms of Service](#10-terms-of-service)
- [Quick Reference](#quick-reference---copypaste-blocks)

---

## 1. Meta Robots Tags (HTML)

### Basic AI Blocking

```html
<meta name="robots" content="noai">
<meta name="robots" content="noimageai">
<meta name="robots" content="noai, noimageai">
```

### Extended Blocking

```html
<meta name="robots" content="noai, noimageai, nosummary">
<meta name="robots" content="noai, noimageai, nosnippet">
<meta name="robots" content="noai, noimageai, nosummary, noml">
```

### Snippet Control

```html
<!-- Block all snippets -->
<meta name="robots" content="nosnippet">

<!-- Limit snippet length (characters) -->
<meta name="robots" content="max-snippet:100">
<meta name="robots" content="max-snippet:50">

<!-- Limit image preview -->
<meta name="robots" content="max-image-preview:none">
<meta name="robots" content="max-image-preview:standard">
```

### AI Training Specific (Proposed Standards)

```html
<meta name="robots" content="DisallowAITraining">
<meta name="robots" content="noAIPreferenceVocabularyTerm">
<meta name="okforai" content="false">
```

---

## 2. Bot-Specific Meta Tags

### OpenAI

```html
<meta name="gptbot" content="noindex, nofollow">
<meta name="openai-user" content="noai">
<meta name="OAI-SearchBot" content="noindex">
```

### Anthropic (Claude)

```html
<meta name="claudebot" content="noindex, nofollow">
<meta name="anthropic-ai" content="noindex">
<meta name="Claude-Web" content="noindex">
```

### Google

```html
<meta name="googlebot" content="noai, noml">
<meta name="Google-Extended" content="noindex">
```

### Microsoft

```html
<meta name="bingbot" content="noai, noml, nocache">
<meta name="copilotbot" content="noai">
```

### Meta

```html
<meta name="facebookbot" content="noai">
<meta name="Meta-ExternalAgent" content="noindex">
```

### Apple

```html
<meta name="applebot" content="noai">
<meta name="Applebot-Extended" content="noindex">
<meta name="apple-genai" content="noai">
```

### Amazon

```html
<meta name="amazonbot" content="noai">
```

### xAI

```html
<meta name="grok" content="noindex">
```

### Search & Research Bots

```html
<meta name="perplexitybot" content="noindex">
<meta name="phindbot" content="noindex">
<meta name="youbot" content="noai">
<meta name="neevaai" content="noai">
<meta name="exa-bot" content="noindex">   #French search engine Exalead - not in use!
```

### Chinese AI Bots

```html
<meta name="bytespider" content="noai, noindex">
<meta name="deepseekbot" content="noindex">
<meta name="baidubot" content="noai">
<meta name="qwenbot" content="noindex">
```

### Data & Crawl Bots

```html
<meta name="CCBot" content="nofollow, noindex">
<meta name="commoncrawl" content="noai">
<meta name="dataforai" content="noai">
<meta name="DataForSeoBot" content="noindex">
<meta name="Diffbot" content="noindex">
<meta name="cohere-ai" content="noindex">
```

### Other AI Bots

```html
<meta name="poebot" content="noindex">
<meta name="quorabot" content="noindex">
<meta name="x-robot" content="noindex">
<meta name="ai-crawler" content="noindex">
<meta name="webcrawler-ai" content="noindex">
<meta name="anybot" content="noai">  #Add your own bot
```

### Complete Bot-Specific Block (Copy-Paste Ready)

```html
<meta name="robots" content="noai, noimageai, nosummary">
<meta name="gptbot" content="noindex, nofollow">
<meta name="openai-user" content="noai">
<meta name="OAI-SearchBot" content="noindex">
<meta name="claudebot" content="noindex, nofollow">
<meta name="anthropic-ai" content="noindex">
<meta name="googlebot" content="noml">
<meta name="Google-Extended" content="noindex">
<meta name="bingbot" content="noai, noml">
<meta name="copilotbot" content="noai">
<meta name="Applebot-Extended" content="noindex">
<meta name="facebookbot" content="noai">
<meta name="Meta-ExternalAgent" content="noindex">
<meta name="amazonbot" content="noai">
<meta name="bytespider" content="noindex">
<meta name="perplexitybot" content="noindex">
<meta name="CCBot" content="noindex">
<meta name="commoncrawl" content="noai">
<meta name="cohere-ai" content="noindex">
<meta name="deepseekbot" content="noindex">
```

---

## 3. X-Robots-Tag HTTP Headers

### Apache (.htaccess)

```apache
Header set X-Robots-Tag "noai, noimageai"
Header set X-Robots-Tag "noai, noimageai, nosummary"
Header set X-Robots-Tag "noai, noimageai, nosummary, noml"
Header set X-Robots-Tag "noai, noimageai, SPC"
Header set X-Robots-Tag "noindex, nofollow, max-snippet:150, max-image-preview:standard"
```

### Bot-Specific Headers (Apache)

```apache
<IfModule mod_headers.c>
    Header set X-Robots-Tag: DisallowAITraining
    Header set X-Robots-Tag "noai, noimageai"
    Header set X-Robots-Tag "gptbot: noindex, nofollow"
    Header set X-Robots-Tag "claudebot: noindex, nofollow"
    Header set X-Robots-Tag "Google-Extended: noindex"
    Header set X-Robots-Tag "Applebot-Extended: noindex"
    Header set X-Robots-Tag "bytespider: noindex"
</IfModule>
```

### Nginx

```nginx
add_header X-Robots-Tag "noai, noimageai" always;
add_header X-Robots-Tag "noai, noimageai, nosummary" always;
```

### Node.js / Express.js

```javascript
app.use((req, res, next) => {
    res.setHeader("X-Robots-Tag", "noai, noimageai");
    next();
});
```

### Fastly (VCL)

```vcl
set resp.http.x-robots-tag = "noai, noimageai";
```

### Cloudflare Workers

```javascript
addEventListener('fetch', event => {
    event.respondWith(handleRequest(event.request));
});

async function handleRequest(request) {
    let response = await fetch(request);
    response = new Response(response.body, response);
    response.headers.set('X-Robots-Tag', 'noai, noimageai');
    return response;
}
```

---

## 4. TDM (Text & Data Mining) Reservation

### EU TDM Opt-Out (Machine Readable)

```html
<head>
    <meta name="robots" content="noai, noimageai">
    <meta name="tdm-reservation" content="1">
    <meta name="tdm-policy" content="https://yoursite.com/tdm-policy">
</head>
```

### HTTP Header

```apache
Header set tdm-reservation "1"
Header set X-Robots-Tag "tdm-reservation: 1"
```

### AI Training Robots.txt Directive (Proposed)

```
User-agent: AITraining
Disallow: /

User-agent: *
Disallow: /
```

---

## 5. Content Signals

### Content Signals Protocol

From [contentsignals.org](https://contentsignals.org/):

```
User-Agent: *
Content-Signal: ai-train=no, search=yes, ai-input=no
```

### SPC (Server Privacy Control)

```apache
Header set X-Robots-Tag "noai, noimageai, SPC"
```

### GPC (Global Privacy Control)

```apache
Header set X-Robots-Tag "noai, noimageai, GPC"
```

---

## 6. Rate Limiting

### Apache - Connection Limit (.htaccess)

```apache
<IfModule mod_rewrite.c>
    MaxConnPerIP 2
</IfModule>
```

### Apache - mod_ratelimit

```apache
<IfModule mod_ratelimit.c>
    SetEnvIf Remote_Addr ".*" RATE_LIMIT
    SetEnv rate-limit-interval "1800"
    SetEnv rate-limit-threshold "1"
</IfModule>
```

### Apache - mod_evasive

Install:
```bash
sudo apt-get install libapache2-mod-evasive
```

Config `/etc/apache2/mods-available/evasive.conf`:
```apache
DOSHashTableSize 3097
DOSPageCount 5
DOSSiteCount 50
DOSBlockingPeriod 600
```

Restart:
```bash
sudo systemctl restart apache2
```

### Nginx Rate Limiting

```nginx
http {
    limit_req_zone $binary_remote_addr zone=one:10m rate=1r/s;
    limit_req_zone $binary_remote_addr zone=ai_limit:10m rate=1r/m;
}

server {
    location / {
        limit_req zone=one burst=5 nodelay;
    }
}
```

### Aggressive Rate Limit for AI Bots (Nginx)

```nginx
map $http_user_agent $is_ai_bot {
    default 0;
    ~*GPTBot 1;
    ~*ClaudeBot 1;
    ~*Bytespider 1;
    ~*Google-Extended 1;
}

limit_req_zone $binary_remote_addr zone=ai_strict:10m rate=1r/h;

server {
    location / {
        if ($is_ai_bot) {
            limit_req zone=ai_strict burst=1;
        }
    }
}
```

---

## 7. Honeypot Traps

### HTML Hidden Link

```html
<a href="/trap-page" class="honeypot">Hidden Link</a>
<style>.honeypot { display: none; visibility: hidden; }</style>
```

### PHP Trap Page

```php
<?php
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$time = date('Y-m-d H:i:s');
$log = "$time | IP: $ip | UA: $ua\n";
file_put_contents('honeypot_log.txt', $log, FILE_APPEND | LOCK_EX);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow, noai">
    <title>Nothing Here</title>
</head>
<body>Nothing to see here.</body>
</html>
```

### CSS Hidden Content Detection

```html
<div style="position:absolute;left:-9999px;opacity:0;">
    If you can read this, you are a bot. Your IP has been logged.
</div>
```

---

## 8. JSON-LD Licensing

### Schema.org AI Usage Restriction

```html
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "license": {
        "@type": "CreativeWork",
        "name": "No AI Training License",
        "url": "https://yoursite.com/no-ai-license"
    },
    "usageInfo": {
        "aiTraining": "disallowed",
        "summarization": "disallowed",
        "reproduction": "disallowed",
        "scraping": "disallowed"
    },
    "copyrightNotice": "All rights reserved. AI training prohibited."
}
</script>
```

---

## 9. Server Configurations

### Complete Apache .htaccess

```apache
<IfModule mod_headers.c>
    Header set X-Robots-Tag "noai, noimageai, nosummary"
    Header set tdm-reservation "1"
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block AI bots
    RewriteCond %{HTTP_USER_AGENT} (GPTBot|ClaudeBot|Bytespider|Google-Extended) [NC]
    RewriteRule .* - [F,L]
</IfModule>
```

### Complete Nginx Config

```nginx
server {
    # AI blocking headers
    add_header X-Robots-Tag "noai, noimageai, nosummary" always;
    add_header tdm-reservation "1" always;
    
    # Block AI bots
    if ($http_user_agent ~* (GPTBot|ClaudeBot|Bytespider|Google-Extended)) {
        return 403;
    }
}
```

### Complete HTML Head

```html
<head>
    <meta charset="UTF-8">
    <meta name="AITraining">
    <meta name="robots" content="noai, noimageai, nosummary">
    <meta name="tdm-reservation" content="1">
    <meta name="gptbot" content="noindex, nofollow">
    <meta name="claudebot" content="noindex, nofollow">
    <meta name="Google-Extended" content="noindex">
    <meta name="bytespider" content="noindex">
    <meta name="Applebot-Extended" content="noindex">
    <meta name="perplexitybot" content="noindex">
    <meta name="CCBot" content="noindex">
</head>
```

---

## 10. Terms of Service

### Example Legal Text

> Any copying, including ephemeral copying, for the purpose of training an artificial intelligence (AI), large language model (LLM), machine learning system, or neural network is strictly prohibited.
>
> Unauthorized scraping, data extraction, or use of automated tools (including AI models, bots, and crawlers) to access, store, or repurpose content from this site is strictly prohibited. Any violation may result in legal action, IP bans, and further enforcement measures.

### HTML Footer Notice

```html
<footer>
    <p>&copy; 2026 Your Site. All rights reserved.</p>
    <p>
        <small>
            AI Training Prohibited. No part of this website may be used for 
            training AI models, LLMs, or machine learning systems without 
            explicit written permission.
        </small>
    </p>
</footer>
```

---

## Quick Reference - Copy/Paste Blocks

### Minimal Protection

```html
<meta name="robots" content="noai, noimageai">
```

### Standard Protection

```html
<meta name="robots" content="noai, noimageai, nosummary">
<meta name="gptbot" content="noindex">
<meta name="claudebot" content="noindex">
<meta name="Google-Extended" content="noindex">
```

### Maximum Protection

```html
<meta name="robots" content="noai, noimageai, nosummary, nosnippet">
<meta name="tdm-reservation" content="1">
<meta name="gptbot" content="noindex, nofollow">
<meta name="claudebot" content="noindex, nofollow">
<meta name="anthropic-ai" content="noindex">
<meta name="Google-Extended" content="noindex">
<meta name="Applebot-Extended" content="noindex">
<meta name="bytespider" content="noindex">
<meta name="perplexitybot" content="noindex">
<meta name="CCBot" content="noindex">
<meta name="cohere-ai" content="noindex">
<meta name="deepseekbot" content="noindex">
<meta name="Meta-ExternalAgent" content="noindex">
```


#20260107 FROM ALBBA: HEADERS:

 Headers & Meta Tags
Start with unambiguous, machine-readable signals—even if ignored by some scrapers, they establish legal and ethical standing. 
Add these to every blog post’s <head>:

<meta name=\"robots\" content=\"index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1\">
<meta name=\"googlebot\" content=\"index, follow, max-snippet:-1\">
<meta name=\"ai\" content=\"noai, noimageai, noarchive\">
<meta name=\"bingbot\" content=\"noai, noimageai\">
<meta name=\"slurp\" content=\"noai\">
<link rel=\"canonical\" href=\"https://yourblog.com/your-post/\">
<meta name=\"application-name\" content=\"Your Blog Name\">


# Block generic patterns used by AI scrapers
User-agent: *
Disallow: /*?*
Disallow: /*.php$
Disallow: /*.json$
Disallow: /search?q=


# HTTP Response Headers for Machine Readability
Add these headers server-side (via .htaccess, nginx config, or Cloudflare Workers) to reinforce intent:

X-Robots-Tag: noai, noimageai, noarchive
Permissions-Policy: interest-cohort=(), attribution-reporting=()
Referrer-Policy: strict-origin-when-cross-origi

---

*Use responsibly and in compliance with applicable laws.*
