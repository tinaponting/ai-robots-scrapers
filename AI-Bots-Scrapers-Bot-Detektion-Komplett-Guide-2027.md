# AI-Bots, Scrapers och Bot-Detektion — Komplett guide 2027

---

## 📑 Innehållsförteckning

0. [Det här måste du läsa först](#0-det-här-måste-du-läsa-först)
1. [AI-plattformar och språkmodeller (nov 2026)](#1-ai-plattformar-och-språkmodeller-nov-2026)
2. [AI-webbläsare och AI-agenter](#2-ai-webbläsare-och-ai-agenter)
3. [AI-crawlers: den kompletta katalogen](#3-ai-crawlers-den-kompletta-katalogen)
4. [Styrsignalerna i detalj](#4-styrsignalerna-i-detalj)
5. [Implementera skydd](#5-implementera-skydd)
6. [IP-nivå: rätt sätt att blockera en leverantörs crawler](#6-ip-nivå-rätt-sätt-att-blockera-en-leverantörs-crawler)
7. [Avancerade detektionstekniker](#7-avancerade-detektionstekniker)
8. [Stealth-scraping och anti-detektion](#8-stealth-scraping-och-anti-detektion)
9. [Juridiska aspekter](#9-juridiska-aspekter)
10. [Monitoring och analytics](#10-monitoring-och-analytics)
11. [Checklista](#11-checklista)
12. [Framtida trender och hot](#12-framtida-trender-och-hot)
13. [Vad som var FEL i 2025-versionen](#13-vad-som-var-fel-i-2025-versionen)
14. [Källor](#14-källor)
15. [Uppdateringslogg](#15-uppdateringslogg)

---

## 0. Det här måste du läsa först

**En gate som failar allt är en gate, inte datan.** Det är den viktigaste regeln i hela den här guiden, och den gäller lika mycket på en UA-regel som på en ASN-lista. Om ett filter släpper igenom 100 % av de riktiga läsarna så fungerar det inte — det blockerar bara dig själv.

### 0.1 Sanningsmatrisen: vad som faktiskt läses

Det mesta som cirkulerar på nätet om "hur man blockerar AI-bots" är **dött**. Här är matrisen, verifierad mot leverantörernas egen dokumentation 2026-11-01.

| Signal | Var den läses | Vem läser den | Vad den faktiskt stoppar | Status |
|---|---|---|---|---|
| `User-agent: <token>` + `Disallow: /` i robots.txt | `robots.txt` | Bara den crawler vars UA-token namnges | Att crawlen får hämta sidan | ✅ Fungerar, om token är rätt |
| `User-Agent: __usage_ai-training` + `Disallow: /` | `robots.txt` | Anthropic (live), OpenAI (inom några månader), Microsoft (från 2027-02-01), Google (tidigt 2027) | AI-träning — och bara träning | ✅ Nytt, delat token (2026-10-30) |
| `<meta name="Bingbot" content="ai-training:disallow">` | Sidhuvudet i HTML | Bingbot / Microsoft | Microsoft-träning, **per sida** | ✅ Från 2027-02-01 |
| `<meta name="Bingbot" content="ai-grounding:disallow">` | Sidhuvudet i HTML | Bingbot / Microsoft | Microsoft-grounding (Copilot, AI Mode, M365) | ✅ Från 2027-02-01 |
| `X-Robots-Tag: Bingbot: ai-training:disallow` | HTTP-svarhuvud | Bingbot / Microsoft | Samma som meta-taggen | ✅ Från 2027-02-01 |
| `<meta name="googlebot" content="nosnippet">` | Sidhuvudet i HTML | Google | Att sidan används som direktinput i AI Overviews / AI Mode | ✅ Fungerar nu — **men** den vanliga sökrubriken försvinner också |
| `Google-Extended` + `Disallow: /` i robots.txt | `robots.txt` | Google | Gemini-träning + Gemini/Vertex-grounding | ✅ Fungerar — **påverkar INTE Google-sök** |
| Search Console → Settings → **Search generative AI** → Exclude | Google Search Console | Google | AI Overviews, AI Mode, generativ Discover | ✅ Globalt sedan 2026-08-31 |
| `User-agent: *` + `Disallow: /` | `robots.txt` | Alla som inte har en egen grupp | **Alla** — inklusive dina riktiga läsare | ⚠️ Farligt, se §5.1 |
| `<meta name="gptbot" content="noindex">` | Sidhuvudet i HTML | — | Ingenting | ❌ Dött syntax |
| `noai` / `noimageai` | meta eller header | Endast ett fåtal datasetverktyg (t.ex. img2dataset) | Ingenting i Google/Bing/OpenAI/Anthropic | ❌ Aldrig implementerat |
| `noml` / `nosummary` | meta | — | Ingenting | ❌ Borttagna ur Googles spec |
| `noarchive` / `nocache` | meta | Bing (historiskt) — **inte** Google | Microsoft-träning, tills **2027-03-01** | ⚠️ Utgår |
| `NoCrawl: Microsoft-officially-supported-ai-agents` | — | — | Ingenting | ❌ Finns inte |
| `Disallow: /` i en `User-agent: *`-grupp | `robots.txt` | Alla | All crawling | ⚠️ Farligt |

### 0.2 De fem saker folk blir fel på

1. **En UA-sträng är ett påstående, inte ett bevis.** Alla kan skicka `GPTBot` i User-Agent. En UA-regel blockerar bara den som är *lat nog att ljuga*.
2. **En leverantörs crawler-IP-lista ligger INTE i leverantörens eget ASN.** Anthropics /22 ligger inne i AS16509 (Amazon). Googles ligger i AS15169 och AS396982. **ASN-blocka aldrig en leverantörs crawler** — du blockerar då tusentals andra hyresgäster i samma nät.
3. **`Google-Extended` påverkar inte din synlighet i Google Sök.** Detta är den mest spridda missförståelsen i hela ämnet. Google-Extended gäller *träning* av Gemini och grounding i Gemini/Vertex. `Googlebot` styr indexering.
4. **Meta-taggar läses bara av Google, Bing och Apple.** `GPTBot`, `ClaudeBot`, `CCBot`, `Amazonbot`, `meta-externalagent` och `Bytespider` läser **bara robots.txt**. En `<meta name="gptbot">` gör ingenting.
5. **robots.txt styr *hämtning*, inte indexering.** En crawler som robots.txt utesluter ser aldrig din `noindex` — regeln ignoreras tyst.

### 0.3 Detektionsinstrumentet — mät innan du blockerar

Innan du blockerar en UA, ett referer eller ett ASN: **behandla instrumentet som misstänkt, inte datan.**

| Test | Verktyg | Tolkning |
|---|---|---|
| **Fingeravtrycksprovet** | Hämta en HTML-sida + minst en JS/CSS-bild | `HTML 200 + ≥1 asset-hämtning` = riktig browser. `HTML 200 + 0 assets` = skript. |
| **Referer är ett påstående** | Chrome skickar bara `https://www.google.com/` | En regel på referer över-fyrar. Använd fingeravtrycksprovet för att avgöra. |
| **Body-storlek = lagerfingeravtryck** | 13 B = edge-deny · 17 B = samma, brotli · ~4,4 kB = WP-sida · 0 B = PHP `header()`+`exit` | Läs **statuskoden**, inte bara brödtexten. |
| **Storleksordning på allow-listan** | Kontrollera *seedaden* i allow-listorna, inte bara policyn | En allow-seed som rymmer `safari` släpper igenom en riktig `Applebot`. |

---

## 1. AI-plattformar och språkmodeller (nov 2026)

### 1.1 Aktuella flaggmodeller

| Leverantör | Aktuell flaggmodell | Släppt | Not |
|---|---|---|---|
| **OpenAI** | GPT-6 Astra | 2026-09-03 | 1,05 M tokens kontext; OSWorld 2.0 76,6 %; Cyber-*"Critical"*-betyg i Preparedness Framework (delvis gate:at) |
| | GPT-6.1 Sol | 2026-09-29 | Annonserad på DevDay; bäst pris/prestanda enligt oberoende mätningar |
| | GPT-6 Sol / GPT-6 Luna / GPT-6.1 Terra | 2026-09-22 | Utbyggnad av GPT-6-familjen |
| | GPT-5.6 Sol / Terra | 2026-07 | Föregångare; Atlas-nedläggningen annonserades i samma release |
| | GPT-5.2 / GPT-5.2-Codex | 2025-12 | Fortfarande i bruk |
| **Anthropic** | Claude Opus 5.5 | 2026-09-22 | $4/$20 per MTok; 1 M kontext; Claude 5.5-familjens första Opus |
| | Claude Sonnet 5.5 | 2026-09-29 | |
| | Claude Haiku 5.5 | 2026-10 | |
| | Claude Fable 5.1 / Mythos 5.1 | 2026 | |
| **Google** | Gemini 4 Carbon | 2026-10-28 | **Begränsad** till säkerhetsforskare via Fairwind; #1 på Artificial Analysis Intelligence Index v5.0 (59) |
| | Gemini 4 Argon | 2026-10-01 | Allmänt tillgänglig |
| | Gemini 3.8 Flash | 2026 | |
| **Alibaba** | Qwen3.8 Max | 2026-08-26 | |
| **DeepSeek** | DeepSeek V4.1 Flash | 2026-10 | Bästa modellen med öppna vikter |
| **Z.AI** | GLM-5.3 | 2026 | |
| **Moonshot** | Kimi K3.1 Pro | 2026-10-23 | #4 på Artificial Analysis; bästa öppna vikter |
| **xAI** | Grok 4.6 | 2026 | |
| **Meta** | Muse Spark 1.1 / Muse Wonder | 2026 | |

> **Märk:** räkneverden sprider sig. Gemini 4 Carbon leder indexet men är inte allmänt tillgänglig; Opus 5.5 leder det du faktiskt kan köpa. OpenAI:s egen jämförelse (Astra 59,3 % vs Opus 5 55,5 %) använder en äldre indexversion — siffrorna är inte jämförbara med v5.0.

### 1.2 Leverantörernas crawler-token (det du skriver i robots.txt)

| Leverantör | Träning | Sök/index | Användarutlöst hämtning | Övrigt |
|---|---|---|---|---|
| OpenAI | `GPTBot` | `OAI-SearchBot` | `ChatGPT-User` | `OAI-AdsBot` (annonsvalidering) |
| Anthropic | `ClaudeBot`, `anthropic-ai` (äldre) | `Claude-SearchBot` | `Claude-User` | `Claude-Web` (äldre) |
| Google | `Google-Extended` | `Googlebot`, `GoogleOther` | `Google-Read-Aloud`, `APIs-Google` | `Google-CloudVertexBot` |
| Perplexity | — | `PerplexityBot` | `Perplexity-User` | |
| Meta | `meta-externalagent` | `meta-webindexer` | `meta-externalfetcher` | `FacebookBot`, `facebookexternalhit` |
| Apple | `Applebot-Extended` | `Applebot` | — | |
| Amazon | `Amazonbot` | `Amazonbot` | — | `Amzn-SearchBot` |
| Common Crawl | `CCBot` | — | — | Öppet korpus som tredje part återanvänder |
| ByteDance | `Bytespider` | — | — | |
| Cohere | `cohere-ai` | — | — | |
| Mistral | `MistralAI-Training` | — | `MistralAI-User` | |
| DuckDuckGo | — | `DuckAssistBot` | — | |
| Exa | — | `ExaSearchBot` | `ExaUser` | Signerar med RFC 9421 |
| Apple/Google/Microsoft | — | `Applebot`, `Googlebot`, `bingbot` | — | **Bannlyser aldrig i grupp med träningscrawlers** |

### 1.3 Kina och övriga open source

```
DeepSeekBot, Qwen, qwen3, Kimi, KimiBot, GLM, MiniMax, Doubao, Baiduspider, PetalBot
```

⚠️ **PetalBot** (Huawei) respekterar inte robots.txt konsekvent och **PetalBot** ≠ `Baiduspider`. `Baiduspider` är en vanlig sökmotor och bör hanteras som Google/Bing.

---

## 2. AI-webbläsare och AI-agenter

> **Detta är den viktigaste nya kategorin sedan 2024.** En AI-agentisk webbläsare är en **riktig läsare**: den kör JavaScript, hämtar assets, följer cookies och skickar referer. Om du blockerar den blockerar du trafik.

### 2.1 Status per browser (nov 2026)

| Browser | Status | Plattformar | Priser | Kommentar |
|---|---|---|---|---|
| **Perplexity Comet** | Aktiv, standardsvar | macOS, Windows, iOS, Android | Gratis (Pro $20, Max $200) | ~18 M MAU midsommaren 2026; bästa agentiska browsern |
| **Dia** | Aktiv (Arc-efterträdare) | macOS GA, Windows beta | Gratis + betalplan | Har **ingen** agentläge — smartare gränssnitt, inte autonom exekutorering |
| **Brave + Leo** | Aktiv, assistiv | Alla plattformar | Gratis, Leo Premium $14,99/mån | On-device, integritetsfokus, ingen autonom agent |
| **Opera Neon** | Aktiv, agentisk | Desktop | $19,99/mån (även gratisnedladdning sedan aug 2026) | MCP-connector för Claude/ChatGPT (2026-03-31) |
| **ChatGPT Atlas** | ❌ **Nedlagd 2026-08-09** | — | — | Meddelat 2026-07-09. Flyttat till ChatGPT desktop-app + Chrome-tillägg. Data överfördes **inte**. |
| **Arc** | ⚠️ Fryst sedan 2025-05 | macOS, Windows | Gratis | Inga nya konton sedan 2026-10-22; Arc Search tappar AI + login + sync 2026-11-23; macOS/Windows stop 2026-12-22. Atlassian köpte The Browser Company. |
| **Edge + Copilot** | Aktiv, inbyggd | Windows, macOS, iOS, Android | Gratis | Separat "Copilot Mode" retiremaj 2026 |
| **Chrome + Gemini** | Aktiv, inbyggd | Alla | Gratis | ~66–70 % av världens browsertrafik går via Chrome |
| **Firefox AI Window** | Aktiv, inbyggd | Alla | Gratis | |
| **Opera One (R3)** | Aktiv | Alla | Gratis | Sidkontext medveten sedan 2026-01-15; tre assistenter i sidfältet |
| **Arc Search** | ⚠️ Avveckling | iOS, Android | Gratis | "Browse for Me" försvinner 2026-11-23 |
| Övriga | Fellou, Genspark Browser, BrowserOS | | | Nisch |

### 2.2 Varför agentiska browsrar ändrar bilden

En agentisk browser som Comet eller Dia:

- hämtar HTML **och** JS/CSS/images → **fingeravtrycksprovet ger 200 + assets = riktig läsare**
- har `User-Agent` som en vanlig Chrome/Safari-UA → **en UA-regel på "bot|crawler|scraper" fångar ingenting**
- skickar `Sec-Fetch-*`, `Accept-Language`, klienthints → dessa är starkare signaler än UA
- kan logga in → sessionsbeteende liknar owner

**Regel:** blockera **aldrig** på basis av att en UA "låter som en bot" om du inte kan skilja den från en människa med samma UA. Bättre: blockera på *beteende* (se §7) eller på *mål*.

---

## 3. AI-crawlers: den kompletta katalogen

### 3.1 De tre jobben — detta är den viktigaste uppdelningen

| Jobb | Vad boten gör | Blockera? | Varför |
|---|---|---|---|
| **Träning** | Samlar sidor för att träna/uppdatera en modell | ✅ Normalt ja | Noll referral-trafik. Det är skräp för dig. |
| **Sök & index** | Bygger en index för att svara med källor | ⚠️ Resonera | Kan ge referral-trafik och citat. |
| **Användarutlöst hämtning** | Hämtar en sida *nu* för att en användare frågat | ❌ Normalt nej | Hög intent, ofta riktig trafik. |
| **Annonsvalidering** | Verifierar att annonslandningssidor är säkra | ❌ Nej | Annonserfunktionen |

**Att blockera träningscrawlern tar inte bort någon besökare.** Att blockera sökcrawlern gör det — och då förlorar du citat och trafik.

### 3.2 Katalog (verifierad 2026-10/11)

| Token | Operatör | Jobb | Respekterar robots.txt | IP-lista publicerad | Rekommendation |
|---|---|---|---|---|---|
| `GPTBot` | OpenAI | Träning | Ja | `openai.com/gptbot.json` (18–21 prefix) | Blockera |
| `anthropic-ai` | Anthropic | Träning (äldre) | Ja | `claude.com/crawling/bots.json` | Blockera (legacy) |
| `ClaudeBot` | Anthropic | Träning | Ja | samma (28 prefix) | Blockera |
| `Claude-SearchBot` | Anthropic | Sök/citat | Ja | samma | Resonera — ny 2026, ger trafik |
| `Claude-User` | Anthropic | Användarutlöst | Ja | samma | Låt igenom |
| `OAI-SearchBot` | OpenAI | Sök/citat | Ja | `openai.com/searchbot.json` (35–39 prefix) | Låt igenom om du vill ha citat |
| `ChatGPT-User` | OpenAI | Användarutlöst | Ja | `openai.com/chatgpt-user.json` (286 prefix) | Låt igenom |
| `OAI-AdsBot` | OpenAI | Annonsvalidering | Ja | `openai.com/adsbot.json` (2 prefix) | Låt igenom |
| `Google-Extended` | Google | Träning + grounding | Ja | Nej (kontrolltoken, ingen egen bot) | Blockera om du vill |
| `GoogleOther` | Google | Generell AI-crawl | Ja | `common-crawlers.json` | Blockera (noll trafik) |
| `Google-CloudVertexBot` | Google | Vertex-grounding | Ja | `common-crawlers.json` | Resonera |
| `Applebot-Extended` | Apple | Träning | Ja | `applebot.json` | Blockera om du vill |
| `Applebot` | Apple | Sök/Spotlight/Siri | Ja | `applebot.json` | Låt igenom |
| `CCBot` | Common Crawl | Öppet korpus | Ja | — | Blockera (används av tredje part) |
| `meta-externalagent` | Meta | Träning + index | Ja | — | Blockera |
| `meta-webindexer` | Meta | Sök för Meta AI | Ja | — | Resonera |
| `meta-externalfetcher` | Meta | Användarutlöst | **Kan kringgå** | — | Låt igenom |
| `Amazonbot` | Amazon | Sök/Alexa + AI | Ja | `amazonbot` | Blockera träning, låt sök |
| `Amzn-SearchBot` | Amazon | Sök | Ja | — | Låt igenom |
| `Bytespider` | ByteDance | Träning | **Nej — dokumenterade brott** | — | Blockera |
| `cohere-ai` | Cohere | Träning | Ja | — | Blockera |
| `PerplexityBot` | Perplexity | Index | **Omtvistat** | `perplexity.ai/perplexitybot.json` (13 prefix) | Resonera |
| `Perplexity-User` | Perplexity | Användarutlöst | Kan kringgå | `perplexitybot.json` (10 prefix) | Låt igenom |
| `ExaSearchBot` / `ExaUser` | Exa | Sök / hämtning | Ja (men `ExaUser` saknar egen grupp) | **Nej** — hyr IP och roterar | UA-regel, inte IP-block |
| `DuckAssistBot` | DuckDuckGo | Sök | Ja | 486 prefix | Låt igenom |
| `MistralAI-Training` | Mistral | Träning | Ja | — | Blockera |
| `MistralAI-User` | Mistral | Användarutlöst | Ja | — | Låt igenom |
| `YouBot` | You.com | Sök | Ja | — | Resonera |
| `ImagesiftBot` | ImageSift | Bildstölder | Okänd | — | Blockera |
| `Timpibot` | — | Masscrawl | Svårt | — | Blockera via UA + rate limit |
| `Diffbot` | Diffbot | Strukturerad extrah. | Ja | — | Resonera |
| `PetalBot` | Huawei | Sök | Inkonsekvent | — | Blockera |

### 3.3 De som försvann

```
GPT-crawler, Claude-Web, Bingbot (använd UA), CopilotBot, GoogleProducer,
Microsoft Copilot (använd UA), ChatGPT (använd UA), SAM 2, StableDiffusionBot,
V-JEPA, DALL-E, peer39_crawler, AndersPinkBot, TurnitinBot, FriendlyCrawler
```

> ⚠️ **`ChatGPT`, `Microsoft Copilot` och `GPT-5` som robots.txt-token är föråldrade.** OpenAI använder numera `GPTBot` / `OAI-SearchBot` / `ChatGPT-User`. En `User-agent: ChatGPT`-grupp fångar ingenting som inte även fångas av `GPTBot`.
> ⚠️ **Det finns ingen `CopilotBot`.** Microsoft använder `bingbot`. En regel på `CopilotBot` är död syntax.

### 3.4 Verifiering: UA ≠ identitet

En UA-sträng kan förfalskas av alla. Leverantörerna publicerar därför **IP-listor** — det är den enda mekanismen som bevisar identitet:

| Leverantör | Fil | Innehåll (okt 2026) |
|---|---|---|
| OpenAI | `openai.com/gptbot.json` | 18 prefix, ~3 472 IPv4 |
| OpenAI | `openai.com/searchbot.json` | 39 prefix, ~2 496 IPv4 |
| OpenAI | `openai.com/adsbot.json` | 2 prefix (/25) |
| OpenAI | `openai.com/chatgpt-user.json` | 286 prefix, ~37 328 IPv4 |
| Anthropic | `claude.com/crawling/bots.json` | 28 prefix |
| Perplexity | `perplexity.ai/perplexitybot.json` | 13 prefix |
| Apple | `search.developer.apple.com/applebot.json` | — |
| Google | `developers.google.com/static/crawling/ipranges/*.json` | **5 filer** (se §6.2) |
| Bing | `bing.com/toolbox/bingbot.json` | 28 IPv4, ingen IPv6 |

**Verifiering i loggen:**

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

# Loggar där "ClaudeBot" påstår sig komma från en IP utanför Anthropics lista
# = förfalskning. Mät andelen förfalskta UA:tokens i loggen.
```

**Observera:** i en stor loggmätning var **2,0 % av botträffarna "aktiva fel"** — de påstod sig vara en verifierbar leverantör men kom från en IP utanför den leverantörens intervall. Det är ett mätvärde, inte en åsikt.

**Regeln:** *ett leverantörstoken på ett ASN som inte tillhör leverantören är en förfalskning.* Testa **både** ASN **och** token.

### 3.5 Web Bot Auth (RFC 9421)

Nya och seriösa leverantörer signerar sina förfrågningar. Rubrikerna:

```
Signature: …
Signature-Input: …
Signature-Agent: "https://crawler.exa.ai"
```

`Signature-Agent` pekar på leverantörens nyckeldirektori (t.ex. `https://crawler.exa.ai/.well-known/http-message-signatures-directory`). Matchar du `crawler\.exa\.ai` i `Signature-Agent` så fångar du leverantören även om UA-strängen ändras — och det kan inte produceras av någon som bara ändrar sin UA.

Det är fortfarande en strängmatchning, inte en signaturverifiering. Men det är en **mycket** starkare signal än UA.

---

## 4. Styrsignalerna i detalj

### 4.1 Det delade policytokenet — `__usage_ai-training`

**Källa:** `draft-kelley-aipref-training-preference-signal-00` (Kevin Kelley, Anthropic), publicerad **30 oktober 2026**. Egenutvecklad Internet-Draft — **inte** IETF-endorsad, ingen formell status.

```txt
User-Agent: __usage_ai-training
Disallow: /
```

**Vad utkastet säger, ordagrant i översättning:**

- Det introducerar **inga nya direktivnamn och ingen ny grammatik**. Språk för sökvägar, *longest-match*-precedence och gruppstrukturen i robots.txt (RFC 9309) ändras inte.
- Policyn binds till **sökvägar** via en vanlig robots.txt-grupp med policynyckeln i `User-Agent`-raden.
- **En jokerteckengrupp (`User-agent: *`) får INTE tolkas som att den matchar policynyckeln.**
- **Om ingen grupp i filen innehåller policynyckeln har ingen preferens uttryckts.**
- Policynyckeln är **inte ett direktiv för crawlbeteende** — den styr användning, inte hämtning.

**Leverantörernas tidsplan (verifierad 2026-11-01):**

| Leverantör | Plan | Tidpunkt |
|---|---|---|
| **Anthropic** | Leverantören av utkastet, stöder redan | Redan live |
| **OpenAI** | Annonserade 2026-10-30 att de kommer att respektera signalen | "inom de kommande månaderna" — ingen exakt datum |
| **Microsoft (Bing)** | Respekterar token för **träning**; lägger till sidnivåkontroller | **2027-02-01** |
| **Google** | Ska stödja token; om `Google-Extended` inte uttryckligen anges, tolkas tokenen som "Google-Extended blockerat" | **Tidigt 2027** |

> **Praktiskt:** publicera tokenet nu — det kostar inget, det är framåtkompatibelt, och det är ett uttryck för vilja. Men **bygg inte ett skydd som DEPENDERAR av att det fungerar** förrän din leverantör har bekräftat läsning.

### 4.2 Microsofts sidnivåpreferenser

Microsofts eget system (annonserat 2026-10-30, Krishna Madhavan) delar upp i **två oberoende preferenser**:

| Preferens | Var | Värden | Default |
|---|---|---|---|
| **AI Training** | robots.txt (token ovan) **eller** per sida | `disallow` | Allow |
| **AI Grounding** | **Endast per sida** — meta eller header | `allow` (default) · `disallow` · `disallowextended` | Allow |

**Sidnivåsyntax:**

```html
<meta name="Bingbot" content="ai-training:disallow">
<meta name="Bingbot" content="ai-grounding:disallow">
<meta name="Bingbot" content="ai-grounding:disallowextended">
```

```http
X-Robots-Tag: Bingbot: ai-training:disallow
X-Robots-Tag: Bingbot: ai-grounding:disallow
```

**Vad värdena betyder:**

- `ai-training:disallow` — sidan används inte för Microsofts AI-träning. **Sidnivåvärdet överstyr robots.txt-värdet för den sidan.**
- `ai-grounding:disallow` — innehållet används inte för att informera genererade svar. Sidan syns inte i Bing, Copilot eller M365-svar.
- `ai-grounding:disallowextended` — **nytt värde.** Behåller grounding i Microsofts *egna* upplevelser (AI Mode, AI Overview, Copilot, Microsoft 365) men utesluter den grounding Microsoft *säljer vidare* (Web IQ, grounding via Foundry API). Detta är det "mjuka" alternativet: du är med i Copilot-svaren men inte i tredje parts AI-tjänster.

**Det finns ingen webbplatsomfattande grounding-preferens i robots.txt.** Microsoft säger det uttryckligen.

**Tidslinje (kritisk):**

| Datum | Händelse |
|---|---|
| **2026-12-15** | Bing Webmaster Tools öppnar **tillfälliga grounding-preferenser** — endast för sajter som använder `noarchive`/`nocache` det datumet |
| **2027-02-01** | Microsoft börjar respektera AI Training + AI Grounding när den crawlar. **Om nya preferenser upptäcks ignorerar Bing eventuella kvarvarande `noarchive`/`nocache`.** |
| **2027-03-01** | **Deadline.** Publicera sidnivå-grounding-preferens **och** registrera den tillfälliga preferensen i Bing Webmaster Tools. Efter dettadatum läses `noarchive`/`nocache` **inte längre** som tränings- eller groundingpreferens. |
| **2027-09-30** | Tillfälliga grounding-preferenser upphör (eller tidigare om Bing hittar den nya preferensen vid omcrawl) |

> ⚠️ **Om du använder `noarchive`/`nocache` idag och vill behålla grounding-spärren efter 2027-03-01 måste du göra BÅDA: lägga till `ai-grounding:disallow`/`disallowextended` och registrera den tillfälliga preferensen i Bing Webmaster Tools.** Gör du bara det ena, förlorar du spärren.

**Ingen av preferenserna påverkar vanliga Bing-resultat.** Men Microsoft varnar: `disallow` och `disallowextended` **reducerar din synlighet i AI-upplevelser**. Och: varken "tillåt träning" eller "tillåt grounding" garanterar innehåll, trafik eller betalning.

### 4.3 Google — tre oberoende lager

| Lager | Vad det styr | Var |
|---|---|---|
| `Google-Extended` + `Disallow: /` | Träning av Gemini-modeller + grounding i Gemini-appen/Vertex AI | robots.txt |
| **Search generative AI control** | AI Overviews, AI Mode, generativt innehåll i Discover | Search Console → Settings |
| `nosnippet` / `max-snippet:N` | Att sidan används som direktinput i AI Overviews / AI Mode | meta + header |

#### 4.3.1 Search generative AI control

**Globalt tillgängligt sedan 2026-08-31** (först i Storbritannien 2026-06-03, efter krav från CMA).

```
Search Console → Settings → Search generative AI
  ├─ Include my site's links and content in Search generative AI features  (default)
  ├─ Exclude my site's links and content from Search generative AI features
  └─ Inherit control from parent
```

**Vad Exclude faktiskt görar:** ditt innehåll syns inte i AI Overviews, AI Mode eller generativ Discover, och är inte längre "eligible as an input" för att generera ett AI-svar.

**Vad det INTE görar:**

- ❌ Påverkar **inte** din rankning i vanlig sök ("isn't used as a ranking or inclusion signal affecting other parts of Search")
- ❌ Påverkar **inte** vanlig Discover-feed (bara Discover-s generative lager)
- ❌ Påverkar **inte** träning — det styrs av `Google-Extended`
- ❌ Påverkar **inte** Merchant Center eller Google Ads

**Tid:** 1–2 dagar efter att inställningen slår till, ibland längre p.g.a. cachelagring.

**⚠️ Arvsföretag (property inheritance):** en URL-prefix-property under en domän ärverkar värdet från närmaste förälder. Exkluderar du föräldern utan att kontrollera barnen kan du blockera sektioner du inte avsåg, eller lämna sektioner öppna som du trodde var stängda.

**Relaterat:** Search Console har också en **Generative AI performance report** (impressions i AI Overviews / AI Mode / Discover-AI) — sedan 2026-08-31 för alla webbplatser världen över. Den visas **inte** om du har exkluderat dig.

#### 4.3.2 `nosnippet` — och dess pris

Google: *"nosnippet … will also prevent the content from being used as a direct input for AI Overviews and AI Mode"*, och det gäller **alla** sökresultat (webb, Images, Discover, AI Overviews, AI Mode).

**Priset:** den vanliga sökrubriken försvinner också. `nosnippet` är alltså dyrt.

`max-snippet:0` = samma som `nosnippet`. `max-snippet:-1` = "Google väljer" (standard boilerplate i SEO-plugins). `max-snippet:20` = tak på 20 tecken som direktinput i AI-svar.

**Billigare alternativ:** `data-nosnippet` på utvalda `<span>`/`<div>`/`<section>` — stänger av enstaka delar av texten. Observera: Google hämtar attributet både före och efter rendering → **ta inte bort eller lägg till `data-nosnippet` på element som har JS på dem.**

> **Rekommendation för en innehållsblogg:** använd **Search generative AI control = Exclude** om du inte vill synas i AI-svar. Det kostar dig inga vanliga rubriker och ingen rankning. Spara `nosnippet` till enskilda sidor där du verkligen vill det.

#### 4.3.3 Vad Google har tagit bort

**Borttagna ur Googles robots-meta-specifikation:**
- `noml` — borttaget
- `nosummary` — borttaget

**Finns kvar i listan men används INTE av Google Search (tillhör "historical and other unused rules"):**
- `noarchive` — används inte längre av Google Search (cache-länken existerar inte)
- `nocache` — används inte av Google Search
- `nositelinkssearchbox` — används inte (funktionen är borta)

**Aldrig implementerade av Google, Bing, OpenAI eller Anthropic:**
- `noai` — endast vissa datasetverktyg (t.ex. `img2dataset` läser `X-Robots-Tag: noai` på **själva bilden**, inte meta-taggen på sidan runt den)
- `noimageai` — samma

**Googles robots-meta-regler som faktiskt gäller (2026):**

| Regel | Status |
|---|---|
| `none` | = `noindex, nofollow` |
| `noindex` | ✅ |
| `nofollow` | ✅ |
| `nosnippet` | ✅ (blockerar AI Overviews/AI Mode-input) |
| `max-snippet:N` | ✅ |
| `max-image-preview:N` | ✅ |
| `max-video-preview:N` | ✅ |
| `indexifembedded` | ✅ (bara tillsammans med `noindex`) |
| `noimageindex` | ✅ |
| `notranslate` | ✅ |
| `unavailable_after:[date]` | ✅ |
| `data-nosnippet` | ✅ (element-nivå) |

**Kampregeln:** *"The more restrictive rule applies."* Meta-taggar och `X-Robots-Tag` behandlas som **en** uppsättning regler.

**Och en viktig konsekvens:** *"a URL disallowed in robots.txt is never seen"* — robotregler och indexeringsregler är två oberoende lager.

### 4.4 Den döda syntaxen — komplett lista

Följande har **ingen effekt** hos någon stor leverantör. De skickas tyst i väg:

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
Content-Usage: ai=n            (utkast, ej implementerat)
MaxConnPerIP                    (det är mod_maxconn, inte mod_rewrite)
```

> **`Content-Usage: train-ai=n`** förekommer i `draft-ietf-aipref-attach` och är värd att hålla ögat på — men det är fortfarande bara ett utkast och ingen leverantör läser det.

### 4.5 HTTP-headernivån

`X-Robots-Tag` är samma instruktion som meta-taggen, men bär på saker där meta inte fungerar (PDF, bilder, API-svar).

```
X-Robots-Tag: noindex
X-Robots-Tag: Bingbot: ai-training:disallow, ai-grounding:disallowextended
```

**Apache — append, aldrig ersätt:**

```apache
# FEL: två set-rader → den andra ersätter den första
Header set X-Robots-Tag "noindex"
Header set X-Robots-Tag "ai-grounding:disallow"

# RÄTT: set sedan add
Header always set X-Robots-Tag "Bingbot: ai-training:disallow"
Header always add X-Robots-Tag "Bingbot: ai-grounding:disallowextended"
```

**nginx:**

```nginx
add_header X-Robots-Tag "Bingbot: ai-training:disallow" always;
add_header X-Robots-Tag "Bingbot: ai-grounding:disallowextended" always;
```

### 4.6 `/.well-known/ai.txt` — det nya utkastet

`draft-car-ai-txt-wellknown-00` (12 juni 2026, K. Cardillo, *individual submission* — ingen IETF-status) föreslår två well-known-URI:er:

- `https://example.com/.well-known/ai.txt`
- `https://example.com/.well-known/ai.json`

Filen är ett blockformat (inspirerat av robots.txt) med fält som `Training: deny|allow|conditional`, `Training-Allow`, `Training-Deny`, `License`, `Attribution`, `Agents`, `Rate-Limit`.

**Position:** komplementärt till robots.txt, inte en ersättning. Det uttrycker nyanser som robots.txt inte kan: "du får crawla men inte träna".

**Status 2026-11-01:** ingen leverantör läser det. Publicera det om du vill signalera policy — det skadar inte.

### 4.7 Cloudflare AI Crawl Control och Pay per Crawl

**AI Crawl Control** (tidigare "AI Audit", nu allmänt tillgänglig):

- **Gratisplan:** identifierar AI-crawlers **via User-Agent-strängar**
- **Betaldplan:** Bot Management detection ID → upptäcker även crawlers som försöker dölja sig

**Åtgärder per crawler:** Allow · Block · Charge (pay per crawl).

**Block-svar (betaldplan):** du kan returnera **HTTP 402 "Payment Required"** i stället för 403, med ett eget meddelandekropp — ett direkt sätt att kommunicera licensvillkor.

**Standardinställningar ändrade 2026-09-15:**
- För **nya** domäner: **Training** och **Agent** blockas som default på sidor som visar annonser. **Search** tillåts.
- Multi-purpose-crawlers (Googlebot, Applebot, BingBot) blockeras om du valt att blockera Training — de följer **alla** sina beteenden.
- Innan dess: alla verifierade bots tilläts som default. Nu är "Verified" inte längre "default allowed" — det betyder "tillåten inom sin kategori".

**Pay per Crawl:** kräver betalplan; charging finns i privat beta (Stripe). Sedan 2026-06-16 finns avancerad konfiguration:
- stäng av pay per crawl för vissa URI-mönster via Configuration Rules (t.ex. fri åtkomst till startsidan)
- dynamisk prissättning: origin svarar med `crawler-price`-header, eller en Cloudflare Worker sätter pris
- när dynamisk prissättning är på läggs `cf-pay-per-crawl` in i origin-förfrågan

**Precedens:** AI Crawl Controls blocking (WAF custom rules) går **före** Cloudflare Bots; pay per crawl går **efter** Cloudflare Bots. Vill du använda både blocking och charging måste du stänga av "Block AI Bots".

### 4.8 Det delade policytokenet vs. AIPREF-vokabulären

| Utkast | Status | Vad det gör |
|---|---|---|
| `draft-ietf-aipref-vocab-08` | Working group, 2026-09-14, Proposed Standard | Vokabulär för AI-användningspreferenser |
| `draft-ietf-aipref-attach` | Working group, Aug 2026 → IESG | Hur preferenser binds till innehåll (robots.txt + HTTP-header) |
| `draft-kelley-aipref-training-preference-signal-00` | Individual, 2026-10-30 | Policynyckeln `__usage_ai-training` |
| `draft-car-ai-txt-wellknown-00` | Individual, 2026-06-12 | `/.well-known/ai.txt` |
| `draft-madhavan-aipref-displaybasedpref-00` | Individual, 2026-03-25 | Sökmotordriven preferensvokabulär |

---

## 5. Implementera skydd

### 5.1 robots.txt

**Regel 1 — namngivna agenter, aldrig jokertecken för blockering.**
En `User-agent: *` + `Disallow: /`-grupp blockerar *alla* som inte har en egen grupp — inklusive Googlebot, Bingbot och alla dina läsare. Om du vill blockera träningscrawlers: **namngiv varje agent.**

**Regel 2 — policynyckeln måste stå i en egen grupp.**
Utkastet säger uttryckligen att en jokerteckengrupp inte får tolkas som att den matchar policynyckeln.

**Regel 3 — RFC 9309: längsta matchen vinner; vid lika längd vinner `Allow`.**
Ett `Allow: /press-kit/` i samma grupp öppnar precis den katalogen för träning.

**Minimal, korrekt robots.txt för en innehållsblogg:**

```txt
# --- Sök och indexering: LÅT IGJOM (du vill ha trafik och citat) ---
User-agent: Googlebot
Allow: /

User-agent: bingbot
Allow: /

User-agent: Applebot
Allow: /

# --- AI-träning: BLOCKERA ---
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

# --- Användarutlöst hämtning och sök-crawlers: LÅT IGJOM ---
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

# --- Det delade policynokenet: egen grupp, ingen jokertecken ---
User-Agent: __usage_ai-training
Disallow: /

# --- Sitemap ---
Sitemap: https://example.se/sitemap.xml
```

**Verifiera att det finns ingen `User-agent: *` med `Disallow: /`:**

```bash
curl -s https://example.se/robots.txt | grep -A2 -i "user-agent: \*"
```

**Robots.txt-testare:** Google Search Console → URL Inspection → robots.txt-tester. Bör visa "Allowed" för Googlebot.

### 5.2 .htaccess (Apache / LiteSpeed)

> ⚠️ **Fällorna som har stoppat all trafik underliggande.** Läs hela listan i §5.2.3 innan du deployar.

#### 5.2.1 En UA-regel som fungerar

```apache
# --- Blockera kända AI-tränings- och datainsamlingscrawlers ---
<IfModule mod_rewrite.c>
RewriteEngine On

RewriteCond %{HTTP_USER_AGENT} "(GPTBot|ClaudeBot|anthropic-ai|Claude-Web|CCBot|Bytespider|meta-externalagent|meta-externalfetcher|Google-Extended|Applebot-Extended|Amazonbot|cohere-ai|MistralAI-Training|AI2Bot|Diffbot|Timpibot|ImagesiftBot)" [NC]
RewriteRule ^ - [F,L]

# Signerat av Exa (RFC 9421) — fångar även om UA byts
RewriteCond %{HTTP:Signature-Agent} "crawler\.exa\.ai" [NC]
RewriteRule ^ - [F,L]

</IfModule>
```

**Vad du INTE ska blockera i samma regel:**
`Googlebot` · `bingbot` · `Applebot` · `OAI-SearchBot` · `Claude-SearchBot` · `PerplexityBot` · `ChatGPT-User` · `Claude-User` · `Perplexity-User` · `MistralAI-User` · `GoogleOther` *(välj: blockera om du vill, men inga referenser)* · `bot` som generellt ord.

#### 5.2.2 Varför just den här formen

| Funktion | Skälet |
|---|---|
| `RewriteEngine On` | Utan den är blocket **dött** — regeln kan aldrig fylla. (Föregående block i samma katalog *bär* state, så det räcker att finnas *någonstans* i katalogen.) |
| `RewriteCond ... "..."` med citattecken | Mönster med mellanslag måste citeras, annars tokenizerar Apache fel |
| `[NC]` | Skiftlägesokänt. Utan det fångar du bara exakt skrivning |
| En enda `[NC]`-cond + `[F,L]` | Kedjor med `[OR]` är den vanligaste källan till "regeln fungerar inte" |
| `RewriteRule ^ - [F,L]` | `-` = ändra inte URI, `F` = 403 Forbidden, `L` = stoppa |
| `<IfModule mod_rewrite.c>` | Skydd mot "Invalid command" → 500 om mod_rewrite saknas |

#### 5.2.3 Fällorna — komplett lista

| # | Fälla | Följd |
|---|---|---|
| 1 | **Saknad `RewriteEngine On`** | Regeln är död. Syns: ingen 403, ingen 500. |
| 2 | **Mellanslag saknas mellan `%{ENV:X}` och mönstret** | Apache läser raden som ett argument → `bad argument line` → **HTTP 500 för ALLA besökare** |
| 3 | **Mönster med mellanslag utan citattecken** | Samma som ovan → 500 |
| 4 | **Cond-rad över 8 191 byte** | Apache vägrar läsa hela filen → **500 för alla**. Mätt: 8 190 B fungerar, 8 192 B ger 500. **Dela långa listor över flera rader.** |
| 5 | **Två adress-familjer i samma AND-kedja** | `REMOTE_ADDR` v4 och v6 AND-as → kedjan är osatisfierbar för varje begäran på jorden |
| 6 | **Negativ cond-lista som motverkar den positiva** | En "tillåt"-lista som blockerar samma agenter gör regeln till no-op |
| 7 | **IPv6-mönster som aldrig kan matcha** | T.ex. `2a00:1450::` som är Googles *webb*-utrymme, inte crawler-utrymme |
| 8 | **`</IfModule>` klistrad på RewriteRule-raden** | 500 för alla |
| 9 | **Filen saknar avslutande ny-rad** | Ändringar landar på kommentaren → trasig struktur → 500 |
| 10 | **Två `Header set X-Robots-Tag`** | Andra raden ersätter den första |
| 11 | **Regel som fångar en riktig läsares UA** | Du blockerar läsare, inte bots |

> **Verifiering:** `apache2 -t` säger **alltid** "Syntax OK" — den parsar aldrig `.htaccess`. **Endast ett live-anrop bevisar filen.**

#### 5.2.4 Mät på servern, inte från din laptop

Att anropa din egen sajt från en datacenter-IP ger ofta **Imunify360 bot-protection** (under WordPress) eller en **JS-challenge** — du ser inte filen, du ser ett ~12 kB splash. Då kan du inte mäta något.

**Kör mätningen från servern, över ssh:**

```bash
ssh user@server 'curl -sS -A "GPTBot/1.1" -o /dev/null -w "%{http_code}\n" https://example.se/'
ssh user@server 'curl -sS -A "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/140.0 Safari/537.36" -o /dev/null -w "%{http_code}\n" https://example.se/'
```

Första raden ska ge **403**, andra **200**. Om båda ger 200 är regeln död. Om båda ger 500 har du brutit filen.

### 5.3 nginx

> **Din egen server kör nginx som yttersta lager.** `map` och `limit_req_zone` måste ligga i `http {}` — inte i `server {}`.

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

# Rate limit per IP, INTE per UA-sträng
limit_req_zone $binary_remote_addr zone=perip:10m rate=30r/m;

# ===== server {} =====
server {
    listen 443 ssl http2;
    server_name example.se;

    # "if" är farligt — men SÄKERT när kroppen bara är ett return
    if ($is_ai_crawler)      { return 403 "AI training crawler blocked\n"; }
    if ($is_signed_crawler)   { return 403 "Signed AI crawler blocked\n"; }

    location / {
        limit_req zone=perip burst=50 nodelay;

        # add_header EFTER return körs aldrig — placera före
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

**Fällor som rättats från 2025-versionen:**

| Fel i 2025-guiden | Varför det är fel | Rätt |
|---|---|---|
| `limit_req_zone` inuti `server {}` | nginx: "limit_req_zone directive is not allowed here" → **nginx startar inte** | `http {}` |
| `limit_req_zone $http_user_agent` | Alla besökare med samma UA delar **en** hink → riktiga läsare rate-limitas | `$binary_remote_addr` |
| `add_header` efter `return` i samma block | `return` avslutar → headern skickas aldrig | `add_header` före, eller i `server`-nivå |
| `if ($is_suspicious) { limit_req ...; }` | `if` i location med komplex kropp → variabel odefinierad i vissa ordningar | rate limit alltid på, `map` för uteliggande undantag |
| `map $http_user_agent $is_suspicious` med `~*(bot\|crawler\|scraper\|ai\|gpt\|claude)` | Matchar `"Safari"`? Nej — men matchar `"Brave"`-ej … matchar däremot **"chatgpt"**, och framför allt UA:n som innehåller ordet "ai" | Bara explicita leverantörstokens |

### 5.4 WordPress

**Robots.txt via PHP (så att det följer med när du byter tema):**

```php
<?php
/**
 * Plugin Name: AI Crawler Policy
 * Description: Genererar robots.txt med namngivna AI-agentgrupper.
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

        $output .= "# --- Shared policy token (own group) ---\n";
        $output .= "User-Agent: __usage_ai-training\nDisallow: /\n\n";
    }
    return $output;
}, 10, 2);
```

> ⚠️ **Använd inte `wp_robots`-filteret för detta** om ett annat plugin (t.ex. din AI-Skold) redan genererar robots.txt — två generatorer över skriver varandra.
> ⚠️ **Kontrollera "Allow vinner vid lika längd" (RFC 9309).** Om din AI-Skold lägger in en `Allow: /` i en *annan* grupp, och du har `Disallow: /` i policy-token-gruppen, är reglerna i olika grupper — de kombineras per grupp, inte globalt. Men inom samma grupp vinner `Allow`. Kolla alltid den faktiska filen.
> ⚠️ **PHP 8.5:** testa pluginet på 8.5. Använd `false === $result` för att kolla db-skrivningar — `false >= 0` är **TRUE** i PHP.

**Bingbot-sidpreferenser i head (via `wp_head`):**

```php
add_action('wp_head', function () {
    if (is_admin()) return;
    echo '<meta name="Bingbot" content="ai-training:disallow">' . "\n";
    echo '<meta name="Bingbot" content="ai-grounding:disallowextended">' . "\n";
});
```

**Skicka headern istället (rekommenderas — gäller även PDF/bilder):**

```php
add_action('send_headers', function () {
    header('X-Robots-Tag: Bingbot: ai-training:disallow', false);
    header('X-Robots-Tag: Bingbot: ai-grounding:disallowextended', false);
});
```

> `false` = **append**. Utan det skriver den andra raden över den första. Apache-motsvarigheten är `set` och sedan `add`.

**Pluginet ska aldrig skriva `noindex`.** Det är ett separat beslut, och det är den dyraste möjliga åtgärden.

### 5.5 Verifieringschecklista

```bash
# 1. Robots.txt finns och är korrekt
curl -sS https://example.se/robots.txt | head -40
curl -sS https://example.se/robots.txt | grep -c "User-agent: \*"

# 2. En UA-regel ger 403, en riktig browser ger 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "GPTBot/1.1"  https://example.se/
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (X11; Linux x86_64) Chrome/140.0 Safari/537.36" https://example.se/

# 3. Headern finns
curl -sSI https://example.se/ | grep -i "x-robots-tag"

# 4. Googlebot får fortfarande 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)" https://example.se/

# 5. bingbot får fortfarande 200
curl -sS -o /dev/null -w "%{http_code}\n" -A "Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)" https://example.se/
```

**Om du kör #2 mot en sajt som svarar 403 för *alla*:** kontrollera statuskoden, inte bara brödtexten. En 17-byte 403 betyder att nekan skedde **före** WordPress startade.

---

## 6. IP-nivå: rätt sätt att blockera en leverantörs crawler

### 6.1 Grundregeln

**Blockera inte en leverantörs crawler på ASN-nivå.** Leverantörens crawlers ligger i delade nät:

| Leverantör | Var crawler-IP:erna ligger | Vad du skulle blockera |
|---|---|---|
| Anthropic | AS16509 (Amazon) | Hundratals tusen hyresgäster |
| Google | AS15169, AS396982 (Google Cloud) | Allt Google |
| Bing | AS8075 | Allt Microsoft |
| OpenAI | Blandat | — |

**Rätt instrument:** CIDR-listan från leverantören, som en **villkorad** blockering.

### 6.2 Leverantörernas publicerade filer

**Google — FEM filer (unionen behövs):**

```
https://developers.google.com/static/crawling/ipranges/common-crawlers.json
https://developers.google.com/static/crawling/ipranges/special-crawlers.json
https://developers.google.com/static/crawling/ipranges/user-triggered-fetchers-google.json
https://developers.google.com/static/crawling/ipranges/user-triggered-fetchers.json
https://developers.google.com/static/crawling/ipranges/user-triggered-agents.json
```

> ⚠️ `googlebot.json` och `adsbot.json` **finns inte längre** (döpta om 2026-10).
> ⚠️ `gstatic.com/ipranges/goog.json` är Googles **generella** lista — **använd den inte** som grund för en crawler-allow-lista.
> ⚠️ Googles botrange **ändrades 2026-10-18** från `192.178.6.0/23` + `192.178.8.0/22` till `192.178.0.0/15`. En allow-lista från före den dagen är trasig.

**Bing:** `https://www.bing.com/toolbox/bingbot.json` — `{"creationTime":…,"prefixes":[{"ipv4Prefix":…}]}`. 28 IPv4-prefix, ingen IPv6. `creationTime` står fast på 2024-01-03, så färska är inte uppenbart.

### 6.3 Villkorad blockering (aldrig en odvillkorad IP-block)

```apache
# Blockera EN crawler från EN leverantör — inte hela nätet
SetEnvIf Request_User-Agent "^(.*ClaudeBot.*)$" CLAUDEBOT=$1

RewriteCond %{ENV:CLAUDEBOT} (.*)
RewriteCond %{REMOTE_ADDR} ^(160\.79\.104\.|147\.162\.37\.) [OR]
RewriteCond %{REMOTE_ADDR} ^(2600:1f18:[0-9a-f]{1,4}:)
RewriteRule ^ - [F,L]
```

> **Varför villkorat:** leverantören kan flytta sina ranges, och en odvillkorad block av en leverantörs range som sedan återanvänds av en annan leverantör blockerar den rakt av. Med villkoret på både UA och IP går en förfalskad UA inte igenom, och en legitim leverantör som flyttar ger ett tillfälligt läckage istället för en permanent felblockering.
>
> ⚠️ `SetEnvIf X-Test-ASN "(.*)" ASN=$1` — skapa **inte** en variabel som heter `ENV:ASN`; det blir en variabel med namnet `ENV:ASN`. Använd `ASN=$1`.
> ⚠️ `mod_setenvif` måste vara laddad, annars ger varje begäran 500 (`Invalid command`).

### 6.4 Uppdateringsrutin

1. Hämta leverantörens fil (versionera den: `claude-bots-2026-11-01.json`).
2. Diffa mot förra versionen.
3. Generera regeln.
4. Verifiera mot en **kontrolluppsättning**: 20–50 riktiga leverantörs-IP:er → 403, och 100 slumpade vanliga IP:er → 200.
5. **0 HTTP 500.**

---

## 7. Avancerade detektionstekniker

### 7.1 Nivåindelning

| Nivå | Signal | Kostnad | Falskpositivrisk |
|---|---|---|---|
| **1** | UA-token (robots.txt + .htaccess) | Låg | Låg (om rätt token) |
| **2** | Rate limiting per IP | Låg | Låg |
| **3** | Mål-path + UA (t.ex. `/xmlrpc.php`) | Låg | Nära noll |
| **4** | JS-challenge / browser-fingerprint | Medel | Medel |
| **5** | ML på beteende | Hög | Hög — kräver träningsdata |

**Rekommendation: börja med 1–3.** Nivå 4–5 ger falskpositiver som kostar dig riktiga läsare.

### 7.2 Nivå 2 — rate limiting

```nginx
limit_req_zone $binary_remote_addr zone=perip:10m rate=30r/m;
limit_req_zone $binary_remote_addr zone=strict:10m rate=5r/m;

server {
    # API och sök: strikt
    location ~ ^/(wp-admin|wp-login|xmlrpc\.php|wp-json) {
        limit_req zone=strict burst=10 nodelay;
        limit_req_status 429;
        proxy_pass http://127.0.0.1:8080;
    }
}
```

### 7.3 Nivå 3 — mål-path + UA (den hållbara instrumentet)

> **Mönstret varar längre än IP-adressen.** En GCP-scanner som läser `/.env` och `/xmlrpc.php` byter adress varje gång. En regel på *mönstret* fångar nästa IP utan att du vet den.

```apache
# Kritiska filer som aldrig ska nås via webb
RewriteCond %{REQUEST_URI} "^/(?:\.env|\.git/|xmlrpc\.php|\.aws/|wp-config\.php)" [NC]
RewriteRule ^ - [F,L]
```

**Kända mönster hos GCP-hemliga scanners (från loggmätningar):**
`/xmlrpc.php` · `/api/` · `/.env` · `/wp-admin` · `/admin.php` · `/login.php` — typiskt 175–272 distinkta pathar per IP, med **102 lyckade 200-svar per IP** (de läser alltså dina inlägg).

### 7.4 Nivå 4 — JS-challenge och fingeravtryck

```javascript
// Mät en besökares "äkthet" med en billig beräkningsuppgift.
(function () {
    const start = performance.now();
    const els = document.querySelectorAll('div');
    for (const el of els) {
        const s = getComputedStyle(el).getPropertyValue('transform');
    }
    const exec = performance.now() - start;

    // Kärnregeln: en riktig browser hämtar assets.
    // Vi mäter det genom att se vilka resurser laddas.
    navigator.sendBeacon('/__fp', JSON.stringify({
        exec,
        elements: els.length,
        // Har sidan hämtat JS/CSS? Då är det en browser.
        resources: performance.getEntriesByType('resource')
            .filter(r => /\.(js|css|woff2?)(\?|$)/.test(r.name)).length
    }));
})();
```

**Tolkning (kalibrerad mot riktiga besökare, inte antaganden):**

| Signal | Riktig browser | Skript |
|---|---|---|
| HTML 200 **+** ≥1 asset-hämtning | ✅ | ❌ |
| HTML 200 **+** 0 asset-hämtningar | ❌ | ✅ |
| `exec` < 10 ms | möjligt (kall cache) | sannolikt |
| `exec` > 500 ms | möjligt (långsam enhet) | möjligt |

> ⚠️ **Ändra inte på enbart `exec`-tid.** En långsam mobil kan ta 800 ms. **Antalet hämtade assets** är den separationskraftigare signalen.

### 7.5 Nivå 5 — ML på beteende

```python
import numpy as np
from sklearn.ensemble import IsolationForest

class BotRisk:
    """
    Riskmodell som FALlar öppet (fail open) för mänsklig trafik.

    VIKTIGT OM KALIBRERINGEN
    ------------------------
    sklearns IsolationForest.decision_function() returnerar:
        negativt  = outlier  (avvikelse)
        positivt = inlier   (normalt)
    ... och ligger typiskt i intervallet [-0.3, +0.3], INTE [-1, +1].

    En naiv 1/(1+exp(x)) på det råvärdet ger ett resultat som ligger kring
    0.5 och aldrig når någon tröskel. Därför skalar vi om värdet kring
    modellens egen beslutsgräns (d = 0 -> p = 0.5) med SLOPE.
    Med SLOPE = 12 hamnar beslutsgränserna ungefär så här:
        d = -0.10  ->  p = 0.77
        d = -0.05  ->  p = 0.65
        d = +0.05  ->  p = 0.35
        d = +0.10  ->  p = 0.23
    SLOPE MÅSTE kalibreras mot ett märkt facit (se kommentaren under
    beslutsgränserna) — annars är trösklarna meningslösa.
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
            return False           # för lite data -> inte fitted
        self.model.fit(np.array(samples, dtype=float))
        self.human_features = samples
        self.fitted = True
        return True

    def score(self, req):
        if not self.fitted:
            return 0.0           # fail open: hellre ingen blockering
        d = float(self.model.decision_function([self.features(req)])[0])
        return float(1.0 / (1.0 + np.exp(self.SLOPE * d)))
```

**Beslutsgränser:**

| Risk | Åtgärd |
|---|---|
| ≥ 0.85 | Blockera (403) + logga |
| 0.60–0.85 | Rate limit + utmaning |
| 0.35–0.60 | Logga, observera |
| < 0.35 | Släpp igenom |

> **Kalibrera trösklarna mot ett facit innan du använder dem.** Kör modellen över ett märkt urval (minst 200 riktiga besökare, varav några med kända bot-signaler) och justera `SLOPE` tills tröskeln 0.85 ligger på den bot-andel du faktiskt vill blockera. En tröskel som aldrig triggar är lika värdelös som ingen tröskel.

> **Träningsdata:** `IsolationForest` med `contamination=0.05` på **bara** mänsklig trafik lär sig "onormalitet". Men din "mänskliga" data innehåller sannolikt redan en hel del bots. **Rensa först, träna sen.** Annars lär modellen att bots är normala.
>
> ⚠️ **En riskmodell utan kalibrering är farligare än ingen modell.** Kör alltid mot ett facit: 200–500 kända riktiga besökare (inkl. din egen admin-session) ska ha risk < 0.35. **En residential + login-heavig adminsession = owner, inte brute force.**

### 7.6 Korrigeringar av 2025-versionens detektionskod

Det här är de faktiska buggarna i det gamla exemplet. De gav **falskpositiver på vanliga läsare**:

| Gammal kod | Problem | Rätt |
|---|---|---|
| `if 'Safari' in ua and 'Chrome' in ua: score += 0.3` | **Varje Chrome-UA innehåller "Safari"** → alla Chrome-användare flaggade | Ta bort regeln helt |
| `required_fields = ['Mozilla','Windows','Chrome']` | **Varje iPhone/iPad saknar "Windows" och "Chrome"** → alla iOS-användare flaggade | Kräv bara `Mozilla` + en riktig webbläsar-token |
| `if chrome_version > 120: score += 0.1` | Alla moderna användare straffas — signalen är värdelös | Ta bort |
| `suspicious_patterns = [r'bot|crawler|spider|scraper', r'GPT|Claude|ChatGPT', ...]` | `re.search` utan escaping, och `Claude` matchar t.ex. "Claude" i andra sammanhang | Använd explicita leverantörstokens, `\b`-ankare |
| `if any(bot in ua for bot in self.ai_bot_uas)` (skiftlägeskänsligt) | `gptbot` i gemener fångas inte | Case-insensitive + explicit lista |
| `request_count > 100` per minut → +0.4 | En läsare som laddar 20 sidor + assets passerar 100/min | Räkna **sidor**, inte alla requests, eller använd ett högre tröskelvärde |
| `redis_client.lpush(...)` i en lista som växer obegränsat | Minnesläcka | `LPUSH` + `LTRIM` till max 1000, eller använd Redis Streams med trim |
| `interval_std < interval_mean * 0.1` → bot | En läsare som klickar 20 länkar i jämn takt matchar | Kräv > 30 requests innan mönstret väger |

---

## 8. Stealth-scraping och anti-detektion

Att förstå fiendens verktyg är det enda sättet att veta vilka spår som är värda att spåra.

### 8.1 Roterande User-Agents

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

### 8.2 Headless browser med human-liknande beteende

```javascript
const puppeteer = require('puppeteer');

async function humanLike(page, url) {
    await page.goto(url, { waitUntil: 'networkidle2' });

    // Rör musen i kurvor, inte raka linjer
    for (let i = 0; i < 12; i++) {
        await page.mouse.move(
            100 + Math.random() * 800,
            100 + Math.random() * 600,
            { steps: 8 + Math.floor(Math.random() * 12) }
        );
        await new Promise(r => setTimeout(r, 80 + Math.random() * 400));
    }

    // Rulla ned med varierad hastighet och pauser
    await page.evaluate(async () => {
        for (let y = 0; y < document.body.scrollHeight; y += 300 + Math.random() * 400) {
            window.scrollTo(0, y);
            await new Promise(r => setTimeout(r, 200 + Math.random() * 800));
        }
    });
}
```

### 8.3 Proxy-rotering och distribuerad crawling

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

### 8.4 Multi-purpose-crawlers och residential-proxies

De riktigt svåra fallen är inte datacenter-IP:er. De är:

- **Residential proxy-nätverk** — trafik kommer från *vanliga privatanslutningar* i ett helt land (t.ex. svenska telekom-ASN:er).
- **Rotating IP per request** — ett nytt IP var 12–23:e minut.

> **Därför är ASN-blockering sårbart mot just de:** de opererar i *accessnät* (ISP:er), inte datacenter. Att blockera ett helt access-ASN tar med dig riktiga läsare i samma nät.
>
> **Rätt svar mot residential-proxies är inte IP-blockering.** Det är: rate limiting per IP, 2FA på inloggning, och mätning av *mönstret* (samma UA från hundratals oberoende IP:er inom kort tid = ett nät, inte hundratals läsare).

---

## 9. Juridiska aspekter

> ⚠️ **Detta är inte juridisk rådgivning.** Det här är en teknisk sammanfattning av regelverket som det såg ut 2026-11-01.

### 9.1 EU:s AI Act, artikel 53

Skyldigheterna ligger hos **leverantörerna av general-purpose AI-modeller**, inte hos dig:

| Skyldighet | Innebörd |
|---|---|
| **53(1)(c)** | En **upphovsrättspolicy** som identifierar och respekterar rättighetsförbehåll enligt DSM-direktivets artikel 4(3) |
| **53(1)(d)** | Ett **offentligt, tillräckligt detaljerat sammanfattning av träningsinnehållet**, enligt en mall från AI Office |

**Mallen** ("Template for the Public Summary of Training Content") publicerades **24 juli 2025** efter en offentlig konsultation med 430+ organisationer.

**Tidsgränser:**
- Från **2025-08-02**: modeller som lanseras på EU-marknaden måste ha sammanfattningen
--modeller som redan är på marknaden: **2027-08-02**

**Straff:** upp till **15 miljoner euro eller 3 % av global omsättning**, vilket är störst.

**AI Office får tillsynings- och sanktionsbefogenheter från augusti 2026.**

### 9.2 DSM-direktivet, artikel 4(3) — rättighetsförbehåll

Rättighetshavare kan **reservera rätten mot text- och datautvinning** (TDM) "i lämplig form, såsom maskinläsbara sätt". Det maskinläsbara sättet är **robots.txt**.

**Det är exakt därför `robots.txt` har juridisk betydelse och inte bara etikett.** GPAI Code of Practice, åtgärd 1.3:

> *"Signatories to the GPAI Code of Practice have committed to employ web crawlers that respect robots.txt and any subsequent version of this Protocol for which the IETF demonstrates that it is technically feasible and implementable by AI providers and content providers, including rightsholders."*

Åtgärd 1.4: *"Mitigate the risk of copyright-infringing outputs by implementing appropriate and proportionate technical safeguards."*

**Konsekvens för dig:**

1. **robots.txt är det juridiskt anerkända sättet att reservera rätten.** Publicera det korrekt, med namngivna agenter.
2. **Att bara blockera med en UA-regel i .htaccess räcker inte som rättighetsförbehåll** — det är inte maskinläsbart för leverantören och leverantören ser det aldrig.
3. **Förbehåll kräver "rättighetshavaren"** — på en blogg är det du som upphovsperson, eller din arbetsgivare. Skriv ner vem som äger rättigheterna.
4. **Europaparlamentet (2026-07-27) konstaterar** att kommissionen stöder tillämpningen av rättighetsförbehållsmekanismen, inklusive robots.txt-baserade förbehåll, inom AI Act-artikel 53.

### 9.3 Dataskydd (GDPR)

- **Personuppgifter i träningsdata** är ett separat spår. Ett träningscrawler som samlar kommentarer med namn och e-post bryter mot GDPR om uppgifterna behandlas utan laglig grund.
- **TDM och GDPR kan kollidera.** Välja "träning tillåten" för ett enskilt AI-agent-token är inte samma sak som att tillåta behandling av personuppgifter.
- **Efter att du har blockerat en bot**: överväg om loggdata som innehåller IP-adresser och UA-strängar behöver gallras, och hur länge du sparar dem.
- **Rätt till radering** gäller även för indexerade AI-svar i den månad leverantören svarar på begäran — vilket inte är garanterat. Bättre att inte ta innehållet i träning från början.

### 9.4 Upphovsrätt

- **Databasrätt** (direktiv 96/9/EG) ger databasproducenten en rätt att reproducera en *väsentlig* del av databasen. En AI-crawler som bygger ett stort lokalt index från din sajt kan falla under det.
- **Artikelskydd** gäller texten i sig.
- **Kända rättsfall** (Europademarken): *LAW360 v Google* (C-682/18) och *C-460/20 Cyando* — upphovsrättsskydd gäller inte bara bokstavligt kopiering utan även **extrahering** när resultatet "återger" uttrycket.
- Detta är **juridisk markering, inte en teknisk blockeringsmekanism.** Tekniken blockerar; rätten avgör.

### 9.5 Praktiskt: bevis

Om du vill kunna driva ett ärende:

1. **Logga med UA-sträng, IP, referer, path, status, timestamp, bytes** — och behåll loggarna.
2. **Verifiera mot leverantörens IP-lista** vid tidpunkten för begäran (då kan du visa "detta var en verklig GPTBot").
3. **Filtrera bort eget trafik** (admin-sessioner, dina egna IP:er) så att signalen är ren.
4. **Separera "träning" från "besök"** i loggen — en crawler som bara hämtar `robots.txt` är inte samma sak som en som läser dina artiklar.
5. **Bevara robots.txt-versioner** — filen vid tidpunkten för klagomålet är beviset.

### 9.6 Sverige och EU

- **CMA (Storbritannien)** tvingade fram Googles "Search generative AI control" — exemplet på att **reglering driver standardisering**.
- **AI Office** (kommissionen) övervakar artikel 53 från augusti 2026.
- **CMA kräver sidnivåkontroller före mars 2027** (i dag finns bara fastighetsnivå).
- **Att ett företag följer robots.txt är ett löfte, inte en skyldighet** — lagstiftningen kräver att leverantören *kunde* respektera förbehåll, inte att varje leverantör gör det.

---

## 10. Monitoring och analytics

### 10.1 Vad du faktiskt ska mäta

| Mätpunkt | Verktyg | Varför |
|---|---|---|
| Vilka UA:tokens besöker | Logganalys | Base för robots.txt |
| Vilka **ASN** de kommer från | `ip2asn` / RIPEstat | Upptäcker "token på främmande ASN" = förfalskning |
| Statuskod per UA | Logganalys | 403 = blockad, 200 = lyckad hämtning |
| Bytes per UA | Logganalys | **En 200 med 40 kB = de läste din artikel.** En 403 med 0 B = de kom inte in. |
| Andel assets per session | Serverlogg / JS-mätning | Skiljer browser från skript |
| Mål-path-mönster | Logganalys | Hitta scanners |

### 10.2 Logganalys — ett fungerande skript

```python
#!/usr/bin/env python3
"""Sammanfattar AI-crawler-trafik från en Nginx/Apache accesslog."""

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

    print(f"{'TOKEN':<22}{'VENDOR':<14}{'REQ':>7}{'200':>7}{'BYTES':>12}{'IPS':>7}  {'LYCKADE 200'}")
    for (token, vendor), d in sorted(hits.items(), key=lambda kv: -kv[1]['bytes']):
        rate = (d['ok'] / d['n'] * 100) if d['n'] else 0
        flag = '  <== LÄSER INNEHÅLL' if d['ok'] and d['bytes'] > 100_000 else ''
        print(f"{token:<22}{vendor:<14}{d['n']:>7}{d['ok']:>7}{d['bytes']:>12}{len(d['ips']):>7}  {rate:5.1f}%{flag}")
    print(f"\nÖvrig trafik: {other['n']} req, {other['ok']} st 200, {other['bytes']} B")

if __name__ == '__main__':
    main(sys.argv[1] if len(sys.argv) > 1 else '/var/log/nginx/access.log')
```

**Nyckelrad:** `LYCKADE 200` + stor byte-count = boten **läste** ditt innehåll. En 403 är inte ett problem — en 200 med 40 kB är.

### 10.3 Dashboard

Den gamla Streamlit-dashboarden i 2025-guiden var funktionell men byggde på Redis-listor som växte obegränsat och använde `except:` utan specifikation. En minimal, robust variant:

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
    r.ltrim(key, 0, 100_000)          # <-- bounda listan

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

**Nyckelpunkt:** `LPUSH` utan `LTRIM` fyller Redis minnet tills servern faller. Detta är exakt den sorts "tyst fel" som en guide inte fångar.

### 10.4 Veckans rutin

| Dag | Uppgift |
|---|---|
| Måndag | Kör logganalysen. Jämför mot förra veckan. |
| Tisdag | Kolla nya UA:tokens (nya leverantörer). Uppdatera robots.txt vid behov. |
| Onsdag | Verifiera att Googlebot/Bingbot fortfarande får 200 från servern. |
| Torsdag | Hämta leverantörernas IP-filer och diffa mot förra versionen. |
| Fredag | Läs Search Console → Generative AI performance report (om du är Included). |

---

## 11. Checklista

### 11.1 Publicering (gör detta)

- [ ] `robots.txt` har **namngivna** grupper för varje träningscrawler
- [ ] `robots.txt` har **ingen** `User-agent: *` + `Disallow: /`
- [ ] `robots.txt` har gruppen `User-Agent: __usage_ai-training` + `Disallow: /`
- [ ] Sök-crawlers och användarutlöst hämtning är **tillåtna**
- [ ] `<meta name="Bingbot" content="ai-training:disallow">` finns (eller `X-Robots-Tag`)
- [ ] `<meta name="Bingbot" content="ai-grounding:disallowextended">` finns
- [ ] **Bing Webmaster Tools:** om du använder `noarchive`/`nocache`, registrera den tillfälliga grounding-preferensen **innan 2027-03-01**
- [ ] Search Console → Settings → Search generative AI: bestäm Include/Exclude
- [ ] `sitemap.xml` finns och anges

### 11.2 Server (gör detta)

- [ ] UA-regel i .htaccess/nginx med `RewriteEngine On`
- [ ] Ingen cond-rad över 8 191 byte
- [ ] `Header set` + `Header add` (inte två `set`)
- [ ] Rate limiting per IP, inte per UA
- [ ] `add_header` placerad före `return` i nginx
- [ ] Mål-path-regler för `/.env`, `/xmlrpc.php`, `/.git/`, `/wp-config.php`
- [ ] `2FA` på inloggning
- [ ] Cron: inga inloggningslänkar i e-post

### 11.3 Verifiering (gör detta)

- [ ] `GPTBot` → **403**
- [ ] `Mozilla/5.0 … Chrome/140.0 …` → **200**
- [ ] `Googlebot` → **200**
- [ ] `bingbot` → **200**
- [ ] `Applebot` → **200**
- [ ] `OAI-SearchBot` → **200**
- [ ] `ChatGPT-User` → **200**
- [ ] `PerplexityBot` → **200**
- [ ] Ingen statuskod 500 någonstans
- [ ] robots.txt läst från **servern** (inte från din laptop)

### 11.4 Ongoing

- [ ] Veckologgning + jämförelse
- [ ] Leverantörernas IP-listor diffas varje månad
- [ ] Modeller/crawlers uppdateras varje kvartal
- [ ] Guide uppdateras när leverantörerna ändrar sina deadlines

---

## 12. Framtida trender och hot

### 12.1 Signerade förfrågningar blir normen

`Signature-Agent` / RFC 9421 / "Web Bot Auth" gör att en leverantör kan **bevisa** att den är den den påstår sig vara — och att du kan verifiera det kryptografiskt. Det dödar UA-spoofing som ett effektivt angrepp.

**Konsekvens:** en UA-regel blir gradvis mindre värdefull, och en IP-verifierad regel mer värdefull.

### 12.2 Agentiska browsrar normaliseras

Comet har ~18 M MAU. När agentiska browsrar är mainstream blir "AI-trafik" och "människotrafik" svårare att skilja åt — och en UA-blocklista för AI-bots blir alltmer kontraproduktiv.

**Konsekvens:** instrumentet flyttar från *crawlers* till *agenter*. Det som räknas är *hur* en agent beter sig, inte *vem* den påstår sig vara.

### 12.3 Betald crawling

Cloudflares Pay per Crawl, direktprissättning via `crawler-price`, och EU:s diskussioner om "licensiering av AI-träning" gör det sannolikt att crawling blir en marknad.

**Konsekvens:** blockera inte nödvändigtvis — *prissätt*. En 402 med kontaktuppgifter är ett affärsbeslut, inte en teknisk åtgärd.

### 12.4 Standardiseringen driver leverantörerna

AIPREF-arbetsgruppen, `ai.txt`-utkastet, Content Signals-initiativet och GPAI Code of Practice pekar alla åt samma håll: **maskinläsbara policydeklarationer**. Den som ligger i framkant kan en dag få ett enda standardiserat "AI-policy"-fält och en enda header.

**Konsekvens:** publicera `/.well-known/ai.txt` nu, även om ingen läser det — det är kostnadsfritt och positionerar dig.

### 12.5 Regulering driver saker

CMA:s krav på sidnivåkontroller före mars 2027, AI Office:s tillsyn från augusti 2026, och artikel 53(1)(c)'s krav på att leverantörerna respekterar rättighetsförbehåll.

**Konsekvens:** robots.txt blir *juridisk relevant*, inte bara etikett. En korrekt fil är ett försvar.

### 12.6 Hot som inte försvinner

- **Residential proxy-nätverk** i accessnät → ASN-blockering är ineffective
- **IP-rotation per request** → per-IP-listor är ineffective
- **Robots.txt-ignorerande bots** (`Bytespider`) → policy är inte enforcement
- **Skärmbilder och rendering** → kostnad för dig, ingen UA att blockera

---

## 13. Vad som var FEL i 2025-versionen

Det här är den ärliga listan. Allt nedan fanns i guiden du skickade och är **antingen fel eller farligt**:

| # | Påstående i 2025-guiden | Verkligheten |
|---|---|---|
| 1 | *"Google Extended kan blockera din webbplats från Google-sökning!"* | **Fel.** Google-Extended gäller träning/groundning i Gemini, inte Google Search. |
| 2 | *"Anthropic IP-ranges: `RewriteCond %{REMOTE_ADDR} ^3\.[67]\. [OR]`"* | **Farligt.** `3.0.0.0/8` är Amazon, `3.67.x` är Google. Det blockerar Google/Amazon, inte Anthropic. Anthropics listor ligger i AS16509. |
| 3 | *"OpenAI IP-range: `52.230.152.` / `20.171.206.`"* | **Föråldrat och fel** — OpenAI publicerar per-crawler-filer (`gptbot.json` m.fl.). |
| 4 | `RedirectMatch 403 "proxy\|API proxy\|HTTP proxy\|…"` | **Fungerar inte som avsett.** Matchar *URL-sökvägen*, inte UA eller referer. |
| 5 | `if ('Safari' in ua and 'Chrome' in ua)` → misstänkt | **Varje Chrome.** Massfalskpositiv. |
| 6 | `required_fields = ['Mozilla','Windows','Chrome']` | **Varje iOS-användare.** Massfalskpositiv. |
| 7 | `if chrome_version > 120` → misstänkt | Straffar alla moderna användare. Värdelös signal. |
| 8 | nginx `limit_req_zone` i `server {}` | **Ogiltigt** → nginx startar inte. |
| 9 | nginx `limit_req_zone $http_user_agent` | Alla med samma UA delar hink → riktiga läsare rate-limitas. |
| 10 | nginx `add_header` efter `return` | **Körs aldrig.** |
| 11 | .htaccess utan `RewriteEngine On` | Regeln är död. |
| 12 | `User-agent: *` som "block alla OpenAI"-exempel | Blockar även Googlebot, Bingbot och dina läsare. |
| 13 | `Meta AI`, `SAM 2`, `DALL-E 3`, `V-JEPA` som UA-token | **Fiction.** Det finns inga sådana bots. |
| 14 | `GPT-crawler`, `Microsoft Copilot`, `ChatGPT` som UA-token | Föråldrade; de verkliga tokens är §1.2. |
| 15 | `"Content-Usage: ai=n"` som fungerande direktiv | Utkast, ingen leverantör läser det. |
| 16 | `Timpibot`, `peer39_crawler`, `FriendlyCrawler` som "kategorier" | Blandade verkliga och halvfärdiga; saknar UA-verifiering. |
| 17 | Redis-listor som växer obegränsat | Minnesläcka. |
| 18 | "ChatGPT Atlas" som aktiv AI-browser | **Nedlagd 2026-08-09.** |
| 19 | "Arc" som aktiv AI-browser med utveckling | Fryst sedan 2025-05; avvecklas 2026-11-23 / 2026-12-22. |
| 20 | "Kimi K2", "GLM 4.6", "GPT-5.1" som aktuella flaggmodeller | Allt äldre; se §1.1. |
| 21 | Inga styrsignaler för 2026 | Hela §4 saknades. |
| 22 | Ingen mätmetod, ingen labbverifiering | En regel som inte testats är en hypotes. |

**Mönstret:** den gamla guiden var en *sammanslagning av råd* utan verifiering. Den nya är byggd kring **leverantörernas egen dokumentation**, med datum.

---

## 14. Källor

**Standarder och utkast**
- [draft-kelley-aipref-training-preference-signal-00](https://www.ietf.org/archive/id/draft-kelley-aipref-training-preference-signal-00.html) (2026-10-30)
- [draft-ietf-aipref-vocab-08](https://datatracker.ietf.org/doc/html/draft-ietf-aipref-vocab-08) (2026-09-14)
- [draft-ietf-aipref-attach](https://datatracker.ietf.org/doc/draft-ietf-aipref-attach/)
- [draft-car-ai-txt-wellknown-00](https://datatracker.ietf.org/doc/draft-car-ai-txt-wellknown/00/) (2026-06-12)
- [RFC 9309 — Robots Exclusion Protocol](https://www.rfc-editor.org/rfc/rfc9309)
- [RFC 9421 — HTTP Message Signatures](https://www.rfc-editor.org/rfc/rfc9421)

**Leverantörer**
- [OpenAI — Overview of OpenAI Crawlers](https://platform.openai.com/docs/bots/)
- [Anthropic — Crawlers documentation](https://support.anthropic.com/en/articles/8896518-does-anthropic-crawl-data-from-the-web-and-how-can-site-owners-block-the-crawler)
- [Bing — New AI controls (2026-10-30)](https://blogs.bing.com/search/feed/)
- [Google — Robots meta tag specification](https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag)
- [Google — Search generative AI control](https://support.google.com/webmasters/answer/16908024)
- [Google — Generative AI performance report](https://support.google.com/webmasters/answer/16984139)
- [Google — Crawler IP ranges](https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers)
- [Cloudflare — AI Crawl Control](https://developers.cloudflare.com/ai-crawl-control/)
- [Cloudflare — Your site, your rules (2026-07-01)](https://blog.cloudflare.com/content-independence-day-ai-options)

**Juridik**
- [EU AI Act — Article 53](https://ai-act-service-desk.ec.europa.eu/en/ai-act/article-53)
- [Template for the Public Summary of Training Content (2025-07-24)](https://digital-strategy.ec.europa.eu/en/policies/contents-gpai)
- [Europaparlamentet — resolution 2026-07-27](https://data.europarl.europa.eu/distribution/doc/SP-2026-07-27-TA-10-2026-0066_en.docx)
- [GPAI Code of Practice](https://digital-strategy.ec.europa.eu/en/policies/contents-code-gpai)

**Referenslistor**
- [ai.robots.txt (GitHub)](https://github.com/ai-robots-txt/ai.robots.txt) — 170+ crawlers
- [Dark Visitors](https://darkvisitors.com)
- [Patrick Stox — Web Crawler & AI Bot Reference](https://patrickstox.com/bots/)
- [QuanticData — AI Crawler User Agent List](https://quanticdata.io/blog/ai-crawler-user-agent-list/)

**Modelljämförelse**
- [Artificial Analysis](https://artificialanalysis.ai/) · [LLM Benchmark](https://llmbenchmark.ai/) · [OutYet.ai](https://outyet.ai/models)

-----

*Den här guiden är ett levande dokument. AI-landskapet flyttar sig med veckor — kontrollera alltid leverantörernas egen dokumentation innan du deployar. 
#UPDATED 2027
