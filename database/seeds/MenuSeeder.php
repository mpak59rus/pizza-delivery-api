<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database menu seeds.
     *
     * @return void
     */
    public function run()
    {
        $pizza = new Category([
            'title' => 'Pizza',
            'slug' => 'pizza',
            'description' => 'Our delicious and juicy pizzas',
            'sort' => 1
        ]);
        $pizza->save();

        $sides = new Category([
            'title' => 'Sides',
            'slug' => 'sides',
            'description' => 'If u need more then just pizza',
            'sort' => 2
        ]);
        $sides->save();

        $drink = new Category([
            'title' => 'Drinks',
            'slug' => 'drinks',
            'description' => 'Something to drink with the pizza',
            'sort' => 3
        ]);
        $drink->save();

        $pizza->products()->saveMany([
            new Product([
                'title' => 'Mexican',
                'slug' => 'mexican-pizza',
                'description' => 'Jalapeno peppers, cherry tomatoes, mozzarella, marinara sauce, green peppers, red onions, sweet corn, extra meatballs',
                'price_eur' => 13.90,
                'price_usd' => 12.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/478f3f39-7e3c-4603-adf7-aa10c5389ba7.jpg',
                'sort' => 1
            ]),
            new Product([
                'title' => 'Mushrooms',
                'slug' => 'mushrooms-pizza',
                'description' => 'Mushrooms, hard cheese, truffle oil, creamy sauce, mozzarella',
                'price_eur' => 12.90,
                'price_usd' => 11.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/76012cdd-945a-4afc-886e-4f166ea3a7e5.jpg',
                'sort' => 2
            ]),
            new Product([
                'title' => 'Cheese & Tomato',
                'slug' => 'cheese-tomato-pizza',
                'description' => 'Marinara sauce, cherry tomatoes, extra mozzarella, oregano',
                'price_eur' => 11.20,
                'price_usd' => 10.20,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/f5faee9e-063a-4a2f-9a1d-3d2becc759ed.jpg',
                'sort' => 3
            ]),
            new Product([
                'title' => 'Farm',
                'slug' => 'farm-pizza',
                'description' => 'Marinara sauce, cherry tomatoes, extra mozzarella, oregano',
                'price_eur' => 12.90,
                'price_usd' => 11.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/b3766d96-475f-46f8-9e6f-c0393af30638.jpg',
                'sort' => 4
            ]),
            new Product([
                'title' => '4 Cheese',
                'slug' => '4cheese-pizza',
                'description' => 'Creamy sauce, cheddar, blue cheese, mozzarella cheese, hard cheese',
                'price_eur' => 12.90,
                'price_usd' => 11.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/9dc7f77d-61b3-4a4c-b0d5-e52c36449896.jpg',
                'sort' => 5
            ]),
            new Product([
                'title' => 'Chicken BBQ',
                'slug' => 'chicken-bbq-pizza',
                'description' => 'Bbq sauce, red onions, bacon, mozzarella, extra chicken, marinara sauce',
                'price_eur' => 12.90,
                'price_usd' => 11.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/0e1eff92-7102-4aa7-8f66-24cac7913204.jpg',
                'sort' => 6
            ]),
            new Product([
                'title' => 'Veggie',
                'slug' => 'veggie-pizza',
                'description' => 'Creamy sauce, sweet corn, red onions, green peppers, mozzarella, cherry tomatoes, mushrooms',
                'price_eur' => 11.90,
                'price_usd' => 10.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/8023ba8e-dcce-4824-b7f0-0ee265c2ad22.jpg',
                'sort' => 7
            ]),
            new Product([
                'title' => 'Hawaiian',
                'slug' => 'hawaiian-pizza',
                'description' => 'Ham, extra mozzarella, marinara sauce, pineapple',
                'price_eur' => 12.40,
                'price_usd' => 11.30,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Pizza/en-GB/bf512c1e-1d41-4255-af21-24d9f102026d.jpg',
                'sort' => 8
            ]),
        ]);

        $sides->products()->saveMany([
            new Product([
                'title' => 'Chicken Strips',
                'slug' => 'chicken-strips',
                'description' => 'Oven-baked crispy coated whole chicken breast strips. 6 pieces',
                'price_eur' => 4.40,
                'price_usd' => 3.30,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Snacks/en-GB/6c536d58-553f-4979-99ca-2f00997e64a2.jpg',
                'sort' => 1
            ]),
            new Product([
                'title' => 'Cheesy Garlic Sticks',
                'slug' => 'cheesy-garlic-sticks',
                'description' => 'Fresh dough topped with mozzarella, hard cheese, mayo, minced garlic and herbs. Dip sauce included',
                'price_eur' => 5.30,
                'price_usd' => 4.30,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Snacks/en-GB/78b9ea94-dfc2-4dc5-81de-309e06dfc0fc.jpg',
                'sort' => 2
            ]),
        ]);

        $drink->products()->saveMany([
            new Product([
                'title' => 'Coca-Cola',
                'slug' => 'coca-cola',
                'description' => '500 ml',
                'price_eur' => 1.50,
                'price_usd' => 0.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Drinks/en-GB/ff0a8b25-0579-4ddf-a58a-1b61c002554f.jpg',
                'sort' => 1
            ]),
            new Product([
                'title' => 'Coca-Cola Zero',
                'slug' => 'coca-cola-zero',
                'description' => '500 ml',
                'price_eur' => 1.50,
                'price_usd' => 0.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Drinks/en-GB/1c24d049-953c-409f-8aeb-b98c95a20ce3.jpg',
                'sort' => 2
            ]),
            new Product([
                'title' => 'Fanta',
                'slug' => 'fanta',
                'description' => '500 ml',
                'price_eur' => 1.50,
                'price_usd' => 0.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Drinks/en-GB/fa16aff3-5782-45a4-902a-9c5878b51abb.jpg',
                'sort' => 3
            ]),
            new Product([
                'title' => 'Sprite',
                'slug' => 'sprite',
                'description' => '500 ml',
                'price_eur' => 1.50,
                'price_usd' => 0.90,
                'image_url' => 'https://dodopizza-a.akamaihd.net/static/Img/Products/Drinks/en-GB/4c01da81-0dc1-4c25-bf2f-ef3bf2153e0d.jpg',
                'sort' => 4
            ]),
        ]);
    }
}
