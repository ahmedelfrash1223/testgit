<?php
use App\Models\Category;
$category = Category::get();
$id = $book->category_id;
$category_name = Category::find($id);

?>
@extends('master')

@section('hero-title', 'انشر كتابك')
@section('title', 'Add Book')
@section('const')

    <!-- Start Contact Form -->
    <div class="untree_co-section">
        <div class="container">

            <div class="block">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-8 pb-4"style="direction: rtl">

                        {{-- start form --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                                <br>
                                <strong>File:</strong> {{ session('file') }}
                            </div>
                        @endif


                        <form action="{{ route('book.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Name --}}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="status" value="null">
                                        <label class="text-black" for="author_name">اسمك كا مؤلف(ة)</label>
                                        <input type="text" class="form-control" id="author_name" name="author_name"
                                            value="{{ $book->author_name }}">
                                        <x-input-error :messages="$errors->get('author_name')" class="mt-2" />
                                    </div>
                                </div>

                                {{-- Book title --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="text-black" for="book_title">عنوان الكتاب</label>
                                        <input type="text" class="form-control" id="title" name="book_title"
                                            value="{{ $book->book_title }}">
                                        <x-input-error :messages="$errors->get('book_title')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="form-group">
                                <label class="text-black" for="category_id">قسم الكتاب</label>
                                <select id="category_id" name="category_id" class="form-control">

                                    <option value="" selected disabled hidden>{{ $category_name->name }}</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                            {{-- price --}}
                            <div class="form-group">
                                <label class="text-black" for="price">سعر الكتاب</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ $book->price }}">
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            {{-- Description --}}
                            <div class="form-group mb-5">
                                <label class="text-black" for="description">وصف الكتاب</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{ $book->description }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <div class="form-group mb-5">
                            </div>

                            {{--  PDF --}}
                            <div class="mb-3">
                                <label for="book_file" class="form-label">رفع الكتاب(pdf)</label>
                                <input class="form-control" name="book_file" type="file" id="book_file"
                                    style="height: 38px"value="{{ $book->book_file }}">
                                <x-input-error :messages="$errors->get('book_file')" class="mt-2" />

                            </div>
                            <div class="mb-3">
                                <label for="cover_image" class="form-label">رفع الغلاف(صورة)</label>
                                <input value="{{ $book->cover_image }}"class="form-control" name="cover_image"
                                    type="file" id="cover_image" style="height: 38px">
                                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />

                            </div>
                            <div class="mb-3">
                                <label for="pledge_file" class="form-label">رفع الاقرار(صورة)</label>
                                <input value="{{ $book->pledge_file }}" class="form-control" type="file"
                                    id="pledge_file" name="pledge_file" style="height: 38px">
                                <x-input-error :messages="$errors->get('pledge_file')" class="mt-2" />

                            </div>

                            <br>
                            <a href="/images/pledge.jpg" download="pledge.jpg" class="download-button">تحميل الاقرار</a>
                            <button type="submit" class="btn btn-primary-hover-outline">انشر كتابك</button>
                        </form>
                        {{-- end form --}}


                    </div>

                </div>

            </div>

        </div>


    </div>
    </div>

    <!-- End Contact Form -->

@endsection
