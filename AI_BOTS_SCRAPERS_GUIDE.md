# Comprehensive Guide to AI Bots, Scrapers, and Blocking Strategies

> **Purpose:** Informational reference for identifying AI crawlers and understanding blocking options  
> **Note:** This guide provides information only. Create your own robots.txt and .htaccess configurations based on your specific needs.

---

## Table of Contents

1. [Introduction](#introduction)
2. [Major AI Companies and Their Crawlers](#section-1-major-ai-companies-and-their-crawlers)
3. [AI-Powered Browsers](#section-2-ai-powered-browsers-and-their-agents)
4. [Data Scraping Companies](#section-3-data-scraping-and-collection-companies)
5. [Image and Video AI Platforms](#section-4-ai-image-and-video-generation-platforms)
6. [AI Frameworks](#section-5-ai-frameworks-and-tools)
7. [Regional Considerations](#section-6-regional-and-specialized-considerations)
8. [Comprehensive User-Agent List](#section-7-comprehensive-user-agent-reference)
9. [Resources and Links](#section-8-resources-and-links)

---

## Introduction

The rapid expansion of artificial intelligence has fundamentally transformed how data moves across the internet. AI companies increasingly deploy automated crawlers, scrapers, and data collection agents to harvest web content for training large language models, building search indexes, and powering AI-powered services.

This guide provides web administrators, developers, and site owners with comprehensive information to identify AI systems that may interact with their digital properties. Understanding which bots exist and what they do enables informed decisions about access control.

**Important Considerations:**
- AI crawler landscapes change rapidly - new players enter regularly
- Not all crawlers respect robots.txt directives
- Some crawlers may spoof user-agents
- Blocking decisions should align with your content policies and business needs

---

## Section 1: Major AI Companies and Their Crawlers

### 1.1 OpenAI

**Website:** https://openai.com  
**Documentation:** https://platform.openai.com/docs/bots

| User-Agent | Purpose |
|------------|---------|
| GPTBot | Main crawler for web content collection |
| GPTBot/1.0, GPTBot/1.2 | Versioned variants |
| ChatGPT-User | Crawler for ChatGPT web search |
| ChatGPT-User/2.0 | Updated version |
| SearchGPT | Dedicated search product crawler |
| OAI-SearchBot | Search-specific indexing |
| OAI-SearchBot/1.0 | Versioned variant |
| Operator | Computer-use agent |
| OpenAI CUA | Computer Use Agent |
| GPT-4, GPT-4o, GPT-4o mini | Model-specific identifiers |
| GPT-3.5, GPT-3.5 Turbo | Legacy model identifiers |
| DALL-E, DALL-E 3 | Image generation related |
| Sora | Text-to-video model |
| Whisper | Speech-to-text model |

### 1.2 Anthropic

**Website:** https://www.anthropic.com  
**Crawler Info:** https://support.anthropic.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web

| User-Agent | Purpose |
|------------|---------|
| ClaudeBot | Primary crawler |
| ClaudeBot/1.0 | Versioned variant |
| anthropic-ai | General identifier |
| claude-web/1.0 | Web crawler variant |
| Claude-User | User-facing search |
| Claude-SearchBot | Search-related crawling |
| Claude 3.5 Haiku | Model-specific |
| Claude 3.7 Sonnet | Model-specific |
| Claude 3 Opus | Model-specific |

### 1.3 Google

**Documentation:** https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers

| User-Agent | Purpose |
|------------|---------|
| Google-Extended | AI training crawler (separate from search) |
| GoogleOther | Generic crawler for various products |
| GoogleOther-Image | Image-specific collection |
| GoogleOther-Video | Video-specific collection |
| Google-CloudVertexBot | Vertex AI platform |
| Gemini | Gemini AI model related |
| Google-NotebookLM | NotebookLM service |
| Imagen3, Imagen3-Fast | Image generation |

**Note:** Blocking Google-Extended should not affect search rankings, as it's separate from Googlebot.

### 1.4 Microsoft / Bing

**Website:** https://azure.microsoft.com/en-us/products/ai-services/openai-service

| User-Agent | Purpose |
|------------|---------|
| bingbot-chat/2.0 | Bing AI chat |
| bingbot/2.0 | General Bing crawler |
| Microsoft Copilot | Copilot AI assistant |
| MSBot | Microsoft AI/language training |
| Azure OpenAI | Enterprise AI platform |

### 1.5 Meta (Facebook)

**Website:** https://ai.meta.com  
**Documentation:** https://developers.facebook.com/docs/sharing/webmasters/web-crawlers

| User-Agent | Purpose |
|------------|---------|
| FacebookBot | General AI content collection |
| FacebookBot/1.0 | Versioned variant |
| facebookexternalhit | External content fetching |
| facebookexternalhit/1.1 | Versioned variant |
| meta-externalagent | AI agent access |
| meta-externalfetcher/1.1 | Content fetching |
| Meta AI | General Meta AI |
| Llama 3.2, Llama 4 | Language model training |
| SAM 2 | Segment Anything Model |

### 1.6 Perplexity

**Website:** https://www.perplexity.ai  
**Bot Documentation:** https://docs.perplexity.ai/guides/bots  
**IP List:** https://www.perplexity.ai/perplexitybot.json

| User-Agent | Purpose |
|------------|---------|
| PerplexityBot | Main crawler |
| PerplexityBot/1.0 | Versioned variant |
| Perplexity-User/1.0 | User-initiated searches |
| Perplexity Deep Research | Deep research feature |

### 1.7 Other Major AI Companies

#### Cohere
**Website:** https://cohere.com

| User-Agent | Purpose |
|------------|---------|
| cohere-training-data-crawler | Training data collection |
| cohere-ai | General identifier |

#### Mistral AI
**Website:** https://mistral.ai

| User-Agent | Purpose |
|------------|---------|
| Mistral | General identifier |
| LeChat | Chat interface |
| MistralAI-User | User-initiated |

#### Grok (x.AI)
**Website:** https://x.ai

| User-Agent | Purpose |
|------------|---------|
| Grok | General identifier |
| Grok 3 | Model version |
| GroqChat | Chat interface |

#### Apple
**Website:** https://support.apple.com/en-us/119829

| User-Agent | Purpose |
|------------|---------|
| Applebot | General Apple crawler |
| Applebot-Extended | AI training specific |

**Warning:** Blocking Applebot may affect Safari functionality.

#### Amazon
**Website:** https://aws.amazon.com/free/machine-learning/

| User-Agent | Purpose |
|------------|---------|
| Amazonbot | General Amazon crawler |
| Amazon Lex | Voice AI |
| amazon-kendra | Enterprise search |
| Amazon Bedrock | AI platform |
| Amazon SageMaker | ML platform |
| Amazon Silk | Browser |
| AWS Trainium | AI training chips |
| Nova Act | AI agent |
| Alexa, AlexaTM | Voice assistant |

---

## Section 2: AI-Powered Browsers and Their Agents

### Major Browsers with AI Features

| Browser | URL | AI Feature |
|---------|-----|------------|
| Arc | https://arc.net | Max |
| Brave | https://brave.com | Leo |
| Firefox | https://www.mozilla.org | mozilla.ai |
| Opera | https://www.opera.com | Aria AI |
| Microsoft Edge | https://www.microsoft.com/edge | Edge AI / Copilot |
| Vivaldi | https://vivaldi.com | Bing AI |
| Safari | https://www.apple.com/safari | Safari AI |
| SigmaOS | https://sigmaos.com | Airis |

### Lesser-Known AI Browsers

| Browser | URL | AI Feature |
|---------|-----|------------|
| Midori | https://astian.org/midori-browser/ | Midori-AI |
| Falkon | https://www.falkon.org | Falkon AI |
| Maxthon | https://www.maxthon.com | AIChat |
| Waterfox | https://www.waterfox.net | Heliopas AI |
| DuckDuckGo | https://duckduckgo.com | AI Chat |
| Lightpanda | https://lightpanda.io | AI-first browser |

---

## Section 3: Data Scraping and Collection Companies

### Common Crawl
**Website:** https://commoncrawl.org

| User-Agent | Purpose |
|------------|---------|
| CCBot | Main crawler |
| CCBot/2.0 | Versioned variant |
| CC-Crawler | Alternative identifier |

### Other Data Scrapers

| User-Agent | Company/Purpose |
|------------|-----------------|
| Webzio, Webzio-Extended | Webz.io data extraction |
| Omgilibot | Webz.io (former name) |
| scrapy | Scrapy framework |
| Scrapy/2.0 | Versioned variant |
| FriendlyCrawler | Generic AI scraper |
| PiplBot | Data collection |
| peer39_crawler | Peer39 contextual data |
| Timpibot | Timpi search engine |
| dataprovider | DataProvider services |

---

## Section 4: AI Image and Video Generation Platforms

### Image Generation

| Platform | URL | User-Agent |
|----------|-----|------------|
| Midjourney | https://www.midjourney.com | Midjourney |
| Ideogram | https://ideogram.ai | Ideogram |
| Stable Diffusion | https://www.diffusion.gg | StableDiffusionBot |

### Video Generation

| Platform | URL | Purpose |
|----------|-----|---------|
| Luma | https://lumalabs.ai | All kinds of AI |
| Hailuo | https://hailuoai.video | Video creator |
| Kling | https://klingai.com | Text to video |
| ElevenLabs | https://elevenlabs.io | Voice generator |
| HeyGen | https://www.heygen.com | AI video creator |

### Image Scrapers

| User-Agent | Purpose |
|------------|---------|
| img2dataset | Large-scale image collection |
| ImagesiftBot | Image indexing |
| thehive.ai | AI image grabber |
| Nicecrawler | Website image creator |
| ImageGen | Image generation training |
| V-JEPA | Meta video AI |

---

## Section 5: AI Frameworks and Tools

### LLM Frameworks

| Framework | URL |
|-----------|-----|
| LangChain | https://python.langchain.com |
| Llama Index | Data framework for LLM apps |
| Haystack | End-to-end NLP framework |
| Dify | Open-source LLM framework |
| CrewAI | https://www.crewai.com |
| AutoGen | Microsoft agent framework |
| SuperAGI | Autonomous AI agent framework |

### Agent Frameworks

| Framework | Purpose |
|-----------|---------|
| AgentGPT | https://agentgpt.reworkd.ai |
| Auto-GPT | https://agpt.co |
| BabyAGI | Autonomous agent |
| MetaGPT | https://www.deepwisdom.ai |
| XAgent | Autonomous LLM-based agents |
| CAMEL | Communicative Agents |
| Smolagents | Minimalist agent framework |

---

## Section 6: Regional and Specialized Considerations

### Sweden-Specific

| User-Agent | URL | Purpose |
|------------|-----|---------|
| GPT-Sw3 | https://huggingface.co/AI-Sweden-Models | Swedish language AI |
| Klang | https://klang.ai/sv/ | Swedish AI |

### China-Based AI

| Company | Models/Agents |
|---------|---------------|
| Baidu | Ernie 4.5, ErnieBot |
| Alibaba | Qwen, Qwen3 |
| Zhipu AI | ChatGLM, GLM-4 |
| Tencent | Hunyuan |
| SenseTime | Sensechat |
| Manus | https://manus.im |
| Moonshot | Kimi |
| DeepSeek | DeepSeek-V3, DeepSeek-R1 |

### Yandex (Russia)

| User-Agent | Purpose |
|------------|---------|
| YandexGPT | Yandex AI |
| YaML | Machine learning |
| YarGPT | Chat GPT alternative |
| yarchatgpt | Chat service |

---
:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
Ai bots - scrapers:
.................................................................
## Ai (important) Adresses:  ###
.
* Alpha AI: https://www.alphaai.capital
* anthropic-ai: https://www.anthropic.com
        Claude ai news: https://claude.ai
* Auto-GPT: https://agpt.co
* Agent GTP: https://agentgpt.reworkd.ai
* Apple/Safari: https://support.apple.com/en-us/119829
* Anthropic: https://www.anthropic.com
* Boomi AI: https://boomi.com/resources/resources-library/boomi-launches-ai-agents
* Hugging face:  https://huggingface.co
* Open ai: https://openai.com
           https://platform.openai.com/docs/overview
* Common Crawl: https://commoncrawl.org
* crew AI: https://www.crewai.com
* Crew ai: spider scraper: https://spider.cloud   Useragent: spider
* Cohere: https://cohere.com
* Grok: https://x.ai
* Google: https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers?hl=en
* Gemini: https://gemini.google.com
* Meta ai (facebook): https://ai.meta.com
* Mistral Ai:  https://docs.mistral.ai/capabilities/agents
* Perplexity:  https://www.perplexity.ai
* Webz.io:  https://webz.io
* Zero GTP: https://www.zerogpt.com
* Webzio * User agent: Webzio-extended  https://webz.io/bot.html

.....................................................................
---------------------------------------------------------------------
### Browsers (with AI):

https://arc.net     AI: Max
https://brave.com   AI: Leo
https://www.mozilla.org/sv-SE/firefox   AI: mozilla.ai 
https://www.opera.com     AI: Aria AI
https://www.microsoft.com/sv-se/edge   AI: Edge AI
https://vivaldi.com    AI: Bing AI
https://www.torproject.or   AI: Tor.ai 
https://mullvad.net/en/browser    AI: NON YET?
https://www.apple.com/safari:  AI:  Safari AI
https://sigmaos.com  AI: Airis

#Less Known AI browsers:
https://astian.org/midori-browser/  AI: Midori-AI
https://www.palemoon.org/    AI: Non yet?
https://www.seamonkey-project.org  AI: Non yet?
https://www.falkon.org  AI: Falkon AI
https://www.maxthon.com   AI: AIChat
https://apps.kde.org/sv/konqueror  AI: Kfind Ai
https://www.comodo.com/home/browsers-toolbars/browser.php *Comodo IceDragon / Comodo Dragon Internet Browser  AI: ?
https://epicbrowser.com     AI: Epic AI?
https://www.lunascape.org   AI: ?? 
https://www.waterfox.net    AI:  Heliopas AI
https://duckduckgo.com      AI: AI Chat
CHINA: QQ Browser   // Yuanbao Quick Answer 
https://ghostbrowser.com    AI: ?
Lightpanda: https://github.com/lightpanda-io/browser URL: https://lightpanda.io

* AI LIST: https://aiagentslist.com/
           https://github.com/topics/artificial-intelligence

# Keep an eye on!:
* User-agent: Kagibot https://kagi.com/     Only works on:Mac OS


* Oracle:  RAG / LLMS
URL: https://docs.oracle.com/en-us/iaas/releasenotes/services/generative-ai-agents/index.htm

* Good to know: https://virtualizationreview.com/Articles/2025/01/13/Top-10-GenAI-Apps-Most-Often-Blocked-by-Orgs.aspx

*TDM Reservation Protocol (TDMRep): https://www.w3.org/community/reports/tdmrep/CG-FINAL-tdmrep-20240202/#sec-properties

* Books and Research, Papers:
Library Genesis (LibGen) 
URL: https://libgen.li/index.php?req=fmode:last&topics%5B%5D=l

LLMS
URL: https://research.aimultiple.com/llmops-tools/

Databricks:
URL: https://www.databricks.com/product/artificial-intelligence

Ollama /various AI:
URL: https://ollama.com

Machine Learning:  https://www.geeksforgeeks.org/machine-learning/machine-learning/

.....................................................................
---------------------------------------------------------------------
## Blogs, News and intresting sites:

#* Huge List of: LLM:
https://llmstxt.site/

**SERDY News:
https://seirdy.one/meta/scrapers-i-block/

AI News: (all stuffs)
https://www.artificialintelligence-news.com/artificial-intelligence-news/
URL 2: https://www.artificialintelligence-news.com/

Google AI news:
https://ai.google/latest-news/
https://deepmind.google
https://deepmind.google/discover/blog

AI Today:
https://aitoday.com/

AI weekly:
https://aiweekly.co/

AI News:
https://www.ainews.com/

Ai News: 
https://www.aibase.com

Amazon AI news:
https://www.aboutamazon.com/artificial-intelligence-ai-news

Verge news:
https://www.theverge.com/ai-artificial-intelligence

Mistral News:
https://mistral.ai/news

AI agents /
https://www.analyticsvidhya.com/blog/2025/03/ai-agents-terms/

.....................................................................
---------------------------------------------------------------------
##Others:

Blogs: 
Krassno: https://www.krasamo.com/block-gptbot
Botpress: https://botpress.com/blog/what-is-an-ai-agent

Control of AI Spiders:
https://darkvisitors.com


Spawning AI txt:  https://spawning.ai/ai-txt 

Google Extended:  https://searchengineland.com/google-extended-does-not-stop-google-search-generative-experience-from-using-your-sites-content-433058

* LEARN MORE:  https://www.mongodb.com/resources/basics/artificial-intelligence/ai-agents
               https://zapier.com/blog/ai-agent

.....................................................................
---------------------------------------------------------------------
## Ai - OTHERS (of intrests: Adresses:  ###

#OTHERS (of intrests):
SuperAgent: https://github.com/superagent-ai/superagent
BabyAGI: https://github.com/yoheinakajima/babyagi
Aomni:  https://www.aomni.com
MetaGPT: https://www.deepwisdom.ai
Tusk AI: https://usetusk.ai
Superagent (BUILD YOUR OWN CHAT): https://www.superagent.sh
Devin AI: https://preview.devin.ai


LAION-AI: https://laion.ai   //open source AI.  
       https://github.com/laion-ai

GPT-J: https://huggingface.co/EleutherAI/gpt-j-6b   //open source AI. 
       https://github.com/graphcore/gpt-j
	   
GPTNeo: https://huggingface.co/togethercomputer/GPT-NeoXT-Chat-Base-20B  //open source AI. 
Cerebras-GPT  https://cerebras.ai/blog/cerebras-gpt-a-family-of-open-compute-efficient-large-language-models/

Pythia:  https://askpythia.ai  
         https://projectpythia.org
		 *
LOTS of more Ai: https://sapling.ai/llm/gpt-j-vs-gptneo
And More: https://github.com/e2b-dev/awesome-ai-agents
Integuru: https://github.com/Integuru-AI/Integuru
DeepSEEK: https://github.com/deepseek-ai/DeepSeek-V3
     URL: https://www.deepseek.com

*Eleuther.ai
https://www.eleuther.ai/releases


# Anomymous:
* All kindsofAgents: https://e2b.dev/ai-agents/general-purpose
* https://theresanaiforthat.com/s/gpt+agents/

-
* Others, like facebook, Instagram and so on:
https://pirg.org/edfund/resources/how-to-stop-your-data-from-being-used-for-ai-training/

* Good to know:
https://www.dev4press.com/kb/user-guide/coresecurity-block-ai-crawlers-and-scrappers/
* https://www.synthesia.io/post/ai-tools
* SEARCH ENGINE 2025 -ai:  https://www.zdnet.com/article/best-ai-search-engine/
* AI WEBSITES -2025: https://dorik.com/blog/best-ai-websites
* Slack AI   https://slack.com/features/ai

# Strong  Ai
URL: https://www.moveworks.com/us/en/resources/ai-terms-glossary/strong-ai
URL 2: https://botpenguin.com/glossary/strong-ai

.....................................................................
---------------------------------------------------------------------
## Agents:
### Only affects SWEDEN:

URL: https://chat-gpt-sverige.se/
URL: https://huggingface.co/docs/transformers/model_doc/gpt-sw3
URL: https://huggingface.co/AI-Sweden-Models/gpt-sw3-20b-instruct

User-agent: GPT-Sw3
Disallow: /

Klang
URL: https://klang.ai/sv/

.....................................................................
---------------------------------------------------------------------
# Accona business (Business USA):  Active?
https://www.accoona.com
User-agent: Accoona-AI-Agent/1.1.1 
Disallow: /
User-agent: Accoona-AI-Agent/1.1.2 
Disallow: /
User-agent: Accoona-AI-Agent
Disallow: /

.....................................................................
---------------------------------------------------------------------
# CHINA:
Zhipu AI : GLM4 (claimed to rival GPT-4)

ManusAI
URL: https://manus.im/
Agent: Manus

Baidu (Tencent): R1 
       Ernie 4.5
	   
Alibaba:
Qwen

CHINA:
Works in all language 
ChatGLM
chatglm
URL: https://chatglm.cn/

QwQ
Yi Chat
Alpaca

#LLM (alibaba open source)*
Useragent: qwen /
qwen3
Qwen3-VL
Qwen Chat
URL: https://qwen3.org/

#OTHERS:
Meituan-agent
AiCheng Agent

PAI-DataSurfer Agent  
//Alibaba Cloud Computing Platform

ReFoRCE + o3 
ReFoRCE + o1-preview 
//Hao AI Lab x Snowflake

Spider-Agent + Qwen3-Coder	31.08

.....................................................................
---------------------------------------------------------------------
* AI: LISTS:
URL: https://justdataplease.com/product/github-repos-research/5/dashboard
URL:https://aiagentslist.com
URL:https://www.aevummachinae.com/All-GPTs
URL: https://allgpts.co

.....................................................................
---------------------------------------------------------------------
### Google:
*  is associated with Google Vertex AI agents. Vertex is supposedly covered by Google-Extended (above).
* google.com

User-agent: Google-CloudVertexBot
Disallow: /

#Google:
Google Gemini

## GoogleOther is a new set of data crawlers from Google, used for web scraping. “GoogleOther is the 
generic crawler that may be used by various product teams for fetching publicly accessible 
content from sites”. Besides the generic GoogleOther, 
they also use GoogleOther-Image and GoogleOther-Video. 
If you block the user agent string “GoogleOther” you will block all of them.

# Google Other: (Mostly robots.txt works if not wanted):
User-agent: GoogleOther
Disallow: / 
User-agent: GoogleOther-Image
Disallow: /
User-agent: GoogleOther-Video
Disallow: /

User-agent: Google-Extended    //Can inteear with google crawlers!! #
Disallow: / 

#Google:
Google - Not affecting ordinary blogs yet.
Gemini 1.5 Pro	
Gemini 1.5 Pro (Vertex AI)	
Gemini 1.5 Flash

## MACHINE Ai: Not affecting blogs, but good to know in case ....
(google - It allows you to train, deploy, 
and customize ML models and AI applications, including large language models (LLMs)

https://cloud.google.com/vertex-ai/
Vertex AI  

Google PaLM2
https://ai.google/discover/palm2
https://cloud.google.com/blog/products/ai-machine-learning/generative-ai-applications-with-vertex-ai-palm-2-models-and-langchain 

GeminiBot	
Google-Extended	Google Gemini LLM training
URL: https://ai.google.dev/competition/projects/gemini-bot-bd

User-agent: Gemini  
User-agent: Google Gemini

User-agent: GoogleOther
User-agent: Google-CloudVertexBot


User-agent: Google-Extended  - Can block google to index site!!

Imagen3
Imagen3-Fast

Phi 4	
Phi 4 Min
URL: https://huggingface.co/microsoft/phi-4

Gato
# Gato (DeepMind)
URL:  https://deepmind.google/discover/blog/a-generalist-agent/

*TXT: Generating text: Gato can write different kinds of creative text formats, 
 like poems, code, scripts, musical pieces, email, letters, etc., 
 showcasing its understanding of language and ability to generate creative content. 
.....................................................................
---------------------------------------------------------------------
##  BING (MICROSOFT):

User-agent: bingbot-chat/2.0
User-agent: Bing ai 

Azure OpenAI 
https://azure.microsoft.com/en-us/products/ai-services/openai-service
https://ai.azure.com/

# Blockera Microsofts AI-robot Tay

User-agent: bingbot/2.0
Disallow: /

User-agent: Microsoft Copilot
Disallow: /

* MSBot 
(Microsoft),Used by Microsoft for various AI and language model training purposes. 
It adheres to robots.txt directives and is designed to gather useful data while respecting website owners’ preferences.

User-agent: MSBot 
Disallow: /

Microsoft Copilot  /video
Llama 3.1 70B 	
Llama 3.1 405B
Llama 3.3 70B 	
Llama 4 Scout 17B 1	
Llama 4 Maverick 17B 128E 
LlamaIndex 
Llama-3.2-3B-Chat

Gemini 1.5 Flash	
Gemini 2.0 Flash	
Gemini 2.5 Pro Preview

....................................
# FLOWER AI:

Flower AI
Collective-1. 
URL: https://flower.ai/

.....................................................................
---------------------------------------------------------------------
# AI Scraper:
* DOWNLOADER:
URL: https://www.microsystools.com/products/website-download/all-versions.php

RewriteCond%{HTTP_USER_AGENT}^A1 Website download [NC,OR]
RewriteCond%{HTTP_USER_AGENT}^A1 Website Scraper [NC,OR]

.....................................................................
---------------------------------------------------------------------
## AI Images creator/Video AI:downmloader - stealers:

Midjourney  - images creator
URL: https://www.midjourney.com

Ideogram  images creator
URL:  https://ideogram.ai/t

Luma  all kins of Ai
URL: https://lumalabs.ai/

Hailuo - video creator
URL: https://hailuoai.video/

Kling - txt to video
URL: https://klingai.com/

ElevenLabs - voice generator
URL: https://elevenlabs.io/


HeyGen - Ai video creator
URL: https://www.heygen.com

*img2dataset
#https://github.com/rom1504/img2dataset:

User-agent: img2dataset
Disallow: /

website image creator
User-agent: Nicecrawler
Disallow: /

 Image Stealer AI:
User-Agent: ImagesiftBot
Disallow: /

ADRESS: https://imagesift.com

* Ai image grabber:
ADRESS: https://thehive.ai/

User-Agent: thehive.ai
Disallow: /

* text to Imagages AI:
Midjourney 
https://www.midjourneyfree.ai

* StableDiffusionBot
URL: https://www.diffusion.gg/

User-agent: StableDiffusionBot
Disallow: /

*Video:
V-JEPA
URL: https://ai.meta.com/blog/v-jepa-yann-lecun-ai-model-video-joint-embedding-predictive-architecture/

User-agent: V-JEPA
            Disallow: /

# Auto ML
Automated Machine Learning (AutoML)  //VARIUS 

# Imageproxy
URL: https://www.aibase.com/repos/project/docker-nginx-image-proxy
URL 2: https://www.netify.ai/resources/hostnames/imageproxy.as.criteo.net
URL 3:https://github.com/imgproxy/imgproxy

Lensa AI - images

* Steal your images:
ImageGen
ImageGen /

.....................................................................
---------------------------------------------------------------------
## AI Framework:
LangChain 
AutoGen
Semantic Kernel
Atomic Agents 
CrewAI
RASA
Hugging Face Transformers Agents
Langflow
Lyzer
Haystack
Langroid
Flowise
Model Context Protocol   /Anthropic
Neural Chat

* LLM frameworks
LangChain
Llama Index - Data framework for LLM applications
Agentic RAG
RAG txt: custom AI applications that can navigate, scrape, and manipulate web content with ease
Dify - Open-source framework for LLM applications
RAG pipeline
Haystack - End-to-end NLP framework
Embedchain - Framework for ChatGPT-like bots
SuperAGI - Open-source autonomous AI agent framework
AGiXT - Scalable framework for AI agents
XAgent - Autonomous LLM-based agent framework
OpenAgents - Open platform for language agents
AI Legion - Swarm framework for autonomous agents
Agent Protocol - Unified interface for AI agents
Agents.js - JavaScript framework for building AI agents
CAMEL - Communicative Agents for "Mind" Exploration
6,380 stars · 762 forks · 76 contributors · 305 issues · Python · Apache-2.0
Autonomous-GPT - Framework for autonomous GPT-4 agents
Parallel execution- ix - Autonomous agent framework
Smolagents - Minimalist framework for building powerful agents
Docker deployment- Pydantic AI - Production-grade agent framework built on Pydantic
Model Context Protocol (MCP)

.....................................................................
---------------------------------------------------------------------
# Open AI:
URL: https://openai.com

* GTP:
https://platform.openai.com/docs/bots GTP:
GPT-4V(ision) (251025)

User-agent: GTPBOT    #YSES by content scrapers!

User-Agent: GPTbot/0.1
User-Agent: GPTBot/1.0

User-agent: ChatGPT
User-agent: ChatGPT-User
User-agent: GPTBot

User-agent: GPT-4o
User-agent: GPT-4o mini
User-agent: GPT-3.5 Turbo
User-agent: SearchGPT 
User-agent: WebChatGPT
User-agent: GPTBot /
User-agent: gpt-crawler
User-agent: GPT-1
User-Agent: GPTbot/0.1
User-Agent: GPTBot/1.0
User-Agent: GPTBot/1.2
User-agent: GPT-2
User-agent: GPT-3 
User-agent: GPT-3.5
User-agent: GPT-3.5 turbo
User-agent: GPT-4 
User-agent: GPT-4,5
User-agent: GPT-5
User-agent: gpt-4-turbo
User-agent: GPT-4o
User-agent: GPT-4V
User-agent: GPT-4o mini
User-agent: GPT 4 Omni	
User-agent: GPT 4 Omni Mini
User-agent: GPT-4.1
User-agent: GPT-4.1-mini
User-agent: GPT-4.1-nano    
	
*
Chat GPT Search  
URL: https://openai.com/index/introducing-chatgpt-search/

ChatGPT-User/2.0
ChatGPT search

*
#OPEN AI:
https://platform.openai.com/docs/bots

User-agent: OAI SearchBot
Disallow: /
User-agent: OAI-SearchBot/1.0
Disallow: /
User-agent: OpenAI o1
Disallow: /
User-agent: OpenAI o1-mini
Disallow: /
User-agent: OpenAI o3-mini
Disallow: /
User-agent: OpenAI 
Disallow: /
User-agent: Openbot
Disallow: /
User-agent: OpenAI GPT
Disallow: /

User-agent: Operator
Disallow: /
https://openai.com/index/introducing-operator


User-agent: OpenAI CUA
Disallow: /

https://scrapybara.com/blog/cua
https://openai.com/index/new-tools-for-building-agents/
https://openai.com/index/computer-using-agent/


.................................................
#Another way:GTBBOT:

<IfModule mod_rewrite.c>	
RewriteCond %{REMOTE_ADDR} ^52\.230\.152\. [OR]
RewriteCond %{REMOTE_ADDR} ^52\.233\.106\. [OR]
RewriteCond %{REMOTE_ADDR} ^20\.171\.206\. [OR]
RewriteCond %{REMOTE_ADDR} ^20\.171\.207\. [OR]
RewriteCond %{REMOTE_ADDR} ^4\.227\.36\.([0-9]|[0-9][0-9]|1[0-1][0-9]|12[0-5])$ [OR]
RewriteCond %{REMOTE_ADDR} ^20\.42\.10\.1(7[6-9]|8[0-3])$ [OR]
RewriteCond %{REMOTE_ADDR} ^172\.203\.190\.1(2[8-9]|3[0-9])$ [OR]
RewriteCond %{REMOTE_ADDR} ^51\.8\.102\. [OR]
RewriteCond %{REMOTE_ADDR} ^189\.89\.12\.150$
RewriteRule ^ - [F,L]</IfModule>

#Image AI:
* https://openai.com/index/dall-e-2  (uses Machine learning)

User-agent: Dall-E
User-agent: Dall-E 3
User-agent: DALL-E Mini
User-agent: DALL·E 3

*
Open AI news:  https://x.com/openai

User-agent: OpenAI ChatGPT
            Disallow: /

User-agent: OpenAI Crawler
            Disallow: /
* Can also come from:  OAI-SearchBot|Mac OS X 

* Operator:  (open AI)
URL: https://openai.com/index/introducing-operator/

* Sora (text-to-video) - https://openai.com/sora (FB) Sora - ny text-to-video modell från OpenAI
Whisper (speech-to-text)

.....................................................................
---------------------------------------------------------------------
### AMAZON AI (also #claudebot is on Amazon!
URL: https://aws.amazon.com/free/machine-learning/
:
# Speaking AI:
User-agent: Amazon Lex
Disallow: /

User-agent: amazon-kendra
Disallow: /

User-agent: Amazon Silk
Disallow: /

User-agent: Amazon SageMaker
Disallow: /

User-agent: AWS Trainium 
Disallow: /

User-agent: amazon-kendra
Disallow: /

User-agent: Amazon Bedrock
Disallow: /

User-agent: Alexa
Disallow: /

User-agent: AlexaTM
Disallow: /

User-agent: Amazon Textract
Disallow: /

User-agent: Amazon Comprehend
Disallow: /

User-agent: Nova Act 
Disallow: /

URL: https://labs.amazon.science/blog/nova-act

??
URL: https://aws.amazon.com/personalize/?p=ft&c=ml&z=3
Amazon Personalize

Constitutional AI (CAI)  (claude)
Sophos 2
Claude-SearchBot

.................................................
### Antoher Way, if they do not give up!:   "UPDAED: 250421, hates: bytesspider....


<IfModule mod_rewrite.c>
RewriteCond%{HTTP_REFERER}^https://.*amazonaws\.com [NC] 
RewriteCond%{HTTP_REFERER}^https://.*amazon\.com [NC]
RewriteCond%{HTTP_REFERER}^https://(([^.]+\.)+)?amazonaws\.com[NC]
RewriteCond%{HTTP_REFERER}^amazonaws\.com$ [OR,NC]  
RewriteCond%{HTTP_REFERER}aws.amazon\.com [NC]
RewriteCond%{HTTP_REFERER}"^https?://(?:[^/]+\.)?amazonaws\.com"[NC,OR]
RewriteCond%{HTTP_REFERER}"^https?://(?:[^/]+\.)?amazon\.com"[NC,OR]
RewriteCond%{HTTP_REFERER}"^https?://(?:[^/]+\.)?Amazon\.com"[NC] 
RewriteCond%{HTTP_REFERER}"^https?://(?:[^/]+\.)?^amazon.com.au"[NC]
RewriteCond%{REMOTE_HOST}^.*\.compute-1\.amazonaws\.com [NC,OR]
RewriteCond%{HTTP_REFERER}^compute-1.amazonaws\.com$ [OR,NC] 
RewriteCond%{REMOTE_HOST}^.*\1.compute.amazonaws\.com [NC,OR] 
RewriteCond%{REMOTE_HOST}^.*\2.compute.amazonaws\.com [NC,OR]
RewriteCond %{REMOTE_HOST} ^compute-2.amazonaws\.com$ [OR,NC]  
RewriteCond%{HTTP_USER_AGENT}"Alexa"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"AlexaTM"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Amazonbot /"[NC,OR]  
RewriteCond%{HTTP_USER_AGENT}"amazonbot"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}".crawl.amazonbot.amazon"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}"Amazon Textract"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Amazon Comprehend"[NC,OR]     
RewriteCond%{HTTP_USER_AGENT}"Amazon Silk"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}"AMAZON-02"[NC,OR]  
RewriteCond%{HTTP_USER_AGENT}"Amazon Bedrock"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}"Amazon SageMaker"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}"AWS Trainium"[NC,OR] 
RewriteCond%{HTTP_USER_AGENT}"Amazon Kendra"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Amazon Lex"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Claude-User"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Claude-SearchBot"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"Nova Act"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"PerplexityBot"[NC,OR]
RewriteCond%{HTTP_USER_AGENT}"PerplexityBot/1.0"[NC,OR]
RewriteCond%{REMOTE_ADDR}!^3\.6.)$ [NC,OR]          #ClaudeBot AI
RewriteCond%{REMOTE_ADDR}!^3\.107.)$ [NC,OR]        #ClaudeBot AI 
RewriteCond%{REMOTE_ADDR}!^3\.21.)$ [NC,OR]         #ClaudeBot AI 
RewriteCond%{REMOTE_ADDR}!^3\.90.)$ [NC,OR] 
RewriteCond%{REMOTE_ADDR}!^3\.145.)$ [NC,OR]        #ClaudeBot AI  
RewriteCond%{REMOTE_ADDR}!^3\.148.)$ [NC,OR]  
RewriteCond%{REMOTE_ADDR}!^3\.238.)$ [NC,OR]        #AI Hacker
RewriteCond%{REMOTE_ADDR}!^13\.)$ [NC,OR]                     #AI Image stealer India
RewriteCond%{REMOTE_ADDR}!^18\.210.92.235)$ [NC,OR]           #AI Image stealer India
RewriteCond%{REMOTE_ADDR}!^18\.223.)$ [NC,OR]          #PerplexityBot
RewriteCond%{REMOTE_ADDR}!^34\.)$ [NC,OR]              #Scraping
RewriteCond%{REMOTE_ADDR}!^34\.235.)$ [NC,OR]          #Scraping
RewriteCond%{REMOTE_ADDR}!^35\.166.195.)$ [NC,OR]      #Scraping
RewriteCond%{REMOTE_ADDR}!^54.217.11.)$ [NC,OR]        #ClaudeBot AI 
RewriteCond%{HTTP_USER_AGENT}"Nutch"[NC]
RewriteRule ^(.*)$ - [F,L]</IfModule>

