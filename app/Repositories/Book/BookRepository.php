<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookInterfcace;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class BookRepository implements BookInterfcace{

    public function index(){

         $books=Book::orderBy("created_at","desc")->get();

         return view('Book.index',compact("books"));

    }

    public function create(){

        return view('Book.create');
    }

    public function store( $request){

        DB::beginTransaction();

        try {
          
    
            // حفظ الصورة إن وجدت
            $imagePath = null;
            if ($request->hasFile('cover_image')) {
               $originalFileName =$request->file('cover_image')->getClientOriginalName();
                $imagePath = $request->file('cover_image')->storeAs('public/cover_images', $originalFileName,'public');
            }
    
            // إنشاء الكتاب
            $book = Book::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_name' => $request->author_name,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn ?? null,
                'published_at' => $request->published_at ?? null,
                'stock' => $request->stock,
                'language' => $request->language,
                'pages' => $request->pages ?? null,
                'is_valid' => $request->is_valid ?? true,
            ]);
    
            DB::commit();
    
            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create book: ' . $e->getMessage());
        }
    }


    public function  show($id){
        $book = Book::findOrFail($id);
        return view('Book.show', compact('book'));
    }

    public function edit($id){
        $book = Book::findOrFail($id);
        return view('Book.edit', compact('book')); 
    }

    public function update( $request, $id)
    {
        DB::beginTransaction();
    
        try {
        
    
            // العثور على الكتاب الموجود بناءً على الـ ID
            $book = Book::findOrFail($id);
    
            // حفظ الصورة الجديدة إذا تم رفعها
            $imagePath = $book->cover_image; // نحتفظ بالصورة القديمة في حال لم يتم رفع صورة جديدة
            if ($request->hasFile('cover_image')) {
                // إذا كانت هناك صورة جديدة، نقوم بحفظها
                $originalFileName = $request->file('cover_image')->getClientOriginalName();
                $imagePath = $request->file('cover_image')->storeAs('public/cover_images', $originalFileName, 'public');
            }
    
            // تحديث الكتاب
            $book->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_name' => $request->author_name,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn ?? null,
                'published_at' => $request->published_at ?? null,
                'stock' => $request->stock,
                'language' => $request->language,
                'pages' => $request->pages ?? null,
                'is_valid' => $request->is_valid ?? true,
            ]);
    
            DB::commit();
    
            return redirect()->route('books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }
    

    public function destroy($id){
        $book=Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index')->with('success','Successfully Deleted');
    }


}