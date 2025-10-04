<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'content' => 'We are a leading technology company dedicated to providing innovative solutions for modern businesses. Founded in 2010, we have grown to become a trusted partner for organizations worldwide. Our team of experienced professionals is committed to delivering exceptional results and building long-lasting relationships with our clients.',
            ],
            [
                'title' => 'Services',
                'content' => 'We offer a comprehensive range of services including web development, mobile app development, cloud solutions, digital marketing, and IT consulting. Our approach combines technical expertise with creative thinking to deliver solutions that drive business growth and enhance user experience.',
            ],
            [
                'title' => 'Contact Information',
                'content' => 'Get in touch with us today to discuss your project requirements. Our team is available Monday through Friday, 9 AM to 6 PM EST. You can reach us by phone at (555) 123-4567, email at info@company.com, or visit our office at 123 Business Avenue, Tech City, TC 12345.',
            ],
            [
                'title' => 'Privacy Policy',
                'content' => 'We are committed to protecting your privacy and personal information. This privacy policy explains how we collect, use, and safeguard your data when you visit our website or use our services. We comply with all applicable privacy laws and regulations to ensure your information remains secure.',
            ],
            [
                'title' => 'Terms of Service',
                'content' => 'These terms of service govern your use of our website and services. By accessing or using our services, you agree to be bound by these terms. Please read them carefully before proceeding. If you do not agree with any part of these terms, you should not use our services.',
            ],
            [
                'title' => 'Careers',
                'content' => 'Join our dynamic team of professionals and help shape the future of technology. We offer competitive salaries, comprehensive benefits, and opportunities for professional growth. Current openings include software engineers, project managers, UX designers, and marketing specialists.',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
