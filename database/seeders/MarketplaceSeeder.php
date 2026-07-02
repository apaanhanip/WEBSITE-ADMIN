<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\ServiceCategory;
use App\Models\StockItem;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'บริการ OTP', 'slug' => 'otp', 'icon' => '📱', 'tagline' => 'รับ OTP หลากหลายประเทศ เริ่มต้น 10 บาท', 'products' => [
                ['Facebook OTP', 12, 'รับ OTP สำหรับสมัคร/ยืนยัน Facebook ระบบออโต้ ส่งทันที'],
                ['Google / Gmail OTP', 15, 'รับ OTP สำหรับสมัครบัญชี Google'],
                ['Shopee OTP', 15, 'รับ OTP สำหรับยืนยัน Shopee'],
                ['TikTok OTP', 18, 'รับ OTP สำหรับสมัคร TikTok'],
                ['TrueMoney OTP', 20, 'รับ OTP สำหรับ TrueMoney Wallet'],
            ]],
            ['name' => 'แอคเคาท์พรีเมียม', 'slug' => 'premium', 'icon' => '🎬', 'tagline' => 'Netflix, YouTube, Disney ราคาถูกที่สุด', 'products' => [
                ['Netflix Premium 30 วัน (แชร์จอ)', 79, 'ดู Netflix 4K พร้อมโปรไฟล์ส่วนตัว 1 จอ อายุ 30 วัน'],
                ['YouTube Premium 30 วัน', 39, 'ไม่มีโฆษณา ฟังเพลงพื้นหลังได้ อายุ 30 วัน'],
                ['Disney+ Hotstar 30 วัน', 59, 'ดูหนังและซีรีส์ Disney+ อายุ 30 วัน'],
                ['Canva Pro 30 วัน', 35, 'ใช้ Canva Pro เต็มรูปแบบ อายุ 30 วัน'],
            ]],
            ['name' => 'แอคเคาท์ AI', 'slug' => 'ai', 'icon' => '🤖', 'tagline' => 'ChatGPT, Gemini, Claude ราคาถูก', 'products' => [
                ['ChatGPT Plus 30 วัน (แชร์)', 199, 'ใช้งาน GPT-4 / GPT-4o แบบแชร์ 3 คน อายุ 30 วัน'],
                ['Gemini Pro 30 วัน', 149, 'Google Gemini Pro เมลร้าน อายุ 30 วัน'],
                ['Claude AI Pro 30 วัน', 179, 'Anthropic Claude Pro อายุ 30 วัน'],
            ]],
            ['name' => 'เติมเกม', 'slug' => 'game-topup', 'icon' => '🎮', 'tagline' => 'ROV, Free Fire, Valorant ระบบออโต้', 'products' => [
                ['Free Fire 100 Diamond', 35, 'เติม Free Fire 100 เพชร ระบบออโต้ กรอก Player ID'],
                ['RoV 110 คูปอง', 39, 'เติม RoV 110 คูปอง'],
                ['Valorant 475 VP', 155, 'เติม Valorant 475 Points'],
            ]],
            ['name' => 'ปั๊มฟอล/ไลค์', 'slug' => 'boost', 'icon' => '📈', 'tagline' => 'เพิ่มผู้ติดตาม TikTok, IG, FB', 'products' => [
                ['TikTok +1000 ผู้ติดตาม', 89, 'เพิ่มผู้ติดตาม TikTok 1000 คน คุณภาพสูง'],
                ['Instagram +1000 Followers', 99, 'เพิ่มผู้ติดตาม IG 1000 คน'],
                ['Facebook Page +500 ไลค์', 79, 'เพิ่มไลค์เพจ Facebook 500'],
            ]],
            ['name' => 'บัตรเงินสด', 'slug' => 'cash-card', 'icon' => '💳', 'tagline' => 'Steam, Razer Gold, Roblox', 'products' => [
                ['Steam Wallet 100 บาท', 99, 'โค้ดเติม Steam Wallet มูลค่า 100 บาท'],
                ['Razer Gold 100 บาท', 98, 'โค้ด Razer Gold 100 บาท'],
                ['Roblox Gift Card 200 บาท', 195, 'โค้ด Roblox 200 บาท'],
            ]],
        ];

        $allProducts = collect();
        $sort = 0;

        foreach ($categories as $catData) {
            $category = ServiceCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'icon' => $catData['icon'],
                    'tagline' => $catData['tagline'],
                    'description' => $catData['tagline'],
                    'sort_order' => $sort++,
                    'is_active' => true,
                ]
            );

            foreach ($catData['products'] as $i => [$name, $price, $desc]) {
                $product = Product::updateOrCreate(
                    ['slug' => $this->productSlug($catData['slug'], $name, $i)],
                    [
                        'service_category_id' => $category->id,
                        'name' => $name,
                        'description' => $desc,
                        'price' => $price,
                        'delivery_type' => 'auto_stock',
                        'is_active' => true,
                        'is_featured' => $i === 0,
                    ]
                );

                // Seed available stock
                if ($product->stockItems()->count() === 0) {
                    for ($s = 1; $s <= 12; $s++) {
                        StockItem::create([
                            'product_id' => $product->id,
                            'content' => $this->fakeStock($name, $s),
                            'status' => 'available',
                        ]);
                    }
                }

                $allProducts->push($product);
            }
        }

        // Demo customer
        $customer = User::updateOrCreate(
            ['email' => 'demo@otp24hub.test'],
            [
                'name' => 'ลูกค้าทดลอง',
                'phone' => '0812345678',
                'password' => Hash::make('password'),
                'balance' => 500,
            ]
        );

        WalletTransaction::firstOrCreate(
            ['user_id' => $customer->id, 'type' => 'topup', 'reference' => 'SEED-TOPUP'],
            [
                'amount' => 500,
                'balance_after' => 500,
                'method' => 'promptpay',
                'description' => 'เติมเงินเริ่มต้น (ตัวอย่าง)',
                'status' => 'success',
            ]
        );

        // Sample completed purchases for the "recent sales" feed & dashboard stats
        if (Purchase::count() === 0) {
            foreach (range(1, 20) as $n) {
                $product = $allProducts->random();
                $stock = StockItem::where('product_id', $product->id)->where('status', 'available')->first();
                if (! $stock) {
                    continue;
                }
                $createdAt = now()->subMinutes(random_int(5, 60 * 24 * 3));
                $purchase = Purchase::create([
                    'order_code' => strtoupper('OTP'.$createdAt->format('ymd').random_int(100000, 999999)),
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => 1,
                    'total' => $product->price,
                    'status' => 'completed',
                    'delivered_content' => $stock->content,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                $stock->update(['status' => 'sold', 'purchase_id' => $purchase->id, 'sold_at' => $createdAt]);
                $product->increment('sold_count');
            }
        }
    }

    private function productSlug(string $catSlug, string $name, int $i): string
    {
        $base = Str::slug($name);

        return $base !== '' ? $base : $catSlug.'-'.($i + 1);
    }

    private function fakeStock(string $name, int $i): string
    {
        $rand = strtoupper(Str::random(6));

        return match (true) {
            str_contains($name, 'OTP') => 'เบอร์: +66'.random_int(600000000, 699999999).' | รหัส OTP จะแสดงหลังใช้งาน',
            str_contains($name, 'Card') || str_contains($name, 'Wallet') || str_contains($name, 'Gold') || str_contains($name, 'บัตร') => 'CODE: '.$rand.'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)),
            str_contains($name, 'เพชร') || str_contains($name, 'Diamond') || str_contains($name, 'คูปอง') || str_contains($name, 'VP') || str_contains($name, 'ฟอล') || str_contains($name, 'Follow') || str_contains($name, 'ไลค์') => 'เติมให้ผ่าน Player ID/ลิงก์ที่แจ้ง | Ref: '.$rand,
            default => 'อีเมล: user'.$i.'_'.strtolower($rand).'@mail.com | รหัสผ่าน: Pass@'.$rand,
        };
    }
}
