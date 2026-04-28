<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Xbox Wireless Controller',
                'description' => 'يد تحكم إكس بوكس لاسلكية أصلية باللون الأسود الكربوني، متوافقة مع أجهزة PC و Xbox Series X/S بدقة استجابة عالية.',
                'price' => 59.99,
                'type' => 'console',
                'quantity' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1629429408209-1f9f2961b2a1?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Nintendo Switch OLED',
                'description' => 'جهاز نينتندو سويتش الجديد بشاشة OLED نابضة بالحياة بقياس 7 إنش، مثالي للعب في البيت أو أثناء التنقل عبر وضعيات اللعب المتعددة.',
                'price' => 349.99,
                'type' => 'console',
                'quantity' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1610945265064-32349780fce0?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Cyberpunk 2077',
                'description' => 'لعبة أكشن وتقمص أدوار في عالم مفتوح مستقبلي. انغمس في مدينة (نايت سيتي) وعش حياة المرتزقة في أضخم الألعاب دقة وتفصيلاً.',
                'price' => 45.00,
                'type' => 'game',
                'quantity' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1618193131614-239ffd471253?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Spider-Man 2 PS5',
                'description' => 'العب بشخصيتي بيتر باركر ومايلز مورالس في مغامرة جديدة ومذهلة تتأرجح فيها في أنحاء مارفلز نيويورك للقضاء على كرايفن وفينوم.',
                'price' => 69.99,
                'type' => 'game',
                'quantity' => 18,
                'image_url' => 'https://images.unsplash.com/photo-1605901309584-818e25960b8f?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'شاشة جيمنج 144Hz',
                'description' => 'شاشة منحنية احترافية بمعدل تحديث 144Hz وزمن استجابة 1ms. مصممة لتقليل التقطيع وتوفير تجربة بصرية فائقة النعومة للاعبي الـ PC.',
                'price' => 220.00,
                'type' => 'pc',
                'quantity' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1527443195645-1133f7f28990?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