.....................................................................
---------------------------------------------------------------------
###FACEBOOOK - META AI: 
** FacebookBot  * BLOCK:

User-agent: FacebookBot
User-agent: FacebookBot/1.0
User-agent: facebookexternalhit
User-agent: facebookexternalhit/1.1
User-agent: meta-externalagent
User-agent: meta-externalfetcher/1.1
Disallow: /


* Language training
User-agent: Llama 3.2
User-agent: Llama 4
Disallow: /

User-agent: Meta AI
Disallow: /

* Meta (Facebook) Llama
https://ai.meta.com
https://www.llama.com
https://developers.facebook.com/docs/sharing/webmasters/web-crawlers

Meta AI: https://www.meta.ai
URL: https://ai.meta.com

SAM2: https://ai.meta.com/blog/segment-anything-2/
User-agent: SAM 2

Meta - OPT

.....................................................................
---------------------------------------------------------------------
* Anthropic AI: to gather data for their “AI” products, such as Claude.
* https://www.anthropic.com

User-agent: anthropic-ai
Disallow: /
User-agent: ClaudeBot
Disallow: /
User-agent: claude-web/1.0
Disallow: /
User-agent: ClaudeBot/1.0
Disallow: /
User-agent: ClaudeBot 3   
Disallow: /
User-agent: Claude 3.7 Sonnet
Disallow: /
User-agent: Claude 3.5 Haiku 
Disallow: /
User-agent: Claude 3 Opus
Disallow: /
User-agent: Claude-User
Disallow: /
User-agent: Claude-SearchBot
Disallow: /

