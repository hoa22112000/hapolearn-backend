@extends('user.master')

@section('content')
    <div class="allcourse">
        <div class="container">
            <form action="{{ route('search') }}" method="get" name="advance_search">
                <div class="search d-flex justify-content-center justify-content-sm-start">
                    <button type="button" class="btn btn-filter collapsed" id="btnFilter" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter"><i class="fas fa-sliders-h"></i> Filter </button>
                    <div class="input-group md-form form-sm form-1 input-group-search">
                        <input class="form-control my-0 py-1 input-text" name="key" value="{{ request()->get("key") }}" type="text" placeholder="Search" aria-label="Search">
                        
                        <div class="input-group-prepend">
                            <span class="input-group-text btn btn-search-icon" id="basic-text1"><i class="fas fa-search text-black"
                                aria-="true"></i>
                            </span>
                        </div>
                    </div>
                    <button class="btn btn-filter mx-3 btn-search" type="submit"  id="btnSearch"> Search </button>
                </div>

                <div class="collapse collapse-filter show" id="collapseFilter">
                    <div class="filter bg-white p-2">
                        <div class="text">
                            <p class="text-filter">Filter</p>
                        </div>
                        <div class="option">
                            <div class="d-block">
                                <div class="form-group form-filter">
                                    <input type="radio" name="choice" class="status" value="0" id="old" />
                                    <label for="old" class="form-label custom-label label-filter-custom item-active"> Latest </label>
                                </div>
                                <div class="form-group form-filter">
                                    <input type="radio" name="choice" class="status" value="1" id="new"/>
                                    <label for="new" class="form-label custom-label label-filter-custom"> Oldest </label>
                                </div>
                                <div class="form-group form-filter">
                                    <select name="teacher" class="custom-select" id="teacher">
                                        <option value="" > Teacher </option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ request("teacher") == $teacher->id  ? "selected" : "" }} >{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-filter">
                                    <select name="number_learner" class="custom-select" id="numberLerner">
                                        <option value=""> Number of learner </option>
                                        <option value="1" {{ request("number_learner") == 1  ? "selected" : "" }}>Ascending</option>
                                        <option value="0" {{ request("number_learner") == 0  ? "selected" : "" }}>Descending</option>
                                    </select>
                                </div>
                                <div class="form-group form-filter">
                                    <select name="time_learning" class="custom-select" id="timeLearning">
                                        <option value="" selected  > Study time </option>
                                        <option value="1" {{ request("time_learning") == 1  ? "selected" : "" }}>Ascending</option>
                                        <option value="0" {{ request("time_learning") == 0  ? "selected" : "" }}>Descending</option>
                                    </select>
                                </div>
                                <div class="form-group form-filter">
                                    <select name="number_lesson" class="custom-select" id="numberLesson">
                                        <option value="" selected> Number of lessons </option>
                                        <option value="1" {{ request("number_lesson") == 1  ? "selected" : "" }}>Ascending</option>
                                        <option value="0" {{ request("number_lesson") == 0  ? "selected" : "" }}>Descending</option>
                                    </select>
                                </div>
                                <div class="form-group form-filter">
                                    <select name="tags" class="custom-select" id="tags">
                                        <option value=""> Tags </option>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ request("tags") == $tag->id  ? "selected" : "" }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-filter">
                                    <select name="reviews" class="custom-select" id="reviews">
                                        <option value="" selected> Reviews </option>
                                        <option value="1">Ascending</option>
                                        <option value="0">Descending</option>
                                    </select>
                                </div>
                                <button type="button" class="btn mx-3 btn-clear btn-danger" id="btnClear"> Clear </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    

            <div class="row list-course margin-top">

                @foreach ($courses as $course)
               
                <div class="col-12 col-sm-6 col-courses col-lessons">
                    <div class="card custom-card">
                        <div class="logo">
                            <div class="row">
                                <div class="col-3 px-1 px-sm-3">
                                    <img src="{{ asset('images/acourse_machine_learning.png') }}" alt="" class="img-lesson">
                                </div>
                                <div class="col-9 text-left desc">
                                    <p class="font-weight-bold title">{{ $course->name }}</p>
                                    <p class="detail">
                                        {{ $course->intro }}
                                    </p>
                                    <a href="#" class="btn link-course link-lesson">More</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="row content-statistic info-course desc">
                                <div class="col-sm-4 col-4">
                                    <span class="title">{{__('Lessons') }}</span>
                                    <span class="number"> {{ number_format($course->lesson_number) }} </span>
                                </div>
                                <div class="col-sm-4 col-4">
                                    <span class="title">{{__('Learners') }}</span>
                                    <span class="number">{{ number_format(  $course->learner_number) }} </span>
                                </div>
                                <div class="col-sm-4 col-4">
                                    <span class="title">{{__('Time') }}</span>
                                    <span class="number">{{ $course->time_learning }} (h) </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
                @endforeach

            </div>

            {{ $courses->appends(request()->input())->links() }}

        </div>
    </div>
@endsection
