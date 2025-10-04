<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\LogSearchQuery;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\Page;
use App\Models\Faq;
use App\Models\SearchLog;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * Unified search across all content types.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $startTime = microtime(true);
        
        $query = $request->query('q');
        $perPage = (int) $request->query('per_page', 10);
        $page = (int) $request->query('page', 1);

        if (!$query) {
            return response()->json([
                'error' => 'Search query is required',
                'message' => 'Please provide a search query parameter (q)',
            ], 400);
        }

        // Get all results from each model (without pagination first)
        $blogPosts = BlogPost::search($query)->get();
        $products = Product::search($query)->get();
        $pages = Page::search($query)->get();
        $faqs = Faq::search($query)->get();

        // Combine all results into a single collection with type information
        $allResults = collect();
        
        foreach ($blogPosts as $item) {
            $allResults->push([
                'item' => $item,
                'type' => 'blog_post',
                'score' => $item->_score ?? 0,
            ]);
        }
        
        foreach ($products as $item) {
            $allResults->push([
                'item' => $item,
                'type' => 'product',
                'score' => $item->_score ?? 0,
            ]);
        }
        
        foreach ($pages as $item) {
            $allResults->push([
                'item' => $item,
                'type' => 'page',
                'score' => $item->_score ?? 0,
            ]);
        }
        
        foreach ($faqs as $item) {
            $allResults->push([
                'item' => $item,
                'type' => 'faq',
                'score' => $item->_score ?? 0,
            ]);
        }

        // Sort by relevance score (descending)
        $allResults = $allResults->sortByDesc('score')->values();

        // Calculate totals
        $totalResults = $allResults->count();
        $totalPages = (int) ceil($totalResults / $perPage);

        // Apply pagination
        $offset = ($page - 1) * $perPage;
        $paginatedResults = $allResults->slice($offset, $perPage);

        // Format results
        $formattedResults = $paginatedResults->map(function ($result) {
            return $this->formatSingleResult($result['item'], $result['type']);
        })->values()->toArray();

        // Get breakdown counts
        $resultsBreakdown = [
            'blog_posts' => $blogPosts->count(),
            'products' => $products->count(),
            'pages' => $pages->count(),
            'faqs' => $faqs->count(),
        ];

        $results = [
            'query' => $query,
            'results' => $formattedResults,
            'results_breakdown' => $resultsBreakdown,
            'pagination' => [
                'total_results' => $totalResults,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => $totalPages,
            ],
        ];

        // Calculate response time
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        // Log search asynchronously
        $this->logSearch($request, $query, $totalResults, $resultsBreakdown, $page, $perPage, $responseTime);

        return response()->json($results);
    }

    /**
     * Get search suggestions (optional).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = $request->query('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        // Get suggestions from all models
        $suggestions = [];

        // Blog post suggestions
        $blogSuggestions = BlogPost::search($query)
            ->take(3)
            ->get()
            ->pluck('title')
            ->toArray();
        $suggestions = array_merge($suggestions, $blogSuggestions);

        // Product suggestions
        $productSuggestions = Product::search($query)
            ->take(3)
            ->get()
            ->pluck('name')
            ->toArray();
        $suggestions = array_merge($suggestions, $productSuggestions);

        // Page suggestions
        $pageSuggestions = Page::search($query)
            ->take(2)
            ->get()
            ->pluck('title')
            ->toArray();
        $suggestions = array_merge($suggestions, $pageSuggestions);

        // Remove duplicates and limit
        $suggestions = array_unique($suggestions);
        $suggestions = array_slice($suggestions, 0, 10);

        return response()->json($suggestions);
    }

    /**
     * Format search results for API response.
     *
     * @param mixed $results
     * @param string $type
     * @return array
     */
    private function formatResults($results, string $type): array
    {
        return $results->map(function ($item) use ($type) {
            return $this->formatSingleResult($item, $type);
        })->toArray();
    }

    /**
     * Format a single search result.
     *
     * @param mixed $item
     * @param string $type
     * @return array
     */
    private function formatSingleResult($item, string $type): array
    {
        $formatted = [
            'id' => $item->id,
            'type' => $type,
            'title' => $this->getTitle($item, $type),
            'snippet' => $this->getSnippet($item, $type),
            'url' => $this->getUrl($item, $type),
            'relevance_score' => $item->_score ?? null,
        ];

        // Add type-specific metadata
        if ($type === 'blog_post') {
            $formatted['published_at'] = $item->published_at?->toISOString();
            $formatted['tags'] = $item->tags ?? [];
        } elseif ($type === 'product') {
            $formatted['price'] = $item->price ?? null;
            $formatted['category'] = $item->category ?? null;
        }

        return $formatted;
    }

    /**
     * Get title for different content types.
     *
     * @param mixed $item
     * @param string $type
     * @return string
     */
    private function getTitle($item, string $type): string
    {
        return match ($type) {
            'blog_post' => $item->title,
            'product' => $item->name,
            'page' => $item->title,
            'faq' => $item->question,
            default => '',
        };
    }

    /**
     * Get snippet for different content types.
     *
     * @param mixed $item
     * @param string $type
     * @return string
     */
    private function getSnippet($item, string $type): string
    {
        return match ($type) {
            'blog_post' => $this->truncateText($item->body, 200),
            'product' => $this->truncateText($item->description, 200),
            'page' => $this->truncateText($item->content, 200),
            'faq' => $this->truncateText($item->answer, 200),
            default => '',
        };
    }

    /**
     * Get URL for different content types.
     *
     * @param mixed $item
     * @param string $type
     * @return string
     */
    private function getUrl($item, string $type): string
    {
        return match ($type) {
            'blog_post' => "/blog/{$item->id}",
            'product' => "/products/{$item->id}",
            'page' => "/pages/{$item->id}",
            'faq' => "/faqs/{$item->id}",
            default => '',
        };
    }

    /**
     * Get search logs (admin only).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSearchLogs(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 20);
        $query = $request->query('query'); // Filter by search query
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $logsQuery = SearchLog::query()
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($query) {
            $logsQuery->where('query', 'like', "%{$query}%");
        }

        if ($startDate) {
            $logsQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $logsQuery->whereDate('created_at', '<=', $endDate);
        }

        $logs = $logsQuery->paginate($perPage);

        return response()->json([
            'logs' => $logs->items(),
            'pagination' => [
                'total' => $logs->total(),
                'per_page' => $logs->perPage(),
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
            ],
        ]);
    }

    /**
     * Get search analytics (admin only).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSearchAnalytics(Request $request): JsonResponse
    {
        $days = $request->query('days', 7);

        // Get popular searches
        $popularSearches = SearchLog::query()
            ->where('created_at', '>=', now()->subDays($days))
            ->selectRaw('query, COUNT(*) as count, AVG(total_results) as avg_results')
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Get searches with no results
        $noResultSearches = SearchLog::query()
            ->where('created_at', '>=', now()->subDays($days))
            ->where('total_results', 0)
            ->selectRaw('query, COUNT(*) as count')
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Get average response time
        $avgResponseTime = SearchLog::query()
            ->where('created_at', '>=', now()->subDays($days))
            ->avg('response_time');

        // Get total searches
        $totalSearches = SearchLog::query()
            ->where('created_at', '>=', now()->subDays($days))
            ->count();

        return response()->json([
            'period_days' => $days,
            'total_searches' => $totalSearches,
            'avg_response_time' => round($avgResponseTime, 2),
            'popular_searches' => $popularSearches,
            'no_result_searches' => $noResultSearches,
        ]);
    }

    /**
     * Rebuild search index (admin only).
     *
     * @return JsonResponse
     */
    public function rebuildIndex(): JsonResponse
    {
        try {
            // Rebuild index for all models
            BlogPost::search()->flush();
            Product::search()->flush();
            Page::search()->flush();
            Faq::search()->flush();

            // Re-import all records
            BlogPost::makeAllSearchable();
            Product::makeAllSearchable();
            Page::makeAllSearchable();
            Faq::makeAllSearchable();

            return response()->json([
                'message' => 'Search index rebuilt successfully',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to rebuild search index',
                'error' => $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Truncate text to specified length.
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    private function truncateText(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . '...';
    }

    /**
     * Log search query asynchronously.
     *
     * @param Request $request
     * @param string $query
     * @param int $totalResults
     * @param array $resultsBreakdown
     * @param int $page
     * @param int $perPage
     * @param float $responseTime
     * @return void
     */
    private function logSearch(
        Request $request,
        string $query,
        int $totalResults,
        array $resultsBreakdown,
        int $page,
        int $perPage,
        float $responseTime
    ): void {
        $searchData = [
            'query' => $query,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $request->user()?->id,
            'total_results' => $totalResults,
            'results_breakdown' => $resultsBreakdown,
            'page' => $page,
            'per_page' => $perPage,
            'response_time' => $responseTime,
        ];

        // Dispatch job to log search asynchronously
        LogSearchQuery::dispatch($searchData)->onQueue('logs');
    }
}
