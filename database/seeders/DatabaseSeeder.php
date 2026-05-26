<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            GameSeeder::class,
            GameItemSeeder::class,
            AnagramSeeder::class,
            ArabicAnagramSeeder::class,
            VowelVoidSeeder::class,
            ArabicVowelVoidSeeder::class,
            MissingLinkSeeder::class,
            ArabicMissingLinkSeeder::class,
            TransferChainSeeder::class,
            ArabicTransferChainSeeder::class,
            TerminologyTriviaSeeder::class,
            ArabicTerminologyTriviaSeeder::class,
            CategoryCrusherSeeder::class,
            ArabicCategoryCrusherSeeder::class,
            MazadQuestionSeeder::class,
        ]);
    }
}
