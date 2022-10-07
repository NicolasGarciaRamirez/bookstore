<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('author','publisher', 'genre')->get();
        return view('book.index', compact('books'));

    }

     public function getData(){
        $genres = Genre::all();
        $publishers = Publisher::all();
        $authors = Author::all();

        return response()->json([
            'genres'=>$genres,
            'publishers'=>$publishers,
            'authors'=>$authors,
        ]);
    }


    /**
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|min:1',
            'pages'=> 'required|min:1',
            'language'=> 'required|min:1',
            'publication_date'=> 'required|min:1',
            'price'=> 'required|min:1',
        ]);

        if ($request->hasFile('image')) {
            $imageName = \Str::random(5). '.' . $request->image->getClientOriginalExtension();
            request()->image->move(public_path('/images/books'), $imageName);

        }

        $book = new Book($request->all());
        $book->image = '/images/books/'.$imageName;
        $book->save();

        return response()->json([
            'saved'=> true,
            'message' => 'Libro creado con exito',
            'book' => $book->load('genre', 'author','publisher')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $title = 'Editar';
        return view('book.new_edit', compact('book', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @return JsonResponse
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        DB::beginTransaction();
        try {
            $book->update($request->all());

            if ($request->hasFile('image')) {
                $imageName = \Str::random(5). '.' . $request->image->getClientOriginalExtension();
                request()->image->move(public_path('/images/books/'), $imageName);
                $imageNameComplete = '/images/books/'.$imageName;
                $book->update(['image' => $imageNameComplete]);
            }
            DB::commit();
            return response()->json([
                'saved'=> true,
                'message' => 'libro actualizado con exito',
                'book' => $book->refresh()->load('genre', 'author','publisher')
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'saved'=> false,
                'message' => `ocurrio un error al guardar ${$e->getMessage()}`,
                'book' => null
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        try {
            $book->delete();
            return response()->json(['deleted' => true, 'message' => 'Libro borrado con exito!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
