<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BotBlockerMiddleware
{
    /**
     * List of legitimate bots that should be allowed
     * These are search engines and legitimate crawlers
     */
    protected array $allowedBots = [
        'Googlebot',
        'Googlebot-Image',
        'Googlebot-Video',
        'Googlebot-News',
        'Google-InspectionTool',
        'Google-PageSpeed',
        'Google-Site-Verification',
        'Google-AdsBot',
        'Google-Adwords',
        'Google-Adwords-Instant',
        'Bingbot',
        'BingPreview',
        'MSNBot',
        'MSNbot',
        'msnbot-media',
        'BingAds',
        'Yahoo! Slurp',
        'Yahoo! Slurp China',
        'YandexBot',
        'YandexMobileBot',
        'YandexImages',
        'YandexVideo',
        'YandexMedia',
        'YandexBlogs',
        'YandexFavicons',
        'YandexWebmaster',
        'YandexAccessibilityBot',
        'DuckDuckBot',
        'DuckDuckBot-Image',
        'DuckDuckBot-HTTPS',
        'Baiduspider',
        'BaiduSpider',
        'Baidu-YunGuanCe',
        'BaiduMobile',
        'BaiduImage',
        'BaiduVideo',
        'BaiduNews',
        'BaiduMap',
        'Sogou Spider',
        'Sogou News Spider',
        'Sogou Mobile Spider',
        'Sogou Web Spider',
        'Sogou Image Spider',
        'Sogou Video Spider',
        'Sogou Map Spider',
        'facebookexternalhit',
        'facebookcatalog',
        'Twitterbot',
        'LinkedInBot',
        'LinkedInBot-Mobile',
        'Pinterestbot',
        'Slackbot',
        'Discordbot',
        'WhatsApp',
        'TelegramBot',
        'SkypeUriPreview',
        'Applebot',
        'Applebot-Mobile',
        'Applebot-Image',
        'AhrefsBot',
        'AhrefsBot-Mobile',
        'AhrefsBot-Desktop',
        'SemrushBot',
        'SemrushBot-SA',
        'SemrushBot-SI',
        'SemrushBot-SB',
        'SemrushBot-BA',
        'SemrushBot-MA',
        'SemrushBot-WB',
        'Majestic-SEO',
        'Majestic-12',
        'MJ12bot',
        'SEOkicks-Robot',
        'SEOkicks-Web-Crawler',
        'SEOkicks-SEO-Checker',
        'SEOkicks-Link-Checker',
        'SEOkicks-Backlink-Checker',
        'SEOkicks-Keyword-Checker',
        'SEOkicks-Rank-Checker',
        'SEOkicks-SEO-Audit',
        'SEOkicks-SEO-Analyzer',
        'SEOkicks-SEO-Optimizer',
        'SEOkicks-SEO-Scanner',
        'SEOkicks-SEO-Spider',
        'SEOkicks-SEO-Crawler',
        'SEOkicks-SEO-Bot',
        'SEOkicks-SEO-Robot',
        'SEOkicks-SEO-Engine',
        'SEOkicks-SEO-System',
        'SEOkicks-SEO-Platform',
        'SEOkicks-SEO-Tool',
        'SEOkicks-SEO-Service',
        'SEOkicks-SEO-Product',
        'SEOkicks-SEO-Solution',
        'SEOkicks-SEO-Application',
    ];

    /**
     * List of known malicious bots/scrapers to block
     */
    protected array $blockedBots = [
        // Bad scrapers
        'Bytespider',
        'Cliqzbot',
        'Scrapy',
        'Python-urllib',
        'Python-requests',
        'Go-http-client',
        'curl',
        'Wget',
        'libwww-perl',
        'lwp-trivial',
        'lwp-request',
        'HTTP::Request',
        'LWP::Simple',
        'WWW-Mechanize',
        'Mechanize',
        'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)',
        'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)',
        'Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/3.0)',
        'Mozilla/5.0 (compatible; MSIE 6.0; Windows NT 5.1)',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko/20100101 Firefox/30.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:14.0) Gecko/20100101 Firefox/14.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0) Gecko/20100101 Firefox/10.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:6.0) Gecko/20100101 Firefox/6.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:4.0) Gecko/20100101 Firefox/4.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/2.0',
        // Content scrapers
        'HTTrack',
        'WebCopier',
        'WebZIP',
        'Offline Explorer',
        'Teleport Pro',
        'Download Ninja',
        'SiteSnagger',
        'WebSnake',
        'WebReaper',
        'WebDownloader',
        'WebCapture',
        'WebGrabber',
        'WebScraper',
        'WebHarvest',
        'WebExtractor',
        'WebMiner',
        'WebParser',
        'WebExtractor',
        'WebContentExtractor',
        'WebDataExtractor',
        'WebInfoExtractor',
        'WebScraper.io',
        'WebScraping',
        'WebScraping-Api',
        'WebScraping-Service',
        'WebScraping-Tool',
        'WebScraping-Platform',
        'WebScraping-Engine',
        'WebScraping-System',
        'WebScraping-Application',
        'WebScraping-Solution',
        'WebScraping-Product',
        'WebScraping-Software',
        // Email harvesters
        'EmailSiphon',
        'EmailWolf',
        'EmailExtractor',
        'EmailCollector',
        'EmailHarvester',
        'EmailSpider',
        'EmailCrawler',
        'EmailMiner',
        'EmailParser',
        'EmailExtractor',
        'EmailGrabber',
        'EmailHunter',
        'EmailFinder',
        'EmailScraper',
        'EmailScraping',
        'Email-Collector',
        'Email-Spider',
        'Email-Crawler',
        'Email-Miner',
        'Email-Parser',
        // Spam bots
        'spambot',
        'spam-bot',
        'spam_bot',
        'spider-bot',
        'spider_bot',
        'crawler-bot',
        'crawler_bot',
        'scraper-bot',
        'scraper_bot',
        'harvest-bot',
        'harvest_bot',
        'harvester-bot',
        'harvester_bot',
        'collector-bot',
        'collector_bot',
        'miner-bot',
        'miner_bot',
        'extractor-bot',
        'extractor_bot',
        'parser-bot',
        'parser_bot',
        'grabber-bot',
        'grabber_bot',
        'hunter-bot',
        'hunter_bot',
        'finder-bot',
        'finder_bot',
        'seeker-bot',
        'seeker_bot',
        'scout-bot',
        'scout_bot',
        'spy-bot',
        'spy_bot',
        'agent-bot',
        'agent_bot',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ─── CHECK IF BOT BLOCKING IS ENABLED ───
        if (!config('app.bot_blocking_enabled', true)) {
            return $next($request);
        }

        $userAgent = $request->userAgent();
        
        // ─── IF NO USER AGENT, BLOCK (likely a bot) ───
        if (empty($userAgent)) {
            abort(403, 'Access Denied');
        }

        // ─── CHECK IF ALLOWED BOT ───
        foreach ($this->allowedBots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return $next($request);
            }
        }

        // ─── CHECK IF BLOCKED BOT ───
        foreach ($this->blockedBots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                // ─── LOG BLOCKED BOT ───
                \Log::warning('Bot blocked', [
                    'user_agent' => $userAgent,
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                ]);
                
                abort(403, 'Access Denied');
            }
        }

        // ─── CHECK FOR SUSPICIOUS PATTERNS ───
        $suspiciousPatterns = [
            '/scrape/i',
            '/scraping/i',
            '/harvest/i',
            '/harvesting/i',
            '/extract/i',
            '/extracting/i',
            '/collect/i',
            '/collecting/i',
            '/mining/i',
            '/parser/i',
            '/parsing/i',
            '/grabber/i',
            '/spider/i',
            '/crawler/i',
            '/bot/i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                // ─── CHECK IF IT'S A LEGITIMATE BOT WITH "bot" IN NAME ───
                $isLegitimate = false;
                foreach ($this->allowedBots as $allowed) {
                    if (stripos($userAgent, $allowed) !== false) {
                        $isLegitimate = true;
                        break;
                    }
                }
                
                if (!$isLegitimate) {
                    \Log::warning('Suspicious bot pattern detected', [
                        'user_agent' => $userAgent,
                        'ip' => $request->ip(),
                        'url' => $request->fullUrl(),
                        'pattern' => $pattern,
                    ]);
                    
                    abort(403, 'Access Denied');
                }
            }
        }

        return $next($request);
    }
}