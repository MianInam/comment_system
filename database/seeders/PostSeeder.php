<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'The Rise of Artificial Intelligence in 2024',
                'content' => 'In 2024, artificial intelligence continues to evolve at an unprecedented pace, impacting industries across the globe. AI is transforming everything from healthcare to finance, automating tasks and providing deeper insights into data.'
            ],
            [
                'title' => 'Exploring New Frontiers in Space Technology',
                'content' => 'Space exploration has reached new heights with advanced technology that allows for faster, more efficient travel beyond Earth. From private companies launching satellites to plans for crewed missions to Mars, the future of space travel is looking brighter than ever.'
            ],
            [
                'title' => 'The Future of Sustainable Energy',
                'content' => 'Sustainable energy is no longer just a trend; it is the future of global energy production. With advancements in solar, wind, and hydroelectric power, we are slowly but surely moving away from fossil fuels to cleaner alternatives.'
            ],
            [
                'title' => 'The Impact of Social Media on Mental Health',
                'content' => 'Social media platforms have revolutionized how we communicate, but their impact on mental health has become a subject of intense research. Studies suggest a strong correlation between excessive social media use and mental health challenges like anxiety and depression.'
            ],
            [
                'title' => 'How Blockchain is Revolutionizing Financial Systems',
                'content' => 'Blockchain technology is disrupting the financial world by providing secure, decentralized systems for transactions. Cryptocurrencies like Bitcoin have paved the way for a new era of digital finance, with blockchain offering transparency and reducing the risk of fraud.'
            ],
            [
                'title' => 'The Role of Remote Work in Post-Pandemic World',
                'content' => 'Remote work has emerged as a permanent shift for many industries, especially after the COVID-19 pandemic. This new model offers flexibility for employees and cost-saving benefits for employers, reshaping traditional workplace dynamics.'
            ],
            [
                'title' => 'Advancements in Quantum Computing',
                'content' => 'Quantum computing is on the cusp of revolutionizing industries by solving complex problems that were previously impossible for classical computers. With its potential to transform fields like cryptography and AI, quantum computing is a technology to watch.'
            ],
            [
                'title' => 'How Digital Marketing is Changing in 2024',
                'content' => 'The world of digital marketing is constantly evolving, with new strategies and technologies emerging each year. In 2024, businesses are using AI-powered tools, influencer marketing, and data analytics to reach their target audiences more effectively than ever before.'
            ],
            [
                'title' => 'The Rise of Electric Vehicles and Their Future',
                'content' => 'Electric vehicles (EVs) are gaining traction as a greener alternative to traditional gasoline-powered cars. With major automotive companies pushing for electric vehicle adoption and charging infrastructure improving, EVs are expected to become a dominant force in the global car market.'
            ],
            [
                'title' => 'The Importance of Cybersecurity in a Digital World',
                'content' => 'As the world becomes more digitized, the need for robust cybersecurity systems grows. Cyberattacks are becoming more sophisticated, and businesses are increasingly investing in security measures to protect their data and their customers\' information.'
            ]
        ];
        $comments = [
            "Amazing product, highly recommend!",
            "Not as good as expected.",
            "Great value for the price.",
            "The quality could be better.",
            "Exceeded my expectations!",
            "Not satisfied with this purchase.",
            "Exactly what I was looking for.",
            "Would not recommend to others.",
            "Pretty decent overall.",
            "Could use some improvements.",
            "Absolutely love it!",
            "Not worth the price.",
            "This has changed my life for the better.",
            "Disappointed with the quality.",
            "Superb experience, would buy again.",
            "Didn't meet my expectations.",
            "Excellent customer service as well.",
            "The product feels cheap.",
            "Great design and functionality.",
            "Not durable at all.",
            "Worth every penny!",
            "Feels a bit overpriced.",
            "Very reliable and high-quality.",
            "Doesn't live up to the hype.",
            "Would definitely recommend to friends.",
            "Not a fan of this product.",
            "Exactly as advertised.",
            "Not as described, very misleading.",
            "Very impressed with the results.",
            "Looks better in pictures.",
            "Functional but could improve.",
            "Terrible experience overall.",
            "Couldn't be happier with this!",
            "I've had better.",
            "Great addition to my routine.",
            "It's just okay, nothing special.",
            "Perfect for what I needed.",
            "Regret buying this.",
            "Fast shipping and great quality.",
            "Not happy with my purchase.",
            "Love the color and design!",
            "Falls apart easily.",
            "Very comfortable and stylish.",
            "Overpriced for what you get.",
            "Great quality for the price.",
            "Feels like a budget product.",
            "Works exactly as described.",
            "Not sturdy enough.",
            "Pleased with my purchase.",
            "Could be more user-friendly.",
            "Highly recommend for anyone.",
            "Cheaply made, broke quickly.",
            "Very easy to use and efficient.",
            "Needs improvement in quality.",
            "Would buy this again!",
            "Won't be buying this again.",
            "Totally satisfied with it.",
            "Didn't perform as expected.",
            "Incredible product!",
            "Waste of money.",
            "Perfect for everyday use.",
            "Stopped working after a week.",
            "Stylish and functional.",
            "Very low-quality material.",
            "This product is a game changer.",
            "Too complicated to use.",
            "Met all my expectations.",
            "Feels poorly designed.",
            "Does exactly what I need.",
            "Not as durable as I thought.",
            "Fast, efficient, and reliable.",
            "Expected more for the price.",
            "Nice addition to my collection.",
            "Product arrived damaged.",
            "Very satisfied with this!",
            "Defective item, had to return.",
            "Super easy to set up and use.",
            "Poorly constructed.",
            "Works like a charm!",
            "Doesn't work as described.",
            "Five stars, highly recommend!",
            "Not worth the hassle.",
            "Very happy with this choice.",
            "Too expensive for what you get.",
            "Love the simplicity of it.",
            "Not user-friendly at all.",
            "Definitely would purchase again.",
            "Feels very flimsy.",
            "Perfect size and shape.",
            "Hard to operate.",
            "Best purchase I've made in a while.",
            "Not good, very disappointed.",
            "Very efficient and reliable.",
            "Stopped working after a month.",
            "Good product, but overpriced.",
            "Failed to meet my needs.",
            "Pleasantly surprised!",
            "Expected better quality.",
            "Simple, yet effective.",
            "Not worth the money.",
            "Very happy with my purchase.",
            "Feels cheap and fragile.",
            "The performance is fantastic!",
            "Poor design, not impressed.",
            "Exceeded all my expectations.",
            "Not as sturdy as I hoped."
        ];



        foreach ($posts as $post) {
            $post = Post::create([
                'title' => $post['title'],
                'content' => $post['content'],
            ]);

            for ($i = 1; $i <= 30; $i++) {
                PostComment::create([
                    'user_id'=>1,
                    'post_id'=>$post->id,
                    'comment'=> $comments[array_rand($comments)]
                ]);
            }
        }
    }
}
