# AI Bot Blocking - All Methods

> Block Scrapers, Image Stealers & AI Bots across Apache, Nginx, PHP, Python, Node.js, Hugo, Kirby, HAProxy, Caddy, Go, Ruby & More

**Updated: 2026-01-07**

---

## Table of Contents

- [Apache .htaccess](#apache-htaccess)
- [Nginx](#nginx)
- [PHP](#php)
- [Python (Flask/Django/FastAPI)](#python)
- [Node.js / Express.js](#nodejs--expressjs)
- [Go (Golang)](#go-golang)
- [Ruby on Rails](#ruby-on-rails)
- [Hugo (Static Site)](#hugo-static-site)
- [Kirby CMS](#kirby-cms)
- [HAProxy](#haproxy)
- [Caddy Server](#caddy-server)
- [Fail2ban](#fail2ban)
- [Rate Limiting](#rate-limiting)
- [Cloudflare WAF](#cloudflare-waf)
- [Honeypot Trap](#honeypot-trap)
- [Creative Obstruction](#creative-obstruction)

---

## Apache .htaccess

### Basic User-Agent Blocking

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_USER_AGENT} ^.*(ChatGPT-User|ClaudeBot|PerplexityBot).*$ [NC]
    RewriteRule .* - [F,L]
</IfModule>
```

### Extended Bot List

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_USER_AGENT} (AI2Bot|anthropic-ai|Bytespider|ChatGPT-User|Claude-Web|ClaudeBot|DataForSeoBot|GPTBot|Google-Extended) [NC]
    RewriteRule (.*) - [F,L]
</IfModule>
```

### Return 403 Forbidden

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_USER_AGENT} (GPTBot|ClaudeBot|Bytespider) [NC]
    RewriteRule .* - [R=403,L]
</IfModule>
```

### Return 503 Service Unavailable

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_USER_AGENT} ^.*(GPTBot|ClaudeBot|Bytespider).*$ [NC]
    RewriteCond %{REQUEST_URI} !^/robots\.txt$
    RewriteRule .* - [R=503,L]
</IfModule>
```

### Block via Request URL

```apache
<IfModule mod_alias.c>
    RedirectMatch 403 /bot/
</IfModule>
```

### Apache 2.4+ (mod_authz_core)

```apache
<IfModule authz_core_module>
    <If "%{HTTP_USER_AGENT} == 'GPTBot'">
        Require all denied
    </If>
</IfModule>
```

### Legacy Method (BrowserMatch)

```apache
BrowserMatchNoCase GPTBot bad_bot
BrowserMatchNoCase ClaudeBot bad_bot
BrowserMatchNoCase Bytespider bad_bot
Order Deny,Allow
Deny from env=bad_bot
```

### Block via Query String

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{QUERY_STRING} (bot|crawl) [NC]
    RewriteRule (.*) - [F,L]
</IfModule>
```

### Block via Referrer

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_REFERER} ^http://(.*)openai\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} ^http://(.*)anthropic\.com [NC]
    RewriteRule (.*) - [F,L]
</IfModule>

```
# haccess:

### ALT 3:

<IfModule mod_rewrite.c>
RewriteCond %{HTTP_USER_AGENT}^.*(BotToBlock1|BotToBlock2|BotToBlock3).*$ [NC] 
RewriteRule .* – [F,L]</IfModule>

#Another one:

<IfModule mod_rewrite.c>
RewriteCond %{HTTP_USER_AGENT} ^.*(ChatGPT-User|ClaudeBot|PerplexityBot).*$ [NC]
RewriteCond %{HTTP_USER_AGENT} ^.*(ChatGPT-User|ClaudeBot|PerplexityBot).*$ [NC]
RewriteCond %{HTTP_USER_AGENT} ^.*(ChatGPT-User|ClaudeBot|PerplexityBot).*$ [NC]
RewriteCond %{HTTP_USER_AGENT} ^.*(ChatGPT-User|ClaudeBot|PerplexityBot).*$ [NC]
RewriteRule .* - [F,L]

#ALTERNATIVE:

<IfModule mod_rewrite.c>
RewriteCond %{HTTP_USER_AGENT} (AI2Bot(.*)|anthropic-ai(.*)|Bytespider(.*)|ChatGPT-User(.*)|Claude-Web(.*)|ClaudeBot(.*)|DataForSeoBot(.*)) [NC]
RewriteRule (.*) - [F,L]
</IfModule>


## ALT 4:
<IfModule mod_rewrite.c>
RewriteCond %{HTTP_USER_AGENT} (EvilBotHere|SpamSpewer|SecretAgentAgent) [NC]
RewriteRule (.*) - [F,L]
</IfModule>

---

## Nginx

NGINX uses `nginx.conf` or vhost files instead of `.htaccess`.

### Basic Blocking

```nginx
if ($http_user_agent ~* (GPTBot|ChatGPT|ClaudeBot|Bytespider|AI2Bot)) {
    return 403;
}
```

### Case-Insensitive Matching

```nginx
if ($http_user_agent ~* (GPTBot|ChatGPT|ClaudeBot|Bytespider)) {
    return 403;
}
```

### Redirect Instead of Block

```nginx
if ($http_user_agent ~* (GPTBot|ClaudeBot|Bytespider)) {
    return 301 https://yoursite.com/blocked;
}
```

### Block by Referrer

```nginx
if ($http_referer ~ "openai\.com|anthropic\.com") {
    return 403;
}
```

### Return 418 (Teapot)

```nginx
if ($scraper = 1) {
    return 418 "I'm a teapot";
}
```
##ALT: way to block ai bots. Block via Request URL:

<IfModule mod_alias.c>
RedirectMatch 403 /bot/
</IfModule>

 
<IfModule mod_alias.c>
RedirectMatch 403 /(bot|bot)/
</IfModule>

# Apache:

<IfModule authz_core_module>
<If "%{HTTP_USER_AGENT} == 'BOT'">
Require all denied
</If>
</IfModule>

###BrowserMatch:

BrowserMatchNoCase (YOUR BOOTS HERE) bad_bot
Order Deny,Allow
Deny from env=bad_bot

###Alternative with no welcome at all:

<IfModule authz_core_module>
<If "%{HTTP_USER_AGENT} == 'GPTBot'">
<If "%{HTTP_USER_AGENT} == 'robots.txt'">
Require all denied
</If></IfModule>

.......
###ALT - Block via Query String:

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{QUERY_STRING} (bot|bot) [NC]
RewriteRule (.*) - [F,L]
</IfModule>

............

####### Notorous bots: 
with IP adress  For notorius ai bots, who gets under the radar.

RewriteCond %{HTTP_USER_AGENT} ^$ [OR]
RewriteCond %{HTTP_USER_AGENT} (bot|crawl|robot) [NC]
RewriteCond %{HTTP_USER_AGENT}!(bot|bot|bot|bot|bot|bot) [NC]
RewriteRule ^/?.*$ "http\:\/\/127\.0\.0\.1" [R,L]

* Change above IP to the Notirous one not wanted ip

.....

#Block via Referrer:

<IfModule mod_rewrite.c>
RewriteCond %{HTTP_REFERER} ^http://(.*)exempel\.ai [NC,OR]
RewriteCond %{HTTP_REFERER} ^http://(.*)exempel\.ai [NC,OR]
RewriteCond %{HTTP_REFERER} ^http://(.*)exempel\.ai [NC]
RewriteRule (.*) - [F,L]
</IfModule>


---

## PHP
### Basic Blocking

```php
<?php
$aiBots = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Claude-Web', 'Bytespider', 'AI2Bot', 'DataForSeoBot', 'Google-Extended'];
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

foreach ($aiBots as $bot) {
    if (stripos($ua, $bot) !== false) {
        http_response_code(403);
        header('X-Robots-Tag: noai, noimageai');
        exit('Access denied');
    }
}
?>
```

### WordPress (functions.php)

```php
<?php
add_filter('robots_txt', 'block_ai_robots', 99, 2);
function block_ai_robots($output, $public) {
    $output .= "\nUser-agent: GPTBot\nDisallow: /\n";
    $output .= "\nUser-agent: ChatGPT-User\nDisallow: /\n";
    $output .= "\nUser-agent: ClaudeBot\nDisallow: /\n";
    $output .= "\nUser-agent: Bytespider\nDisallow: /\n";
    $output .= "\nUser-agent: Google-Extended\nDisallow: /\n";
    return $output;
}
?>
```

---

## Python


```python
from flask import Flask, request, abort

app = Flask(__name__)
AI_BOTS = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Bytespider', 'AI2Bot']

@app.before_request
def block_ai_bots():
    ua = request.headers.get('User-Agent', '')
    if any(bot.lower() in ua.lower() for bot in AI_BOTS):
        abort(403)
```

### Django Middleware

```python
# middleware.py
class AIBotBlockMiddleware:
    def __init__(self, get_response):
        self.get_response = get_response
    
    def __call__(self, request):
        ua = request.META.get('HTTP_USER_AGENT', '')
        bots = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Bytespider']
        if any(bot.lower() in ua.lower() for bot in bots):
            from django.http import HttpResponseForbidden
            return HttpResponseForbidden('Access denied')
        return self.get_response(request)
```

Add to `settings.py`:
```python
MIDDLEWARE = [
    # ...
    'yourapp.middleware.AIBotBlockMiddleware',
]
```

### FastAPI

```python
from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse

app = FastAPI()

@app.middleware("http")
async def block_ai_bots(request: Request, call_next):
    ua = request.headers.get("User-Agent", "")
    bots = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Bytespider']
    if any(bot.lower() in ua.lower() for bot in bots):
        return JSONResponse(status_code=403, content={"error": "Forbidden"})
    return await call_next(request)
```

---

## Node.js / Express.js

# For Express.js (Node.js) applications, modify the response headers:

app.use((req, res, next) => {
res.setHeader(“X-Robots-Tag”, “noai, noimageai”);
next();
});

---

### Middleware

```javascript
const AI_BOTS = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Bytespider', 'AI2Bot', 'DataForSeoBot'];

app.use((req, res, next) => {
    const ua = req.headers['user-agent'] || '';
    if (AI_BOTS.some(bot => ua.toLowerCase().includes(bot.toLowerCase()))) {
        return res.status(403).send('Access denied');
    }
    res.setHeader('X-Robots-Tag', 'noai, noimageai');
    next();
});
```

### X-Robots-Tag Header Only

```javascript
app.use((req, res, next) => {
    res.setHeader("X-Robots-Tag", "noai, noimageai");
    next();
});
```

---

## Go (Golang)

```go
package main

import (
    "net/http"
    "regexp"
)

var botPattern = regexp.MustCompile(`(?i)(GPTBot|ChatGPT|ClaudeBot|Bytespider|AI2Bot)`)

func blockBots(next http.Handler) http.Handler {
    return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
        if botPattern.MatchString(r.Header.Get("User-Agent")) {
            http.Error(w, "Forbidden", http.StatusForbidden)
            return
        }
        next.ServeHTTP(w, r)
    })
}

func main() {
    mux := http.NewServeMux()
    mux.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
        w.Write([]byte("Welcome!"))
    })
    http.ListenAndServe(":8080", blockBots(mux))
}
```

---

## Ruby on Rails

```ruby
# config/initializers/ai_bot_blocker.rb
class AIBotBlocker
  BOTS = %w[GPTBot ChatGPT ClaudeBot Bytespider AI2Bot]
  
  def initialize(app)
    @app = app
  end
  
  def call(env)
    ua = env['HTTP_USER_AGENT'] || ''
    if BOTS.any? { |bot| ua.downcase.include?(bot.downcase) }
      return [403, {'Content-Type' => 'text/plain'}, ['Forbidden']]
    end
    @app.call(env)
  end
end

Rails.application.config.middleware.use AIBotBlocker
```

---

## Hugo (Static Site)

enableRobotsTXT: true
other-configs: your-configs
params:

  your-params-config: your-params-config
  robots:
    - bot
    - bot
    - bot
    - bot
    - bot
	
Include in: config.yaml


# MediaWiki specifically, here’s an nginx pattern that takes effect if it’s a complex URL:

set $BOT "";
if ($uri ~* (/w/index.php)) {
    set $BOT "C"; }
	
# then detect the bot tell and give a 503

---
	
### robots.txt Template

Create `layouts/robots.txt`:

```
User-agent: GPTBot
Disallow: /

User-agent: ChatGPT-User
Disallow: /

User-agent: ClaudeBot
Disallow: /

User-agent: Bytespider
Disallow: /

User-agent: Google-Extended
Disallow: /

User-agent: *
Allow: /
```

### Netlify Headers

Add to `netlify.toml`:

```toml
[[headers]]
  for = "/*"
  [headers.values]
    X-Robots-Tag = "noai, noimageai"
```

### Vercel Headers

Add to `vercel.json`:

```json
{
  "headers": [
    {
      "source": "/(.*)",
      "headers": [
        { "key": "X-Robots-Tag", "value": "noai, noimageai" }
      ]
    }
  ]
}
```

---

## Kirby CMS

```php
<?php
// site/config/config.php
return [
    'hooks' => [
        'route:before' => function () {
            $bots = ['GPTBot', 'ChatGPT', 'ClaudeBot', 'Bytespider', 'AI2Bot'];
            $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
            foreach ($bots as $bot) {
                if (stripos($ua, $bot) !== false) {
                    header('HTTP/1.0 403 Forbidden');
                    die('Access denied');
                }
            }
        }
    ]
];
?>
```

---

## HAProxy

```haproxy
frontend http_front
    bind *:80
    
    # AI bot ACLs
    acl is_gptbot hdr_sub(User-Agent) -i GPTBot
    acl is_chatgpt hdr_sub(User-Agent) -i ChatGPT
    acl is_claudebot hdr_sub(User-Agent) -i ClaudeBot
    acl is_bytespider hdr_sub(User-Agent) -i Bytespider
    acl is_ai2bot hdr_sub(User-Agent) -i AI2Bot
    
    # Block AI bots
    http-request deny if is_gptbot or is_chatgpt or is_claudebot or is_bytespider or is_ai2bot
    
    default_backend webservers
```

### Using Regex

```haproxy
frontend http_front
    bind *:80
    acl is_ai_bot hdr_reg(User-Agent) -i (GPTBot|ChatGPT|ClaudeBot|Bytespider|AI2Bot)
    http-request deny if is_ai_bot
    default_backend webservers
```

---

## Caddy Server

```caddyfile
example.com {
    @ai_bots {
        header_regexp User-Agent (?i)(GPTBot|ChatGPT|ClaudeBot|Bytespider|AI2Bot|DataForSeoBot)
    }
    respond @ai_bots "Access Denied" 403
    
    header X-Robots-Tag "noai, noimageai"
    
    root * /var/www/html
    file_server
}
```

---

## Fail2ban

Create `/etc/fail2ban/filter.d/nginx-badbots.conf`:

```ini
[Definition]
badbots = GPTBot|ChatGPT|ClaudeBot|Bytespider|AI2Bot

failregex = (?i)<HOST> -.*"(GET|POST|HEAD) (.*?)" \d+ \d+ "(.*?)" ".*(?:%(badbots)s).*"$

ignoreregex =
```

---

## Rate Limiting

### Apache (mod_evasive)

```bash
sudo apt-get install libapache2-mod-evasive
```

Configure `/etc/apache2/mods-available/evasive.conf`:

```apache
DOSHashTableSize 3097
DOSPageCount 5
DOSSiteCount 50
DOSBlockingPeriod 600
```

```bash
sudo systemctl restart apache2
```

### Nginx (limit_req_zone)

```nginx
http {
    limit_req_zone $binary_remote_addr zone=one:10m rate=1r/s;
}

server {
    location / {
        limit_req zone=one burst=5;
    }
}
```

```bash
sudo systemctl restart nginx
```


### Block AI bots on a NGINX*  web server ##

NGINX web servers do not use .htaccess files, but instead nginx.conf (or Vhost files). 

To block bad bots on your NGINX server, add a list of user agents to your nginx.conf, like this:
If more bots, add:  Bot|Bot|BotBot|Bot|Bot and so on.


if ($http_user_agent ~* (Bot|Bot|Bot) ) { 
return 403; 
}

#OR:
if ($http_user_agent ~* "( )") {
    return 403;
}

# case insensitive ###

if ($http_user_agent ~* (BadBotOne|BadBotTwo)) {
	return 403
}

# No scrapers
if ($scraper = 1) {
return 418 "?";
}

If you prefer to redirect them somewhere, just use a return 301 instead:

 # case insensitive matching
    if ($http_user_agent ~* (netcrawl|npbot|malicious)) {
        return 301 https://yoursite.com;
    }

# WITH referers. 

if ($http_referer ~ "domain\.com|badsite\.net|example\.com")  {
  return 403;

}

---

## Cloudflare WAF

Custom rule expression:

```
(lower(http.user_agent) contains "gptbot")
or (lower(http.user_agent) contains "chatgpt")
or (lower(http.user_agent) contains "claudebot")
or (lower(http.user_agent) contains "claude-web")
or (lower(http.user_agent) contains "bytespider")
or (lower(http.user_agent) contains "ai2bot")
or (lower(http.user_agent) contains "dataforseobot")
```

---

## Honeypot Trap

### HTML Hidden Link

```html
<a href="/trap-page" class="honeypot">Hidden Link</a>
<style>.honeypot { display: none; }</style>
```

### PHP Trap Page

```php
<?php
$ip = $_SERVER['REMOTE_ADDR'];
$file = 'honeypot_log.txt';
file_put_contents($file, date('Y-m-d H:i:s') . " - $ip\n", FILE_APPEND);
?>
<html>
<head><meta name="robots" content="noindex, nofollow"></head>
<body>Nothing to see here.</body>
</html>
```

---

## Creative Obstruction

Make AI bots download a 10GB file (Nginx):

```nginx
if ($http_user_agent ~* "(GPTBot|ClaudeBot|Bytespider)") {
    return 307 https://ash-speed.hetzner.com/10GB.bin;
}
```

---

## Common AI Bots to Block

| Bot Name | User Agent | Publisher |
|----------|------------|-----------|
| GPTBot | GPTBot | OpenAI |
| ChatGPT-User | ChatGPT-User | OpenAI |
| ClaudeBot | ClaudeBot | Anthropic |
| Claude-Web | Claude-Web | Anthropic |
| Bytespider | Bytespider | ByteDance |
| AI2Bot | AI2Bot | Allen Institute |
| DataForSeoBot | DataForSeoBot | DataForSEO |
| Google-Extended | Google-Extended | Google |
| Applebot-Extended | Applebot-Extended | Apple |
| PerplexityBot | PerplexityBot | Perplexity |

---

*Use these techniques responsibly and in compliance with applicable laws.*
