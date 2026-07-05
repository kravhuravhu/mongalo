<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        DB::table('admins')->insert([
            'name' => 'Arthur Mongalo',
            'email' => 'admin@thecollective.co.za',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Books
        $books = [
            [
                'title' => 'Divine Identity',
                'slug' => 'divine-identity',
                'subtitle' => 'Who God Says You Are',
                'description' => 'A revelatory book that dismantles the lies holding you back and equips you to walk boldly in your God-given purpose. Written from real ministry conversations over a decade of serving believers across South Africa.',
                'price' => 149.00,
                'is_featured' => 1,
                'cover_color' => '#a67c4e',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Walking in Freedom',
                'slug' => 'walking-in-freedom',
                'subtitle' => 'Breaking Chains You Didn\'t Know You Were Carrying',
                'description' => 'Discover the freedom that comes from understanding your identity in Christ and breaking free from generational patterns. A practical guide to living in victory.',
                'price' => 129.00,
                'is_featured' => 0,
                'cover_color' => '#8B6B4A',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '40 Days of Growth',
                'slug' => 'forty-days-of-growth',
                'subtitle' => 'A Daily Journey Through Scripture, Reflection, and Prayer',
                'description' => 'A 40-day devotional designed to help you grow in your faith, deepen your prayer life, and discover new dimensions of God\'s love. Perfect for personal or group study.',
                'price' => 99.00,
                'is_featured' => 0,
                'cover_color' => '#C49A6C',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($books as $book) {
            DB::table('books')->insert($book);
        }

        // Free Resources
        $freeResources = [
            [
                'title' => 'Gideon SA Booklet',
                'slug' => 'gideon-sa-booklet',
                'subtitle' => 'Classic Evangelism Tool',
                'description' => 'A timeless resource for sharing your faith. Perfect for personal use or giving away to friends and family.',
                'price' => 0.00,
                'is_free' => 1,
                'cover_color' => '#2C5F2D',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Chick Publications Sample',
                'slug' => 'chick-publications-sample',
                'subtitle' => 'Gospel Tracts Collection',
                'description' => 'Sample collection of powerful gospel tracts that clearly present the message of salvation in a simple, engaging way.',
                'price' => 0.00,
                'is_free' => 1,
                'cover_color' => '#1A3A4A',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pocket Bible (PDF)',
                'slug' => 'pocket-bible-pdf',
                'subtitle' => 'The Gospel of John',
                'description' => 'A digital pocket Bible featuring the Gospel of John. Perfect for reading on your phone or tablet wherever you go.',
                'price' => 0.00,
                'is_free' => 1,
                'cover_color' => '#2C3E50',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Salvation Prayer Guide',
                'slug' => 'salvation-prayer-guide',
                'subtitle' => 'Your First Steps in Faith',
                'description' => 'A simple guide to help you pray the prayer of salvation and begin your journey with God. Includes scripture references and next steps.',
                'price' => 0.00,
                'is_free' => 1,
                'cover_color' => '#8B6914',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($freeResources as $resource) {
            DB::table('books')->insert($resource);
        }

        // Events
        $events = [
            [
                'title' => 'Identity in Christ Conference',
                'slug' => 'identity-in-christ-conference',
                'description' => 'Join us for a powerful day of discovering who you are in Christ. Worship, teaching, and community. Bring a friend!',
                'date' => now()->addDays(30)->format('Y-m-d'),
                'time' => '09:00:00',
                'location' => 'Sandton Convention Centre, Johannesburg',
                'capacity' => 200,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Faith & Purpose Revival Night',
                'slug' => 'faith-purpose-revival-night',
                'description' => 'An evening of worship, testimony, and prayer. Come expecting breakthrough. Doors open at 5:30 PM.',
                'date' => now()->addDays(45)->format('Y-m-d'),
                'time' => '18:00:00',
                'location' => 'Pretoria Community Hall, Pretoria',
                'capacity' => 150,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->insert($event);
        }
    }
}