URL: https://support.anthropic.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler


#### claudebot Hell:

<IfModule mod_rewrite.c>
RewriteCond%{HTTP_USER_AGENT}"anthropic-ai"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude 3.7 Sonnet"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude 3.5 Haiku"[NC] 
RewriteCond%{HTTP_USER_AGENT}"Claude 3 Opus"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude-User"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude-SearchBot"[NC]
RewriteCond%{HTTP_USER_AGENT}"claudebot"[NC]
RewriteCond%{HTTP_USER_AGENT}"claudeBot"[NC]
RewriteCond%{HTTP_USER_AGENT}"anthropic-ai"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude bot"[NC] 
RewriteCond%{HTTP_USER_AGENT}"ClaudeBot/1.0"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude 2.0"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude 2.1"[NC]
RewriteCond%{HTTP_USER_AGENT}"ClaudeBot 3"[NC] 
RewriteCond%{HTTP_USER_AGENT}"ClaudeBot"[NC]
RewriteCond%{HTTP_USER_AGENT}"Claude-Web"[NC]
RewriteCond%{HTTP_USER_AGENT}"claude-web/1.0
RewriteCond%{HTTP_USER_AGENT}"Claude-Web/1.0"[NC]
RewriteCond%{HTTP_USER_AGENT}^.*ClaudeBot.*$
RewriteCond%{REQUEST_URI}!robots\.txt  - [F,L]
RewriteRule ^(.*)$ - [F]</IfModule>

# ANOTHER WAY;
<IfModule mod_rewrite.c>
RewriteCond %{HTTP_USER_AGENT} ^.*ClaudeBot.*$
RewriteCond %{REQUEST_URI} !robots\.txt  - [F,L]
RewriteRule .* http://www.anthropic.com [R,L]
</IfModule>
https://www.anthropic.com/

.....................................................................
---------------------------------------------------------------------
## Cohere ai.
URL: https://cohere.com/

User-agent: cohere-training-data-crawler
Disallow: /

User-agent: cohere-ai
Disallow: /

* LLM:
 Command A
 Command R7B
 Cohere R+
 
 .....................................................................
---------------------------------------------------------------------
## I ASK:
URL: https://iask.ai/

User-agent: iAskBot
Disallow: /
User-agent: iAskBot/1.0
Disallow: /
User-agent: iaskspider/2.0
Disallow: /

.....................................................................
---------------------------------------------------------------------
## Perplexity  Ai
URL: https://www.perplexity.ai/
URL UA: https://docs.perplexity.ai/guides/bots
IP LIST: https://www.perplexity.ai/perplexitybot.json
SONAR: https://github.com/ppl-ai/api-cookbook

User-agent: PerplexityBot
Disallow: /
User-agent: PerplexityBot/1.0    (added: 250414)
Disallow: /
User-agent: Perplexity-User/1.0
Disallow: /
User-agent: Perplexit-User
Disallow: /
User-agent: 
User-agent: PerplexityUser
Disallow: /
User-agent: Perplexity Deep Research
Disallow: /

.....................................................................
---------------------------------------------------------------------
#Apple AI:
# https://support.apple.com/en-us/119829

OTHER apple (siri) #May: Affect Safari! Browser! Be carful!
User-agent: Applebot
Disallow: /

User-agent: Applebot-Extended
Disallow: /

