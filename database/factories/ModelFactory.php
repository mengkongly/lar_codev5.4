<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'role_id' => $faker->numberBetween(1,3),
        'is_active' => $faker->numberBetween(0,1),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'user_id' => $faker->numberBetween(1,20),
        'category_id' => $faker->numberBetween(1,6),
        'title' => $faker->sentence(7,20),
        'body' => $faker->paragraph(rand(10,15), true),
        'slug' => $faker->slug()
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->randomElement(['Administrator','Author','Subscriber'])
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->randomElement(['Electronic','Home Appliance','Outdoor Staff','Sport', 'Car/Truck','Furniture'])
    ];
});

$factory->define(App\Photo::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'path' => $faker->randomElement(['m_1542651506_m1.jpg','m_1542651507_m2.jpeg','post_1542426693_g4.jpg','m_1542651506_iphonex.jpg']),
        'photoable_id' => $faker->numberBetween(1,20),
        'photoable_type' => $faker->randomElement(['App\User','App\Post'])
    ];
});


$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'post_id' => $faker->numberBetween(1,20),
        'user_id' => $faker->numberBetween(1,10),
        'is_active' => $faker->numberBetween(0,1),
        'body' => $faker->sentence()
    ];
});

$factory->define(App\CommentReply::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'comment_id' => $faker->numberBetween(1,10),
        'user_id' => $faker->numberBetween(1,10),
        'is_active' => $faker->numberBetween(0,1),
        'body' => $faker->sentence()
    ];
});