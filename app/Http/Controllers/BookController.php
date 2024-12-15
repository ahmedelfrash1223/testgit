<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(){
        $book = Book::get();
        return view('theme.books',compact('book'));
    }


    public function upload(BookRequest $request)
    {




        // // Save the cover image
        // $coverImage = $request->file('cover_image');
        // $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
        // $coverImage->move(public_path('uploads/covers'), $coverImageName);

        // // Save the book file
        // $bookFile = $request->file('book_file');
        // $bookFileName = time() . '_' . $bookFile->getClientOriginalName();
        // $bookFile->move(public_path('uploads/books'), $bookFileName);

        // // Save the pledge file
        // $pledgeFile = $request->file('pledge_file');
        // $pledgeFileName = time() . '_' . $pledgeFile->getClientOriginalName();
        // $pledgeFile->move(public_path('uploads/pledges'), $pledgeFileName);

        $fileUploader = new FileUploader();

        $coverImageName = $fileUploader->upload($request->file('cover_image'), 'uploads/covers');
        $bookFileName = $fileUploader->upload($request->file('book_file'), 'uploads/books');
        $pledgeFileName = $fileUploader->upload($request->file('pledge_file'), 'uploads/pledges');

        // Save book details to the database (optional)
        // Assuming you have a Book model

        Book::create([
            'user_id' => $request->user_id,
            'author_name' => $request->author_name,
            'book_title' => $request->book_title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'cover_image' => $coverImageName,
            'book_file' => $bookFileName,
            'pledge_file' => $pledgeFileName,
            'status' => $request->status,
            'price' => $request->price,

        ]);

        return back()->with([
            'success' => 'Book uploaded successfully',
            'timestamp' => time(),
            'file' => $bookFileName,
    ]);


    }
    public function delete($id){
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->back();
    }
    public function update(Request $request,$id){
        $book = Book::findOrFail($id);
        $data = $request->validate([
            'status' => 'required',
        ]);

        $book->update($data);
        return redirect()->back();
    }

    public function book_update(BookUpdateRequest $request,$id){
        $book = Book::findOrFail($id);

        $fileUploader = new FileUploader();

        $coverImageName = $fileUploader->upload($request->file('cover_image'), 'uploads/covers');
        $bookFileName = $fileUploader->upload($request->file('book_file'), 'uploads/books');
        $pledgeFileName = $fileUploader->upload($request->file('pledge_file'), 'uploads/pledges');

       $book->update([
            'user_id' => $request->user_id,
            'author_name' => $request->author_name,
            'book_title' => $request->book_title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'cover_image' => $coverImageName,
            'book_file' => $bookFileName,
            'pledge_file' => $pledgeFileName,
            'status' => $book->status,
            'price' => $request->price,

        ]);
        return back()->with([
            'success' => 'Book uploaded successfully',
            'timestamp' => time(),
            'file' => $bookFileName,
    ]);
    }




    public function review($id){
        $book = Book::findOrFail($id);

        return view('theme.review_book',compact('book'));
    }
}