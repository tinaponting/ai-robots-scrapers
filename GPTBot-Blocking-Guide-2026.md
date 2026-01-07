# GPTBot & OpenAI Bots - Complete Blocking Guide 2026

> Comprehensive guide to blocking OpenAI's web crawlers (GPTBot, OAI-SearchBot, ChatGPT-User)

**Updated: 2026-01-07**

---

## Table of Contents

- [OpenAI Bot Overview](#openai-bot-overview)
- [User Agent Strings](#user-agent-strings)
- [Known IP Ranges](#known-ip-ranges)
- [Robots.txt Methods](#robotstxt-methods)
- [Apache .htaccess Methods](#apache-htaccess-methods)
- [Nginx Methods](#nginx-methods)
- [Meta Tags](#meta-tags)
- [Cloudflare Rules](#cloudflare-rules)
- [Other Platforms](#other-platforms)

---

## OpenAI Bot Overview

OpenAI operates several web crawlers:

| Bot Name | Purpose | Respects robots.txt |
|----------|---------|---------------------|
| **GPTBot** | Training data collection | Yes |
| **OAI-SearchBot** | SearchGPT / ChatGPT search | Yes |
| **ChatGPT-User** | Real-time browsing by users | Yes |

### Important Notes

- **Case Sensitivity**: Some scrapers use `GPTBOT` (uppercase) to bypass filters - block both!
- **Multiple Bots**: Block ALL OpenAI bots, not just GPTBot
- **IP Blocking**: User agents can be spoofed; IP blocking is more reliable

---

## User Agent Strings

### GPTBot (Training Crawler)

```
Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.0; +https://openai.com/gptbot)
Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.1; +https://openai.com/gptbot)
Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)
```

### OAI-SearchBot (Search Crawler)

```
Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; OAI-SearchBot/1.0; +https://openai.com/searchbot)
Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36; compatible; OAI-SearchBot/1.0; +https://openai.com/searchbot
```

### ChatGPT-User (Browse Mode)

```
Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; ChatGPT-User/1.0; +https://openai.com/bot)
```

---

## Known IP Ranges

OpenAI operates from Azure infrastructure. Block these IP ranges for complete protection:

### Official OpenAI IP Ranges (2026)

| CIDR Block | Notes |
|------------|-------|
| `20.171.206.0/24` | Azure - OpenAI |
| `20.171.207.0/24` | Azure - OpenAI |
| `20.125.66.80/28` | Azure - OpenAI |
| `4.227.36.0/25` | Azure - OpenAI |
| `20.42.10.176/28` | Azure - OpenAI |
| `51.8.102.0/24` | Azure - OpenAI |
| `52.230.152.0/24` | Azure - OpenAI |
| `52.233.106.0/24` | Azure - OpenAI |
| `135.234.64.0/24` | Azure - OpenAI |
| `172.182.193.160/28` | Azure - OpenAI |
| `172.203.190.128/28` | Azure - OpenAI |
| `23.98.142.176/28` | Azure - OpenAI |
| `40.84.180.224/28` | Azure - OpenAI |
| `13.65.240.240/28` | Azure - OpenAI |
| `20.161.75.208/28` | Azure - OpenAI |
| `52.225.75.208/28` | Azure - OpenAI |
| `52.156.77.0/24` | Azure - OpenAI |

### Specific IPs (Observed)

```
51.8.102.54
51.8.102.157
20.171.206.1 - 20.171.206.254
20.171.207.1 - 20.171.207.254
```

> **Note**: OpenAI periodically updates their IP ranges. Check [openai.com/gptbot](https://openai.com/gptbot) for the latest.

---

## Robots.txt Methods

### Basic Blocking

```
# Block GPTBot (training)
User-agent: GPTBot
Disallow: /

# Block case variation (scrapers use this!)
User-agent: GPTBOT
Disallow: /

User-agent: gptbot
Disallow: /

# Block OAI-SearchBot (search)
User-agent: OAI-SearchBot
Disallow: /

# Block ChatGPT browsing
User-agent: ChatGPT-User
Disallow: /
```

### Complete OpenAI Block

```
# ===== OPENAI BOTS =====
User-agent: GPTBot
Disallow: /

User-agent: GPTBOT
Disallow: /

User-agent: gptbot
Disallow: /

User-agent: OAI-SearchBot
Disallow: /

User-agent: ChatGPT-User
Disallow: /

User-agent: ChatGPT
Disallow: /

User-agent: OpenAI
Disallow: /

User-agent: openai
Disallow: /
```

### Partial Blocking (Allow some paths)

```
# Allow homepage, block everything else
User-agent: GPTBot
Allow: /$
Disallow: /

# Block specific directories
User-agent: GPTBot
Disallow: /blog/
Disallow: /articles/
Disallow: /content/
Disallow: /api/
```

---

## Apache .htaccess Methods

### Block by User Agent

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block GPTBot (all case variations)
    RewriteCond %{HTTP_USER_AGENT} GPTBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} GPTBOT [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} gptbot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} OAI-SearchBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} ChatGPT-User [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} ChatGPT [NC]
    RewriteRule .* - [F,L]
</IfModule>
```

### Block by User Agent + Referrer

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block OpenAI by referrer
    RewriteCond %{HTTP_REFERER} openai\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} chatgpt\.com [NC]
    RewriteRule .* - [F,L]
    
    # Block by user agent
    RewriteCond %{HTTP_USER_AGENT} GPTBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} OAI-SearchBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} ChatGPT [NC]
    RewriteRule .* - [F,L]
</IfModule>
```

### Block by IP Ranges

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # OpenAI IP ranges
    RewriteCond %{REMOTE_ADDR} ^20\.171\.206\. [OR]
    RewriteCond %{REMOTE_ADDR} ^20\.171\.207\. [OR]
    RewriteCond %{REMOTE_ADDR} ^20\.125\.66\. [OR]
    RewriteCond %{REMOTE_ADDR} ^4\.227\.36\. [OR]
    RewriteCond %{REMOTE_ADDR} ^20\.42\.10\. [OR]
    RewriteCond %{REMOTE_ADDR} ^51\.8\.102\. [OR]
    RewriteCond %{REMOTE_ADDR} ^52\.230\.152\. [OR]
    RewriteCond %{REMOTE_ADDR} ^52\.233\.106\. [OR]
    RewriteCond %{REMOTE_ADDR} ^135\.234\.64\. [OR]
    RewriteCond %{REMOTE_ADDR} ^172\.182\.193\. [OR]
    RewriteCond %{REMOTE_ADDR} ^172\.203\.190\.
    RewriteRule .* - [F,L]
</IfModule>
```

### Complete Apache Block (User Agent + IP)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # ===== BLOCK OPENAI BY USER AGENT =====
    RewriteCond %{HTTP_USER_AGENT} GPTBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} GPTBOT [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} OAI-SearchBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} ChatGPT-User [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} ChatGPT [NC]
    RewriteRule .* - [F,L]
    
    # ===== BLOCK OPENAI BY IP =====
    RewriteCond %{REMOTE_ADDR} ^20\.171\.206\. [OR]
    RewriteCond %{REMOTE_ADDR} ^20\.171\.207\. [OR]
    RewriteCond %{REMOTE_ADDR} ^51\.8\.102\. [OR]
    RewriteCond %{REMOTE_ADDR} ^52\.230\.152\. [OR]
    RewriteCond %{REMOTE_ADDR} ^52\.233\.106\. [OR]
    RewriteCond %{REMOTE_ADDR} ^135\.234\.64\.
    RewriteRule .* - [F,L]
</IfModule>

# ===== HEADERS =====
<IfModule mod_headers.c>
    Header set X-Robots-Tag "noai, noimageai"
</IfModule>
```

### Using Deny Directive

```apache
# Block specific IPs
<RequireAll>
    Require all granted
    Require not ip 20.171.206.0/24
    Require not ip 20.171.207.0/24
    Require not ip 51.8.102.0/24
    Require not ip 52.230.152.0/24
    Require not ip 52.233.106.0/24
    Require not ip 135.234.64.0/24
</RequireAll>
```

---

## Nginx Methods

### Block by User Agent

```nginx
# Block OpenAI bots
if ($http_user_agent ~* (GPTBot|GPTBOT|gptbot|OAI-SearchBot|ChatGPT-User|ChatGPT)) {
    return 403;
}
```

### Block by IP Ranges

```nginx
# OpenAI IP ranges - deny
geo $openai_block {
    default 0;
    20.171.206.0/24 1;
    20.171.207.0/24 1;
    20.125.66.80/28 1;
    4.227.36.0/25 1;
    20.42.10.176/28 1;
    51.8.102.0/24 1;
    52.230.152.0/24 1;
    52.233.106.0/24 1;
    135.234.64.0/24 1;
    172.182.193.160/28 1;
    172.203.190.128/28 1;
}

server {
    if ($openai_block) {
        return 403;
    }
}
```

### Complete Nginx Block

```nginx
# Map for OpenAI bot detection
map $http_user_agent $is_openai_bot {
    default 0;
    ~*GPTBot 1;
    ~*GPTBOT 1;
    ~*OAI-SearchBot 1;
    ~*ChatGPT-User 1;
    ~*ChatGPT 1;
}

# OpenAI IP ranges
geo $is_openai_ip {
    default 0;
    20.171.206.0/24 1;
    20.171.207.0/24 1;
    51.8.102.0/24 1;
    52.230.152.0/24 1;
    52.233.106.0/24 1;
    135.234.64.0/24 1;
}

server {
    listen 80;
    server_name example.com;
    
    # Block by user agent OR IP
    if ($is_openai_bot) {
        return 403;
    }
    
    if ($is_openai_ip) {
        return 403;
    }
    
    # Add headers
    add_header X-Robots-Tag "noai, noimageai" always;
    
    # ... rest of config
}
```

### Rate Limit OpenAI Bots

```nginx
# Aggressive rate limiting for OpenAI
limit_req_zone $binary_remote_addr zone=openai_limit:10m rate=1r/h;

map $http_user_agent $is_openai {
    default 0;
    ~*GPTBot 1;
    ~*OAI-SearchBot 1;
}

server {
    location / {
        if ($is_openai) {
            limit_req zone=openai_limit burst=1 nodelay;
        }
    }
}
```

---

## Meta Tags

### HTML Head

```html
<head>
    <meta name="robots" content="noai, noimageai">
    <meta name="gptbot" content="noindex, nofollow">
    <meta name="GPTBot" content="noindex, nofollow">
    <meta name="OAI-SearchBot" content="noindex, nofollow">
    <meta name="ChatGPT-User" content="noindex, nofollow">
    <meta name="openai" content="noindex, nofollow">
</head>
```

### X-Robots-Tag Header

```apache
# Apache
Header set X-Robots-Tag "gptbot: noindex, nofollow"
Header set X-Robots-Tag "OAI-SearchBot: noindex, nofollow"
```

```nginx
# Nginx
add_header X-Robots-Tag "gptbot: noindex, nofollow" always;
add_header X-Robots-Tag "OAI-SearchBot: noindex, nofollow" always;
```

---

## Cloudflare Rules

### WAF Custom Rule - Block User Agent

```
(http.user_agent contains "GPTBot") or
(http.user_agent contains "GPTBOT") or
(http.user_agent contains "gptbot") or
(http.user_agent contains "OAI-SearchBot") or
(http.user_agent contains "ChatGPT-User") or
(http.user_agent contains "ChatGPT")
```

**Action**: Block

### WAF Custom Rule - Block IP Ranges

```
(ip.src in {20.171.206.0/24 20.171.207.0/24 51.8.102.0/24 52.230.152.0/24 52.233.106.0/24 135.234.64.0/24})
```

**Action**: Block

### Combined Rule

```
(http.user_agent contains "GPTBot") or
(http.user_agent contains "OAI-SearchBot") or
(http.user_agent contains "ChatGPT") or
(ip.src in {20.171.206.0/24 20.171.207.0/24 51.8.102.0/24})
```

---

## Other Platforms

### WordPress (functions.php)

```php
<?php
// Block OpenAI bots
add_action('init', 'block_openai_bots');
function block_openai_bots() {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $openai_bots = ['GPTBot', 'GPTBOT', 'gptbot', 'OAI-SearchBot', 'ChatGPT-User', 'ChatGPT'];
    
    foreach ($openai_bots as $bot) {
        if (stripos($ua, $bot) !== false) {
            http_response_code(403);
            exit('Access denied');
        }
    }
}

// Add robots.txt rules
add_filter('robots_txt', 'add_openai_robots_rules', 99, 2);
function add_openai_robots_rules($output, $public) {
    $output .= "\nUser-agent: GPTBot\nDisallow: /\n";
    $output .= "\nUser-agent: GPTBOT\nDisallow: /\n";
    $output .= "\nUser-agent: OAI-SearchBot\nDisallow: /\n";
    $output .= "\nUser-agent: ChatGPT-User\nDisallow: /\n";
    return $output;
}
?>
```

### Node.js / Express

```javascript
const OPENAI_BOTS = ['GPTBot', 'GPTBOT', 'gptbot', 'OAI-SearchBot', 'ChatGPT-User', 'ChatGPT'];
const OPENAI_IPS = ['20.171.206.', '20.171.207.', '51.8.102.', '52.230.152.'];

app.use((req, res, next) => {
    const ua = req.headers['user-agent'] || '';
    const ip = req.ip || req.connection.remoteAddress;
    
    // Check user agent
    if (OPENAI_BOTS.some(bot => ua.includes(bot))) {
        return res.status(403).send('Access denied');
    }
    
    // Check IP
    if (OPENAI_IPS.some(range => ip.startsWith(range))) {
        return res.status(403).send('Access denied');
    }
    
    next();
});
```

### Python Flask

```python
from flask import Flask, request, abort

app = Flask(__name__)

OPENAI_BOTS = ['GPTBot', 'GPTBOT', 'gptbot', 'OAI-SearchBot', 'ChatGPT-User', 'ChatGPT']
OPENAI_IP_PREFIXES = ['20.171.206.', '20.171.207.', '51.8.102.', '52.230.152.']

@app.before_request
def block_openai():
    ua = request.headers.get('User-Agent', '')
    ip = request.remote_addr
    
    # Block by user agent
    if any(bot.lower() in ua.lower() for bot in OPENAI_BOTS):
        abort(403)
    
    # Block by IP
    if any(ip.startswith(prefix) for prefix in OPENAI_IP_PREFIXES):
        abort(403)
```

### HAProxy

```haproxy
frontend http_front
    bind *:80
    
    # OpenAI bot ACLs
    acl is_gptbot hdr_sub(User-Agent) -i GPTBot
    acl is_gptbot_upper hdr_sub(User-Agent) GPTBOT
    acl is_oai_search hdr_sub(User-Agent) -i OAI-SearchBot
    acl is_chatgpt hdr_sub(User-Agent) -i ChatGPT
    
    # OpenAI IP ACLs
    acl is_openai_ip src 20.171.206.0/24
    acl is_openai_ip src 20.171.207.0/24
    acl is_openai_ip src 51.8.102.0/24
    
    # Block
    http-request deny if is_gptbot or is_gptbot_upper or is_oai_search or is_chatgpt or is_openai_ip
    
    default_backend webservers
```

### Caddy

```caddyfile
example.com {
    @openai_bots {
        header_regexp User-Agent (?i)(GPTBot|GPTBOT|OAI-SearchBot|ChatGPT-User|ChatGPT)
    }
    
    @openai_ips {
        remote_ip 20.171.206.0/24 20.171.207.0/24 51.8.102.0/24
    }
    
    respond @openai_bots "Access Denied" 403
    respond @openai_ips "Access Denied" 403
    
    header X-Robots-Tag "noai, noimageai"
}
```

---

## Troubleshooting

### Verify Blocking Works

Test with curl:

```bash
# Test GPTBot user agent
curl -A "Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)" https://yoursite.com

# Should return 403 Forbidden
```

### Check Logs for GPTBot

```bash
# Apache
grep -i "gptbot\|oai-searchbot\|chatgpt" /var/log/apache2/access.log

# Nginx
grep -i "gptbot\|oai-searchbot\|chatgpt" /var/log/nginx/access.log
```

### Common Issues

| Issue | Solution |
|-------|----------|
| GPTBot still accessing | Check for uppercase `GPTBOT` variant |
| OAI-SearchBot bypassing | Add IP-based blocking |
| Rules not working | Verify mod_rewrite is enabled |
| Partial blocking | Combine user-agent + IP blocking |

---

## Resources

- [OpenAI GPTBot Documentation](https://openai.com/gptbot)
- [OpenAI SearchBot Documentation](https://openai.com/searchbot)
- [OpenAI IP Ranges (JSON)](https://openai.com/gptbot.json)

---

*Updated: 2026-01-07*
