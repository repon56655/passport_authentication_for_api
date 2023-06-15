<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
        // Create Book Function
        public function createBook(Request $request){
                $request->validate([
                        "title" => "required | unique:books",
                        "description" => "required",
                        "cost" => "required"
                ]);

                $book = new Book();

                $book->author_id = auth()->user()->id;
                $book->title = $request->title;
                $book->description = $request->description;
                $book->book_cost = $request->cost;
                $save_book = $book->save();

                if($save_book){
                        return response()->json([
                                "status" => true,
                                "message" => "successfully book created"
                        ]);
                }
                else{
                        return response()->json([
                                "status" => false,
                                "message" => "something wrong"
                        ]);
                }
        }
    
        // List Book Function
        public function authorBook(){
                $author_id = auth()->user()->id;
                $books = Author::find($author_id)->books;
                return response()->json([
                        "status" => true,
                        "message" => "author books listed",
                        "book" => $books
                ]);
        }
    
        // Single Book Function 
        public function singleBook($book_id)
        {
            $author_id = auth()->user()->id;
            $book_list = Book::where("id", $book_id)->orWhere("author_id", $author_id)->get();
        
            if ($book_list !== null) {
                return response()->json([
                    "status" => true,
                    "message" => "book found",
                    "book_list" => $book_list
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "book not found"
                ]);
            }
        }

        //Update Book Function
        public function updateBook(Request $request, $book_id){
                $author_id = auth()->user()->id;
                if(Book::where([
                        "author_id" => $author_id,
                        "id" => $book_id
                ])->exists()){
                        $book = Book::find($book_id);
                        $book->title = isset($request->title)?$request->title:$book->title;
                        $book->description = isset($request->description)?$request->description:$book->description;
                        $book->book_cost = isset($request->book_cost)?$request->book_cost:$book->book_cost;
                        $save_book = $book->save();

                        if($save_book){

                                return response()->json([
                                        "status" => true,
                                        "message" => "book updated"
                                ]);
                        }
                        else{
                                return response()->json([
                                        "status" => false,
                                        "message" => "something error"
                                ]);
                        }

  
                }else{
                        return response()->json([
                                "status" => false,
                                "message" => "not exist or not authorized by user"
                        ]);
                }

        }
    
        // Delete Book Function
        public function deleteBook($book_id){

                $author_id = auth()->user()->id;

                if(Book::where([
                        "author_id" => $author_id,
                        "id" => $book_id
                ])->exists()){

                        $book = Book::where(["id" => $book_id, "author_id" => $author_id])->first();
                        $book->delete();

                        return response()->json([
                                "status" => true,
                                "message" => "book deleted successfully"
                        ]);
  
                }else{
                        return response()->json([
                                "status" => false,
                                "message" => "not exist or not authorized by user"
                        ]);
                }
        }
}
