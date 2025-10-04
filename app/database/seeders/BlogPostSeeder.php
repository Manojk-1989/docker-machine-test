<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogPosts = [
            [
                'title' => 'Getting Started with Laravel',
                'body' => 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in most web projects.',
                'tags' => ['laravel', 'php', 'web-development', 'tutorial'],
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Building REST APIs with Laravel',
                'body' => 'REST APIs are essential for modern web applications. Laravel provides excellent tools for building robust and scalable APIs. In this post, we will explore how to create API resources, handle authentication, and implement rate limiting.',
                'tags' => ['laravel', 'api', 'rest', 'authentication'],
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Database Design Best Practices',
                'body' => 'Good database design is crucial for application performance and maintainability. This comprehensive guide covers normalization, indexing strategies, and common pitfalls to avoid when designing your database schema.',
                'tags' => ['database', 'design', 'performance', 'mysql'],
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Modern JavaScript Frameworks Compared',
                'body' => 'The JavaScript ecosystem has evolved rapidly with frameworks like React, Vue, and Angular. Each framework has its strengths and use cases. This article provides a detailed comparison to help you choose the right framework for your project.',
                'tags' => ['javascript', 'react', 'vue', 'angular', 'frontend'],
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Docker for PHP Developers',
                'body' => 'Docker has revolutionized how we develop and deploy applications. For PHP developers, Docker provides consistent environments across different machines and simplifies deployment. Learn how to containerize your Laravel applications effectively.',
                'tags' => ['docker', 'php', 'deployment', 'devops'],
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Machine Learning Basics for Web Developers',
                'body' => 'Machine learning is becoming increasingly important in web development. Understanding basic concepts like supervised learning, neural networks, and natural language processing can help you build more intelligent web applications.',
                'tags' => ['machine-learning', 'ai', 'web-development', 'python'],
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'CSS Grid vs Flexbox: When to Use What',
                'body' => 'CSS Grid and Flexbox are powerful layout systems that have transformed how we approach web design. While they share some similarities, they excel in different scenarios. This guide helps you understand when to use each layout method.',
                'tags' => ['css', 'frontend', 'layout', 'design'],
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Optimizing Laravel Performance',
                'body' => 'Performance optimization is critical for user experience and SEO. Laravel offers various techniques to improve application speed, from query optimization to caching strategies. Learn how to make your Laravel applications faster and more efficient.',
                'tags' => ['laravel', 'performance', 'optimization', 'caching'],
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create($post);
        }
    }
}
