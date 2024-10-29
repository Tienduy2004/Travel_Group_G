@extends('layouts.app') 
@section('content')
<style>
    .post-content img {
    max-width: 100%; /* Ensure the image doesn't exceed the container width */
    height: auto;    /* Keeps the aspect ratio intact */
    max-height: 400px; /* Limits the maximum height */
    object-fit: contain; /* Scales the image to fit within the height without cropping */
}

</style>
<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Blog Detail</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Blog Detail</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Booking Start -->
<div class="container-fluid booking mt-5 pb-5">
    <div class="container pb-5">
        <div class="bg-light shadow" style="padding: 30px;">
            <div class="row align-items-center" style="min-height: 60px;">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Destination</option>
                                    <option value="1">Destination 1</option>
                                    <option value="2">Destination 1</option>
                                    <option value="3">Destination 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date1" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input"
                                        placeholder="Depart Date" data-target="#date1" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date2" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input"
                                        placeholder="Return Date" data-target="#date2" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Duration</option>
                                    <option value="1">Duration 1</option>
                                    <option value="2">Duration 1</option>
                                    <option value="3">Duration 1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" type="submit"
                        style="height: 47px; margin-top: -2px;">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->


<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="pb-3">
                    <div class="blog-item">
                        <div class="position-relative">
                            @if (!empty($blog->image_url))
                                <img class="img-fluid w-100" src=" {{ asset('img/' . $blog->image_url) }}" alt="">
                            @else
                                <img class="img-fluid w-100" src=" {{ asset('img/undefined.jpg') }}" alt="">
                            @endif
                            <div class="blog-date">
                                <h6 class="font-weight-bold mb-n1">{{ $blog->created_at->format('d') }}</h6>
                                <small class="text-white text-uppercase">{{ $blog->created_at->format('M') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white mb-3" style="padding: 30px;">
                        <div class="d-flex mb-3">
                            <a class="text-primary text-uppercase text-decoration-none"
                                href="">{{ $blog->user->name }}</a>
                            <span class="text-primary px-2">|</span>
                            <a class="text-primary text-uppercase text-decoration-none"
                                href="">{{ $blog->category->name }}</a>
                        </div>
                        <h2 class="mb-3">{{ $blog->title }}</h2>
                        <div class="post-content">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>
                <!-- Blog Detail End -->

                <!-- Comment List Start -->
                <div class="bg-white" style="padding: 30px; margin-bottom: 30px;">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">3 Comments</h4>
                    <div class="media mb-4">
                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                        <div class="media-body">
                            <h6><a href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>
                            <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor labore
                                accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.
                                Gubergren clita aliquyam consetetur sadipscing, at tempor amet ipsum diam tempor
                                consetetur at sit.</p>
                            <button class="btn btn-sm btn-outline-primary">Reply</button>
                        </div>
                    </div>
                    <div class="media">
                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                        <div class="media-body">
                            <h6><a href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>
                            <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor labore
                                accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.
                                Gubergren clita aliquyam consetetur sadipscing, at tempor amet ipsum diam tempor
                                consetetur at sit.</p>
                            <button class="btn btn-sm btn-outline-primary">Reply</button>
                            <div class="media mt-4">
                                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6><a href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>
                                    <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor
                                        labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed
                                        eirmod ipsum. Gubergren clita aliquyam consetetur sadipscing, at tempor amet
                                        ipsum diam tempor consetetur at sit.</p>
                                    <button class="btn btn-sm btn-outline-primary">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Comment List End -->

                <!-- Comment Form Start -->
                <div class="bg-white mb-3" style="padding: 30px;">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>
                    <form>
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website">
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <input type="submit" value="Leave a comment"
                                class="btn btn-primary font-weight-semi-bold py-2 px-3">
                        </div>
                    </form>
                </div>
                <!-- Comment Form End -->
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <!-- Author Bio -->
                <div class="d-flex flex-column text-center bg-white mb-5 py-5 px-4">
                    <img src="img/user.jpg" class="img-fluid mx-auto mb-3" style="width: 100px;">
                    <h3 class="text-primary mb-3">John Doe</h3>
                    <p>Conset elitr erat vero dolor ipsum et diam, eos dolor lorem, ipsum sit no ut est ipsum erat kasd
                        amet elitr</p>
                    <div class="d-flex justify-content-center">
                        <a class="text-primary px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-primary px-2" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary px-2" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="mb-5">
                    <div class="bg-white" style="padding: 30px;">
                        <div class="input-group">
                            <input type="text" class="form-control p-4" placeholder="Keyword">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary border-primary text-white"><i
                                        class="fa fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category List -->
                <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categories</h4>
                    <div class="bg-white" style="padding: 30px;">
                        <ul class="list-inline m-0">
                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                <a class="text-dark" href="{{ route('blog') }}"><i
                                        class="fa fa-angle-right text-primary mr-2"></i>All</a>
                                <span class="badge badge-primary badge-pill">{{ $totalPost }}</span>
                            </li>
                            @foreach ($categories as $category)
                                <li class="mb-3 d-flex justify-content-between align-items-center">
                                    <a class="text-dark"
                                        href="{{ route('category.posts', Crypt::encrypt($category->id)) }}"><i
                                            class="fa fa-angle-right text-primary mr-2"></i>{{ $category->name }}</a>
                                    <span class="badge badge-primary badge-pill">{{ $category->posts_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Recent Post -->
                <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Recent Post</h4>
                    <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                        <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                        <div class="pl-3">
                            <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                            <small>Jan 01, 2050</small>
                        </div>
                    </a>
                    <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                        <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                        <div class="pl-3">
                            <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                            <small>Jan 01, 2050</small>
                        </div>
                    </a>
                    <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                        <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                        <div class="pl-3">
                            <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                            <small>Jan 01, 2050</small>
                        </div>
                    </a>
                </div>

                <!-- Tag Cloud -->
                <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h4>
                    <div class="d-flex flex-wrap m-n1">
                        <a href="" class="btn btn-light m-1">Design</a>
                        <a href="" class="btn btn-light m-1">Development</a>
                        <a href="" class="btn btn-light m-1">Marketing</a>
                        <a href="" class="btn btn-light m-1">SEO</a>
                        <a href="" class="btn btn-light m-1">Writing</a>
                        <a href="" class="btn btn-light m-1">Consulting</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->
@endsection