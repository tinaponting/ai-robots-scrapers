# AI-Bots, Scrapers och Teknologier - Komplett Guide 2025

*Senast uppdaterad: 15 november 2025*

---

## 📑 Innehållsförteckning

1. [AI-plattformar och Språkmodeller](#ai-plattformar-och-språkmodeller)
2. [AI-webbläsare](#ai-webbläsare)
3. [AI-scrapers och Crawlers](#ai-scrapers-och-crawlers)
4. [AI-nyheter och Informationskällor](#ai-nyheter-och-informationskällor)
5. [AI-frameworks och Verktyg](#ai-frameworks-och-verktyg)
6. [Skyddsåtgärder och Robots.txt](#skyddsåtgärder-och-robotstxt)
7. [Kina AI-modeller](#kina-ai-modeller)
8. [Tekniska Detaljer och User Agents](#tekniska-detaljer-och-user-agents)

---

## 🚀 AI-plattformar och Språkmodeller

### Stora Tech-företag

#### OpenAI
- **ChatGPT/GPT-5-serien**
  - URL: https://openai.com
  - Senaste: GPT-5.1 (Augusti 2025)
  - User Agents: `GPT-5`, `GPT-5.1`, `GPT-5.1-mini`, `GPT-5.1-thinking`, `ChatGPT`, `GPTBot`, `GPT-4o`, `GPT-4o-mini`
  - **Varning**: Aggressiv scraping, blockera vid behov

#### Anthropic (Claude)
- **Claude 4-serien**
  - URL: https://www.anthropic.com
  - Senaste: Claude Sonnet 4.5 (September 2025) - "Best coding model in the world"
  - User Agents: `ClaudeBot`, `Claude-SearchBot`, `anthropic-ai`, `Claude 3.5 Haiku`, `Claude 3 Opus`, `Claude 4`
  - **Varning**: Mycket aktiv scraping

#### Google
- **Gemini & AI-tjänster**
  - URL: https://ai.google
  - User Agents: `GoogleOther`, `GoogleOther-Image`, `GoogleOther-Video`, `Google-CloudVertexBot`, `Google-Extended`
  - **Obs**: Google Extended kan blockera din webbplats från Google-sökning!

#### Microsoft
- **Copilot & Bing AI**
  - User Agents: `bingbot/2.0`, `Microsoft Copilot`, `MSBot`
  - URL: https://ai.azure.com

### Öppna Källkod AI-modeller

#### Hugging Face
- **Största plattformen för öppna AI-modeller**
  - URL: https://huggingface.co
  - User Agents: `Hugging Face`, `HuggingChat`, `Open-R1`

#### Eleuther.ai
- **Utvecklare av GPT-J, GPT-Neo**
  - URL: https://www.eleuther.ai
  - Open source LLM-modeller

---

## 🌐 AI-webbläsare

### Huvudwebbläsare med AI (2025)

| Webbläsare | AI-funktion | URL | User Agent |
|------------|-------------|-----|------------|
| **Arc** | Max AI | https://arc.net | Arc |
| **Brave** | Leo AI | https://brave.com | Brave Leo |
| **Firefox** | AI Window | https://firefox.com | mozilla.ai |
| **Opera** | Aria AI | https://opera.com | Opera |
| **Microsoft Edge** | Edge AI | https://microsoft.com/edge | Edge AI |
| **Safari** | Safari AI | https://apple.com/safari | Safari AI |
| **Chrome** | Gemini AI | https://chrome.com | Chrome med Gemini |

### Mindre Kända AI-webbläsare

- **SigmaOS**: Airis AI (https://sigmaos.com)
- **Midori**: Midori-AI (https://astian.org/midori-browser/)
- **Falkon**: Falkon AI (https://www.falkon.org)
- **Maxthon**: AIChat (https://www.maxthon.com)

---

## 🤖 AI-scrapers och Crawlers

### LLM-träningscrawlers

#### OpenAI
```
User-agent: GPTBot
User-agent: GPT-5
User-agent: ChatGPT
User-agent: GPT-crawler
```

#### Anthropic (Claude)
```
User-agent: ClaudeBot
User-agent: Claude-SearchBot
User-agent: anthropic-ai
```

#### Google
```
User-agent: GoogleOther
User-agent: GoogleOther-Image
User-agent: GoogleOther-Video
User-agent: Google-CloudVertexBot
```

#### Perplexity AI
```
User-agent: PerplexityBot
User-agent: PerplexityBot/1.0
User-agent: Perplexity-User/1.0
```

### Övriga AI-scrapers

#### Amazon/AWS
```
User-agent: Amazonbot
User-agent: Amazon SageMaker
User-agent: Amazon Bedrock
User-agent: amazon-kendra
```

#### Meta (Facebook)
```
User-agent: FacebookBot
User-agent: facebookexternalhit
User-agent: Meta AI
User-agent: SAM 2
```

#### Microsoft
```
User-agent: bingbot/2.0
User-agent: Microsoft Copilot
User-agent: MSBot
```

---

## 📰 AI-nyheter och Informationskällor

### Svenska AI-nyheter
- **SERDY**: https://seirdy.one/meta/scrapers-i-block/ (Scraping-blockeringar)

### Internationella AI-nyheter
- **AI News**: https://www.artificialintelligence-news.com/
- **Google AI**: https://ai.google/latest-news/
- **DeepMind**: https://deepmind.google/discover/blog
- **AI Today**: https://aitoday.com/
- **AI Weekly**: https://aiweekly.co/
- **The Verge AI**: https://www.theverge.com/ai-artificial-intelligence
- **Mistral AI News**: https://mistral.ai/news

### LLM-specialistkällor
- **LLMs**: https://llmstxt.site/
- **Amazon AI News**: https://www.aboutamazon.com/artificial-intelligence-ai-news

### Tekniska Resurser
- **Common Crawl**: https://commoncrawl.org
- **Hugging Face Chat**: https://huggingface.co/chat/
- **Ollama**: https://ollama.com

---

## 🛠️ AI-frameworks och Verktyg

### LLM-Orchestration Frameworks
- **LangChain**: Populäraste framework för LLM-applikationer
- **LlamaIndex**: Databaserad RAG-framework
- **Semantic Kernel**: Microsofts SDK för generativ AI
- **Haystack**: Slut-till-slut NLP framework
- **Flowise**: Drag & drop LLM flow builder

### Agent Frameworks
- **CrewAI**: Multi-agent AI systemer
- **AutoGen**: Microsofts agent framework
- **LangGraph**: State management för LLM workflows
- **SuperAGI**: Open-source autonomous agent framework
- **Agent Protocol**: Unified interface för AI agents

### RAG-spezifika Verktyg
- **Dify**: Open-source LLM app development platform
- **Embedchain**: Framework för ChatGPT-liknande bots
- **Chroma**: Open-source embedding database
- **Weaviate**: Vector database för AI-applikationer

---

## 🛡️ Skyddsåtgärder och Robots.txt

### Grundläggande Blockering

```txt
# Blockera alla OpenAI bots
User-agent: GPTBot
Disallow: /

User-agent: ChatGPT
Disallow: /

# Blockera Anthropic bots
User-agent: ClaudeBot
Disallow: /

User-agent: anthropic-ai
Disallow: /

# Blockera Google Other bots
User-agent: GoogleOther
Disallow: /

# Blockera Perplexity
User-agent: PerplexityBot
Disallow: /
```

### Apache .htaccess Blockering (Avancerad)

```apache
<IfModule mod_rewrite.c>
# Blockera OpenAI
RewriteCond %{HTTP_USER_AGENT} "GPTBot" [NC,OR]
RewriteCond %{HTTP_USER_AGENT} "ChatGPT" [NC,OR]
RewriteCond %{HTTP_USER_AGENT} "GPT-5" [NC]

# Blockera Anthropic
RewriteCond %{HTTP_USER_AGENT} "ClaudeBot" [NC,OR]
RewriteCond %{HTTP_USER_AGENT} "anthropic-ai" [NC,OR]

# Blockera Google
RewriteCond %{HTTP_USER_AGENT} "GoogleOther" [NC,OR]
RewriteCond %{HTTP_USER_AGENT} "Google-Extended" [NC,OR]

# Blockera Perplexity
RewriteCond %{HTTP_USER_AGENT} "PerplexityBot" [NC]

RewriteRule ^(.*)$ - [F,L]
</IfModule>
```

### IP-blockering (För envisa crawlers)

```apache
# OpenAI IP-range
RewriteCond %{REMOTE_ADDR} ^52\.230\.152\. [OR]
RewriteCond %{REMOTE_ADDR} ^52\.233\.106\. [OR]
RewriteCond %{REMOTE_ADDR} ^20\.171\.206\. [OR]
RewriteCond %{REMOTE_ADDR} ^20\.171\.207\. [OR]

# Anthropic IP-ranges
RewriteCond %{REMOTE_ADDR} ^3\.[67]\. [OR]
RewriteRule ^ - [F,L]
```

### Proxy-blockering

```apache
# Blockera AI proxies
RedirectMatch 403 "proxy|API proxy|HTTP proxy|residential proxy|reverse proxy"
```

---

## 🇨🇳 Kina AI-modeller (2025 Trends)

### Toppmodeller 2025
- **DeepSeek R1/V3**: https://www.deepseek.com
- **Qwen 3-serien**: Alibaba's flagship models
- **Kimi K2 Thinking**: Moonshot AI, $4.6M modell
- **GLM 4.6**: Zhipu AI's GPT-4 konkurrent
- **ChatGLM**: https://chatglm.cn/

### User Agents (Kina)
```
User-agent: DeepSeek
User-agent: Qwen
User-agent: qwen3
User-agent: Kimi
User-agent: GLM
```

### Säkerhetsnotering
⚠️ **Viktigt**: Kinesiska AI-modeller visar stark tillväxt i användning och är nu bland de mest populära enligt rapporter från 2025.

---

## 🔧 Tekniska Detaljer och User Agents

### Kategoriserade User Agent Lists

#### Språkmodell-trainingscrawlers
```
- GPTBot, ChatGPT, GPT-5, GPT-4
- ClaudeBot, Claude-User, anthropic-ai
- PerplexityBot, Perplexity-User
- GoogleOther, Google-CloudVertexBot
- Microsoft Copilot, bingbot
```

#### Bild/Video-scrapers
```
- ImagesiftBot (image theft)
- StableDiffusionBot
- V-JEPA (video)
- Dall-E, DALL-E 3
```

#### Öppna källkod-crawlers
```
- Scrapy
- FriendlyCrawler
- Timpibot (svår att blockera)
- peer39_crawler
```

#### Specialiserade crawlers
```
- TurnitinBot (utbildning)
- AndersPinkBot (utbildning)
- DuckAssistBot (sökning)
```

### Användbara Verktyg för Detektion

#### Detektionsresurser
- **Dark Visitors**: https://darkvisitors.com
- **AI robots.txt**: https://github.com/ai-robots-txt/ai.robots.txt
- **Pageradar AI User Agents**: https://pageradar.io/free-tools/ai-user-agents-list

#### Skyddsplugin för WordPress
- **BBQ Pro**: https://plugin-planet.com/bbq-pro/
- **Block AI Crawlers**: Olika plugins tillgängliga

---

## 📊 Aktuella Trender 2025

### AI-webbläsare Explosion
- **Firefox AI Window** lanserad (Mars 2025)
- **Chrome med Gemini** integrering (September 2025)
- **AI-assistenter** blir standard i alla större webbläsare

### LLM-tävlingslandskap
- **GPT-5** vs **Claude 4.5**: Konkurrens intensifieras
- **Kinesiska modeller** tar global marknadsandel
- **Local LLMs** (Ollama, etc.) växer kraftigt

### Skyddsmetoder
- **AI-specifika robots.txt** blir standard
- **Cloudflare AI Training Control** lanserad
- **Juridiska utmaningar** kring content scraping

---

## ⚠️ Viktiga Säkerhetsnoteringar

### Risk Level: Hög
- **GPT-5-serie**: Aggressiv data-samling
- **Claude 4-serie**: Omfattande web-scraping
- **Google Other**: Kan påverka sökmotor-indexering

### Risk Level: Medel
- **Perplexity**: Smart stealth-crawling
- **Kinesiska modeller**: Växande användning
- **Öppna source crawlers**: Många variationer

### Rekommendationer
1. **Använd uppdaterade robots.txt** med AI-specifika regler
2. **Implementera IP-blockering** för envisa crawlers
3. **Övervaka trafik** med analytics för att upptäcka AI-bots
4. **Håll dig uppdaterad** med nya user agents och threats

---

## 🔄 Uppdateringslogg

- **15 november 2025**: Komplett omskrivning med 2025-trender
- **Tillagd**: Kimi K2, Claude Sonnet 4.5, GPT-5.1
- **Uppdaterad**: AI-webbläsare sektion med senaste lanseringar
- **Förbättrad**: Säkerhetsrekommendationer och blockering

---

*Denna guide är ett levande dokument och uppdateras kontinuerligt med de senaste AI-teknologierna och threats. Senast verifierad: 15 november 2025*