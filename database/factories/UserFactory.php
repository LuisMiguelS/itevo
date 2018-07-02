<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\BranchOffice::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'slug' => str_slug($name),
    ];
});

$factory->define(App\Classroom::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'building' => $faker->word,
        'branch_office_id' => factory(App\BranchOffice::class)->create()
    ];
});

$factory->define(App\TypeCourse::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'branch_office_id' => factory(App\BranchOffice::class)->create()
    ];
});

$factory->define(App\Resource::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'branch_office_id' => factory(App\BranchOffice::class)->create()
    ];
});


$factory->define(App\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'branch_office_id' => factory(App\BranchOffice::class)->create(),
        'type_course_id' => factory(App\TypeCourse::class)->create()
    ];
});

$factory->define(App\Promotion::class, function (Faker $faker) {
    return [
        'branch_office_id' => factory(App\BranchOffice::class)->create(),
        'period' => $faker->randomElement([\App\Promotion::PROMOTION_NO_1, \App\Promotion::PROMOTION_NO_2, \App\Promotion::PROMOTION_NO_3]),
        'status' => $faker->randomElement([\App\Promotion::STATUS_INSCRIPTION, \App\Promotion::STATUS_CURRENT, \App\Promotion::STATUS_FINISHED])
    ];
});

$factory->define(App\Teacher::class, function (Faker $faker) {
    return [
        'branch_office_id' => factory(App\BranchOffice::class)->create(),
        'id_card' => substr($faker->unique()->creditCardNumber, 0, 13),
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'phone' => substr($faker->unique()->phoneNumber, 0, 13)
    ];
});
