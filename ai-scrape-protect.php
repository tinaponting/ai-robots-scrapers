<?php
/*
* Plugin Name:      AI Scrape Protect
* Plugin URI:       https://wordpress.org/plugins/ai-scrape-protect/
* Description:      Protects your website from AI scraping by adding opt-out instructions to robots.txt for common AI bots and adding meta tags to HTML head.
* Version:          3.1
* Tested up to:     6.7.2
* Author:           Uisce Web Development, Daan Verbaan
* Author URI:       https://uisce.eu
* License:          GPL v2 or later
* License URI:      https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:      ai-scrape-protect
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook into the admin_enqueue_scripts action to add the CSS to the admin area
function ai_scrape_protect_enqueue_admin_styles() {
    // Get the plugin directory
    $plugin_url = plugin_dir_url( __FILE__ );

    // Enqueue your custom admin CSS
    wp_enqueue_style( 'ai-scrape-protect-admin-style', $plugin_url . 'css/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'ai_scrape_protect_enqueue_admin_styles' );


class AISP_Manage_Robots_Txt {
	
    private $user_agents = [
        ".ai",
        ".AI",	
        "AI agents /",	
		"Agent GPT",
        "AgentGPT",
        "Agentic",
        "AI Article Writer",
        "AI Content Detector",
        "AI Dungeon",
        "AI Search Engine",
        "AI SEO Crawler",
        "AI Training /",
        "AITraining",
        "AI Writer",
        "AI2 Bot",
        "AI2Bot",
        "AI21 Labs",
        "AIBot",
        "AIMatrixCrawler",
        "AISearchBot",
        "AITraining /",
        "Alpha AI",
        "AlphaAI",
        "AIMatrix",
        "Alexa",
        "AlexaTM",
        "Amazon Bedrock",
        "Amazon Comprehend",
        "Amazon Lex",
        "Amazon SageMaker",
        "Amazon Silk",
        "Amazon Textract",
        "AmazonBot", 
        "amazonbot",  
        "amazon-kendra",
        "amazon-kendra",
        "Nova Act",
        "Amelia",
        "AndersPinkBot",
        "Anthropic",
        "anthropic-ai",
		"AIMatrixCrawler", 
        "AnyPicker",
        "Anyword",
        "Applebot",
        "Applebot-Extended",
        "Aria Browse",
        "Aria browse Aria AI",
        "Aria browser AI",
        "Articoolo",
        "AutoGPT",
        "Automated Writer",
        "AwarioRssBot",
        "AwarioSmartBot",
        "AWS Trainium",
        "BardBot",
        "Bing ai",
        "BingAI",
        "Bingbot-chat",
        "bingbot-chat/2.0",
        "Brave Leo",
        "Brave Leo AI",
        "Brightbot 1.0",
        "ByteDance",
        "ByteDance crawler",
        "Bytespider",
        "Bytedance",
        "CrawlGPT", 
        "CatBoost",
        "CCBot",
        "ccbot",
        "CCBot/2.0",
        "CC-Crawler",
        "CC-Crawler/2.0",
        "ChatGLM",
        "ChatGPT",	
        "chatUser",
        "Claude-User",
        "Claude-SearchBot",	
        "ChatGPT-User",
        "ChatGPT-User/1.0",
        "Chinchilla", 
        "Claude",
        "claude-web/1.0",
        "ClaudeBot/1.0",			
        "Claude 3.5 Haiku", 
        "Claude 3.7 Sonnet", 
        "Claude Opus",        
        "ClaudeBot",           
        "Claude bot",
        "ClaudeBot/1.0",
        "Claude 2.0",
        "Claude 2.1",
        "Claude-Web/1.0",
        "Claude-Web",
        "ClearScope",
        "Cohere",
		"cohere-ai",
        "cohere-training-data-crawler",
		"Cotoyogi",
		"Common Crawl",
		"commoncrawl",
		"Content Harmony",
		"Content King",
		"Content Optimizer",
		"Content Samurai",
		"Content Scraper GPT",
		"ContentAtScale",
		"ContentBot",
		"Contentedge",
		"Conversion AI",
		"Copilot",
		"CopyAI",
		"Copymatic",
		"Copyscape",
		"Cotoyogi",
		"CrawlQ AI",
		"CrawlGPT",
        "gpt-crawler",
		"Crawlspace",
		"CopyAI",
		"Crew AI",
		"crewAI",
		"DALL-E",
		"DALL-E 2",
		"DALL·E 3",
		"DALL-E Mini",
		"DataForSeoBot",
		"DataProvider",
		"dataprovider",
		"DeepAI",
		"DeepL",
		"DeepMind",
		"DeepSeek",
		"DeepSeek-R1",
		"DepolarizingGPT",
		"DialoGPT",
		"Diffbot",
		"Doubao AI",
		"DuckAssistBot",
		"Extended GPT Scraper",
		"FacebookBot",
		"FacebookBot/1.0",
		"FacebookExternalHit",
		"facebookexternalhit",
		"facebookexternalhit/1.1",
		"Firecrawl",
		"FirecrawlAgent",
		"Flyriver",
		"flyriverbot/1.1",
		"Frase AI",
		"FriendlyCrawler",
		"FriendlyCrawler/1.0",
		"FriendlyCrawler/Nutch-1.20-SNAPSHOT",
		"FraudGPT",
		"Gato",
		"Gemini",
		"Gemma",
		"GenAI",
		"Google Bard AI",
		"Google Gemini",
		"Google-CloudVertexBot",
		"GPT",
		"GTB Bot",
		"GTBot",
		"GTPBOT",
		"Goose",
		"GPT 4 Omni",
		"GPT 4 Omni Mini",
		"GPTBot",
		"GPTBot /",
		"GPTZero",
		"GPT-1",
		"GPT-2",
		"GPT-3",
		"GPT-3.5",
		"GPT-3.5 Turbo",
		"GPT-4",
		"GPT-4,5",
		"GPT-5",
		"GPT-4o",
		"GPT-4o mini",
		"GPT-4V",
		"gpt-4-turbo",
		"Content Scraper GPT",
		"Extended GPT Scraper",
		"GPT Scraper",
		"SearchGPT", 
		"GPT", 
		"Grammarly",
		"Grok",
		"GrokAI",
		"Goose",
		"Grendizer",		
		"Hemingway Editor",
		"Hugging Face",
		"Hypotenuse AI",
		"iaskspider",
		"iaskspider/2.0",
	    "iAskBot",
		"ICC-Crawler",
		"ImagesiftBot",
		"img2dataset",
		"Inferkit",
		"INK Editor",
		"INKforall",
		"IntelliSeek",
		"IntelliSeek.ai",
		"ISSCyberRiskCrawler",
		"JasperAI",
		"Kafkai",
		"Kangaroo",
		"Kangaroo Bot",
		"Keyword Density AI",
		"knowledge",
		"KomoBot",
		"LeftWingGPT",
		"LLaMA",
		"Llama 3.2",
		"Llama 4",
		"magpie-crawler",
		"MarketMuse",
		"MetaTagBot",
		"MetaAI",
		"MetaTagBot",
		"Meta-AI",
		"Meta AI",
		"Meta Llama",
		"Meta-ExternalI",
		"Meta-ExternalAgent",
		"Meta-ExternalFetcher",
		"meta-externalagent",
		"meta-externalfetcher/1.1",
		"Meltwater",
		"Mistral",
		"Narrative",
		"NeevaBot",
		"Neural Text",
		"NeuralSEO",
		"Narrative",		
		"Narrative Device",
		"Nicecrawler",
		"MSBot",
		"OAI SearchBot",
		"OAI-SearchBot/1.0",
		"Omgili",
		"Omgilibot",
		"Open AI",
		"OpenAI",
		"OpenAI o1",
		"OpenAI o1-mini",
		"OpenAI o3-mini",
		"OpenAIContentCrawler",
		"OpenAI Crawler",
		"OpenAI CUA",
		"Operator",
		"Openbot",
		"OpenBot",
		"OpenText AI",
		"Outwrite",
		"PanguBot",
		"peer39_crawler",
		"peer39_crawler/1.0",
		"PerplexityBot",
		"PetalBot",
		"PiplBot",
		"proximic",
		"PaperLiBot",
		"PaperLiBot/2.1",
		"Perplexity-User/1.0",
		"Perplexit-User",
		"PerplexityUser",
		"PhindBot",
		"ProWritingAid",
		"Paraphraser.io",
		"Page Analyzer AI",
		"QuillBot",
		"Rytr",
		"RobotSpider",		
		"RightWingGPT",
		"Scalenut",
		"SaplingAI",
		"SkyDancer",
		"SEO Content Machine",
		"SlickWrite",
		"Sudowrite",
		"Spinbot",
		"ScriptBook",
		"ScalenutBot",
		"Scraper",
		"Scrapy",
		"Scrapy/2.0",
		"SearchGPT",
		"SemrushBot-OCOB",
		"sentibot",
		"ScrapeGPT",
		"SEO Content Machine",
		"SEO Robot",
		"ShadowGPT",
		"Seekr",
		"StableDiffusionBot",
		"Sidetrade",
		"Simplified AI",
		"SlickWrite",
		"Spin Rewriter",
		"Stability",
		"Stability AI",
		"Sudowrite",
		"Surfer AI",
		"Text Blaze",
		"TextCortex",
		"thehive.ai",
		"The Knowledge AI",
		"Timpibot",
		"Timpibot/0.8",
		"TurnitinBot",
		"VelenPublicWebCrawler",
		"Vidnami AI",
		"WebChatGPT",
		"Webzio",
		"Webzio-Extended",
		"WebText /",
		"Whisper",
		"wormsGTP",
		"WormGPT V3.0",
		"wpbot",
		"wpbot/1.1",
		"wpbot/1.2",
		"Writescope",
		"WriterZen",
		"WordAI",
		"Writesonic",
		"Wordtune",
		"Writecream",
		"Vidnami AI",
		"x.AI",
		"X.AI",
        "XBot", 		
        "xBot",
		"Zero GTP",
		"ZeroCHAT",
		"Zerochat",
		"ZeroGPT",
		"Zimm",
		"yarchatgpt",
        "YarGPT",
        "YouBot"
    ];

    public function __construct() {
        add_filter('robots_txt', [$this, 'modify_robots_txt'], 999, 2); // Use higher priority
    }

    public function modify_robots_txt($output, $public) {
        $output .= "\n# START AI Scrape Protect block\n# ---------------------------\n";

        // Add all User-agent rules
        foreach ($this->user_agents as $user_agent) {
            $output .= "User-agent: $user_agent\n";
        }

        // Add a single Disallow rule for all User-agents
        $output .= "Disallow: /\n";
        $output .= "# ---------------------------\n# END AI Scrape Protect block\n";

        return $output;
    }
}

class AISP_Add_Meta_Tags {

    public function __construct() {
        add_action('wp_head', [$this, 'add_ai_meta_tags'], 1);
    }

    public function add_ai_meta_tags() {
        echo "\n<!-- AI Scrape Protect Meta Tags -->\n\n";

        // Prevents OpenAI's GPTBot from accessing and using the content for AI model training.
        echo "<!-- Prevents OpenAI's GPTBot from accessing the content. -->\n";
        echo '<meta name="gptbot" content="disallow">' . "\n";

        // Instructs general AI bots to avoid indexing, summarizing, or using the content for AI purposes.
        echo "<!-- Instructs general AI bots to avoid indexing, summarizing, or using the content. -->\n";
        echo '<meta name="robots" content="noai, nosummary">' . "\n";

        // Prevents Bing's bot from using the content for AI-related purposes, such as training language models.
        echo "<!-- Prevents Bing's bot from using the content for AI purposes. -->\n";
        echo '<meta name="bingbot" content="nocache">' . "\n";

        // Adds a future-proof tag to prohibit AI training.
        echo "<!-- Future-proof tag for prohibiting AI training. -->\n";
        echo '<meta name="robots" content="DisallowAITraining">' . "\n";

        // Prevents AI use of images.
        echo "<!-- Prevents AI use of images. -->\n";
        echo '<meta name="robots" content="noai, noimageai">' . "\n";

        // Adds a dedicated meta tag for CCBot.
        echo "<!-- Dedicated meta tag for CCBot. -->\n";
        echo '<meta name="CCBot" content="nofollow">' . "\n\n";

        echo "<!-- End AI Scrape Protect Meta Tags -->\n";
    }
}

// Add icons to the WordPress Admin Bar
class AISP_Admin_Bar_Icons {

    public function __construct() {
        // Hook into WordPress admin bar to display icons
        add_action('admin_bar_menu', [$this, 'add_admin_bar_icons'], 100);
    }

    public function add_admin_bar_icons($admin_bar) {
        // Ensure the function is loaded and available
        if ( !function_exists('is_plugin_active') ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        // Check if the plugin is active
        $is_plugin_active = is_plugin_active('ai-scrape-protect/ai-scrape-protect.php');

        // Define the icon URLs based on the plugin state
        $icon_url = $is_plugin_active ? plugin_dir_url(__FILE__) . 'images/ai-scrape-protect-active.png' : '';

        // Debug: Output for testing
        // error_log('Plugin active: ' . ($is_plugin_active ? 'Yes' : 'No'));

        // Add an item to the admin bar with the corresponding icon
        $admin_bar->add_node([
            'id'    => 'ai-scrape-protect-icon',
            'title' => '<img src="' . esc_url($icon_url) . '" alt="' . __('AI Scrape Protect Icon', 'ai-scrape-protect') .'" title="' . __('AI Scrape Protection enabled, click for plugin info', 'ai-scrape-protect') .'" style="height: 20px; width: 20px;"/>',
            'href'  => 'https://uisce.eu/wordpress-ai-scrape-protect-plugin/', 
            'meta'  => [
                'target' => '_blank' 
            ]
        ]);
    }
}




// Initialize all classes
new AISP_Manage_Robots_Txt();
new AISP_Add_Meta_Tags();
new AISP_Admin_Bar_Icons();
