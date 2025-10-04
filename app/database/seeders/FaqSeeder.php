<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I reset my password?',
                'answer' => 'To reset your password, click on the "Forgot Password" link on the login page. Enter your email address and we will send you a password reset link. Follow the instructions in the email to create a new password.',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express, Discover), PayPal, and bank transfers for business accounts. All payments are processed securely through our encrypted payment system.',
            ],
            [
                'question' => 'How long does shipping take?',
                'answer' => 'Standard shipping typically takes 3-5 business days within the continental US. Express shipping (2-day) and overnight options are available for an additional fee. International shipping times vary by destination.',
            ],
            [
                'question' => 'Can I return or exchange items?',
                'answer' => 'Yes, we offer a 30-day return policy for most items. Products must be in their original condition and packaging. Some items like digital downloads and personalized products may not be eligible for return.',
            ],
            [
                'question' => 'Do you offer technical support?',
                'answer' => 'Yes, we provide comprehensive technical support for all our products and services. You can contact our support team via email, phone, or live chat. Support hours are Monday through Friday, 9 AM to 6 PM EST.',
            ],
            [
                'question' => 'How do I track my order?',
                'answer' => 'Once your order ships, you will receive a confirmation email with a tracking number. You can use this number to track your package on our website or the carrier\'s website. Allow 24 hours for tracking information to update.',
            ],
            [
                'question' => 'Are my personal details secure?',
                'answer' => 'Absolutely. We use industry-standard encryption and security measures to protect your personal information. We never share your data with third parties without your consent, and we comply with all relevant privacy regulations.',
            ],
            [
                'question' => 'Do you offer bulk discounts?',
                'answer' => 'Yes, we offer volume discounts for orders of 10 or more items. The discount percentage increases with the quantity ordered. Contact our sales team for a custom quote based on your specific requirements.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