.....................................................................
---------------------------------------------------------------------
#Yandex  - #ANDEX: Search engine:
URL: http://yarchatgpt.ru

#Yandex:
# Machine learning:
  CatBoost
  Yandex - YaLM

User-agent: YarGPT
Disallow: /

Also: User-agent: yarchatgpt
      Disallow: /
	  
User-agent: YaML
User-agent: YandexGPT
User-agent: YandexLLM
User-agent: YandexAdditional
User-agent: YandexAdditionalBot
User-agent: yarchatgpt
User-agent: YarGPT

.....................................................................
---------------------------------------------------------------------
# Duck.ai
anonymous AI chatbot
DuckDuckGo Chat
DuckAssistBot 
DuckDuckGo-Enhanced

#### SEARCH ENGINE  AI:  ##
DuckDuckGo Search:
DuckDuckGo Search used by DuckAssist (AI tool), which reportedly cites its sources.
URL: https://duckduckgo.com
URL: https://duckduckgo.com/duckduckgo-help-pages/results/duckassistbot/

User-agent: DuckAssistBot
Disallow: /

.....................................................................
---------------------------------------------------------------------
#WORDPress AI:
WPBot is an easy to use, Native, No coding required, AI ChatBot for 
WordPress websites to provide automated Live Chat Support, 
This ChatBot can be also be powered by OpenAI ChatGPT, DialogFlow, 
or simply use the built-in features to 
provide Live Customer support and collect data without any extra cost. 
Own and Manage this Native WordPress ChatBot directly from your 

https://sv.wordpress.org/plugins/chatbot/


User-agent: wpbot
Disallow: /
User-agent: wpbot/1.1
Disallow: /

.....................................................................
---------------------------------------------------------------------
# DialogFlow

User-agent: DialogFlow
Disallow: /
.....................................................................
---------------------------------------------------------------------
SenseTime  /CHINA
Sensechat
URL: https://www.sensetime.com/en
.....................................................................
---------------------------------------------------------------------
## AI SCRAPERS - AI And AI datascrapers: 

User-agent: FriendlyCrawler
Disallow: /

User-agent: FriendlyCrawler/1.0
Disallow: /

User-agent: FriendlyCrawler/Nutch-1.20-SNAPSHOT
Disallow: /

# Scraper (scrapes your blog for everything:
User-agent: scrapy
Disallow: /

User-agent: AlphaAI
Disallow: /

# Collect all data:
User-agent: PiplBot
Disallow: /

# peer crawler:
An open source and collaborative framework for extracting the data you need from websites.

Site: https://www.peer39.com/

User-agent: peer39_crawler/1.0
Disallow: /

# AI Data Scraper
# https://darkvisitors.com/agents/timpibot

User-agent: Timpibot
Disallow: /
User-agent: Timpibot
Disallow: /
User-agent: Timpibot/0.8 
Disallow: /    
User-agent: Timpibot/0.9 
Disallow: /

