# AI Bots, Scrapers and Bot Detection — Complete Guide 2027

---

## 📑 Table of contents

0. [Read this first](#0-read-this-first)
1. [AI platforms and language models (Nov 2026)](#1-ai-platforms-and-language-models-nov-2026)
2. [AI browsers and AI agents](#2-ai-browsers-and-ai-agents)
3. [AI crawlers: the complete catalogue](#3-ai-crawlers-the-complete-catalogue)
4. [The control signals in detail](#4-the-control-signals-in-detail)
5. [Implementing protection](#5-implementing-protection)
6. [IP level: the right way to block a vendor's crawler](#6-ip-level-the-right-way-to-block-a-vendors-crawler)
7. [Advanced detection techniques](#7-advanced-detection-techniques)
8. [Stealth scraping and anti-detection](#8-stealth-scraping-and-anti-detection)
9. [Legal considerations](#9-legal-considerations)
10. [Monitoring and analytics](#10-monitoring-and-analytics)
11. [Checklist](#11-checklist)
12. [Future trends and threats](#12-future-trends-and-threats)
13. [What was WRONG in the 2025 version](#13-what-was-wrong-in-the-2025-version)
14. [Sources](#14-sources)
15. [Changelog](#15-changelog)

---

## 0. Read this first

**A gate that fails everything is the gate, not the data.** This is the single most important rule in the whole guide, and it applies to a UA rule exactly as much as to an ASN list. If a filter lets through 100% of your real readers, it doesn't work — it only blocks you.

### 0.1 The truth table: what is actually read

Most of what circulates online about "how to block AI bots" is **dead**. Here is the matrix, verified against the vendors' own documentation on 2026-11-01.

| Signal | Where it is read | Who reads it | What it actually stops | Status |
|---|---|---|---|---|
| `User-agent: <token>` + `Disallow: /` in robots.txt | `robots.txt` | Only the crawler whose UA token is named | The crawl being allowed to fetch the page | ✅ Works, if the token is right |
| `User-Agent: __usage_ai-training` + `Disallow: /` | `robots.txt` | Anthropic (live), OpenAI (within months), Microsoft (from 2027-02-01), Google (early 2027) | AI *training* — and only training | ✅ New, shared token (2026-10-30) |
| `<meta name="Bingbot" content="ai-training:disallow">` | Page head in HTML | Bingbot / Microsoft | Microsoft training, **per page** | ✅ From 2027-02-01 |
| `<meta name="Bingbot" content="ai-grounding:disallow">` | Page head in HTML | Bingbot / Microsoft | Microsoft grounding (Copilot, AI Mode, M365) | ✅ From 2027-02-01 |
| `X-Robots-Tag: Bingbot: ai-training:disallow` | HTTP response header | Bingbot / Microsoft | Same as the meta tag | ✅ From 2027-02-01 |
| `<meta name="googlebot" content="nosnippet">` | Page head in HTML | Google | The page being used as direct input in AI Overviews / AI Mode | ✅ Works now — **but** the normal search snippet disappears too |
| `Google-Extended` + `Disallow: /` in robots.txt | `robots.txt` | Google | Gemini training + Gemini/Vertex grounding | ✅ Works — **does NOT affect Google Search** |
| Search Console → Settings → **Search generative AI** → Exclude | Google Search Console | Google | AI Overviews, AI Mode, generative Discover | ✅ Worldwide since 2026-08-31 |
| `User-agent: *` + `Disallow: /` | `robots.txt` | Everyone without their own group | **Everything** — including your real readers | ⚠️ Dangerous, see §5.1 |
| `<meta name="gptbot" content="noindex">` | Page head in HTML | — | Nothing | ❌ Dead syntax |
| `noai` / `noimageai` | meta or header | Only a few dataset tools (e.g. img2dataset) | Nothing at Google/Bing/OpenAI/Anthropic | ❌ Never implemented |
| `noml` / `nosummary` | meta | — | Nothing | ❌ Removed from Google's spec |
| `noarchive` / `nocache` | meta | Bing (historically) — **not** Google | Microsoft training, until **2027-03-01** | ⚠️ Expires |
| `NoCrawl: Microsoft-officially-supported-ai-agents` | — | — | Nothing | ❌ Does not exist |
| `Disallow: /` inside a `User-agent: *` group | `robots.txt` | Everyone | All crawling | ⚠️ Dangerous |

### 0.2 The five things people get wrong

1. **A UA string is a claim, not proof.** Anyone can send `GPTBot` in their User-Agent. A UA rule only blocks whoever is *lazy enough to lie*.
2. **A vendor's crawler IP list is NOT in the vendor's own ASN.** Anthropic's /22 sits inside AS16509 (Amazon). Google's sit in AS15169 and AS396982. **Never ASN-block a vendor's crawler** — you would block thousands of other tenants in the same network.
3. **`Google-Extended` does not affect your visibility in Google Search.** This is the most widespread misunderstanding in the entire field. Google-Extended covers *training* of Gemini and grounding in Gemini/Vertex. `Googlebot` governs indexing.
4. **Meta tags are read by Google, Bing and Apple only.** `GPTBot`, `ClaudeBot`, `CCBot`, `Amazonbot`, `meta-externalagent` and `Bytespider` read **robots.txt only**. A `<meta name="gptbot">` does nothing.
5. **robots.txt governs *fetching*, not indexing.** A crawler that robots.txt excludes never sees your `noindex` — the rule is silently ignored.

### 0.3 The detection instrument — measure before you block

Before you block a UA, a referer or an ASN: **treat the instrument as suspect, not the data.**

| Test | Tool | Interpretation |
|---|---|---|
| **Fingerprint test** | Fetch an HTML page + at least one JS/CSS asset | `HTML 200 + ≥1 asset fetch` = a real browser. `HTML 200 + 0 assets` = a script. |
| **A referer is a claim** | Chrome sends only `https://www.google.com/` | A referer rule over-fires. Use the fingerprint test to decide. |
| **Body size = layer fingerprint** | 13 B = edge deny · 17 B = same, brotli · ~4.4 kB = WP page · 0 B = PHP `header()`+`exit` | Read the **status code**, not just the body. |
| **Mind the seed on allow-lists** | Check the *seeds* in allow-lists, not just the policy | An allow-seed containing `safari` releases a real `Applebot`. |

---

## 1. AI platforms and language models (Nov 2026)

### 1.1 Current flagship models

| Vendor | Current flagship | Released | Note |
|---|---|---|---|
| **OpenAI** | GPT-6 Astra | 2026-09-03 | 1.05 M token context; OSWorld 2.0 76.6%; "Critical" cyber rating under the Preparedness Framework (partly gated) |
| | GPT-6.1 Sol | 2026-09-29 | Announced at DevDay; best price/performance by independent measurements |
| | GPT-6 Sol / GPT-6 Luna / GPT-6.1 Terra | 2026-09-22 | Expansion of the GPT-6 family |
| | GPT-5.6 Sol / Terra | 2026-07 | Predecessors; the Atlas retirement was announced in the same release |
| | GPT-5.2 / GPT-5.2-Codex | 2025-12 | Still in use |
| **Anthropic** | Claude Opus 5.5 | 2026-09-22 | $4/$20 per MTok; 1 M context; first Opus of the Claude 5.5 family |
| | Claude Sonnet 5.5 | 2026-09-29 | |
| | Claude Haiku 5.5 | 2026-10 | |
| | Claude Fable 5.1 / Mythos 5.1 | 2026 | |
| **Google** | Gemini 4 Carbon | 2026-10-28 | **Restricted** to security researchers via Fairwind; #1 on the Artificial Analysis Intelligence Index v5.0 (59) |
| | Gemini 4 Argon | 2026-10-01 | Generally available |
| | Gemini 3.8 Flash | 2026 | |
| **Alibaba** | Qwen3.8 Max | 2026-08-26 | |
| **DeepSeek** | DeepSeek V4.1 Flash | 2026-10 | Best model with open weights |
| **Z.AI** | GLM-5.3 | 2026 | |
| **Moonshot** | Kimi K3.1 Pro | 2026-10-23 | #4 on Artificial Analysis; leads open weights |
| **xAI** | Grok 4.6 | 2026 | |
| **Meta** | Muse Spark 1.1 / Muse Wonder | 2026 | |

> **Note:** the race is wide open. Gemini 4 Carbon leads the index but is not generally available; Opus 5.5 leads among what you can actually buy. OpenAI's own comparison (Astra 59.3% vs Opus 5 55.5%) uses an older index version — those numbers are not comparable to v5.0.

### 1.2 Vendor crawler tokens (what you write in robots.txt)

| Vendor | Training | Search/index | User-triggered fetch | Other |
|---|---|---|---|---|
| OpenAI | `GPTBot` | `OAI-SearchBot` | `ChatGPT-User` | `OAI-AdsBot` (ad validation) |
| Anthropic | `ClaudeBot`, `anthropic-ai` (older) | `Claude-SearchBot` | `Claude-User` | `Claude-Web` (older) |
| Google | `Google-Extended` | `Googlebot`, `GoogleOther` | `Google-Read-Aloud`, `APIs-Google` | `Google-CloudVertexBot` |
| Perplexity | — | `PerplexityBot` | `Perplexity-User` | |
| Meta | `meta-externalagent` | `meta-webindexer` | `meta-externalfetcher` | `FacebookBot`, `facebookexternalhit` |
| Apple | `Applebot-Extended` | `Applebot` | — | |
| Amazon | `Amazonbot` | `Amazonbot` | — | `Amzn-SearchBot` |
| Common Crawl | `CCBot` | — | — | Open corpus that third parties reuse |
| ByteDance | `Bytespider` | — | — | |
| Cohere | `cohere-ai` | — | — | |
| Mistral | `MistralAI-Training` | — | `MistralAI-User` | |
| DuckDuckGo | — | `DuckAssistBot` | — | |
| Exa | — | `ExaSearchBot` | `ExaUser` | Signs with RFC 9421 |
| Apple/Google/Microsoft | — | `Applebot`, `Googlebot`, `bingbot` | — | **Never lumped in with training crawlers** |

### 1.3 China and the rest of the open source world

```
DeepSeekBot, Qwen, qwen3, Kimi, KimiBot, GLM, MiniMax, Doubao, Baiduspider, PetalBot
```

⚠️ **PetalBot** (Huawei) does not consistently respect robots.txt, and **PetalBot** ≠ `Baiduspider`. `Baiduspider` is an ordinary search engine and should be handled like Google/Bing.

---

## 2. AI browsers and AI agents

> **This is the most important new category since 2024.** An agentic AI browser is a **real reader**: it runs JavaScript, fetches assets, honours cookies and sends referers. If you block it, you block traffic.

### 2.1 Status per browser (Nov 2026)

| Browser | Status | Platforms | Price | Notes |
|---|---|---|---|---|
| **Perplexity Comet** | Live, the default answer | macOS, Windows, iOS, Android | Free (Pro $20, Max $200) | ~18 M MAU by mid-summer 2026; the best agentic browser |
| **Dia** | Live (Arc successor) | macOS GA, Windows beta | Free + paid tiers | Has **no** agent mode — a smarter interface, not an autonomous executor |
| **Brave + Leo** | Live, assistive | All platforms | Free, Leo Premium $14.99/mo | On-device, privacy-focused, no autonomous agent |
| **Opera Neon** | Live, agentic | Desktop | $19.99/mo (also a free download since Aug 2026) | MCP connector for Claude/ChatGPT (2026-03-31) |
| **ChatGPT Atlas** | ❌ **Retired 2026-08-09** | — | — | Announced 2026-07-09. Moved into the ChatGPT desktop app + Chrome extension. Data did **not** transfer. |
| **Arc** | ⚠️ Frozen since 2025-05 | macOS, Windows | Free | No new accounts since 2026-10-22; Arc Search loses AI + login + sync on 2026-11-23; macOS/Windows stops 2026-12-22. Atlassian acquired The Browser Company. |
| **Edge + Copilot** | Live, built in | Windows, macOS, iOS, Android | Free | The separate "Copilot Mode" was retired in May 2026 |
| **Chrome + Gemini** | Live, built in | All | Free | ~66–70% of global browser traffic goes through Chrome |
| **Firefox AI Window** | Live, built in | All | Free | |
| **Opera One (R3)** | Live | All | Free | Tab-aware since 2026-01-15; three assistants in the sidebar |
| **Arc Search** | ⚠️ Being wound down | iOS, Android | Free | "Browse for Me" disappears 2026-11-23 |
| Others | Fellou, Genspark Browser, BrowserOS | | | Niche |

### 2.2 Why agentic browsers change the picture

An agentic browser such as Comet or Dia:

- fetches HTML **and** JS/CSS/images → **the fingerprint test gives 200 + assets = a real reader**
- presents a normal Chrome/Safari `User-Agent` → **a UA rule matching "bot|crawler|scraper" catches nothing**
- sends `Sec-Fetch-*`, `Accept-Language`, client hints → these are far stronger signals than the UA
- can log in → session behaviour resembles the owner

**Rule:** never block on the grounds that a UA "looks like a bot" unless you can separate it from a human with the same UA. Better: block on *behaviour* (see §7) or on *target*.

---

## 3. AI crawlers: the complete catalogue

### 3.1 The three jobs — the most important distinction

| Job | What the bot does | Block? | Why |
|---|---|---|---|
| **Training** | Collects pages to train/update a model | ✅ Normally yes | Zero referral traffic. It is scrap for you. |
| **Search & index** | Builds an index so it can answer with citations | ⚠️ Decide | It may send referral traffic and citations. |
| **User-triggered fetch** | Fetches a page *now* because a user asked | ❌ Normally no | High intent, often real traffic. |
| **Ad validation** | Verifies that ad landing pages are safe | ❌ No | The ad function depends on it |

**Blocking a training crawler does not cost you a single visitor.** Blocking a search crawler does — and you lose citations and traffic with it.

### 3.2 Catalogue (verified 2026-10/11)

| Token | Operator | Job | Respects robots.txt | Published IP list | Recommendation |
|---|---|---|---|---|---|
| `GPTBot` | OpenAI | Training | Yes | `openai.com/gptbot.json` (18–21 prefixes) | Block |
| `anthropic-ai` | Anthropic | Training (legacy) | Yes | `claude.com/crawling/bots.json` | Block (legacy) |
| `ClaudeBot` | Anthropic | Training | Yes | same (28 prefixes) | Block |
| `Claude-SearchBot` | Anthropic | Search/citations | Yes | same | Decide — new in 2026, sends traffic |
| `Claude-User` | Anthropic | User-triggered | Yes | same | Allow |
| `OAI-SearchBot` | OpenAI | Search/citations | Yes | `openai.com/searchbot.json` (35–39 prefixes) | Allow if you want citations |
| `ChatGPT-User` | OpenAI | User-triggered | Yes | `openai.com/chatgpt-user.json` (286 prefixes) | Allow |
| `OAI-AdsBot` | OpenAI | Ad validation | Yes | `openai.com/adsbot.json` (2 prefixes) | Allow |
| `Google-Extended` | Google | Training + grounding | Yes | No (control token, not its own bot) | Block if you want |
| `GoogleOther` | Google | General AI crawl | Yes | `common-crawlers.json` | Block (no traffic) |
| `Google-CloudVertexBot` | Google | Vertex grounding | Yes | `common-crawlers.json` | Decide |
| `Applebot-Extended` | Apple | Training | Yes | `applebot.json` | Block if you want |
| `Applebot` | Apple | Search/Spotlight/Siri | Yes | `applebot.json` | Allow |
| `CCBot` | Common Crawl | Open corpus | Yes | — | Block (reused by third parties) |
| `meta-externalagent` | Meta | Training + index | Yes | — | Block |
| `meta-webindexer` | Meta | Search for Meta AI | Yes | — | Decide |
| `meta-externalfetcher` | Meta | User-triggered | **May bypass** | — | Allow |
| `Amazonbot` | Amazon | Search/Alexa + AI | Yes | `amazonbot` | Block training, allow search |
| `Amzn-SearchBot` | Amazon | Search | Yes | — | Allow |
| `Bytespider` | ByteDance | Training | **No — documented violations** | — | Block |
| `cohere-ai` | Cohere | Training | Yes | — | Block |
| `PerplexityBot` | Perplexity | Index | **Contested** | `perplexity.ai/perplexitybot.json` (13 prefixes) | Decide |
| `Perplexity-User` | Perplexity | User-triggered | May bypass | `perplexitybot.json` (10 prefixes) | Allow |
| `ExaSearchBot` / `ExaUser` | Exa | Search / fetch | Yes (but `ExaUser` has no group of its own) | **No** — rents IPs and rotates | UA rule, not an IP block |
| `DuckAssistBot` | DuckDuckGo | Search | Yes | 486 prefixes | Allow |
| `MistralAI-Training` | Mistral | Training | Yes | — | Block |
| `MistralAI-User` | Mistral | User-triggered | Yes | — | Allow |
| `YouBot` | You.com | Search | Yes | — | Decide |
| `ImagesiftBot` | ImageSift | Image theft | Unknown | — | Block |
| `Timpibot` | — | Mass crawl | Hard | — | Block via UA + rate limit |
| `Diffbot` | Diffbot | Structured extraction | Yes | — | Decide |
| `PetalBot` | Huawei | Search | Inconsistent | — | Block |

### 3.3 The ones that disappeared

```
GPT-crawler, Claude-Web, Bingbot (as a UA), CopilotBot, GoogleProducer,
Microsoft Copilot (as a UA), ChatGPT (as a UA), SAM 2, StableDiffusionBot,
V-JEPA, DALL-E, peer39_crawler, AndersPinkBot, TurnitinBot, FriendlyCrawler
```

> ⚠️ **`ChatGPT`, `Microsoft Copilot` and `GPT-5` as robots.txt tokens are outdated.** OpenAI now uses `GPTBot` / `OAI-SearchBot` / `ChatGPT-User`. A `User-agent: ChatGPT` group catches nothing that `GPTBot` does not already catch.
> ⚠️ **There is no `CopilotBot`.** Microsoft uses `bingbot`. A rule on `CopilotBot` is dead syntax.

### 3.4 Verification: UA ≠ identity

A UA string can be forged by anyone. The vendors therefore publish **IP lists** — that is the only mechanism that proves identity:

| Vendor | File | Content (as of Oct 2026) |
|---|---|---|
| OpenAI | `openai.com/gptbot.json` | 18 prefixes, ~3 472 IPv4 |
| OpenAI | `openai.com/searchbot.json` | 39 prefixes, ~2 496 IPv4 |
| OpenAI | `openai.com/adsbot.json` | 2 prefixes (/25) |
| OpenAI | `openai.com/chatgpt-user.json` | 286 prefixes, ~37 328 IPv4 |
| Anthropic | `claude.com/crawling/bots.json` | 28 prefixes |
| Perplexity | `perplexity.ai/perplexitybot.json` | 13 prefixes |
| Apple | `search.developer.apple.com/applebot.json` | — |
| Google | `developers.google.com/static/crawling/ipranges/*.json` | **5 files** (see §6.2) |
| Bing | `bing.com/toolbox/bingbot.json` | 28 IPv4, no IPv6 |

**Verification in the log:**

```python
import ipaddress, json, urllib.request

def load_ranges(url):
    with urllib.request.urlopen(url, timeout=10) as r:
        return [ipaddress.ip_network(p["ipv4Prefix"])
                for p in json.load(r).get("prefixes", [])]

def is_real_bot(ip, token, url):
    try:
        addr = ipaddress.ip_address(ip)
    except ValueError:
        return False
    return any(addr in net for net in load_ranges(url))

# Log lines where "ClaudeBot" claims to come from an IP outside Anthropic's list
# = forgery. Measure the share of forged UA tokens in your log.
```

**Observed:** in one large log measurement, **2.0% of bot hits were "actively wrong"** — they claimed a verifiable vendor but came from an IP outside that vendor's ranges. That is a measurement, not an opinion.

**The rule:** *a vendor token on an ASN that does not belong to the vendor is a forgery.* Test **both** the ASN **and** the token.

### 3.5 Web Bot Auth (RFC 9421)

New and serious vendors sign their requests. The headers:

```
Signature: …
Signature-Input: …
Signature-Agent: "https://crawler.exa.ai"
```

`Signature-Agent` points at the vendor's key directory (e.g. `https://crawler.exa.ai/.well-known/http-message-signatures-directory`). If you match `crawler\.exa\.ai` in `Signature-Agent`, you catch the vendor even if the UA string changes — and it cannot be produced by anyone who merely edits their UA.

It is still a string match, not signature verification. But it is a **much** stronger signal than a UA.

---

## 4. The control signals in detail

### 4.1 The shared policy token — `__usage_ai-training`

**Source:** `draft-kelley-aipref-training-preference-signal-00` (Kevin Kelley, Anthropic), published **30 October 2026**. An individual Internet-Draft — **not** IETF-endorsed, no formal standing.

```txt
User-Agent: __usage_ai-training
Disallow: /
```

**What the draft says, quoted in translation:**

- It introduces **no new directive names and no new grammar**. The path language, *longest-match* precedence and the group structure of robots.txt (RFC 9309) are unchanged.
- The preference is bound to **paths** via an ordinary robots.txt group with the policy key in the `User-Agent` line.
- **A wildcard group (`User-agent: *`) must NOT be interpreted as matching the policy key.**
- **If no group in the file contains the policy key, no preference has been expressed.**
- The policy key is **not a directive for crawl behaviour** — it governs usage, not fetching.

**Vendor timelines (verified 2026-11-01):**

| Vendor | Plan | Timing |
|---|---|---|
| **Anthropic** | Author of the draft, already supports it | Already live |
| **OpenAI** | Announced 2026-10-30 that it will honour the signal | "Within the coming months" — no exact date |
| **Microsoft (Bing)** | Honours the token for **training**; adds page-level controls | **2027-02-01** |
| **Google** | Plans to support the token; if `Google-Extended` is not explicitly specified, the token is interpreted as "Google-Extended blocked" | **Early 2027** |

> **Practically:** publish the token now — it costs nothing, it is forward-compatible, and it expresses intent. But **do not build a protection that DEPENDS on it working** until a vendor has confirmed they read it.

### 4.2 Microsoft's page-level preferences

Microsoft's own system (announced 2026-10-30 by Krishna Madhavan) splits into **two independent preferences**:

| Preference | Where | Values | Default |
|---|---|---|---|
| **AI Training** | robots.txt (the token above) **or** per page | `disallow` | Allow |
| **AI Grounding** | **Page level only** — meta or header | `allow` (default) · `disallow` · `disallowextended` | Allow |

**Page-level syntax:**

```html
<meta name="Bingbot" content="ai-training:disallow">
<meta name="Bingbot" content="ai-grounding:disallow">
<meta name="Bingbot" content="ai-grounding:disallowextended">
```

```http
X-Robots-Tag: Bingbot: ai-training:disallow
X-Robots-Tag: Bingbot: ai-grounding:disallow
```

**What the values mean:**

- `ai-training:disallow` — the page is not used for Microsoft's AI training. **A page-level value overrides the robots.txt value for that page.**
- `ai-grounding:disallow` — the content is not used to inform generated responses. The page does not appear in Bing, Copilot or M365 answers.
- `ai-grounding:disallowextended` — **a new value.** Keeps grounding inside Microsoft's *own* experiences (AI Mode, AI Overview, Copilot, Microsoft 365) but excludes the grounding Microsoft *sells on* (Web IQ, grounding via the Foundry API). This is the "soft" option: you stay in Copilot answers but not in third-party AI services.

**There is no site-wide grounding preference in robots.txt.** Microsoft says so explicitly.

**Timeline (critical):**

| Date | Event |
|---|---|
| **2026-12-15** | Bing Webmaster Tools opens **temporary grounding preferences** — only for sites using `noarchive`/`nocache` on that date |
| **2027-02-01** | Microsoft starts honouring AI Training + AI Grounding as it crawls. **If new preferences are detected, Bing disregards any leftover `noarchive`/`nocache`.** |
| **2027-03-01** | **Deadline.** Publish the page-level grounding preference **and** record the temporary preference in Bing Webmaster Tools. After this date `noarchive`/`nocache` are **no longer read** as training or grounding preferences. |
| **2027-09-30** | Temporary grounding preferences expire (or earlier if Bing finds the new preference on a recrawl) |

> ⚠️ **If you use `noarchive`/`nocache` today and want to keep the grounding block after 2027-03-01, you must do BOTH: add `ai-grounding:disallow`/`disallowextended` and record the temporary preference in Bing Webmaster Tools.** Doing only one loses the block.

**Neither preference affects ordinary Bing results.** But Microsoft warns: `disallow` and `disallowextended` **reduce your brand visibility in AI experiences**. And: neither "allow training" nor "allow grounding" guarantees inclusion, traffic or payment.

### 4.3 Google — three independent layers

| Layer | What it governs | Where |
|---|---|---|
| `Google-Extended` + `Disallow: /` | Training of Gemini models + grounding in the Gemini app / Vertex AI | robots.txt |
| **Search generative AI control** | AI Overviews, AI Mode, generative content in Discover | Search Console → Settings |
| `nosnippet` / `max-snippet:N` | The page being used as direct input in AI Overviews / AI Mode | meta + header |

#### 4.3.1 Search generative AI control

**Available worldwide since 2026-08-31** (first in the UK on 2026-06-03, following CMA pressure).

```
Search Console → Settings → Search generative AI
  ├─ Include my site's links and content in Search generative AI features  (default)
  ├─ Exclude my site's links and content from Search generative AI features
  └─ Inherit control from parent
```

**What Exclude actually does:** your content does not appear in AI Overviews, AI Mode or generative Discover, and is no longer "eligible as an input" for generating an AI response.

**What it does NOT do:**

- ❌ Does **not** affect your ranking in ordinary search ("isn't used as a ranking or inclusion signal affecting other parts of Search")
- ❌ Does **not** affect the regular Discover feed (only Discover's generative layer is in scope)
- ❌ Does **not** affect training — that is governed by `Google-Extended`
- ❌ Does **not** affect Merchant Center or Google Ads

**Timing:** 1–2 days after the setting goes live, sometimes longer due to caching.

**⚠️ Property inheritance:** a URL-prefix property under a domain inherits the value from the nearest parent. Excluding the parent without checking the children can block sections you did not intend, or leave sections open you believed were closed.

**Related:** Search Console also has a **Generative AI performance report** (impressions in AI Overviews / AI Mode / Discover-AI) — available to every site worldwide since 2026-08-31. It does **not** appear if you have excluded yourself.

#### 4.3.2 `nosnippet` — and its price

Google: *"nosnippet … will also prevent the content from being used as a direct input for AI Overviews and AI Mode"*, and it applies to **all** search results (web, Images, Discover, AI Overviews, AI Mode).

**The price:** the normal search snippet disappears too. `nosnippet` is therefore expensive.

`max-snippet:0` = same as `nosnippet`. `max-snippet:-1` = "Google chooses" (standard boilerplate in SEO plugins). `max-snippet:20` = a cap of 20 characters as direct input in AI answers.

**Cheaper alternative:** `data-nosnippet` on selected `<span>`/`<div>`/`<section>` elements — switches off individual parts of the text. Note: Google picks the attribute up both before and after rendering → **do not remove or add `data-nosnippet` on elements that have JS on them.**

> **Recommendation for a content blog:** use **Search generative AI control = Exclude** if you do not want to appear in AI answers. It costs you no ordinary snippets and no ranking. Save `nosnippet` for individual pages where you really want it.

#### 4.3.3 What Google has removed

**Removed from Google's robots meta specification:**
- `noml` — removed
- `nosummary` — removed

**Still listed but NOT used by Google Search (the "historical and other unused rules" list):**
- `noarchive` — no longer used by Google Search (the cached-link feature no longer exists)
- `nocache` — not used by Google Search
- `nositelinkssearchbox` — not used (the feature is gone)

**Never implemented by Google, Bing, OpenAI or Anthropic:**
- `noai` — only certain dataset tools (e.g. `img2dataset` reads `X-Robots-Tag: noai` on the **image itself**, not a meta tag on the surrounding page)
- `noimageai` — same

**Google's robots meta rules that actually apply (2026):**

| Rule | Status |
|---|---|
| `none` | = `noindex, nofollow` |
| `noindex` | ✅ |
| `nofollow` | ✅ |
| `nosnippet` | ✅ (blocks AI Overviews/AI Mode input) |
| `max-snippet:N` | ✅ |
| `max-image-preview:N` | ✅ |
| `max-video-preview:N` | ✅ |
| `indexifembedded` | ✅ (only together with `noindex`) |
| `noimageindex` | ✅ |
| `notranslate` | ✅ |
| `unavailable_after:[date]` | ✅ |
| `data-nosnippet` | ✅ (element level) |

**The tie-break rule:** *"The more restrictive rule applies."* Meta tags and `X-Robots-Tag` are treated as **one** set of rules.

**And one important consequence:** *"a URL disallowed in robots.txt is never seen"* — crawl rules and indexing rules are two independent layers.

### 4.4 The dead syntax — complete list

The following has **no effect** at any major vendor. They are silently dropped:

```
NoCrawl: Microsoft-officially-supported-ai-agents
User-agent: CopilotBot
<meta name="gptbot" content="noindex">
<meta name="claudebot" content="noindex">
<meta name="ccbot" content="noindex">
<meta name="bytespider" content="noindex">
<meta name="amazonbot" content="noindex">
<meta name="meta-externalagent" content="noindex">
noai, noimageai, noml, nosummary
Content-Usage: ai=n            (draft, not implemented)
MaxConnPerIP                    (that is mod_maxconn, not mod_rewrite)
```

> **`Content-Usage: train-ai=n`** appears in `draft-ietf-aipref-attach` and is worth keeping an eye on — but it is still only a draft and no vendor reads it.

### 4.5 The HTTP header level

`X-Robots-Tag` is the same instruction as the meta tag, but it carries on things where meta does not work (PDFs, images, API responses).

```
X-Robots-Tag: noindex
X-Robots-Tag: Bingbot: ai-training:disallow, ai-grounding:disallowextended
```

**Apache — append, never replace:**

```apache
# WRONG: two set lines -> the second replaces the first
Header set X-Robots-Tag "noindex"
Header set X-Robots-Tag "ai-grounding:disallow"

# RIGHT: set, then add
Header always set X-Robots-Tag "Bingbot: ai-training:disallow"
Header always add X-Robots-Tag "Bingbot: ai-grounding:disallowextended"
```

**nginx:**

```nginx
add_header X-Robots-Tag "Bingbot: ai-training:disallow" always;
add_header X-Robots-Tag "Bingbot: ai-grounding:disallowextended" always;
```

### 4.6 `/.well-known/ai.txt` — the new draft

`draft-car-ai-txt-wellknown-00` (12 June 2026, K. Cardillo, *individual submission* — no IETF status) proposes two well-known URIs:

- `https://example.com/.well-known/ai.txt`
- `https://example.com/.well-known/ai.json`

The file is a block format (inspired by robots.txt) with fields such as `Training: deny|allow|conditional`, `Training-Allow`, `Training-Deny`, `License`, `Attribution`, `Agents`, `Rate-Limit`.

**Position:** complementary to robots.txt, not a replacement. It expresses nuance that robots.txt cannot: "you may crawl but not train".

**Status 2026-11-01:** no vendor reads it. Publish it if you want to signal a policy — it does no harm.

### 4.7 Cloudflare AI Crawl Control and Pay per Crawl

**AI Crawl Control** (formerly "AI Audit", now generally available):

- **Free plan:** identifies AI crawlers **via User-Agent strings**
- **Paid plan:** Bot Management detection ID → also detects crawlers trying to hide

**Actions per crawler:** Allow · Block · Charge (pay per crawl).

**Block responses (paid plan):** you can return **HTTP 402 "Payment Required"** instead of 403, with your own body — a direct way to communicate licensing terms.

**Defaults changed on 2026-09-15:**
- For **new** domains: **Training** and **Agent** are blocked by default on pages that display ads. **Search** remains allowed.
- Multi-purpose crawlers (Googlebot, Applebot, BingBot) are blocked if you chose to block Training — they follow **all** of their behaviours.
- Before that: all verified bots were allowed by default. Now "Verified" is no longer "default allowed" — it means "allowed within its category".

**Pay per Crawl:** requires a paid plan; charging is in private beta (Stripe). Since 2026-06-16 there is advanced configuration:
- disable pay per crawl for certain URI patterns via Configuration Rules (e.g. free access to the home page)
- dynamic pricing: the origin returns a `crawler-price` header, or a Cloudflare Worker sets the price
- when dynamic pricing is on, `cf-pay-per-crawl` is added to origin requests

**Precedence:** AI Crawl Control's blocking (WAF custom rules) happens **before** Cloudflare Bots; pay per crawl happens **after** Cloudflare Bots. If you want to use both blocking and charging, you must turn off "Block AI Bots".

### 4.8 The shared policy token vs. the AIPREF vocabulary

| Draft | Status | What it does |
|---|---|---|
| `draft-ietf-aipref-vocab-08` | Working group, 2026-09-14, Proposed Standard | Vocabulary for AI usage preferences |
| `draft-ietf-aipref-attach` | Working group, Aug 2026 → IESG | How preferences are bound to content (robots.txt + HTTP headers) |
| `draft-kelley-aipref-training-preference-signal-00` | Individual, 2026-10-30 | The `__usage_ai-training` policy key |
| `draft-car-ai-txt-wellknown-00` | Individual, 2026-06-12 | `/.well-known/ai.txt` |
| `draft-madhavan-aipref-displaybasedpref-00` | Individual, 2026-03-25 | Search-driven preference vocabulary |

---

## 5. Implementing protection

### 5.1 robots.txt

**Rule 1 — named agents, never a wildcard for blocking.**
A `User-agent: *` + `Disallow: /` group blocks *everyone* without their own group — including Googlebot, Bingbot and all your readers. If you want to block training crawlers: **name every agent.**

**Rule 2 — the policy key must sit in its own group.**
The draft states explicitly that a wildcard group must not be interpreted as matching the policy key.

**Rule 3 — RFC 9309: the longest match wins; on a length tie, `Allow` wins.**
An `Allow: /press-kit/` in the same group opens exactly that directory for training.

**Minimal, correct robots.txt for a content blog:**

```txt
# --- Search and indexing: ALLOW (you want the traffic and the citations) ---
User-agent: Googlebot
Allow: /

User-agent: bingbot
Allow: /

User-agent: Applebot
Allow: /

# --- AI training: BLOCK ---
User-agent: GPTBot
Disallow: /

User-agent: ClaudeBot
Disallow: /

User-agent: anthropic-ai
Disallow: /

User-agent: Google-Extended
Disallow: /

User-agent: Applebot-Extended
Disallow: /

User-agent: CCBot
Disallow: /

User-agent: meta-externalagent
Disallow: /

User-agent: Bytespider
Disallow: /

User-agent: Amazonbot
Disallow: /

User-agent: cohere-ai
Disallow: /

User-agent: MistralAI-Training
Disallow: /

User-agent: AI2Bot
Disallow: /

User-agent: Diffbot
Disallow: /

# --- User-triggered fetch and search crawlers: ALLOW ---
User-agent: OAI-SearchBot
Allow: /

User-agent: Claude-SearchBot
Allow: /

User-agent: PerplexityBot
Allow: /

User-agent: ChatGPT-User
Allow: /

User-agent: Claude-User
Allow: /

User-agent: Perplexity-User
Allow: /

User-agent: MistralAI-User
Allow: /

# --- The shared policy key: its own group, no wildcard ---
User-Agent: __usage_ai-training
Disallow: /

# --- Sitemap ---
Sitemap: https://example.se/sitemap.xml
```

**Verify there is no `User-agent: *` with `Disallow: /`:**

```bash
curl -s https://example.se/robots.txt | grep -A2 -i "user-agent: \*"
```

**robots.txt testers:** Google Search Console → URL Inspection → robots.txt tester. It should show "Allowed" for Googlebot.

### 5.2 .htaccess (Apache / LiteSpeed)

> ⚠️ **The traps that have taken down all traffic.** Read the full list in §5.2.3 before you deploy.

#### 5.2.1 A UA rule that works

```apache
# --- Block known AI training and data-harvest crawlers ---
<IfModule mod_rewrite.c>
RewriteEngine On

RewriteCond %{HTTP_USER_AGENT} "(GPTBot|ClaudeBot|anthropic-ai|Claude-Web|CCBot|Bytespider|meta-externalagent|meta-externalfetcher|Google-Extended|Applebot-Extended|Amazonbot|cohere-ai|MistralAI-Training|AI2Bot|Diffbot|Timpibot|ImagesiftBot)" [NC]
RewriteRule ^ - [F,L]

# Signed by Exa (RFC 9421) - catches it even if the UA is changed
RewriteCond %{HTTP:Signature-Agent} "crawler\.exa\.ai" [NC]
RewriteRule ^ - [F,L]

</IfModule>
```

**What you should NOT block in the same rule:**
`Googlebot` · `bingbot` · `Applebot` · `OAI-SearchBot` · `Claude-SearchBot` · `PerplexityBot` · `ChatGPT-User` · `Claude-User` · `Perplexity-User` · `MistralAI-User` · `GoogleOther` *(your call — but it sends no referrals)* · `bot` as a generic word.

#### 5.2.2 Why this exact shape

| Feature | Reason |
|---|---|
| `RewriteEngine On` | Without it the block is **dead** — the rule can never fire. (An earlier block in the same directory *does* carry the state, so it is enough for it to exist *somewhere* in the directory.) |
| `RewriteCond ... "..."` with quotes | Patterns containing spaces must be quoted, otherwise Apache tokenises the line wrongly |
| `[NC]` | Case-insensitive. Without it you only catch the exact spelling |
| A single `[NC]` cond + `[F,L]` | Chains with `[OR]` are the most common reason "the rule does not work" |
| `RewriteRule ^ - [F,L]` | `-` = don't change the URI, `F` = 403 Forbidden, `L` = stop |
| `<IfModule mod_rewrite.c>` | Protection against "Invalid command" → 500 if mod_rewrite is missing |

#### 5.2.3 The traps — complete list

| # | Trap | Consequence |
|---|---|---|
| 1 | **Missing `RewriteEngine On`** | The rule is dead. Symptom: no 403, no 500. |
| 2 | **Missing space between `%{ENV:X}` and the pattern** | Apache reads the line as one argument → `bad argument line` → **HTTP 500 for EVERY visitor** |
| 3 | **Pattern with spaces and no quotes** | Same as above → 500 |
| 4 | **Cond line longer than 8 191 bytes** | Apache refuses to read the whole file → **500 for everyone**. Measured: 8 190 B works, 8 192 B gives 500. **Split long lists across several lines.** |
| 5 | **Two address families in one AND chain** | `REMOTE_ADDR` v4 and v6 are AND-ed → the chain is unsatisfiable for every request on earth |
| 6 | **A negative cond list that cancels the positive one** | An "allow" list that blocks the same agents turns the rule into a no-op |
| 7 | **An IPv6 pattern that can never match** | e.g. `2a00:1450::`, which is Google's *web-serving* space, not its crawler space |
| 8 | **`</IfModule>` glued to the RewriteRule line** | 500 for everyone |
| 9 | **The file has no trailing newline** | Edits land on the comment → broken structure → 500 |
| 10 | **Two `Header set X-Robots-Tag`** | The second line replaces the first |
| 11 | **A rule that catches a real reader's UA** | You are blocking readers, not bots |

> **Verification:** `apache2 -t` says **"Syntax OK" every single time** — it never parses `.htaccess`. **Only a live request proves the file.**

#### 5.2.4 Measure on the server, not from your laptop

Requesting your own site from a datacenter IP often returns **Imunify360 bot protection** (below WordPress) or a **JS challenge** — you do not see the file, you see a ~12 kB splash. Then you cannot measure anything.

**Run the measurement from the server, over ssh:**

```bash
ssh user@server 'curl -sS -A "GPTBot/1.1" -o /dev/null -w "%{http_code}\n" https://example.se/'
ssh user@server 'curl -sS -A "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/140.0 Safari/537.36" -o /dev/null -w "%{http_code}\n" https://example.se/'
```

The first line must give **403**, the second **200**. If both give 200, the rule is dead. If both give 500, you have broken the file.

### 5.3 nginx

> **Your own server runs nginx as the outermost layer.** `map` and `limit_req_zone` must live in `http {}` — not in `server {}`.

```nginx
# ===== http {} =====
map $http_user_agent $is_ai_crawler {
    default 0;
    ~*(GPTBot|ClaudeBot|anthropic-ai|CCBot|Bytespider|meta-externalagent|Google-Extended|Applebot-Extended|Amazonbot|cohere-ai|MistralAI-Training|AI2Bot|Diffbot|Timpibot) 1;
}

map $http_signature_agent $is_signed_crawler {
    default 0;
    ~*crawler\.exa\.ai 1;
}

# Rate limit per IP, NOT per UA string
limit_req_zone $binary_remote_addr zone=perip:10m rate=30r/m;

# ===== server {} =====
server {
    listen 443 ssl http2;
    server_name example.se;

    # "if" is dangerous - but SAFE when the body is only a return
    if ($is_ai_crawler)      { return 403 "AI training crawler blocked\n"; }
    if ($is_signed_crawler)   { return 403 "Signed AI crawler blocked\n"; }

    location / {
        limit_req zone=perip burst=50 nodelay;

        # add_header AFTER return never runs - put it before
        add_header X-Robots-Tag "Bingbot: ai-training:disallow" always;
        add_header X-Robots-Tag "Bingbot: ai-grounding:disallowextended" always;

        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

**Traps corrected from the 2025 guide:**

| Error in the 2025 guide | Why it is wrong | Correct |
|---|---|---|
| `limit_req_zone` inside `server {}` | nginx: "limit_req_zone directive is not allowed here" → **nginx will not start** | `http {}` |
| `limit_req_zone $http_user_agent` | Every visitor with the same UA shares **one** bucket → real readers get rate-limited | `$binary_remote_addr` |
| `add_header` after `return` in the same block | `return` terminates → the header is never sent | `add_header` before, or at `server` level |
| `if ($is_suspicious) { limit_req ...; }` | `if` in a location with a complex body → the variable is undefined in some orders | Always rate limit, use `map` for the exceptions |
| `map $http_user_agent $is_suspicious` with `~*(bot\|crawler\|scraper\|ai\|gpt\|claude)` | Matches "Safari"? No — but it matches **"chatgpt"**, and above all any UA containing the word "ai" | Only explicit vendor tokens |

### 5.4 WordPress

**robots.txt via PHP (so it survives a theme change):**

```php
<?php
/**
 * Plugin Name: AI Crawler Policy
 * Description: Generates robots.txt with named AI-agent groups.
 */

add_filter('robots_txt', function ($output, $public) {
    if ($public) {
        $output .= "\n# --- AI training: block ---\n";
        foreach ([
            'GPTBot', 'ClaudeBot', 'anthropic-ai', 'Claude-Web', 'CCBot',
            'Bytespider', 'meta-externalagent', 'meta-externalfetcher',
            'Google-Extended', 'Applebot-Extended', 'Amazonbot',
            'cohere-ai', 'MistralAI-Training', 'AI2Bot', 'Diffbot',
        ] as $bot) {
            $output .= "User-agent: {$bot}\nDisallow: /\n\n";
        }

        $output .= "# --- Shared policy key (own group) ---\n";
        $output .= "User-Agent: __usage_ai-training\nDisallow: /\n\n";
    }
    return $output;
}, 10, 2);
```

> ⚠️ **Do not use the `wp_robots` filter for this** if another plugin (e.g. your AI Shield) already generates robots.txt — two generators overwrite each other.
> ⚠️ **Check "Allow wins on a length tie" (RFC 9309).** If your AI Shield adds an `Allow: /` in *another* group, and you have `Disallow: /` in the policy-key group, the rules live in different groups — they are combined per group, not globally. But within the same group `Allow` wins. Always check the actual file.
> ⚠️ **PHP 8.5:** test the plugin on 8.5. Use `false === $result` to check DB writes — `false >= 0` is **TRUE** in PHP.

**Bingbot page preferences in the head (via `wp_head`):**

```php
add_action('wp_head', function () {
    if (is_admin()) return;
    echo '<meta name="Bingbot" content="ai-training:disallow">' . "\n";
    echo '<meta name="Bingbot" content="ai-grounding:disallowextended">' . "\n";
});
```

**Send the header instead (recommended — it also covers PDFs and images):**

```php
add_action('send_headers', function () {
    header('X-Robots-Tag: Bingbot: ai-training:disallow', false);
    header('X-Robots-Tag: Bingbot: ai-grounding:disallowextended', false);
});
```

> `false` = **append**. Without it the second line overwrites the first. The Apache equivalent is `set` followed by `add`.

**The plugin must never write `noindex`.** That is a separate decision, and the most expensive action available.

### 5.5 Verification checklist

```bash
# 1. robots.txt exists and is correct
curl -sS https://example.se/robots.txt | head -40
curl -sS https://example.se/robots.txt | grep -c "User-agent: \*"

# 2. A UA rule gives 403, a real browser gives 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "GPTBot/1.1"  https://example.se/
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (X11; Linux x86_64) Chrome/140.0 Safari/537.36" https://example.se/

# 3. The header is present
curl -sSI https://example.se/ | grep -i "x-robots-tag"

# 4. Googlebot still gets 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)" https://example.se/

# 5. bingbot still gets 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)" https://example.se/
```

**If #2 returns 403 for *everything*:** check the status code, not just the body. A 17-byte 403 means the denial happened **before** WordPress started.

---

## 6. IP level: the right way to block a vendor's crawler

### 6.1 The basic rule

**Do not block a vendor's crawler at the ASN level.** The vendors' crawlers live in shared networks:

| Vendor | Where the crawler IPs live | What you would be blocking |
|---|---|---|
| Anthropic | AS16509 (Amazon) | Hundreds of thousands of tenants |
| Google | AS15169, AS396982 (Google Cloud) | All of Google |
| Bing | AS8075 | All of Microsoft |
| OpenAI | Mixed | — |

**The right instrument:** the CIDR list from the vendor, applied as a **conditional** block.

### 6.2 The vendors' published files

**Google — FIVE files (the union is needed):**

```
https://developers.google.com/static/crawling/ipranges/common-crawlers.json
https://developers.google.com/static/crawling/ipranges/special-crawlers.json
https://developers.google.com/static/crawling/ipranges/user-triggered-fetchers-google.json
https://developers.google.com/static/crawling/ipranges/user-triggered-fetchers.json
https://developers.google.com/static/crawling/ipranges/user-triggered-agents.json
```

> ⚠️ `googlebot.json` and `adsbot.json` **no longer exist** (renamed 2026-10).
> ⚠️ `gstatic.com/ipranges/goog.json` is Google's **general** list — **do not** use it as the basis for a crawler allow-list.
> ⚠️ Google's bot range **changed on 2026-10-18** from `192.178.6.0/23` + `192.178.8.0/22` to `192.178.0.0/15`. An allow-list from before that date is broken.

**Bing:** `https://www.bing.com/toolbox/bingbot.json` — `{"creationTime":…,"prefixes":[{"ipv4Prefix":…}]}`. 28 IPv4 prefixes, no IPv6. `creationTime` is stuck at 2024-01-03, so staleness is not obvious.

### 6.3 Conditional blocking (never an unconditional IP block)

```apache
# Block ONE crawler from ONE vendor - not the whole network
SetEnvIf Request_User-Agent "^(.*ClaudeBot.*)$" CLAUDEBOT=$1

RewriteCond %{ENV:CLAUDEBOT} (.*)
RewriteCond %{REMOTE_ADDR} ^(160\.79\.104\.|147\.162\.37\.) [OR]
RewriteCond %{REMOTE_ADDR} ^(2600:1f18:[0-9a-f]{1,4}:)
RewriteRule ^ - [F,L]
```

> **Why conditional:** the vendor can move its ranges, and an unconditional block of a vendor range that is later reused by another vendor blocks them straight out. With the condition on both UA and IP, a forged UA does not get through, and a legitimate vendor that moves causes a temporary leak instead of a permanent misfire.
>
> ⚠️ `SetEnvIf X-Test-ASN "(.*)" ASN=$1` — do **not** create a variable literally named `ENV:ASN`; that creates a variable called `ENV:ASN`. Use `ASN=$1`.
> ⚠️ `mod_setenvif` must be loaded or every request returns 500 (`Invalid command`).

### 6.4 Refresh routine

1. Fetch the vendor's file (version it: `claude-bots-2026-11-01.json`).
2. Diff it against the previous version.
3. Generate the rule.
4. Verify against a **control set**: 20–50 real vendor IPs → 403, and 100 random ordinary IPs → 200.
5. **0 HTTP 500.**

---

## 7. Advanced detection techniques

### 7.1 Tiers

| Tier | Signal | Cost | False-positive risk |
|---|---|---|---|
| **1** | UA token (robots.txt + .htaccess) | Low | Low (if the token is right) |
| **2** | Rate limiting per IP | Low | Low |
| **3** | Target path + UA (e.g. `/xmlrpc.php`) | Low | Near zero |
| **4** | JS challenge / browser fingerprint | Medium | Medium |
| **5** | ML on behaviour | High | High — requires training data |

**Recommendation: start with 1–3.** Tiers 4–5 produce false positives that cost you real readers.

### 7.2 Tier 2 — rate limiting

```nginx
limit_req_zone $binary_remote_addr zone=perip:10m rate=30r/m;
limit_req_zone $binary_remote_addr zone=strict:10m rate=5r/m;

server {
    # API and login: strict
    location ~ ^/(wp-admin|wp-login|xmlrpc\.php|wp-json) {
        limit_req zone=strict burst=10 nodelay;
        limit_req_status 429;
        proxy_pass http://127.0.0.1:8080;
    }
}
```

### 7.3 Tier 3 — target path + UA (the durable instrument)

> **The pattern outlives the IP address.** A GCP scanner that reads `/.env` and `/xmlrpc.php` changes address every time. A rule on the *pattern* catches the next IP without you knowing it.

```apache
# Critical files that should never be reachable over the web
RewriteCond %{REQUEST_URI} "^/(?:\.env|\.git/|xmlrpc\.php|\.aws/|wp-config\.php)" [NC]
RewriteRule ^ - [F,L]
```

**Known patterns from GCP secret-file scanners (measured in logs):**
`/xmlrpc.php` · `/api/` · `/.env` · `/wp-admin` · `/admin.php` · `/login.php` — typically 175–272 distinct paths per IP, with **102 successful 200s per IP** (they are reading your posts).

### 7.4 Tier 4 — JS challenge and fingerprinting

```javascript
// Measure a visitor's "authenticity" with a cheap computation.
(function () {
    const start = performance.now();
    const els = document.querySelectorAll('div');
    for (const el of els) {
        const s = getComputedStyle(el).getPropertyValue('transform');
    }
    const exec = performance.now() - start;

    // The core rule: a real browser fetches assets.
    // We measure it by seeing which resources have loaded.
    navigator.sendBeacon('/__fp', JSON.stringify({
        exec,
        elements: els.length,
        // Has the page fetched JS/CSS? Then it is a browser.
        resources: performance.getEntriesByType('resource')
            .filter(r => /\.(js|css|woff2?)(\?|$)/.test(r.name)).length
    }));
})();
```

**Interpretation (calibrated against real visitors, not assumptions):**

| Signal | Real browser | Script |
|---|---|---|
| HTML 200 **+** ≥1 asset fetch | ✅ | ❌ |
| HTML 200 **+** 0 asset fetches | ❌ | ✅ |
| `exec` < 10 ms | possible (warm cache) | likely |
| `exec` > 500 ms | possible (slow device) | possible |

> ⚠️ **Do not act on `exec` timing alone.** A slow phone can take 800 ms. **The number of fetched assets** is the more separating signal.

### 7.5 Tier 5 — ML on behaviour

```python
import numpy as np
from sklearn.ensemble import IsolationForest

class BotRisk:
    """
    Risk model that FAILS OPEN for human traffic.

    IMPORTANT ON CALIBRATION
    -----------------------
    sklearn's IsolationForest.decision_function() returns:
        negative = outlier  (anomalous)
        positive = inlier   (normal)
    ... and typically lives in the range [-0.3, +0.3], NOT [-1, +1].

    A naive 1/(1+exp(x)) on the raw value returns something around
    0.5 and never reaches any threshold. So we rescale the value around
    the model's own decision boundary (d = 0 -> p = 0.5) using SLOPE.
    With SLOPE = 12 the boundaries land roughly like this:
        d = -0.10  ->  p = 0.77
        d = -0.05  ->  p = 0.65
        d = +0.05  ->  p = 0.35
        d = +0.10  ->  p = 0.23
    SLOPE MUST be calibrated against a labelled ground truth (see the
    note under the thresholds) - otherwise the thresholds are meaningless.
    """

    SLOPE = 12.0

    def __init__(self, slope=None):
        self.model = IsolationForest(contamination=0.05, random_state=42)
        self.human_features = []
        self.fitted = False
        if slope is not None:
            self.SLOPE = float(slope)

    def features(self, req):
        return [
            min(req.get('assets', 0), 50),
            min(req.get('req_per_min', 0), 200) / 200.0,
            req.get('has_referer', 0),
            req.get('accepts_html', 0),
            min(req.get('sec_fetch_dest', 0), 1),
            req.get('cookie_jar_size', 0) / 50.0,
        ]

    def fit(self, samples):
        if len(samples) < 500:
            return False           # too little data -> not fitted
        self.model.fit(np.array(samples, dtype=float))
        self.human_features = samples
        self.fitted = True
        return True

    def score(self, req):
        if not self.fitted:
            return 0.0           # fail open: better no block than a wrong one
        d = float(self.model.decision_function([self.features(req)])[0])
        return float(1.0 / (1.0 + np.exp(self.SLOPE * d)))
```

**Decision thresholds:**

| Risk | Action |
|---|---|
| ≥ 0.85 | Block (403) + log |
| 0.60–0.85 | Rate limit + challenge |
| 0.35–0.60 | Log, observe |
| < 0.35 | Let through |

> **Calibrate the thresholds against a ground truth before you use them.** Run the model over a labelled sample (at least 200 real visitors, some with known bot signals) and adjust `SLOPE` until the 0.85 threshold sits at the share of bots you actually want to block. A threshold that never fires is worth as little as no threshold.
>
> **Training data:** `IsolationForest` with `contamination=0.05` on **human traffic only** learns "normality". But your "human" data probably already contains a fair number of bots. **Clean first, train second.** Otherwise the model learns that bots are normal.
>
> ⚠️ **An uncalibrated risk model is more dangerous than no model.** Always test against a ground truth: 200–500 known real visitors (including your own admin session) should score below 0.35. **A residential + login-heavy admin session = the owner, not a brute forcer.**

### 7.6 Corrections to the 2025 detection code

These are the actual bugs in the old example. They produced **false positives on ordinary readers**:

| Old code | Problem | Correct |
|---|---|---|
| `if 'Safari' in ua and 'Chrome' in ua: score += 0.3` | **Every Chrome UA contains "Safari"** → every Chrome user flagged | Remove the rule entirely |
| `required_fields = ['Mozilla','Windows','Chrome']` | **Every iPhone/iPad lacks "Windows" and "Chrome"** → every iOS user flagged | Require only `Mozilla` + a genuine browser token |
| `if chrome_version > 120: score += 0.1` | Every modern user is penalised — the signal is worthless | Remove |
| `suspicious_patterns = [r'bot|crawler|spider|scraper', r'GPT|Claude|ChatGPT', ...]` | `re.search` without escaping, and `Claude` matches "Claude" in other contexts | Use explicit vendor tokens with `\b` anchors |
| `if any(bot in ua for bot in self.ai_bot_uas)` (case-sensitive) | `gptbot` in lower case is not caught | Case-insensitive + explicit list |
| `request_count > 100` per minute → +0.4 | A reader loading 20 pages + assets passes 100/min | Count **pages**, not all requests, or raise the threshold |
| `redis_client.lpush(...)` into a list that grows unbounded | Memory leak | `LPUSH` + `LTRIM` to max 1000, or use Redis Streams with trimming |
| `interval_std < interval_mean * 0.1` → bot | A reader clicking 20 links at an even pace matches | Require > 30 requests before the pattern weighs |

---

## 8. Stealth scraping and anti-detection

Understanding the adversary's tools is the only way to know which traces are worth watching.

### 8.1 Rotating User-Agents

```python
import random, requests

class StealthSession:
    def __init__(self):
        self.session = requests.Session()
        self.pool = [
            {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
                              '(KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',
                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language': 'sv-SE,sv;q=0.9,en;q=0.8',
                'Accept-Encoding': 'gzip, deflate, br',
                'Upgrade-Insecure-Requests': '1',
            },
            {
                'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 '
                              '(KHTML, like Gecko) Version/26.0 Safari/605.1.15',
                'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language': 'sv-SE,sv;q=0.9',
                'Accept-Encoding': 'gzip, deflate, br',
            },
        ]

    def headers(self):
        h = random.choice(self.pool).copy()
        h['Accept-Language'] = random.choice(['sv-SE,sv;q=0.9', 'en-GB,en;q=0.8', 'de-DE,de;q=0.7'])
        return h
```

### 8.2 Headless browser with human-like behaviour

```javascript
const puppeteer = require('puppeteer');

async function humanLike(page, url) {
    await page.goto(url, { waitUntil: 'networkidle2' });

    // Move the mouse in curves, not straight lines
    for (let i = 0; i < 12; i++) {
        await page.mouse.move(
            100 + Math.random() * 800,
            100 + Math.random() * 600,
            { steps: 8 + Math.floor(Math.random() * 12) }
        );
        await new Promise(r => setTimeout(r, 80 + Math.random() * 400));
    }

    // Scroll down at varying speed with pauses
    await page.evaluate(async () => {
        for (let y = 0; y < document.body.scrollHeight; y += 300 + Math.random() * 400) {
            window.scrollTo(0, y);
            await new Promise(r => setTimeout(r, 200 + Math.random() * 800));
        }
    });
}
```

### 8.3 Proxy rotation and distributed crawling

```python
import random, time, requests
from itertools import cycle

class Rotator:
    def __init__(self, proxies):
        self.proxies = proxies
        self.used = set()

    def pick(self):
        avail = [p for p in self.proxies if p not in self.used] or list(self.proxies)
        p = random.choice(avail)
        self.used.add(p)
        return p

    def get(self, url, tries=3):
        for _ in range(tries):
            proxy = self.pick()
            try:
                r = requests.get(url, proxies={'http': proxy, 'https': proxy},
                                 timeout=10, headers=StealthSession().headers())
                if r.status_code == 200:
                    return r
                if r.status_code == 429:
                    time.sleep(random.uniform(30, 90))
            except requests.RequestException:
                self.used.add(proxy)
        return None
```

### 8.4 Multi-purpose crawlers and residential proxies

The genuinely hard cases are not datacenter IPs. They are:

- **Residential proxy networks** — traffic comes from *ordinary private connections* across an entire country (e.g. Swedish telecom ASNs).
- **IP rotation per request** — a new IP every 12–23 minutes.

> **This is why ASN-blocking is so weak against exactly those:** they operate in *access networks* (ISPs), not datacenters. Blocking an entire access ASN takes real readers with it.
>
> **The right answer against residential proxies is not IP blocking.** It is: rate limiting per IP, 2FA on login, and measuring the *pattern* (the same UA from hundreds of independent IPs within a short window = one network, not hundreds of readers).

---

## 9. Legal considerations

> ⚠️ **This is not legal advice.** This is a technical summary of the regulation as it stood on 2026-11-01.

### 9.1 EU AI Act, Article 53

The obligations sit with **general-purpose AI model providers**, not with you:

| Obligation | Meaning |
|---|---|
| **53(1)(c)** | A **copyright policy** that identifies and respects reservations of rights under DSM Directive Article 4(3) |
| **53(1)(d)** | A **public, sufficiently detailed summary of the training content**, using the AI Office template |

**The template** ("Template for the Public Summary of Training Content") was published **24 July 2025** after a public consultation with 430+ organisations.

**Deadlines:**
- From **2025-08-02**: models placed on the EU market must ship with the summary
- Models already on the market: **2027-08-02**

**Penalties:** up to **EUR 15 million or 3% of global turnover**, whichever is higher.

**The AI Office has enforcement and supervisory powers from August 2026.**

### 9.2 DSM Directive, Article 4(3) — reservation of rights

Rightsholders can **reserve the right against text and data mining** (TDM) "in an appropriate manner, such as by machine-readable means". The machine-readable means is **robots.txt**.

**This is exactly why robots.txt has legal significance and is not merely etiquette.** GPAI Code of Practice, measure 1.3:

> *"Signatories to the GPAI Code of Practice have committed to employ web crawlers that respect robots.txt and any subsequent version of this Protocol for which the IETF demonstrates that it is technically feasible and implementable by AI providers and content providers, including rightsholders."*

Measure 1.4: *"Mitigate the risk of copyright-infringing outputs by implementing appropriate and proportionate technical safeguards."*

**What this means for you:**

1. **robots.txt is the legally recognised way to reserve rights.** Publish it correctly, with named agents.
2. **Blocking only with a UA rule in .htaccess does not constitute a reservation** — it is not machine-readable for the provider, and the provider never sees it.
3. **A reservation requires the "rightsholder"** — on a blog that is you as the author, or your employer. Write down who holds the rights.
4. **The European Parliament (2026-07-27) states** that the Commission is committed to supporting the practical application of the rights-reservation mechanism, including robots.txt-based reservations, within AI Act Article 53.

### 9.3 Data protection (GDPR)

- **Personal data in training data** is a separate track. A training crawler that collects comments containing names and email addresses breaches GDPR if the data is processed without a legal basis.
- **TDM and GDPR can collide.** "Training allowed" for one AI agent token is not the same as permitting the processing of personal data.
- **After you block a bot**: consider whether log data containing IP addresses and UA strings needs to be erased, and how long you keep it.
- **The right to erasure** also applies to indexed AI answers to the extent the provider responds to requests — which is not guaranteed. Better not to let the content into training in the first place.

### 9.4 Copyright

- **Database right** (Directive 96/9/EC) gives the database producer the right to prevent the reproduction of a *substantial* part of the database. An AI crawler that builds a large local index from your site may fall under it.
- **Article protection** covers the text itself.
- **Known case law** (CJEU): *LAW360 v Google* (C-682/18) and *C-460/20 Cyando* — copyright protection covers not only literal copying but also **extraction** where the result "reproduces" the expression.
- This is **a legal mark, not a technical blocking mechanism.** The technology blocks; the court decides.

### 9.5 In practice: evidence

If you want to be able to pursue a complaint:

1. **Log the UA string, IP, referer, path, status, timestamp, bytes** — and keep the logs.
2. **Verify against the vendor's IP list** at the time of the request (so you can show "this really was a genuine GPTBot").
3. **Filter out your own traffic** (admin sessions, your own IPs) so the signal is clean.
4. **Separate "training" from "visits"** in the log — a crawler that only fetches `robots.txt` is not the same as one that reads your articles.
5. **Preserve robots.txt versions** — the file as it stood at the time of the complaint is the evidence.

### 9.6 Sweden and the EU

- **The CMA (UK)** forced Google's "Search generative AI control" — a textbook example of **regulation driving standardisation**.
- **The AI Office** (Commission) supervises Article 53 from August 2026.
- **The CMA requires page-level controls before March 2027** (today only property-level exists).
- **A company following robots.txt is a promise, not an obligation** — the legislation requires that the provider *could* respect a reservation, not that every provider does.

---

## 10. Monitoring and analytics

### 10.1 What you should actually measure

| Measurement | Tool | Why |
|---|---|---|
| Which UA tokens visit | Log analysis | The base for robots.txt |
| Which **ASN** they come from | `ip2asn` / RIPEstat | Detects "token on a foreign ASN" = forgery |
| Status code per UA | Log analysis | 403 = blocked, 200 = successful fetch |
| Bytes per UA | Log analysis | **A 200 with 40 kB = they read your article.** A 403 with 0 B = they never got in. |
| Assets per session | Server log / JS measurement | Separates browser from script |
| Target-path patterns | Log analysis | Finds scanners |

### 10.2 Log analysis — a working script

```python
#!/usr/bin/env python3
"""Summarises AI-crawler traffic from a Nginx/Apache access log."""

import re, sys, collections, ipaddress

AI_TOKENS = {
    'GPTBot': 'OpenAI', 'OAI-SearchBot': 'OpenAI', 'ChatGPT-User': 'OpenAI',
    'ClaudeBot': 'Anthropic', 'Claude-SearchBot': 'Anthropic', 'Claude-User': 'Anthropic',
    'anthropic-ai': 'Anthropic', 'PerplexityBot': 'Perplexity', 'Perplexity-User': 'Perplexity',
    'Google-Extended': 'Google', 'GoogleOther': 'Google', 'Googlebot': 'Google',
    'bingbot': 'Microsoft', 'Applebot': 'Apple', 'Applebot-Extended': 'Apple',
    'meta-externalagent': 'Meta', 'meta-webindexer': 'Meta', 'meta-externalfetcher': 'Meta',
    'CCBot': 'CommonCrawl', 'Bytespider': 'ByteDance', 'Amazonbot': 'Amazon',
    'cohere-ai': 'Cohere', 'MistralAI-Training': 'Mistral', 'ExaSearchBot': 'Exa',
}

LOG = re.compile(
    r'(?P<ip>\S+) \S+ \S+ \[(?P<ts>[^\]]+)\] "(?P<method>\S+) (?P<path>\S+) [^"]*" '
    r'(?P<status>\d{3}) (?P<bytes>\S+) "(?P<ref>[^"]*)" "(?P<ua>[^"]*)"'
)

def classify(ua):
    for token, vendor in AI_TOKENS.items():
        if token.lower() in ua.lower():
            return token, vendor
    return None, None

def main(path):
    hits = collections.defaultdict(lambda: {'n': 0, 'ok': 0, 'bytes': 0, 'ips': set(), 'paths': set()})
    other = {'n': 0, 'ok': 0, 'bytes': 0}

    with open(path, errors='replace') as fh:
        for line in fh:
            m = LOG.search(line)
            if not m:
                continue
            ua = m['ua']
            token, vendor = classify(ua)
            if not token:
                other['n'] += 1
                other['ok'] += m['status'] == '200'
                other['bytes'] += int(m['bytes']) if m['bytes'].isdigit() else 0
                continue
            d = hits[(token, vendor)]
            d['n'] += 1
            d['ok'] += m['status'] == '200'
            d['bytes'] += int(m['bytes']) if m['bytes'].isdigit() else 0
            d['ips'].add(m['ip'])
            d['paths'].add(m['path'].split('?')[0])

    print(f"{'TOKEN':<22}{'VENDOR':<14}{'REQ':>7}{'200':>7}{'BYTES':>12}{'IPS':>7}  {'SUCCESSFUL 200'}")
    for (token, vendor), d in sorted(hits.items(), key=lambda kv: -kv[1]['bytes']):
        rate = (d['ok'] / d['n'] * 100) if d['n'] else 0
        flag = '  <== READ CONTENT' if d['ok'] and d['bytes'] > 100_000 else ''
        print(f"{token:<22}{vendor:<14}{d['n']:>7}{d['ok']:>7}{d['bytes']:>12}{len(d['ips']):>7}  {rate:5.1f}%{flag}")
    print(f"\nOther traffic: {other['n']} req, {other['ok']} st 200, {other['bytes']} B")

if __name__ == '__main__':
    main(sys.argv[1] if len(sys.argv) > 1 else '/var/log/nginx/access.log')
```

**The key line:** `SUCCESSFUL 200` + a large byte count = the bot **read** your content. A 403 is not a problem — a 200 with 40 kB is.

### 10.3 Dashboard

The old Streamlit dashboard in the 2025 guide worked, but it relied on Redis lists that grew without bound and used bare `except:` clauses. A minimal, robust version:

```python
import redis, json, collections
from datetime import datetime, timedelta, timezone

r = redis.Redis(host='localhost', port=6379, db=0)

def record(ip, ua, status, bytes_sent, path):
    key = 'traffic'
    r.lpush(key, json.dumps({
        'ts': datetime.now(timezone.utc).isoformat(),
        'ip': ip, 'ua': ua, 'status': status,
        'bytes': bytes_sent, 'path': path,
    }))
    r.ltrim(key, 0, 100_000)          # <-- bound the list

def stats(hours=24):
    cutoff = (datetime.now(timezone.utc) - timedelta(hours=hours)).isoformat()
    rows = []
    for raw in r.lrange('traffic', 0, 100_000):
        try:
            d = json.loads(raw)
        except json.JSONDecodeError:
            continue
        if d['ts'] >= cutoff:
            rows.append(d)
    return rows

def summary(rows):
    by_status = collections.Counter(d['status'] for d in rows)
    by_bytes  = collections.Counter()
    for d in rows:
        by_bytes[d['ua'][:60]] += d['bytes']
    top = by_bytes.most_common(15)
    return {
        'total': len(rows),
        'status': dict(by_status),
        'top_ua_by_bytes': top,
        'unique_ips': len({d['ip'] for d in rows}),
        'total_bytes': sum(d['bytes'] for d in rows),
    }
```

**Key point:** `LPUSH` without `LTRIM` fills Redis memory until the server falls over. This is exactly the kind of "silent failure" a guide cannot catch.

### 10.4 Weekly routine

| Day | Task |
|---|---|
| Monday | Run the log analysis. Compare against last week. |
| Tuesday | Check for new UA tokens (new vendors). Update robots.txt if needed. |
| Wednesday | Verify that Googlebot/Bingbot still get 200 from the server. |
| Thursday | Fetch the vendors' IP files and diff against the previous version. |
| Friday | Read Search Console → Generative AI performance report (if you are Included). |

---

## 11. Checklist

### 11.1 Publishing (do this)

- [ ] `robots.txt` has **named** groups for every training crawler
- [ ] `robots.txt` has **no** `User-agent: *` + `Disallow: /`
- [ ] `robots.txt` has the group `User-Agent: __usage_ai-training` + `Disallow: /`
- [ ] Search crawlers and user-triggered fetches are **allowed**
- [ ] `<meta name="Bingbot" content="ai-training:disallow">` is present (or `X-Robots-Tag`)
- [ ] `<meta name="Bingbot" content="ai-grounding:disallowextended">` is present
- [ ] **Bing Webmaster Tools:** if you use `noarchive`/`nocache`, record the temporary grounding preference **before 2027-03-01**
- [ ] Search Console → Settings → Search generative AI: decide Include/Exclude
- [ ] `sitemap.xml` exists and is declared

### 11.2 Server (do this)

- [ ] UA rule in .htaccess/nginx with `RewriteEngine On`
- [ ] No cond line longer than 8 191 bytes
- [ ] `Header set` + `Header add` (not two `set`)
- [ ] Rate limiting per IP, not per UA
- [ ] `add_header` placed before `return` in nginx
- [ ] Target-path rules for `/.env`, `/xmlrpc.php`, `/.git/`, `/wp-config.php`
- [ ] `2FA` on login
- [ ] No login links in email

### 11.3 Verification (do this)

- [ ] `GPTBot` → **403**
- [ ] `Mozilla/5.0 … Chrome/140.0 …` → **200**
- [ ] `Googlebot` → **200**
- [ ] `bingbot` → **200**
- [ ] `Applebot` → **200**
- [ ] `OAI-SearchBot` → **200**
- [ ] `ChatGPT-User` → **200**
- [ ] `PerplexityBot` → **200**
- [ ] No 500 status anywhere
- [ ] robots.txt read from **the server** (not from your laptop)

### 11.4 Ongoing

- [ ] Weekly log analysis + comparison
- [ ] Vendor IP lists diffed monthly
- [ ] Models/crawlers refreshed quarterly
- [ ] Guide updated when vendors change their deadlines

---

## 12. Future trends and threats

### 12.1 Signed requests become the norm

`Signature-Agent` / RFC 9421 / "Web Bot Auth" lets a vendor **prove** that it is who it claims to be — and lets you verify that cryptographically. It kills UA spoofing as an effective attack.

**Consequence:** a UA rule gradually loses value, and an IP-verified rule gains it.

### 12.2 Agentic browsers go mainstream

Comet has ~18 M MAU. Once agentic browsers are mainstream, telling "AI traffic" apart from "human traffic" gets harder — and a UA blocklist for AI bots becomes increasingly counterproductive.

**Consequence:** the instrument moves from *crawlers* to *agents*. What counts is *how* an agent behaves, not *who* it claims to be.

### 12.3 Paid crawling

Cloudflare's Pay per Crawl, direct pricing via `crawler-price`, and the EU's discussions on "licensing AI training" make it likely that crawling becomes a market.

**Consequence:** you do not necessarily need to block — you can *charge*. A 402 with contact details is a business decision, not a technical measure.

### 12.4 Standardisation drives the vendors

The AIPREF working group, the `ai.txt` draft, the Content Signals initiative and the GPAI Code of Practice all point the same way: **machine-readable policy declarations**. Whoever is ahead of the curve may one day get a single standardised "AI policy" field and a single header.

**Consequence:** publish `/.well-known/ai.txt` now, even though nobody reads it — it is free and it positions you.

### 12.5 Regulation moves things

CMA's demand for page-level controls before March 2027, AI Office supervision from August 2026, and Article 53(1)(c)'s requirement that providers respect rights reservations.

**Consequence:** robots.txt becomes *legally relevant*, not just etiquette. A correct file is a defence.

### 12.6 Threats that do not go away

- **Residential proxy networks** in access networks → ASN blocking is ineffective
- **IP rotation per request** → per-IP lists are ineffective
- **robots.txt-ignoring bots** (`Bytespider`) → policy is not enforcement
- **Screenshots and rendering** → costs you money, and there is no UA to block

---

## 13. What was WRONG in the 2025 version

This is the honest list. Everything below was in the guide you sent and is **either wrong or dangerous**:

| # | Claim in the 2025 guide | Reality |
|---|---|---|
| 1 | *"Google Extended can block your website from Google search!"* | **Wrong.** Google-Extended covers training/grounding in Gemini, not Google Search. |
| 2 | *"Anthropic IP ranges: `RewriteCond %{REMOTE_ADDR} ^3\.[67]\. [OR]`"* | **Dangerous.** `3.0.0.0/8` is Amazon, `3.67.x` is Google. It blocks Google/Amazon, not Anthropic. Anthropic's ranges sit in AS16509. |
| 3 | *"OpenAI IP range: `52.230.152.` / `20.171.206.`"* | **Outdated and wrong** — OpenAI publishes per-crawler files (`gptbot.json` etc.). |
| 4 | `RedirectMatch 403 "proxy\|API proxy\|HTTP proxy\|…"` | **Does not work as intended.** It matches the *URL path*, not the UA or referer. |
| 5 | `if ('Safari' in ua and 'Chrome' in ua)` → suspicious | **Every Chrome.** Mass false positives. |
| 6 | `required_fields = ['Mozilla','Windows','Chrome']` | **Every iOS user.** Mass false positives. |
| 7 | `if chrome_version > 120` → suspicious | Punishes every modern user. Worthless signal. |
| 8 | nginx `limit_req_zone` in `server {}` | **Invalid** → nginx does not start. |
| 9 | nginx `limit_req_zone $http_user_agent` | Everyone sharing a UA shares a bucket → real readers get rate-limited. |
| 10 | nginx `add_header` after `return` | **Never runs.** |
| 11 | .htaccess without `RewriteEngine On` | The rule is dead. |
| 12 | `User-agent: *` as the "block all OpenAI" example | Also blocks Googlebot, Bingbot and your readers. |
| 13 | `Meta AI`, `SAM 2`, `DALL-E 3`, `V-JEPA` as UA tokens | **Fiction.** No such bots exist. |
| 14 | `GPT-crawler`, `Microsoft Copilot`, `ChatGPT` as UA tokens | Outdated; the real tokens are in §1.2. |
| 15 | `"Content-Usage: ai=n"` as a working directive | A draft; no vendor reads it. |
| 16 | `Timpibot`, `peer39_crawler`, `FriendlyCrawler` as "categories" | Mixed real and half-finished; no UA verification. |
| 17 | Redis lists growing without bound | Memory leak. |
| 18 | "ChatGPT Atlas" as an active AI browser | **Retired 2026-08-09.** |
| 19 | "Arc" as an active AI browser under development | Frozen since 2025-05; wound down 2026-11-23 / 2026-12-22. |
| 20 | "Kimi K2", "GLM 4.6", "GPT-5.1" as current flagships | All older; see §1.1. |
| 21 | No 2026 control signals | All of §4 was missing. |
| 22 | No measurement method, no lab verification | A rule that has not been tested is a hypothesis. |

**The pattern:** the old guide was a *mixture of tips* without verification. The new one is built around **the vendors' own documentation**, with dates.

---

## 14. Sources

**Standards and drafts**
- [draft-kelley-aipref-training-preference-signal-00](https://www.ietf.org/archive/id/draft-kelley-aipref-training-preference-signal-00.html) (2026-10-30)
- [draft-ietf-aipref-vocab-08](https://datatracker.ietf.org/doc/html/draft-ietf-aipref-vocab-08) (2026-09-14)
- [draft-ietf-aipref-attach](https://datatracker.ietf.org/doc/draft-ietf-aipref-attach/)
- [draft-car-ai-txt-wellknown-00](https://datatracker.ietf.org/doc/draft-car-ai-txt-wellknown/00/) (2026-06-12)
- [RFC 9309 — Robots Exclusion Protocol](https://www.rfc-editor.org/rfc/rfc9309)
- [RFC 9421 — HTTP Message Signatures](https://www.rfc-editor.org/rfc/rfc9421)

**Vendors**
- [OpenAI — Overview of OpenAI Crawlers](https://platform.openai.com/docs/bots/)
- [Anthropic — Crawlers documentation](https://support.anthropic.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler)
- [Bing — New AI controls (2026-10-30)](https://blogs.bing.com/search/feed/)
- [Google — Robots meta tag specification](https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag)
- [Google — Search generative AI control](https://support.google.com/webmasters/answer/16908024)
- [Google — Generative AI performance report](https://support.google.com/webmasters/answer/16984139)
- [Google — Crawler IP ranges](https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers)
- [Cloudflare — AI Crawl Control](https://developers.cloudflare.com/ai-crawl-control/)
- [Cloudflare — Your site, your rules (2026-07-01)](https://blog.cloudflare.com/content-independence-day-ai-options)

**Law**
- [EU AI Act — Article 53](https://ai-act-service-desk.ec.europa.eu/en/ai-act/article-53)
- [Template for the Public Summary of Training Content (2025-07-24)](https://digital-strategy.ec.europa.eu/en/policies/contents-gpai)
- [European Parliament — resolution 2026-07-27](https://data.europarl.europa.eu/distribution/doc/SP-2026-07-27-TA-10-2026-0066_en.docx)
- [GPAI Code of Practice](https://digital-strategy.ec.europa.eu/en/policies/contents-code-gpai)

**Reference lists**
- [ai.robots.txt (GitHub)](https://github.com/ai-robots-txt/ai.robots.txt) — 170+ crawlers
- [Dark Visitors](https://darkvisitors.com)
- [Patrick Stox — Web Crawler & AI Bot Reference](https://patrickstox.com/bots/)
- [QuanticData — AI Crawler User Agent List](https://quanticdata.io/blog/ai-crawler-user-agent-list/)

**Model comparisons**
- [Artificial Analysis](https://artificialanalysis.ai/) · [LLM Benchmark](https://llmbenchmark.ai/) · [OutYet.ai](https://outyet.ai/models)

-----

*This guide is a living document. The AI landscape moves in weeks — always check the vendors' own documentation before you deploy. 
#UPDATED 2027