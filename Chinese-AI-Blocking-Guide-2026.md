# Chinese AI Companies & Bots - Complete Blocking Guide 2026

> Comprehensive guide to Chinese AI companies, their bots, and blocking methods

**Updated: 2026-01-07**

---

## Table of Contents

- [Overview](#overview)
- [Major Chinese AI Companies](#major-chinese-ai-companies)
- [Known Bot User Agents](#known-bot-user-agents)
- [Robots.txt Blocking](#robotstxt-blocking)
- [Apache .htaccess Methods](#apache-htaccess-methods)
- [Nginx Methods](#nginx-methods)
- [Complete Blocking Solutions](#complete-blocking-solutions)

---

## Overview

Chinese AI companies are rapidly advancing in the global AI race. Many operate web crawlers to collect training data. This guide covers blocking methods for all major Chinese AI bots.

> **Note**: ByteDance/Bytespider is particularly aggressive - uses ~100,000+ IP addresses and often ignores robots.txt!

---

## Major Chinese AI Companies

### ByteDance (字节跳动)

| Product | Description | URL |
|---------|-------------|-----|
| **Doubao** | Main AI chatbot | doubao.com |
| **Skylark** | Enterprise LLM | bytedance.com |
| **Bytespider** | Web crawler (aggressive!) | - |
| **TikTok AI** | Content AI | tiktok.com |

**Headquarters**: Beijing, China (also Singapore, Hong Kong)

**GitHub**: [github.com/bytedance](https://github.com/bytedance)

⚠️ **Warning**: Bytespider is extremely aggressive. Uses 100,000+ IP addresses and often ignores robots.txt!

---

### DeepSeek (深度求索)

| Product | Description | URL |
|---------|-------------|-----|
| **DeepSeek-R1** | Reasoning model | deepseek.com |
| **DeepSeek-V3** | Latest LLM | deepseek.com |
| **DeepSeek Coder** | Code generation | github.com/deepseek-ai |
| **DeepSeek Chat** | Chatbot | chat.deepseek.com |

**Headquarters**: Hangzhou, China

**GitHub**: [github.com/deepseek-ai](https://github.com/deepseek-ai)

---

### Alibaba (阿里巴巴)

| Product | Description | URL |
|---------|-------------|-----|
| **Tongyi Qianwen (通义千问)** | Main LLM | tongyi.aliyun.com |
| **Qwen / Qwen2.5** | Open-weight models | qwen.aliyun.com |
| **Qwen-72B** | Large parameter model | huggingface.co/Qwen |

**Headquarters**: Hangzhou, China

**Cloud**: [alibabacloud.com/solutions/generative-ai/qwen](https://www.alibabacloud.com/en/solutions/generative-ai/qwen)

---

### Baidu (百度)

| Product | Description | URL |
|---------|-------------|-----|
| **ERNIE Bot (文心一言)** | Main chatbot | yiyan.baidu.com |
| **ERNIE 4.0 / 4.5** | Latest LLM | research.baidu.com |
| **Baidubot** | Web crawler | - |

**Headquarters**: Beijing, China

**Research**: [research.baidu.com](https://research.baidu.com)

---

### Tencent (腾讯)

| Product | Description | URL |
|---------|-------------|-----|
| **Hunyuan (混元)** | Main LLM | hunyuan.tencent.com |
| **HunyuanAide** | Chatbot assistant | - |

**Headquarters**: Shenzhen, China

**Portal**: [hunyuan.tencent.com](https://hunyuan.tencent.com)

---

### Zhipu AI (智谱AI)

| Product | Description | URL |
|---------|-------------|-----|
| **ChatGLM** | Chatbot | chatglm.cn |
| **GLM-4** | Latest model | zhipuai.cn |
| **ChatGLM-Spider** | Web crawler | - |

**Headquarters**: Beijing, China

**GitHub**: [github.com/THUDM](https://github.com/THUDM)

**HuggingFace**: [huggingface.co/THUDM](https://huggingface.co/THUDM)

---

### Moonshot AI (月之暗面)

| Product | Description | URL |
|---------|-------------|-----|
| **Kimi** | AI assistant (200K context) | kimi.moonshot.cn |
| **Moonshot** | API platform | moonshot.cn |

**Headquarters**: Beijing, China

**Website**: [moonshot.cn](https://www.moonshot.cn)

---

### 01.AI (零一万物)

| Product | Description | URL |
|---------|-------------|-----|
| **Yi** | Open-source LLM | 01.ai |
| **Yi-Large** | Enterprise model | yi.ai |
| **Yi-34B** | Mid-size model | huggingface.co/01-ai |

**Headquarters**: Beijing, China

**Founder**: Kai-Fu Lee (李开复)

**Features**: Excellent multilingual support (Chinese, English, Spanish, Japanese, German, French)

---

### Baichuan (百川智能)

| Product | Description | URL |
|---------|-------------|-----|
| **Baichuan** | Open-source LLM | baichuan-ai.com |
| **Baichuan-13B** | 13B parameter model | github.com/baichuan-inc |

**Headquarters**: Beijing, China

**Website**: [baichuan-ai.com](https://www.baichuan-ai.com)

---

### iFlytek (科大讯飞)

| Product | Description | URL |
|---------|-------------|-----|
| **Spark (讯飞星火)** | Main LLM | xinghuo.xfyun.cn |
| **Spark V4.0** | Latest version | iflytek.com |

**Headquarters**: Hefei, China

**News**: Spark V4.0 rivals GPT-4 Turbo performance

---

### SenseTime (商汤科技)

| Product | Description | URL |
|---------|-------------|-----|
| **SenseNova** | LLM platform | sensetime.com |
| **SenseChat** | Chatbot | - |

**Headquarters**: Hong Kong / Shanghai

---

### Huawei (华为)

| Product | Description | URL |
|---------|-------------|-----|
| **PanGu (盘古)** | Multimodal LLM | huawei.com |
| **PanguBot** | Web crawler | - |

**Headquarters**: Shenzhen, China

---

### MiniMax (稀宇科技)

| Product | Description | URL |
|---------|-------------|-----|
| **MiniMax** | LLM platform | minimax.io |
| **Hailuo AI** | Video generation | hailuoai.video |
| **Talkie** | Character AI | talkie-ai.com |

**Headquarters**: Shanghai, China

**Websites**: 
- [minimax.io](https://minimax.io)
- [minimaxai.me](https://minimaxai.me)

---

### InternLM (书生)

| Product | Description | URL |
|---------|-------------|-----|
| **InternLM** | Open-source LLM | internlm.intern-ai.org.cn |
| **InternLM2** | Latest version | github.com/InternLM |

**Developed by**: Shanghai AI Lab

**GitHub**: [github.com/InternLM](https://github.com/InternLM)

---

### Manus AI

| Product | Description | URL |
|---------|-------------|-----|
| **Manus** | General AI Agent | manus.im |
| **OpenManus** | Open-source version | github.com/manusai |

**Features**: First general-purpose AI agent, can build & scrape autonomously

---

## Known Bot User Agents

### Complete List

| Bot Name | User Agent Pattern | Company |
|----------|-------------------|---------|
| Bytespider | `Bytespider` | ByteDance |
| Bytedance | `Bytedance` | ByteDance |
| Doubao AI | `Doubao` | ByteDance |
| DeepSeekBot | `DeepSeekBot` | DeepSeek |
| Baidubot | `Baiduspider`, `Baidubot` | Baidu |
| ChatGLM-Spider | `ChatGLM-Spider` | Zhipu AI |
| Qwenbot | `Qwenbot` | Alibaba |
| PanguBot | `PanguBot` | Huawei |
| Kimi | `Kimi` | Moonshot AI |
| Hunyuan | `Hunyuan` | Tencent |
| YiBot | `YiBot` | 01.AI |
| AlphaAI | `AlphaAI` | Singapore |

### Full User Agent Strings

**ChatGLM-Spider**:
```
Mozilla/5.0 (compatible; ChatGLM-Spider/1.0; +https://chatglm.cn/)
```

**Bytespider**:
```
Mozilla/5.0 (Linux; Android 5.0) AppleWebKit/537.36 (KHTML, like Gecko) Mobile Safari/537.36 (compatible; Bytespider; spider-feedback@bytedance.com)
```

---

## Robots.txt Blocking

### All Chinese AI Bots

```
# ===== CHINESE AI BOTS =====

# ByteDance
User-agent: Bytespider
Disallow: /

User-agent: Bytedance
Disallow: /

User-agent: Doubao
Disallow: /

# DeepSeek
User-agent: DeepSeekBot
Disallow: /

User-agent: deepseek
Disallow: /

# Baidu
User-agent: Baiduspider
Disallow: /

User-agent: Baidubot
Disallow: /

# Zhipu AI / ChatGLM
User-agent: ChatGLM-Spider
Disallow: /

User-agent: ChatGLM
Disallow: /

# Alibaba / Qwen
User-agent: Qwenbot
Disallow: /

User-agent: AlibabaBot
Disallow: /

# Huawei
User-agent: PanguBot
Disallow: /

# Moonshot / Kimi
User-agent: Kimi
Disallow: /

User-agent: MoonshotBot
Disallow: /

# Tencent
User-agent: Hunyuan
Disallow: /

User-agent: TencentBot
Disallow: /

# 01.AI
User-agent: YiBot
Disallow: /

# SenseTime
User-agent: SenseBot
Disallow: /

# iFlytek
User-agent: iFlytekBot
Disallow: /

# MiniMax
User-agent: MiniMaxBot
Disallow: /

# InternLM
User-agent: InternLMBot
Disallow: /

# Other
User-agent: AlphaAI
Disallow: /
```

---

## Apache .htaccess Methods

### Block by User Agent

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # ByteDance (aggressive!)
    RewriteCond %{HTTP_USER_AGENT} Bytespider [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} Bytedance [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} Doubao [NC,OR]
    
    # DeepSeek
    RewriteCond %{HTTP_USER_AGENT} DeepSeek [NC,OR]
    
    # Baidu
    RewriteCond %{HTTP_USER_AGENT} Baiduspider [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} Baidubot [NC,OR]
    
    # Zhipu AI / ChatGLM
    RewriteCond %{HTTP_USER_AGENT} ChatGLM [NC,OR]
    
    # Alibaba / Qwen
    RewriteCond %{HTTP_USER_AGENT} Qwen [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} AlibabaBot [NC,OR]
    
    # Huawei
    RewriteCond %{HTTP_USER_AGENT} PanguBot [NC,OR]
    
    # Moonshot / Kimi
    RewriteCond %{HTTP_USER_AGENT} Kimi [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} Moonshot [NC,OR]
    
    # Tencent
    RewriteCond %{HTTP_USER_AGENT} Hunyuan [NC,OR]
    
    # 01.AI
    RewriteCond %{HTTP_USER_AGENT} YiBot [NC,OR]
    
    # Others
    RewriteCond %{HTTP_USER_AGENT} SenseBot [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} MiniMax [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} InternLM [NC,OR]
    RewriteCond %{HTTP_USER_AGENT} AlphaAI [NC]
    
    RewriteRule .* - [F,L]
</IfModule>
```

### Special ByteDance Blocking

ByteDance often uses HTTP/1.0 and HTTP/1.1 requests that bypass normal filters:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block Bytespider by user agent
    RewriteCond %{HTTP_USER_AGENT} ^.*(Bytedance|Bytespider).*$ [NC]
    RewriteRule .* - [F,L]
</IfModule>

# Additional blocking for HTTP version abuse
<IfModule mod_alias.c>
    # Block suspicious HTTP/1.0 and HTTP/1.1 patterns
    RedirectMatch 403 "robots\.txt.*HTTP/1\.[01]"
</IfModule>
```

### Block by Referrer

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Block Chinese AI referrers
    RewriteCond %{HTTP_REFERER} bytedance\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} deepseek\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} baidu\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} chatglm\.cn [NC,OR]
    RewriteCond %{HTTP_REFERER} alibaba\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} huawei\.com [NC,OR]
    RewriteCond %{HTTP_REFERER} moonshot\.cn [NC,OR]
    RewriteCond %{HTTP_REFERER} tencent\.com [NC]
    RewriteRule .* - [F,L]
</IfModule>
```

---

## Nginx Methods

### Block by User Agent

```nginx
# Block Chinese AI bots
if ($http_user_agent ~* (Bytespider|Bytedance|Doubao|DeepSeek|Baiduspider|Baidubot|ChatGLM|Qwen|AlibabaBot|PanguBot|Kimi|Moonshot|Hunyuan|YiBot|SenseBot|MiniMax|InternLM|AlphaAI)) {
    return 403;
}
```

### Map-Based Blocking (More Efficient)

```nginx
map $http_user_agent $is_chinese_ai_bot {
    default 0;
    ~*Bytespider 1;
    ~*Bytedance 1;
    ~*Doubao 1;
    ~*DeepSeek 1;
    ~*Baiduspider 1;
    ~*Baidubot 1;
    ~*ChatGLM 1;
    ~*Qwen 1;
    ~*AlibabaBot 1;
    ~*PanguBot 1;
    ~*Kimi 1;
    ~*Moonshot 1;
    ~*Hunyuan 1;
    ~*YiBot 1;
    ~*SenseBot 1;
    ~*MiniMax 1;
    ~*InternLM 1;
    ~*AlphaAI 1;
}

server {
    if ($is_chinese_ai_bot) {
        return 403;
    }
}
```

### Rate Limit Chinese Bots

```nginx
limit_req_zone $binary_remote_addr zone=china_ai_limit:10m rate=1r/h;

map $http_user_agent $is_chinese_bot {
    default 0;
    ~*Bytespider 1;
    ~*DeepSeek 1;
    ~*Baiduspider 1;
    ~*ChatGLM 1;
}

server {
    location / {
        if ($is_chinese_bot) {
            limit_req zone=china_ai_limit burst=1 nodelay;
        }
    }
}
```

---

## Complete Blocking Solutions

### Meta Tags (HTML)

```html
<head>
    <meta name="robots" content="noai, noimageai">
    <meta name="bytespider" content="noindex, nofollow">
    <meta name="deepseekbot" content="noindex, nofollow">
    <meta name="baiduspider" content="noindex, nofollow">
    <meta name="chatglm" content="noindex, nofollow">
    <meta name="qwenbot" content="noindex, nofollow">
    <meta name="pangubot" content="noindex, nofollow">
    <meta name="kimi" content="noindex, nofollow">
    <meta name="hunyuan" content="noindex, nofollow">
</head>
```

### Cloudflare WAF Rule

```
(http.user_agent contains "Bytespider") or
(http.user_agent contains "Bytedance") or
(http.user_agent contains "Doubao") or
(http.user_agent contains "DeepSeek") or
(http.user_agent contains "Baiduspider") or
(http.user_agent contains "ChatGLM") or
(http.user_agent contains "Qwen") or
(http.user_agent contains "PanguBot") or
(http.user_agent contains "Kimi") or
(http.user_agent contains "Hunyuan") or
(http.user_agent contains "AlphaAI")
```

**Action**: Block

### HAProxy

```haproxy
frontend http_front
    bind *:80
    
    # Chinese AI bot ACLs
    acl is_bytespider hdr_sub(User-Agent) -i Bytespider
    acl is_bytedance hdr_sub(User-Agent) -i Bytedance
    acl is_deepseek hdr_sub(User-Agent) -i DeepSeek
    acl is_baidu hdr_sub(User-Agent) -i Baiduspider
    acl is_chatglm hdr_sub(User-Agent) -i ChatGLM
    acl is_qwen hdr_sub(User-Agent) -i Qwen
    acl is_pangu hdr_sub(User-Agent) -i PanguBot
    acl is_kimi hdr_sub(User-Agent) -i Kimi
    acl is_hunyuan hdr_sub(User-Agent) -i Hunyuan
    
    # Block all
    http-request deny if is_bytespider or is_bytedance or is_deepseek or is_baidu or is_chatglm or is_qwen or is_pangu or is_kimi or is_hunyuan
    
    default_backend webservers
```

### Caddy

```caddyfile
example.com {
    @chinese_ai_bots {
        header_regexp User-Agent (?i)(Bytespider|Bytedance|Doubao|DeepSeek|Baiduspider|ChatGLM|Qwen|PanguBot|Kimi|Hunyuan|AlphaAI)
    }
    
    respond @chinese_ai_bots "Access Denied" 403
    
    header X-Robots-Tag "noai, noimageai"
}
```

### PHP

```php
<?php
$chineseAiBots = [
    'Bytespider', 'Bytedance', 'Doubao',
    'DeepSeek', 'Baiduspider', 'Baidubot',
    'ChatGLM', 'Qwen', 'AlibabaBot',
    'PanguBot', 'Kimi', 'Moonshot',
    'Hunyuan', 'YiBot', 'SenseBot',
    'MiniMax', 'InternLM', 'AlphaAI'
];

$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

foreach ($chineseAiBots as $bot) {
    if (stripos($ua, $bot) !== false) {
        http_response_code(403);
        exit('Access denied');
    }
}
?>
```

### Python Flask

```python
from flask import Flask, request, abort

app = Flask(__name__)

CHINESE_AI_BOTS = [
    'Bytespider', 'Bytedance', 'Doubao',
    'DeepSeek', 'Baiduspider', 'ChatGLM',
    'Qwen', 'PanguBot', 'Kimi', 'Moonshot',
    'Hunyuan', 'YiBot', 'AlphaAI'
]

@app.before_request
def block_chinese_ai():
    ua = request.headers.get('User-Agent', '')
    if any(bot.lower() in ua.lower() for bot in CHINESE_AI_BOTS):
        abort(403)
```

### Node.js / Express

```javascript
const CHINESE_AI_BOTS = [
    'Bytespider', 'Bytedance', 'Doubao',
    'DeepSeek', 'Baiduspider', 'ChatGLM',
    'Qwen', 'PanguBot', 'Kimi', 'Moonshot',
    'Hunyuan', 'YiBot', 'AlphaAI'
];

app.use((req, res, next) => {
    const ua = (req.headers['user-agent'] || '').toLowerCase();
    
    if (CHINESE_AI_BOTS.some(bot => ua.includes(bot.toLowerCase()))) {
        return res.status(403).send('Access denied');
    }
    
    next();
});
```

---

## Regex Patterns

### For Apache/Nginx

```
Bytespider|Bytedance|Doubao|DeepSeek|Baiduspider|Baidubot|ChatGLM|chatglm\.cn|Qwen|AlibabaBot|PanguBot|Kimi|Moonshot|Hunyuan|YiBot|SenseBot|MiniMax|InternLM|AlphaAI
```

### ChatGLM Specific

```
chatglm.spider|chatglm\.cn
```

---

## Resources

| Company | Documentation |
|---------|---------------|
| ByteDance | [github.com/bytedance](https://github.com/bytedance) |
| DeepSeek | [github.com/deepseek-ai](https://github.com/deepseek-ai) |
| Zhipu AI | [github.com/THUDM](https://github.com/THUDM) |
| Alibaba Qwen | [github.com/QwenLM](https://github.com/QwenLM) |
| 01.AI Yi | [github.com/01-ai](https://github.com/01-ai) |
| InternLM | [github.com/InternLM](https://github.com/InternLM) |
| Dark Visitors | [darkvisitors.com](https://darkvisitors.com) |

---

*Updated: 2026-01-07*
