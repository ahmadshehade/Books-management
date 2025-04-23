<?php

namespace Database\Seeders;

use App\Models\BookType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("book_types")->delete();
        $data=[
            ['name' => 'Novels'],
            ['name' => 'Self-Development'],
            ['name' => 'Technology'],
            ['name' => 'Religious'],
            ['name' => 'World Literature'],
            ['name' => 'History'],
            ['name' => 'Philosophy'],
            ['name' => 'Science'],
            ['name' => 'Children'],
            ['name' => 'Biographies'],
        ];
        foreach($data as $book_type){
              BookType::create($book_type);
        }
    }
}