## Hard to block:
Timpibot/0.8     Mozilla/5.0 (compatible; Timpibot/0.8; +http://www.timpi.io)
Timpibot/0.9     Timpibot/0.9 (+http://www.timpi.io)

https://timpi.io/
I blocked whole user string!

# AI + HACKING:
https://flowgpt.com/p/wormgpt-v30
# WormGPT V3.0 is a powerful and ruthless AI chatbot designed to assist 
hackers with their hacking and programming endeavors

User-agent: WormGPT V3.0
Disallow: /
User-agent: WormGPT 
Disallow: /

#THIS Is blocked by: common hackers tools
https://www.dataprovider.com/spider/
User-agent: dataprovider
Disallow: /

* https://gptzero.me/
# ByPasser of ai: Can by pass allrobots.txt, scurity to steal your stuff:(

User-agent: GPTZero
Disallow: /
User-agent: ZeroCHAT
Disallow: /

* https://www.zerogpt.com
User-agent: ZeroGPT
Disallow: /

........................................................
#Allenai ai:
https://allenai.org/crawler
https://allenai.org
User-agent: AI2Bot
Disallow: /

........................................................
* Scrapy:
URL: https://scrapy.org/
ALSO: URL: https://www.zyte.com
SPIDERS/User agents: https://docs.scrapy.org/en/latest/topics/spiders.html

User-agent: scrapy
Disallow: /
User-agent: Scrapy/2.0
Disallow: /

.....................................................................
---------------------------------------------------------------------
### LLMS trainering bots:  GONE??  

# LLMS - Dalvik is a virtual machine (VM) for the Android operating system. 
Usually used on mobile click farms for automated tasks. 
No sane human will be using this browser agent. 
Works mostly on: Android OS.

URL: https://en.wikipedia.org/wiki/Dalvik_(software)
URL: https://source.android.com/docs/core/runtime/dalvik-bytecode
User agent Info:  https://useragents.io/uas/dalvik-2-1-0-linux-u-android-14-sm-s918b-build-up1a-231005-007_8c5110c0e19bc84a14542b3da3db568a#google_vignette
More: https://www.geeksforgeeks.org/what-is-dvmdalvik-virtual-machine/


User-agent: Dalvik/2
Disallow: / 

User-agent: Dalvik/2.1.0
Disallow: / 

-----------------------------------------------------
LLMS trainer:

https://allenai.org
https://github.com/allenai

URL: https://allenai.org/crawler
User-agent: AI2 Bot
Disallow: /


* Cotoyogi
GenAI training-data scraper
URL: https://ds.rois.ac.jp/en_center8/en_crawler/

User-agent: Cotoyogi
Disallow: /

LiteLLM    https://www.litellm.ai
URL: https://docs.litellm.ai/docs/


* ON GITHUB:
reliableGPT   https://github.com/BerriAI/reliableGPT  

.....................................................................
---------------------------------------------------------------------
* Mistral ai
URL: https://mistral.ai
URL: http://chat.mistral.ai
URL: https://mistral.ai/en
URL: https://docs.mistral.ai/capabilities/agents/

User-agent: Mistral
User-agent: LeChat
User-agent: Mistral Chat

Open source modeller
https://huggingface.co/mistralai/Mistral-7B-v0.1
https://huggingface.co/mistralai/Mix...-Instruct-v0.1

.....................................................................
---------------------------------------------------------------------
# Sidetrade indexer bot - training AI: 
URL: https://www.sidetrade.com/	
Extracts data for a variety of uses including training AI.	
AI product training. Only affects if you got a shop and thoroughly.

User-agent: Sidetrade 
Disallow: /

.....................................................................
---------------------------------------------------------------------
### Grok: https://x.ai/
URL: https://groq.com

Grok-1.5	
Grok-2 mini	
Grok-2
Grok-2‡
Grok 3
GroqChat
Groq Cloud AI
Grok AI chatbot

.....................................................................
---------------------------------------------------------------------
# OTHER AI:

* https://www.peer39.com/

User-agent: peer39_crawler
User-agent: peer39_crawler/1.0


## TurnitinBot
* A web crawler (aka spider, robot or bot) is a computer program that scours the web gathering content.
https://www.turnitin.com/robot/crawlerinfo.html

User-agent: TurnitinBot
Disallow: /   

# AndersPinkBot
* curated content for learning  LLM!
https://anderspink.com

User-agent: AndersPinkBot
Disallow: /

ISSCyberRiskCrawler  
URL: https://iss-cyber.com/

User-agent: ISSCyberRiskCrawler
Disallow: /

URL: https://crawlspace.dev
DOES:  Scrapes data, images and so on
User-agent: Crawlspace
Disallow: /

# SEMRUSCH AI:
URL:  https://sv.semrush.com/bot/
SemrushBot-OCOB 

User-agent: SemrushBot-OCOB 
Disallow: /

# Goose
URL: https://block.github.io/goose/

User-agent: Goose
Disallow: /

# Falcons Ai:
https://falcons.ai/  
https://github.com/Falcons-ai/
https://falconllm.tii.ae/
https://huggingface.co/datasets/tiiuae/falcon-refinedweb

aiHitBot:
https://www.aihitdata.com/about
"aiHitdata is a massive, artificial intelligence/machine learning, automated system"

Cotoyogi:
https://ds.rois.ac.jp/en_center8/en_crawler/
AI LLM scraper, more info (in Japanese): https://ds.rois.ac.jp/center8/

FirecrawlAgent:
https://www.firecrawl.dev/
AI LLM scraper: "Firecrawl turns entire websites into clean, LLM-ready markdown or structured data. Scrape, crawl and extract the web with a single API. Ideal for AI companies looking to empower their LLM applications with web data."

# COMPANY:
Text.cortex
URL: https://textcortex.com/

starling   /customer Reacher Ai
https://getstarling.ai/

Moondream 2
URL: https://moondream.ai/

LLaVA
URL: https://huggingface.co/docs/transformers/main/model_doc/llava

Granite-3.2
URL: https://www.ibm.com/new/announcements/ibm-granite-3-2-open-source-reasoning-and-vision

spider
URL: https://spider.cloud

PyTorch 
AstrBot (User-friendly LLM-based multi-platform chatbot with a WebUI, supporting RAG, LLM agents, and plugins integration)


#Browser: Tor
TorChat

* MultiOn's Agent API
URL: https://theagi.company/

* XXXGPT  -very Danrous:
TXT: adversarial AI tool that came on the black hat scene shortly after WormGPT and FraudGPT. 
This tool focuses more on facilitating technical, code-based hacks by writing remote access trojans (RATs), 
keyloggers, infostealers, cryptostealers, and more. 

User-agent: XXXGPT

* LLM:
User-agent: Panscient
Disallow: /

* facset:
User-agent: Factset_spyderbot
Disallow: /

* English scraper AI:
SBIntuitionsBot 
URL: https://www.sbintuitions.co.jp/en/bot/

ASK:
User-agent: Ask AI
Disallow: /

Perplexity AI App
URL: https://github.com/inulute/perplexity-ai-app/releases
Perplexity AI Chat
Perplexity-ai

.....................................................................
---------------------------------------------------------------------
# Ahrefs:
https://ahrefs.com/blog/ai-features/
https://ahrefs.com/writing-tools

AI copilot 
AI Search Intent 
AI Chat 

.....................................................................
---------------------------------------------------------------------
KEEP AN EYE ON:

https://github.com/ItzCrazyKns/Perplexica
https://github.com/The-Art-of-Hacking/h4cker
https://github.com/jingyaogong/minimind
https://github.com/TransformerOptimus/SuperAGI
https://github.com/e2b-dev/awesome-ai-agents
https://github.com/camel-ai/owl
https://github.com/yamadashy/repomix
https://www.camel-ai.org
https://github.com/Lightning-AI
https://github.com/facebookarchive/caffe2
https://github.com/e2b-dev/awesome-ai-agents


.....................................................................
---------------------------------------------------------------------
* Hugging Face:
https://huggingface.co/blog/open-r1
URL: https://huggingface.co/chat/models
URL: https://huggingface.co/chat/

User-agent: Hugging Face
User-agent: HuggingChat
User-agent: Open-R1
 
.....................................................................
---------------------------------------------------------------------
# AUSTRAILA:
* Operator	Kangaroo LLM
Documentation	https://kangaroollm.com.au/kangaroo-bot/

User-agent: Kangaroo Bot
            Disallow: /
			
User-agent: Kangaroo 			
            Disallow: /
			
.....................................................................
---------------------------------------------------------------------
* https://you.com/
YouChat  

User-agent: YouBot
Disallow: /	
.....................................................................
---------------------------------------------------------------------
*Firecrawl
https://firecrawl.dev	
URL: https://docs.firecrawl.dev/integrations/crewai

User-agent: Firecrawl
            Disallow: /
			
User-agent: FirecrawlAgent
            Disallow: /	
.....................................................................
---------------------------------------------------------------------		
# RIGHT/LEFT wing Ai: 
https://www.wingai.app
 
RightWingGPT
LeftWingGPT
DepolarizingGPT

.....................................................................
---------------------------------------------------------------------
# The Common Crawl crawler bot  / CommonCrawl.org 
Disallow: /
User-agent: CCBot
Disallow: /

User-agent: ccbot
Disallow: /

.....................................................................
---------------------------------------------------------------------
* https://finity.ai  NOT WORKING??
User-agent: PaperLiBot/2
Disallow: /
User-agent: PaperLiBot/2.1
Disallow: /

.....................................................................
---------------------------------------------------------------------
## AI - not sorted:

* https://docs.writesonic.com
User-agent: Chatsonic  (GTP4.0?`)
Disallow: /
*

## Downloader:
https://www.brandwatch.com/legal/magpie-crawler/
User-agent: magpie-crawler
Disallow:/


# Japan: https://ucri.nict.go.jp/en/icccrawler/
User-agent: ICC-Crawler
Disallow: /

' Stability AI
User-agent: Stability AI
Disallow: /
* https://stability.ai/

* Agent GPT
https://agentgpt.reworkd.ai/
* Scrapers of content!

User-agent: Agent GPT
Disallow: /

* ScraperGPT
User-agent: ScraperGPT
Disallow: /

* https://shadowgpt.ai
User-agent: ShadowGPT
Disallow: /

* https://www.librechat.ai
LibreChat

* ChainGPT
URL: https://www.chaingpt.org/
ChainGPT

#  UltimateGPT
https://support.zendesk.com/hc/en-us/articles/8357749315098-About-the-UltimateGPT-block-in-conversation-flows-for-advanced-AI-agents
UltimateGPT

#  FraudGPT  
URL:  https://www.inuit.se/blogg/wormgpt-och-fraudgpt-uppkomsten-av-skadliga-llm
URL: https://secureops.com/blog/ai-attacks-fraudgpt/
URL: https://eviden.com/insights/blogs/wormgpt-when-genai-also-serves-malicious-actors/

Monica 
*is a new entrant. This service offers an all-in-one AI assistant with a wide range of services. 
Users can choose from various large language models.

Not sorted AI:
PaLM 
Gemma
Pi, your personal AI
Poe
Galactica, LLaMA
Aya 23

# aiHitBot   =   gathering business information from websites.

QuillBot  
URL: https://quillbot.com/

URL: https://mondaygpt.com/

AndiBot   https://andisearch.com/ or: https://www.andi.co/
PhindBot  https://www.phind.com/

Flux
URL: https://flux1.ai 

* AutoGLM  - Zhipu AI for deep research and autonomous task execution
User-agent: AutoGLM

PUH:.....

OpenAI o3
ChatGPT 4o-mini	
ChatGPT 4o	
ChatGPT 4.5 
ChatGPT 4.1	
ChatGPT o1	
ChatGPT o3-mini	

Azure AI Search
ai-crawlers-training
ChatGPT Operator
gentoo-chat
ChatOpenAI

webscraping-ai-ruby
webscraping-ai-php
webscraping-ai-python
Scrapegraph-ai
Node.js
Webscrape AI
AI Web Scraper
ScrapeGraphAI
SmartScraperGraph

WeChat

ImageGPT
GPT-4o Image
Open Deep Research
Open Perflexity 
Kaggle agent
AI Journalist Agent
Browser MCP Agent
FastGPT
BraveGPT
YourGPT  

skrape.ai
Anonymous AI
AnythingLLM

OpenAI GPTBot
OpenAI Image Downloader

WRTNBot/1.0 
WRTNBot
ZeroSearch

GigaChat
Cognitive AI engine
LLM Scraper
AI-Crawler
DataForAI
gen-ai
PoeBot
Apple-GenAI
WebCrawler-AI
CopilotBot
	
DeepSeek V3	
DeepSeek R1	Y
Qwen2.5 72B	
Qwen 2.5‑VL
Mistral AI:
Mixtral 8x22B
Magistral 
Gemma 3

AI Ghostwriter
Ghostwriter 
FIRE-1 Agent
.....................................................................
---------------------------------------------------------------------
## AI SCRAPERS:

360 GPT
* Marketing
https://gpt360.io


* SentiBot
URL: https://sites.google.com/senti1.com/sentibot-eu/home
URL 2: https://sentione.com/
Blocks SentiOne's AI-powered social media listening and analysis tools


URL: https://catboost.ai/
User-agent: CatBoost


URL: https://www.brightbot.app
Brightbot 1.0

wormsGTP
URL: https://eviden.com/insights/blogs/wormgpt-when-genai-also-serves-malicious-actors/
URL:  https://www.inuit.se/blogg/wormgpt-och-fraudgpt-uppkomsten-av-skadliga-llm


Content Scraper GPT
https://gptstore.ai/gpts/ZJvDe_sHZu-website-metadata-content-scraper-gpt
URL: https://gptstore.ai

Extended GPT Scraper
https://apify.com/drobnikj/extended-gpt-scraper


ScrapeGPT
URL: https://gptstore.ai/gpts/re5RLeMZTc-scrapegpt


GPT Scraper
https://apify.com/drobnikj/gpt-scraper

https://www.flyriver.com/crawler
Flyriverbot 


# Anonymous:  Lots of tools:
URL: https://topai.tools/
URL: https://topai.tools/s/autonomous-gpt-agent
Autonomous Gpt Agent  ?


* OpenRouter  Toolbox:
URL: https://openrouter.ai
URL: https://openrouter.ai/models

* Dataiku for Enterprise AI:
https://www.dataiku.com/product/

* https://www.phind.com/
PhindBot

* BabyAGI
Txt: lightweight, open-source autonomous agent 
URL: https://babyagi.org/

Lightpanda
Scraper AI  
URL: https://lightpanda.io/
TXT:  Lightpanda is a headless browser intended for 'AI agents, LLM training, scraping and testing': https://github.com/lightpanda-io/browse
## * Under Progress, not yet ant threat? and not AI, it is scraper!  ***

.....................................................................
---------------------------------------------------------------------
##  KNOCKS OUT all ai: knowledge

User-agent: knowledge /
            Disallow: /  
			 
* KNOCKS OUT all ai Chat:

User-agent: chatUser / 
            Disallow: /			
			
* KNOCKS OUT  AI agents /
              Disallow: /  
	
	
# Open Web Search/ LLM - GenAI-targeted opt ou
User-agent: GenAI
Disallow: /

* KNOCKS OUT ALL ai sites: 
User-agent: .ai

.....................................................................
---------------------------------------------------------------------
* AI chatbot - Texts:
Copy.ai
Jasper Chat  //jasper
SpinBot

AI Chat  https://deepai.org/chat
AI Chatbot https://www.semrush.com/free-tools/ai-text-generator/

.....................................................................
---------------------------------------------------------------------
##RAG:

Agentic
Autonomous RAG
Agentic RAG
Agentic-RAG
Claude-RAG
ReAct AI Agent 
ScrapeGraphAI
RAG Agent
RAG Search
RAG_VertexAI
RAG_search
RAG ChatGPT
RAG LLM
RAG 
RAG Azure AI
GenAI RAG
RAG Chatbot
RAG pipeline
Cohere RAG
Agentic RAG LangGraph
together AI
Corrective RAG 
Deepseek Local RAG Agent
Gemini Agentic RAG
Hybrid Search RAG 
Llama 3.1 Local RAG
Local Hybrid Search RAG
Local RAG Agent
RAG-as-a-Service
RAG Agent Cohere
Basic RAG Chain
RAG Database Routing
Vision RAG
Redis AI RAG 
GenAI RAG
Basic RAG
Langchain raptor
RAPTOR LLM
langchain-google-genai
langchain-perplexity
langchain-openai

.....................................................................
---------------------------------------------------------------------
# AI TRAINING:  Use both!

User Agent: AITraining
User-agent: AITraining /

User-Agent: .*?-ai$ 
Disallow: /

Content-Usage: ai=n
Disallow: /

user-agent: *
model-training: disallow

.....................................................................
---------------------------------------------------------------------
https://imgproxy.net/  AI? Prove me wrong, to not have it?

User-agent: imgproxy /
Txt: streamline image management and optimize website performance
NOTE: Can come from amany domains
.....................................................................
---------------------------------------------------------------------
User-agent: Slack-ImgProxy
Disallow: /

URL: https://api.slack.com/robots

.....................................................................
---------------------------------------------------------------------

https://roboflow.com/
https://labelbox.com/
https://www.cvat.ai/   
.....................................................................
---------------------------------------------------------------------
# Datasets:  ? affecting sites.
https://www.kaggle.com/
https://www.kaggle.com/models

.....................................................................
---------------------------------------------------------------------
URL: https://spider.cloud/
User Agent: spider
.....................................................................
---------------------------------------------------------------------

## LLM:S 
ChatLLM 
URL: https://chatllm.abacus.ai
.....................................................................
---------------------------------------------------------------------
## TEXT STEALERS:
:
Grammarly
URL: https://www.grammarly.com

WebText /     
URL: https://paperswithcode.com/dataset/webtext

.....................................................................
---------------------------------------------------------------------
AI PROXY:
URL: https://www.braintrust.dev/docs/guides/proxy
AI proxy
https://docs.konghq.com/hub/kong-inc/ai-proxy/
AI proxy

ai-proxy

## BLOCK AI (Scraping) Proxies:

<IfModule mod_alias.c>
RedirectMatch 403 AI proxydeny
RedirectMatch 403 API Proxydeny
RedirectMatch 403 HTTP Proxiesdeny
Redirectmatch 403 proxydenydeny
Redirectmatch 403 forward proxydeny
Redirectmatch 403 Server proxiesdeny
Redirectmatch 403 residential proxiesdeny
Redirectmatch 403 reverse proxydeny
Redirectmatch 403 proxy requestsdeny
Redirectmatch 403 IPv4 Proxiesdeny
Redirectmatch 403 IPv6 Proxiesdeny
Redirectmatch 403 Mobile Proxiesdeny
Redirectmatch 403 Virgin proxiesdeny
Redirectmatch 403 Proxy Serversdeny 
Redirectmatch 403 sproxiesdeny
Redirectmatch 403 Static ISP Proxiesdeny
Redirectmatch 403 ISP Proxiesdeny
RedirectMatch 403 check\_proxydeny
</IfModule>

OR: <IfModule mod_php8.c>  or if:  <IfModule mod_php7.c>  
Add: ProxyRequests Off
</IfModule>

Proxi Lists:
* https://spys.one/en/anonymous-proxy-list/
* https://spys.one/en/
* https://proxyscrape.com/free-proxy-list

RAW:
AI proxy|API Proxy|HTTP Proxies|proxydeny|forward proxy|Server proxies|residential proxies|reverse proxy|proxy request|
IPv4 Proxies|IPv6 Proxies|Mobile Proxies|Virgin proxies|Proxy Servers| sproxiesd|Static ISP Proxies|ISP Proxies|proxy
.....................................................................
---------------------------------------------------------------------
# RECOMMENDATIONS to use plugins:
## BLOCK AI: -  BBQ:   https://plugin-planet.com/bbq-pro/   Great plugin with lots custom rules:)

# Content scraper block plugin, lots to choose from.
.....................................................................
---------------------------------------------------------------------
## New Ai: 250728

MiniMax-M1
MiniMax-Text-01
URL: https://www.minimax.io/

Cog
URL: https://github.com/replicate/cog

ContentShake AI

mightygpt
LLM Browser 
URL: https://www.futuretools.io/tools/mightygpt

X:
Grok 3.5

GPT-4.5
Quark chatbot
Quark   (alibaba)

https://matrix.tencent.com
Zhuque AI image detector
OR: AI Detection Assistant

Alice	Yandex (chatbot)
YandexGPT

AliGenie	Alibaba Group	
CarynAI
AgentQL  (dataextration)

smartbot
https://vnptai.io/vi

AI _ image stealers:
coreweave.com
URL: 	https://coreweave.com/

Chai 
https://langbase.com
https://chai.new

# DANGER:
DarkBard 
WolfGPT
PoisonGPT
ChaosGPT
FreedomGPT 

GPT-J 
URL: https://huggingface.co/docs/transformers/v4.48.2/model_doc/gptj

GrammarlyGO
Jenni AI
Janitor AI
WordAi
Venus Chub AI
Crushon AI
Charstar AI

Claude-sonnet-4
OpenAI/o4-mini
Claude-3 Opus 

Datenbank Crawler  AI?

Baidu AI:  
User-agent: Baiduspider
		
ThinkBot AI ?
User Agent: ThinkBot
URL: https://play.google.com/store/apps/details?id=pmsopmsoftware.opengpt&pli=1
URL 2: http://thinkbot.net  = Thinkbot/0.5.8
UURL #: https://www.thinkbots.ai/
ALSO COMES FROM: apnic.net


User-agent: Devin  // Devin AI
URL: https://app.devin.ai

User-agent: Echobot Bot
User-agent: EchoboxBot
URL: https://echobox.com


bedrockbot
URL:https://pypi.org/project/bedrock-bot/
https://www.piwheels.org/project/bedrock-bot/

GenAI chatbot 

python Ai
Go
Elixir (machine-learning)
Scala   (machine-learning)
...........................

SummalyBot
URL: ttps://www.grammarly.com/ai/ai-writing-tools/summarizing-tool

Thinkbot
URL: https://www.thinkbot.agency
? Is it a threat to bloggers/business profile?
...........................

User-agent: GoogleAgent-Mariner
URL: https://darkvisitors.com/agents/googleagent-mariner
URL 2: https://deepmind.google/models/project-mariner/
...........................
...........................

Qwen3 
Kimi-2

Shadow AI 
where hidden agents access private data.

Devin
URL: https://darkvisitors.com/agents/devin

Gemini-Deep-Research
URL: https://darkvisitors.com/agents/gemini-deep-research

...........................

##SKICKAT TILL Perrish.
cvat.ai
Video AI
URL: https://www.cvat.ai/

fetchfox.ai
URL: https://fetchfox.ai/
URL 2: https://github.com/fetchfox/fetchfox

Vanna.AI
URL: https://vanna.ai/
............................
SummalyBot
URL: ttps://www.grammarly.com/ai/ai-writing-tools/summarizing-tool

Thinkbot
URL: https://www.thinkbot.agency
............................
??
User-agent: GoogleAgent-Mariner
URL: https://darkvisitors.com/agents/googleagent-mariner
URL 2: https://deepmind.google/models/project-mariner/
............................
Qwen3 
Kimi-2

Shadow AI 
where hidden agents access private data.

Devin
URL: https://darkvisitors.com/agents/devin

Gemini-Deep-Research
URL: https://darkvisitors.com/agents/gemini-deep-research

............................
Alice	Yandex	
YandexGPT
AliGenie	
CarynAI		
Celia	Huawei	
Chai	Chai	
ChatBot	Text	
ChatGPT	OpenAI	
GigaChat		
Kuki	
SILVIA	Cognitive Code	?
Q	Amazon	
Zo is Microsoft’s replacement to Tay
Luna: as far as I can tell, this is still vaporware. But presents a story that it aggregates a number of AI-as-a-cloud services to answer any question very well. We’ll see.
Lumo chatbot
Llama2.ai

............................................................................
### On The Way:
GPT-6

## Not harm what I can see!
netEstate Imprint Crawler 
https://darkvisitors.com/agents/netestate-imprint-crawler#netestate-imprint-crawler
URL2: https://www.netestate.de
URL3: https://github.com/michaelbrunnbauer/sparqlcrawlserver
URL3: https://www.sengine.info/
URL:3: https://www.website-datenbank.de/

.............................
### Not blocking! Se Darkvisitors adwise: ###
GoogleAgent-Mariner
https://darkvisitors.com/agents/googleagent-mariner#what-is-googleagent-mariner

.............................
#  Echobot
# AI EchoBot
URL: https://github.com/microsoft/BotBuilder-Samples
URL2: https://echobot.me/
URL3: https://wpcommerz.com/echobot/
URL4: https://github.com/MmmarRTha/echobot-ai-app
URL4: https://echobot-ai-app.vercel.app/

Notes; AI AI Framework, need gtp or mIstral or gemini to work = No threat yet!

.............................
##PAIN in in the Ass:  #
### Still in use: On th e list again!
AwarioRssBot
AwarioSmartBot
AwarioBot 1.0

## Retired:
Claude 3.7 

#  DELATE:  not active
AndersPinkBot
URL: https://anderspink.com
Redict to: https://www.go1.com/


##BLOCK:
Applebot/0.1

NEW:
GPT-5 Mini
GPT-5 Nano
GPT-5 Chat
URL: https://www.bleepingcomputer.com/news/artificial-intelligence/microsoft-accidentally-confirms-gpt-5-gpt-5-mini-gpt-5-nano-ahead-of-launch/


OAI-SearchBot/1.0   
Qwen 3 
Kimi K2

## Claude:
Claude Opus 4.1

python Ai
Go

Kimi K2
Kimi-2

TO Perrish sent: 

GLM-4.5
URL: https://z.ai/blog/glm-4.5
Chat: https://chat.z.ai/

Clearview AI

.............................
Chats AI:

Zendesk 
Microsoft 365 Copilot
Grok
Jasper Chat
Deep AI
Generative AI
HuggingChat
Character.ai
Poe
Chatsonic
Copy.ai
ZenoChat
Lumo AI chatbot  //Proton

........................................
Noted: Not admitted but in the future?
Diffusion Deep Researcher
deep research
Gemini Diffusion

Tinybird
URL: https://www.tinybird.co/

Linked in post Generator:
TinyLLaMA-1.1B-Chat
URL: https://github.com/brezzergit/LinkedIn-LLM-Post-Generator

.......................................
Maybe?  Been visiting me:)
VNPT AI
URL: https://vnpt.com.vn/english/news/vnpt-ready-to-make-long-term-and-continuous-investments-in-ai.html

ADDED: 
 Google-Firebase
 Useragent: Firebase
 URL: https://firebase.google.com/
 URL 2: https://extensions.dev/extensions?category=ai
 
## OTHERS:
https://openrouter.ai/models?q=v1

rtrvr.ai
URL: https://www.rtrvr.ai/
Cannot find the useragent!

.......................................
### Added now to htaccess/robots.txt.

spawning-ai

ChatGPT Agent
Claude LLM

AddSearchBot 
URL: https://darkvisitors.com/agents/addsearchbot
URL: https://darkvisitors.com/agents/addsearchbot#what-is-addsearchbot

bigsur.ai 
https://darkvisitors.com/agents/bigsur-ai#bigsur-ai
User-agent: bigsur.ai

LinerBot 
URL: https://darkvisitors.com/agents/linerbot

Gemini User
User-agent: Gemini-User

Olivia  (chatbot)
URL: https://github.com/olivia-ai/olivia
URL2: https://olivia-ai.org/

AI Scraper 
(Web Data Extractor)
URL: https://galaxy.ai/ai-scraper

AI Website Screenshot
https://image.galaxy.ai/website-screenshot-generator

hybrid LLM

#### OPEN AI
GPT-oss /

GPT4Free
URL: https://github.com/xtekky/gpt4free

SEObot
URL: https://seobotai.com/
AutoGen
AgentGPT

GPT Researcher

AI SCRAPER:
Thordata
URL: https://www.thordata.com/

Devin
URL: https://darkvisitors.com/agents/devin

PerfectChatGPT
URL: https://www.perfectessaywriter.ai

Kimi-VL
URL: https://github.com/MoonshotAI/Kimi-VL

Gemini-Deep-Research
URL: https://darkvisitors.com/agents/gemini-deep-research

Qopywriter.ai
URL: https://qopywriter.ai/

LiteLLM Proxy (LLM Gateway)
URL: https://docs.litellm.ai/docs/providers/litellm_proxy

Qwen-Agent
URL: https://github.com/QwenLM/Qwen-Agent

ShapBot
URL: https://parallel.ai

meta-webindexer/1.1
URL: https://developers.facebook.com/docs/sharing/webmasters/web-crawlers/
 
Deep Research

Firebase

BabyCatAGI
URL: https://replit.com/@YoheiNakajima/BabyCatAGI#main.py
.......................................
### LAGT IN 250913  ####
##AI FACEBOT:
Meta-Webindexer 1.1
Meta-Webindexer 1/1

Thinkbot 
Thinkbot/0.5.8
URL: https://thinkbot.agency/

Instructor
instructor-php
URL: https://instructorphp.com/

openpi
URL: https://github.com/Physical-Intelligence/openpi

https://github.com/CeramicTeam/CeramicTerracotta
URL 2: https://ceramic.ai/
Useragent: Ceramic TerraCotta Crawler
Useragent: TerraCotta

#OPEN AI:
OpenAIo4-mini 

OpenAGI
Open Interpreter
Agent Middleware
Agent API
AI Legion
DigitalOceanGenAICrawler
Brightbot operator 

# Another writing/spelling:
Superagent
Auto-GPT
AgentGPT

AI Scrapers:
n8n-nodes-aiscraper
LangExtract

OTHERS:
quillbot.com
LINER Bot
MiniMax
MetaGPT
netEstate Imprint Crawler
Kimi-k1.5
Julius AI
React Agent
Big Sur AI
Big Sur AI Crawler
AliyunSecBot

#China:
Qwen 4
qwen:4b
Qwen 4 LLM
QwenLM
Qwen-Chat

GTP:
ChatGPT-User
GPT Researcher
ChatGPT Operator 

AI:
panscient.com
knowledge-base

AI HTTP Analyzer
URL: https://portswigger.net/bappstore/36cb140ac1a6449bbab1bafc18df8cfa

#Kruti AI Assistant:  
Ola
https: https://www.kruti.ai/

Useragent: superagi
https://superagi.com/

AI Scraper:
https://spider.cloud/
URL": https://github.com/spider-rs/spider
Useragent: Spider/2.0; +https://spider.cloud

##Tencent Hunyuan AI:##		
DeepSeekV2.5-Chat
Zhuque AI Detector
Mixtral-8x22B-Instruct
Llama3.1-405B-Instruct	
Llama3.1-70B-Instruct
Hunyuan-Large-Instruct	
Hunyuan-7B-Instruct	7B	

# List of Chatbots, LLMs and other AI Models:
Alpaca.cpp
ChatALL
Cursor.sh
Caffe
Fastai
LocalAI
Linux AI assistant
MetaGPT
Mistral.ai
Mycroft AI
Ollama.ai
OpenRouter
PrivateGPT
PyTorch
Azure OpenAI
Cerebras
Cohere (v1 and v2)
Fireworks
Google Gemini (native and OpenAI compatible)
Moonshot / Kimi
Ollama (on localhost)
OpenAI
OpenRouter
Sambanova
::::::::::::::::::::::::::::::::::::::

Shell GPT
URL: https://github.com/TheR1D/shell_gpt

LLM Scraping:
Scrapegraph-ai
URL: https://scrapegraph-doc.onrender.com/

DIV:
Alpaca
Ernie 
GPT OSS
GPT4ALL
GPT-5 Thinking mini
GPT-5o 
DeepSeekBot
DeepSeek V3
OpenLens AI
Kingsoft-LLM 
Meta Agent
Celia	
Chat2DB-Agent
Claude-4-Sonnet
Grok 4 Fast
Spider-Agent
Magnus

Jamba 1.5 Large
Jamba 1.5 Mini
URL: https://aws.amazon.com/bedrock/ai21/

Kingsoft-LLM 
Kingsoft AI

Jina AI:
URL: https://jina.ai/models/
ReaderLM-v2

Ask Data with Relational 
Knowledge Graph

GPTBot/1,2
ClaudeBot/1.0
? Google-CloudVertexBot
Kangaroo-Bot

https://www.adcreative.ai/

Sudowrite
https://sudowrite.com/

::::::::::::::::::::::::::::::::::::::

Crawl4AI
URL: https://docs.crawl4ai.com/

AgentFlow:
🌐 Website: https://agentflow.stanford.edu/
📚 Documentation: https://huggingface.co/papers/2510.05592
💻 GitHub: https://github.com/lupantech/AgentFlow

::::::::::::::::::::::::::::::::::::::
##250918 Notes:

Lagt in på: Extended Fork of blockai bots:
perplexity.ai
"perplexity.ai",
"PerplexityBot/1.0",	
"perplexity-*-*-*-*",
".perplexity.ai",

allenai\.org 
cohere\.ai 
mistral\.ai 
openai\.com/bot 
omgili\.com 
perplexity\.ai 
spider\.cloud 

### Very hard to get rid of, if it on Amazon ,this works:

DENY:
ClaudeBot 1/O
compatible; "ClaudeBot/1.0; +claudebot\@anthropic.com
/ClaudeBot[\s\/]?[\d\.]*?/i
/^ClaudeBot/1\.0; \+https\://www\.anthropic\.com$/

##And they try with this:

^test-bot$

---------------


SeLLMa
URL: https://blog.seznam.cz/2025/01/seznam-cz-nabizi-na-sve-domovske-strance-shrnuti-clanku-s-vyuzitim-vlastnich-ai-technologii/
 
nanochat
https://github.com/karpathy/nanochat

open-manus-v2
https://github.com/XiaomingX/open-manus-v2

IbouBot  //added  

Perplexity Stealth
⚠️ STEALTH
Perplexity uses headless browsers with Chrome user agents to bypass blocking

* resec.ai
PyTorch
VelenPublicWebCrawler/1.0

Bard-Ai ?
Cloudflare-AutoRAG ?

FR^GETECKEN - IMPACT?
ChatGPT Atlas
URL: https://openai.com/index/introducing-chatgpt-atlas/

ChatGPT-Browser
Perfexity Cometh
DIA
Strawberry
URL:  https://strawberrybrowser.com/

MUSIC GENERATORS:
OpenAI Suno
URL: https://the-decoder.com/openai-is-building-an-ai-model-that-can-generate-music-from-text-or-audio-promptsopenai-is-building-an-ai-model-that-can-generate-music-from-text-or-audio-prompts/?utm_source=mailpoet&utm_medium=email&utm_source_platform=mailpoet&utm_campaign=ads

Udio
URL: https://www.udio.com/



## Section 7: Comprehensive User-Agent Reference

### A-B

```
Abacus AI Deep Agent
AcademicBotRTU
AddSearchBot
Agent API
Agent GPT
AgentGPT
Agentic
Agentic RAG
AgentQL
AI Agent
AI Article Writer
AI Chat
AI Chatbot
AI Content Detector
AI Crawler
AI Data Scraper
AI Deep Research Agent
AI Journalist
AI Legion
AI RAG
AI Scraper
AI Search
AI Search Engine
AI SEO Crawler
AI Training
AI Web Scraper
AI Writer
AI2Bot
AI2Bot-DeepResearchEval
AIBot
aiHitBot
AIMatrix
airesearchbot
AISearchBot
AlexaTM
Alice Yandex
AliGenie
AliyunSecBot
Alpha AI
AlphaAI
Amazon Bedrock
Amazon Comprehend
Amazon Kendra
Amazon Lex
Amazon SageMaker
Amazon Silk
Amazon Textract
Amazonbot
AmazonBuyForMe
Amelia
AndiBot
Anomura
Anonymous AI
anthropic-ai
Anthropic-Claude
AnyPicker
AnythingLLM
Anyword
Applebot-Extended
Apple-GenAI
Aria AI
Articoolo
Ask AI
atlassian-bot
AutoGen
AutoGLM
AutoGPT
Automated Writer
AutoML
Autonomous RAG
AutoRAG
AutoScraper
AutoWebGLM
Auto-GPT
AwarioRssBot
AwarioSmartBot
AWS Trainium
Azure AI Search
Azure OpenAI
BabyAGI
BabyCatAGI
baiduspider-ai
BardBot
Basic RAG
Bedrock
bedrock-chat
Big Sur AI
Botsonic
Brave Leo AI
BraveGPT
Brightbot
Browser Use
BrowserBase Open Operator
Bytebot
ByteDance
Bytespider
```

### C-D

```
CarynAI
CatBoost
CCBot
CCBot/2.0
CC-Crawler
Ceramic TerraCotta Crawler
Chai
Character-AI
Charstar AI
Chat2DB-Agent
ChatAnthropic
Chatbot
ChatGLM
ChatGLM-Spider
ChatGPT
ChatGPT Agent
ChatGPT Operator
ChatGPT Retrieval
ChatGPT search
ChatGPT-User
ChatGPT-User/2.0
ChatLLM
ChatOpenAI
Chatsonic
ChatUser
Chinchilla
Claude
ClaudeBot
ClaudeBot/1.0
Claude-RAG
Claude-SearchBot
Claude-User
Claude-Web
claude-web/1.0
ClearScope
Clearview
Cloudflare AutoRAG
CloudVertexBot
Cognitive AI
Cohere
cohere-ai
cohere-training-data-crawler
Command-A-Reasoning
Common Crawl
CommonCrawl
Content Harmony
ContentAtScale
ContentBot
Conversion AI
Copilot
CopyAI
Copymatic
Copyscape
CoreWeave
Corrective RAG
Cotoyogi
CRAB
Crawl4AI
CrawlGPT
CrawlQ AI
Crawlspace
CrewAI
Crushon AI
DALL-E
DALL-E 2
DALL-E Mini
DALL·E 3
DarkBARD
DarkBERT
DarkGPT
DataForSeoBot
DataProvider
dataprovider
Deep AI
Deep Research
DeepAI
DeepL
DeepMind
DeepResearch
DeepSeek
DeepSeek R1
DeepSeek V3
DeepSeekBot
DeepSeek-LLM
DeepSeek-R1
Devin
DialoGPT
Diffbot
DigitalOceanGenAICrawler
DocsGPTOnyx
Dolma
Doubao AI
DuckAssistBot
DuckDuckGo Chat
DuckDuckGo-Enhanced
```

### E-G

```
Echobot
Echobox
Evil-GPT
Extended GPT Scraper
FAISS
FacebookBot
FacebookBot/1.0
facebookexternalhit/1.1
Factset_spyderbot
Falcon
FastGPT
Firebase
Firecrawl
FirecrawlAgent
FIRE-1 Agent
Flux
Flyriver
Frase AI
FraudGPT
FriendlyCrawler
Gato
Gemini
Gemini Agentic RAG
Gemini-Deep-Research
Gemini-User
Gemma
Gen AI
GenAI
Genspark
GhostGPT
Ghostwriter
GigaChat
GLM
GLM 4.6
GodMode
Google Gemini
GoogleAgent-Mariner
Google-CloudVertexBot
Google-Extended
Google-NotebookLM
Goose
GPT
GPT Researcher
GPT Scraper
GPT4ALL
GPT4Free
GPTBot
GPTBot/1.2
GPTZero
GPT-1
GPT-2
GPT-3
GPT-3.5
GPT-3.5 turbo
GPT-4
GPT-4o
GPT-4o mini
GPT-4V
gpt-4-turbo
GPT-4.1
GPT-4.1-mini
GPT-4.1-nano
GPT-5
gpt-crawler
Grammarly
Grendizer
Grok
Grok 3
GrokBot
Groq-Bot
GT Bot
GTBot
GTPBOT
```

### H-L

```
Haystack RAG Pipeline
Hemingway Editor
Hugging Face
HuggingChat
huggingfacebot
Hunyuan
Hybrid Search RAG
Hypotenuse AI
iAskBot
iaskspider/2.0
ICC-Crawler
Ideogram
ImageGen
Imagen 4
ImagesiftBot
img2dataset
imgproxy
Inferkit
INK Editor
INKforall
Instructor
IntelliSeek
ISSCyberRiskCrawler
Jamba 1.5 Large
Janitor AI
JasperAI
Jenni AI
Julius AI
Kafkai
Kaggle
Kangaroo Bot
KawaiiGPT
Keyword Density AI
Kimi
Kimi K2
KlaviyoAIBot
Knowledge Graph
KomoBot
LAION-huggingface-processor
LAIONDownloader
LangChain
langchain-openai
langchain-perplexity
Langfuse
Language AI
LCC
Le Chat
Lensa
Leonardo
Lightpanda
LightRAG
LINER Bot
LinerBot
LinkupBot/1.0
LiteLLM
LLaMA
Llama 3.1
Llama 3.2
Llama 4
LLM
LLM Scraper
LLM-jp-Crawler
Local RAG Agent
LocalAI
Lovable
```

### M-O

```
Magistral
magpie-crawler
MalwareGPT
Manus
MarketMuse
MBZUAI Chatbot
Meltwater
Meta Agent
Meta AI
MetaAI
MetaGPT
meta-externalagent
meta-externalfetcher/1.1
Meta-Webindexer
Midjourney
Mini AGI
MiniMax
Mintlify
Mistral
MistralAI-User
Mistral.ai
Mixtral 8x22B
Molmo
Monica
Moonshot
Mycroft AI
Nano Banana
Nanobrowser
NeevaBot
netEstate Imprint Crawler
Neural Text
NeuralSEO
NextChat
Nicecrawler
NinjaAI
NodeZero
NotebookLM
NotebookLM Deep Research
Nova Act
NovaAct
OAI SearchBot
OAI-SearchBot
OAI-SearchBot/1.0
OASIS
Ollama
OLMo
OLMo 2 Chatbot
Omgili
Omgilibot
Onyx
Open AI
Open Deep Research
Open Interpreter
Open Operator
OpenAGI
OpenAI
OpenAI Crawler
OpenAI CUA
OpenAI GPTBot
OpenAI o1
OpenAI o1-mini
OpenAI o3
OpenAI o3-mini
OpenAI Operator
openai-python
Openbot
OpenInterpreter
OpenRouter
Operator
Outwrite
OWL
Owlin
```

### P-R

```
Page Analyzer AI
PandasAI
PanguBot
Panscient
PaperLiBot
Paraphraser.io
peer39_crawler
PerplexityBot
PerplexityBot/1.0
PerplexityUser
Perplexity Deep Research
Perplexity-User/1.0
PetalBot
Phind
PhindBot
PiplBot
Pixmo
Playwright Agentic AI
Poe
PoeBot
PoeSearchBot
Poggio-Citations
PoisonGPT
PrivateGPT
ProWritingAid
proximic
PulsarRPA
Puppeteer
Python lxml
PyTorch
Qualified
QualifiedBot
QuillBot
Quark
Qwen
Qwen Chat
Qwen Deep Research
Qwen-Agent
Qwen2
Qwen3
RAG
RAG Agent
RAG Chatbot
RAG Database
RAG Pipeline
RAG Search
Raptor
React Agent
ReAct AI Agent
REALM
Redis AI RAG
Reka Flash 3.1
Replicate-Bot
RobotSpider
RunPod-Bot
Rytr
```

### S-T

```
SAM 3
Sambanova
SaplingAI
SBIntuitionsBot
scaleai
Scalenut
scale-crawler
ScrapeGraph
ScrapeGraphAI
Scraper
ScraperGPT
Scrapy
Scrapy 2.12.0
ScriptBook
Search GPT
SearchGPT
Seekr
SemrushBot
Sentibot
SEO Content Machine
SEO Robot
SEObot
ShadowGPT
ShapBot
Shell GPT
Sidetrade
Simplified AI
Skydancer
Skyvern
SlickWrite
SmartBot
SmartScrape
Sonic
Sora
SpamGPT
Spawning-ai
Spider
Spider-Agent
Spin Rewrite
Spinbot
Stability AI
Stable Diffusion
StableDiffusionBot
Stagehand
Sudowrite
SummalyBot
Super Agent
Superagent
superagi
Surfer AI
taiko
TerraCotta
Text Blaze
TextCortex
Text-RAG
TheKnowledgeAI
thehive.ai
Thinkbot
TikTokSpider
Timpibot
Together AI
Together-Bot
TorChat
TurnitinBot
```

### U-Z

```
uAgents
UI-TARS
VelenPublicWebCrawler
Venus Chub AI
Vidnami AI
VimGPT
Vision RAG
V-JEPA
Weaviate
WebChatGPT
WebCrawler-AI
WebExplorer-8B
Webscrape AI
webscraping-ai-python
WebSurfer
WebText
WebVoyager
Webzio
Webzio-Extended
WeChat
Whisper
WizardLM
WolfGPT
WordAI
Wordtune
WormGPT
WormGPT V3.0
WPBot
wpbot
Writecream
WriterZen
Writescope
Writesonic
WRTNBot
xAI
xAI-Bot
Xanthorox AI
xBot
XLNet
XXXGPT
YaML
YandexAdditional
YandexAdditionalBot
YandexGPT
YandexLLM
yarchatgpt
YarGPT
YouBot
YourGPT
you-bot
ZanistaBot
Zero
ZeroCHAT
ZeroGPT
ZeroSearch
ZeroStep
Zhipu
Zhuque AI
Zhuque AI Detector
Zimm
```

---

## Section 8: Resources and Links

### Official Documentation

| Resource | URL |
|----------|-----|
| OpenAI Bots | https://platform.openai.com/docs/bots |
| Anthropic Crawler | https://support.anthropic.com/en/articles/8896518 |
| Google Crawlers | https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers |
| Meta Web Crawlers | https://developers.facebook.com/docs/sharing/webmasters/web-crawlers |
| Apple Bots | https://support.apple.com/en-us/119829 |
| Perplexity Bots | https://docs.perplexity.ai/guides/bots |

### AI News and Updates

| Source | URL |
|--------|-----|
| AI News | https://www.artificialintelligence-news.com |
| Google AI | https://ai.google/latest-news/ |
| DeepMind Blog | https://deepmind.google/discover/blog |
| Mistral News | https://mistral.ai/news |
| The Verge AI | https://www.theverge.com/ai-artificial-intelligence |

### Tools and Resources

| Resource | URL | Purpose |
|----------|-----|---------|
| Dark Visitors | https://darkvisitors.com | AI crawler database |
| LLMs.txt | https://llmstxt.site/ | LLM documentation list |
| AI Agents List | https://aiagentslist.com | Agent directory |
| Spawning AI | https://spawning.ai/ai-txt | AI.txt protocol |
| TDMRep | https://www.w3.org/community/reports/tdmrep/ | Text/Data Mining Reservation |

### Learning Resources

| Resource | URL |
|----------|-----|
| MongoDB AI Agents | https://www.mongodb.com/resources/basics/artificial-intelligence/ai-agents |
| Zapier AI Agent Guide | https://zapier.com/blog/ai-agent |
| Botpress AI Agents | https://botpress.com/blog/what-is-an-ai-agent |
| Analytics Vidhya | https://www.analyticsvidhya.com/blog/2025/03/ai-agents-terms/ |

### Open Source AI

| Project | URL |
|---------|-----|
| Hugging Face | https://huggingface.co |
| Ollama | https://ollama.com |
| LAION-AI | https://laion.ai |
| EleutherAI | https://www.eleuther.ai |
| DeepSeek | https://github.com/deepseek-ai/DeepSeek-V3 |

---

## Additional Notes

### Known Aggressive Crawlers

Some crawlers have been reported as particularly resource-intensive:
- ClaudeBot (Anthropic)
- Bytespider (ByteDance)
- PerplexityBot
- CCBot (Common Crawl)

### Crawlers That May Ignore robots.txt

While most legitimate AI companies claim to respect robots.txt, server-level blocking provides stronger protection. Monitor your access logs to verify compliance.

### Cloud Infrastructure Used by AI Crawlers

Many AI crawlers operate from major cloud providers:
- Amazon AWS
- Google Cloud Platform
- Microsoft Azure
- Various data center providers

IP-based blocking can supplement user-agent blocking but requires ongoing maintenance as IP ranges change.

---


#Frameworks that Facilitate RAG:

Haystack: LLM orchestration framework to build customizable, production-ready LLM applications.
LangChain: An all-purpose framework for working with LLMs.
Semantic Kernel: An SDK from Microsoft for developing Generative AI applications.
LlamaIndex: Framework for connecting custom data sources to LLMs.
Dify: An open-source LLM app development platform.
Cognita: Open-source RAG framework for building modular and production ready applications.
Verba: Open-source application for RAG out of the box.
Mastra: Typescript framework for building AI applications.
Letta: Open source framework for building stateful LLM applications.
Flowise: Drag & drop UI to build customized LLM flows.
Swiftide: Rust framework for building modular, streaming LLM applications.
CocoIndex: ETL framework to index data for AI, such as RAG; with realtime incremental updates.
Pathway: Performant open-source Python ETL framework with Rust runtime, supporting 300+ data sources.
Pathway AI Pipelines: A production-ready RAG framework supporting real-time indexing, retrieval, and change tracking across diverse data sources.

# These tools can assist in evaluating the performance of your RAG system, from tracking user feedback to 
logging query interactions and comparing multiple evaluation metrics over time.

LangFuse: Open-source tool for tracking LLM metrics, observability, and prompt management.
Ragas: Framework that helps evaluate RAG pipelines.
LangSmith: A platform for building production-grade LLM applications, allows you to closely monitor and evaluate your application.
Hugging Face Evaluate: Tool for computing metrics like BLEU and ROUGE to assess text quality.
Weights & Biases: Tracks experiments, logs metrics, and visualizes performance.


RAG (Retrieval Augmented Generation)
🔥 Agentic RAG with Embedding Gemma
🧐 Agentic RAG with Reasoning
📰 AI Blog Search (RAG)
🔍 Autonomous RAG
🔄 Contextual AI RAG Agent
🔄 Corrective RAG (CRAG)
🐋 Deepseek Local RAG Agent
🤔 Gemini Agentic RAG
👀 Hybrid Search RAG (Cloud)
🔄 Llama 3.1 Local RAG
🖥️ Local Hybrid Search RAG
🦙 Local RAG Agent
🧩 RAG-as-a-Service
✨ RAG Agent with Cohere
⛓️ Basic RAG Chain
📠 RAG with Database Routing
🖼️ Vision RAG

---
## Model evaluation is supported for the following 
foundation models (to see which Regions support each model, refer to Supported foundation models in Amazon Bedrock):

AI21 Labs Jamba 1.5 Large
AI21 Labs Jamba 1.5 Mini
Amazon Nova Canvas amazon.nova-canvas-v1:0 e
Amazon Nova Lite
Amazon Nova Lite amazon.nova-lite-v1:0 t
Amazon Nova Micro
Amazon Nova Micro amazon.nova-micro-v1:0
Amazon Nova Pro
Amazon Nova Pro amazon.nova-pro-v1:0
Amazon Nova Reel amazon.nova-reel-v1:0 us-east-1
Amazon Rerank 1.0 amazon.rerank-v1:0
Amazon Titan Embeddings G1 - Text amazon.titan-embed-text-v1
Amazon Titan Image Generator G1 v2 amazon.titan-image-generator-v2:0
Amazon Titan Multimodal Embeddings G1 amazon.titan-embed-image-v1
Amazon Titan Text Embeddings V2 amazon.titan-embed-text-v2:0
Amazon Titan Text G1 - Express
Amazon Titan Text G1 - Lite

Anthropic Claude 3 Haiku
Anthropic Claude 3 Haiku anthropic.claude-3-haiku-20240307-v1:0
Anthropic Claude 3 Opus
Anthropic Claude 3 Sonnet
Anthropic Claude 3.5 Haiku
Anthropic Claude 3.5 Haiku anthropic.claude-3-5-haiku-20241022-v1:0
Anthropic Claude 3.5 Sonnet
Anthropic Claude 3.5 Sonnet v1 anthropic.claude-3-5-sonnet-20240620-v1:0
Anthropic Claude 3.5 Sonnet v2
Anthropic Claude 3.5 Sonnet v2 anthropic.claude-3-5-sonnet-20241022-v2:0
Anthropic Claude 3.7 Sonnet
Anthropic Claude 3.7 Sonnet anthropic.claude-3-7-sonnet-20250219-v1:0
Anthropic Claude Haiku 4.5 anthropic.claude-haiku-4-5-20251001-v1:0
Anthropic Claude Opus 4.0 anthropic.claude-opus-4-20250514-v1:0
Anthropic Claude Opus 4.1 anthropic.claude-opus-4-1-20250805-v1:0
Anthropic Claude Sonnet 4.0 anthropic.claude-sonnet-4-20250514-v1:0
Anthropic Claude Sonnet 4.5 anthropic.claude-sonnet-4-5-20250929-v1:0

Cohere Cohere Embed English cohere.embed-english-v3
Cohere Cohere Embed Multilingual cohere.embed-multilingual-v3
Cohere Command R
Cohere Command R+
Cohere Embed English cohere.embed-english-v3
Cohere Embed Multilingual cohere.embed-multilingual-v3
Cohere Rerank 3.5 cohere.rerank-v3-5:0

DeepSeek DeepSeek-R1
DeepSeek DeepSeek-R1 deepseek.r1-v1:0
Jamba 1.5 Large ai21.jamba-1-5-large-v1:0

Jamba 1.5 Mini ai21.jamba-1-5-mini-v1:0

Luma Luma Ray v2 luma.ray-v2:0

Meta Llama 3 8B Instruct
Meta Llama 3 8B Instruct meta.llama3-8b-instruct-v1:0
Meta Llama 3 70B Instruct
Meta Llama 3 70B Instruct meta.llama3-70b-instruct-v1:0
Meta Llama 3.1 8B Instruct
Meta Llama 3.1 8B Instruct meta.llama3-1-8b-instruct-v1:0
Meta Llama 3.1 70B Instruct
Meta Llama 3.1 70B Instruct meta.llama3-1-70b-instruct-v1:0
Meta Llama 3.1 405B Instruct
Meta Llama 3.1 405B Instruct meta.llama3-1-405b-instruct-v1:0
Meta Llama 3.2 1B Instruct
Meta Llama 3.2 1B Instruct meta.llama3-2-1b-instruct-v1:0
Meta Llama 3.2 3B Instruct
Meta Llama 3.2 3B Instruct meta.llama3-2-3b-instruct-v1:0
Meta Llama 3.2 11B Instruct
Meta Llama 3.2 11B Instruct meta.llama3-2-11b-instruct-v1:0
Meta Llama 3.2 90B Instruct
Meta Llama 3.2 90B Instruct meta.llama3-2-90b-instruct-v1:0
Meta Llama 3.3 70B Instruct
Meta Llama 3.3 70B Instruct meta.llama3-3-70b-instruct-v1:0
Meta Llama 4 Maverick 17B Instruct meta.llama4-maverick-17b-instruct-v1:0
Meta Llama 4 Scout 17B Instruct meta.llama4-scout-17b-instruct-v1:0 us-east-1

Mistral AI Mistral 7B Instruct
Mistral AI Mistral 7B Instruct mistral.mistral-7b-instruct-v0:2
Mistral AI Mistral Large (24.02)
Mistral AI Mistral Large (24.02) mistral.mistral-large-2402-v1:0
Mistral AI Mistral Large (24.07)
Mistral AI Mistral Large (24.07) mistral.mistral-large-2407-v1:0 us-west-2
Mistral AI Mistral Small (24.02)
Mistral AI Mistral Small (24.02) mistral.mistral-small-2402-v1:0 us-east-1
Mistral AI Mixtral 8x7B Instruct
Mistral AI Mixtral 8x7B Instruct mistral.mixtral-8x7b-instruct-v0:1
Mistral AI Pixtral Large (25.02) mistral.pixtral-large-2502-v1:0

Stability AI SD3 Large 1.0 stability.sd3-large-v1:0
Stability AI Stable Diffusion 3.5 Large stability.sd3-5-large-v1:0
Stability AI Stable Image Core 1.0 stability.stable-image-core-v1:0
Stability AI Stable Image Core 1.1 stability.stable-image-core-v1:1
Stability AI Stable Image Ultra 1.0 stability.stable-image-ultra-v1:0
Stability AI Stable Image Ultra 1.1 stability.stable-image-ultra-v1:1

Writer Palmyra X4 writer.palmyra-x4-v1:0
Writer Palmyra X5 writer.palmyra-x5-v1:0

..........................................................................
--------------------------------------------------------------------------
ADDED: 251027

AI Assistant
airesearchbot
ai-agent-playwright
Anomura
Anthropic-Claude
baiduspider-ai
Bravebot
Character-AI
ChatGPT-User v2.0
Claude Haiku 4.5
ClaudeBot/1.6
Cloudflare-AutoRAG
Cohere LLM
Cohere-Command
Command-A-Reasoning
DeepSeek R1 Chatbot
DocsGPTOnyx
Dolma
Dots Chatbot
DuckAssistBot
Embed v3
ERNIE X1.1
Gemini-Ai
Gemini-Deep-Research
GLM 4.6
Google-NotebookLM
GPT-5-high
GPT-5-high
GPT-crawler
GPT-Qwen Deep Research
Grok 4 Fast
Grok-4
Grok-4 Heavy
Groq-Bot
huggingfacebot
HuggingFace-Bot
hugging-face-ai
Ideogram
Imagen 4
Langfuse
Language AI
Leonadro
LLM Proxy
LLM Scraper
Magistral Medium
MBZUAI Chatbot
MBZUAI Chatbot
Molmo
Nano Banana
Nanobrowser
nanochat
NotebookLM
OLMo
OLMo 2 Chatbot
OLMoASR
OLMoE
Onyx
Open Operator
Open Source LLM
OpenInterpreter
open-manus-v2
OVHcloud AI Training
Owlin
PaLM 2
Perplexity Stealth
Pixmo
Playwright Agentic AI
PulsarRPA
Python lxml
PyTorch
Qwen Deep Research
Reka Flash 3.1
Replicate-Bot
RunPod-Bot
scaleai
scale-crawler
scale-crawler
ScrapeGraphAI
Scraper Bot
Scraping Agent AI
Scrapy-LLM
SeLLMa
sider.ai
Skyvern
Stable Diffusion
Stagehand
STEALTH
Step 3
taiko
Together-Bot
Tülu
UI-TARS
VimGPT
WebVoyager
xAI-Bot
XLNet
you-bot
ZeroStep


#ADDED: 251104

XWrite
URL: https://xeo.bot/en/products/xwrite

MAI-Image-1
URL: https://microsoft.ai/news/introducing-mai-image-1-debuting-in-the-top-10-on-lmarena/

BuddyBot
URL: https://getbuddybot.com/
URL 2: https://wordpress.org/plugins/buddybot-ai-custom-ai-assistant-and-chat-agent/

::::::::::::::::::::::::::::::::::::::::::
#ADDED: GTP  / Robots  - htaccess.txt
GPT-5.1
GPT-5.1 Instant
GPT-5.1 Thinking
GPT-5.1 Auto

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
#ADDED: 251125

GPTBot/1.3
OLMO 3
Meta's SAM 3

Petabot 
URL: https://petanux.com/petabot/

resec.ai
URL: https://resea.ai/

Crawl4ai 
Grok 4.1
ChatGPT Retrieval
ERNIE
FAISS (Facebook AI Similarity Search)

Haystack:
Haystack - deepset AI
U haystack-ai
Haystack RAG Pipeline 

REALM
Weaviate
langchain-openai
DeepSeek-V3.1
AI Deep Research Agent
NotebookLM Deep Research

LinkupBot/1.0 (LinkupBot for web indexing; https://linkup.so/bot; [bot@linkup.so](mailto:bot@linkup.so)
Linkup Deep
https://www.linkup.so/

KlaviyoAIBot
URL: https://help.klaviyo.com/hc/en-us/articles/40496146232219

KI-Crawler
URL: https://www.smartlemon.de/blog/logfile-analyse-llms/

NextChat
URL: https://github.com/ChatGPTNextWeb/NextChat

Knowledge-graph RAG
knowledge graph

LLM Scraper
openai-user
openai-python

AI-Crawler
URL: https://github.com/oxylabs/ai-crawler-py

AI Crawler
URL: https://www.genaiprotos.com/prototype/ai-crawler/


Perplexity Stealth
Replicate-Bot

NetShelter ContentScan
URL: https://inpowered.ai/

ZanistaBot
URL: https://zanista.ai/crawler-info

User-agent: LLM-jp-Crawler
URL: https://llm-jp.github.io/crawler/

Amazon Q Business
https://aws.amazon.com/q/business/  
Amazon Kendra Web Crawler
https://docs.aws.amazon.com/kendra/latest/dg/stop-web-crawler.html

Agentic RAG with Reasoning

https://udger.com/resources/ua-list/bot-detail?bot=Cypex
UserAgent: scan.cypex.ai
cypex.ai/scanning Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36
I do not need any more security:(  I am armed to the teeth!  Very shade!

LMArena bot
https://udger.com/resources/ua-list/bot-detail?bot=LMArena+bot

Abacus AI Deep Agent
AI2Bot-DeepResearchEval
Poggio-Citations
LAION-huggingface-processor 
LCC
SBIntuitionsBot
Spider
ZanistaBot 
Opus 4.5
PandasAI
AI guardrails
gobrowser
AI Agentic RAG Pipeline  
LightRAG
GPT-Shield-AI-Plagiarism-Detector

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

## Copy AI check:
Writer	
Quill	
Writefull	
Corrector	
Sapling
Content at scale	
Copyleaks	
Crossplag


##ADDED, robots.txt: (260105:)
GPT-5.2 
GPT-5.2 Pro
GPT-5.2 Thinking
GPT-5.2 Instant
GPT Image 1.5

### 2026:

Channel3Bot
Echobot Bot
Flux 2
ips-agent
Kimi Agentic
KunatoCrawler
Manus-User
NotebookLM
TwinAgent

.............................?
LÄGGA IN:

GPT-5.2 
GPT-5.2 Pro
GPT-5.2 Thinking
GPT-5.2 Instant
GPT Image 1.5

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
### 2026:

Channel3Bot
Echobot Bot
Flux 2
ips-agent
Kimi Agentic
KunatoCrawler
Manus-User
NotebookLM
TwinAgent

.............................?
# AI Assistant
# https://darkvisitors.com/agents/ai2bot-deepresearcheval

User-agent: Ai2Bot-DeepResearchEval
Disallow: /

StoryGraph (ML book recs)

check content:
StealthGPT 
GPTZero
Originality AI
TurnitIn
Copyleaks
WinstonAI

OPEN LLMS:
https://github.com/eugeneyan/open-llms

...............................
?
claude-4-haiku-thinking
inclusionai/ring-1t
grok-4-fast-thinking
arcee-ai/maestro-reasoning
deepseek-r1-distill-llama-70b
deepseek/deepseek-v3.2-exp
DeepMind Genie 3
Manus-User

wpbot/1.3
Gemini 3 Pro

mistral-large-3
mistral-medium
mistral-small
Mistral OCR 3

minimal AGI

amazon: nova-premier-v1
NotebookLM
microsoft: phi-4-reasoning-plus
microsoft: phi-4-multimodal-instruct

ai21: jamba-mini-1.7

robots-ai-permissions​/2.​0 (+​process_splits_async.​py) 
https://udger.com/resources/ua-list/bot-detail?bot=robots-ai-permissions
https://darkvisitors.com/agents/robots-ai-permissions

OpenVLA

IbouBot Crawler

LCC
URL: https://darkvisitors.com/agents/lcc

Spider
URL: https://darkvisitors.com/agents/spider

imagen4
gpt-image1?

Meta search scraper
TwinAgent
Poggio-Citations
Channel3Bot 
OpenAI Python

........................................................

Webz.io	Data extraction and web scraping used by other AI training companies. Formerly known as Omgili.	User-agent: webzio
URL: https://webz.io/bot.htm

Google releases: Deep Think 2
Google releases: GoogleAgent URL Context

???
User-agent: Awario
AllenAI Bot
PanguBot
ZanistaBot
Agentic AI
User-agent: AI-Content-Detector
User-agent: AI-Crawler
User-agent: atlassian-bot
User-agent: BuddyBot
User-agent: Thinkbot
User-agent: WARDBot
User-agent: Channel3Bot
User-agent: KlaviyoAIBot
User-agent: KunatoCrawler
User-agent: LCC
User-agent: liner-bot
User-agent: TavilyBot
User-agent: IbouBot
User-agent: Spider
User-agent: digitaloceangenai-crawler
ChatGLM-Spider       
Sogou"            
Baiduspider          
ErnieBot             
DeepseekBot           
Python Scrapy
AI webscraper
Perplexity Comet
 
Clara (formerly x.ai)

Another speling: Auto-GPT

Cotoyogi

DAngerous: imageSpider

------------------------
........................
Poetiq scored 54% on ARC-AGI-2

#? OpenBrain’s latest public model: Agent-0
                                    Agent-1 
								    Agent-2
								    Agent-3

DuckDuckGo LangChain Bot
AutoGLM Rumination

Perplexity: Sonar Pro
VaultGemma 
DialoGPT-medium
GLM-4.6
GLM-4.6 GGUF
Opus 4.5 
Anthropic: Claude v1.2 
OpenAI: o4 Mini Deep Research

Kagi AI
Kagi LLM
URL: https://help.kagi.com/kagi/ai/llm-benchmark.html


LangGraph Python
https://langchain-ai.github.io/langgraph/llms.txt

LangGraph JS
https://langchain-ai.github.io/langgraphjs/llms.txt

LangChain Python
https://python.langchain.com/llms.txt

LangChain JS
https://js.langchain.com/llms.txt

.
Scrapeless: 1.0 
URL: https://www.scrapeless.com/en/ai-agent

......................
GrokAppAndroid  // NOT A thret yet!
URL: https://docsbot.ai/prompts/research/deep-research-grok-app-android
NEEDS: ChatGPT, Gemini, and Claude chatbots and models to work!


AI Agents in Rust
URL. https://adk-rust.com/en

____________________________________________

## Disclaimer

This guide is provided for informational purposes only. The AI crawler landscape changes rapidly. Always verify current information and test your configurations before implementing. The effectiveness of blocking measures depends on crawler compliance and implementation details.

---

*Guide compiled from public sources and community contributions. 

> **Last Updated:** January 20250107  