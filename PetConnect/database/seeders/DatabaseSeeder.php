<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetPost;
use App\Models\PetPostLike;
use App\Models\PetPostComment;
use App\Models\PetType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // php artisan migrate:fresh --seed

        // =========================
        // USERS
        // =========================
        $users = collect([
            User::create([
                'name' => 'John',
                'email' => 'john@test.com',
                'password' => Hash::make('12345678'),
            ]),
            User::create([
                'name' => 'Anna',
                'email' => 'anna@test.com',
                'password' => Hash::make('12345678'),
            ]),
            User::create([
                'name' => 'Peter',
                'email' => 'peter@test.com',
                'password' => Hash::make('12345678'),
            ]),
        ]);

        // =========================
        // PET TYPES (FIXED)
        // =========================
        $types = collect([
            PetType::create(['name' => 'Dog']),
            PetType::create(['name' => 'Cat']),
            PetType::create(['name' => 'Rabbit']),
            PetType::create(['name' => 'Hamster']),
            PetType::create(['name' => 'Parrot']),
            PetType::create(['name' => 'Fish']),
            PetType::create(['name' => 'Turtle']),
            PetType::create(['name' => 'Snake']),
            PetType::create(['name' => 'Horse']),
            PetType::create(['name' => 'Guinea Pig']),
        ]);

        // =========================
        // REAL PET IMAGES
        // =========================
        $petImages = [
            'pets/69344d666e760.jpg',
            'pets/693441f30f14f.jpg',
            'pets/693449df28ff8.png',
            'pets/69349481bdcf5.jpg',
            'pets/6934418307e2e.jpg',
        ];

        $imageIndex = 0;

        // =========================
        // POSTS IMAGES
        // =========================
        $postImages = [
            'posts/post_69344a84c5e7d0.69089012.jpg',
            'posts/post_69344a35104d01.90942213.jpg',
            'posts/post_6934449a538b64.95678297.jpg',
            'posts/post_69344256b475e2.18907328.jpg',
            'posts/post_693448619b8824.62068663.jpg',
        ];

        $petNames = ['Buddy','Max','Charlie','Bella','Lucy','Daisy','Luna','Milo','Rocky','Coco','Oscar','Loki','Simba','Nala','Molly','Toby','Rex','Leo','Chloe','Lily','Jack','Zoe','Ruby','Bobby','Lucky','Shadow','Misty','Penny','Ginger','Peanut'];

        $pets = collect();
        $posts = collect();

        // =========================
        // PETS
        // =========================
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {

                $pet = Pet::create([
                    'user_id' => $user->id,
                    'type_id' => $types->random()->id,
                    'name' => $petNames[array_rand($petNames)],
                    'age' => rand(1, 12),
                    'description' => "Lovely pet of {$user->name}",
                ]);

                // взимаме снимка по ред (циклично)
                $imagePath = $petImages[$imageIndex % count($petImages)];
                $imageIndex++;

                $image = PetImage::create([
                    'path' => $imagePath,
                    'post_id' => null,
                ]);

                $pet->update([
                    'image_id' => $image->id
                ]);

                $pets->push($pet);
            }
        }

        // =========================
        // POSTS + IMAGES
        // =========================

        $postTitles = [
            'My crazy day with',
            'A funny moment with',
            'Why I love',
            'Adventures with my',
            'The secret life of',
            'Best day ever with',
            'Sleeping problems of',
            'How I trained my',
            'A walk in the park with',
            'Chaos caused by',
            'Unexpected behavior of',
            'Life with my',
        ];

        foreach ($pets as $pet) {
            for ($i = 1; $i <= 2; $i++) {

                $post = PetPost::create([
                    'pet_id' => $pet->id,
                    'title' => $postTitles[array_rand($postTitles)] . ' ' . $pet->name,
                    'content' => "This is a fun story about {$pet->name}",
                ]);

                $posts->push($post);

                PetImage::create([
                    'path' => $postImages[array_rand($postImages)],
                    'post_id' => $post->id,
                ]);
            }
        }

        // =========================
        // LIKES
        // =========================
        foreach ($posts as $post) {
            foreach ($users->random(rand(1, 3)) as $user) {

                PetPostLike::firstOrCreate([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            }
        }

    }
}
