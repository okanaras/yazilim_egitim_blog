@extends('layouts.front')

@section('title')
@endsection

@section('css')
@endsection

@section('container-top')
    @if (isset($settings) && $settings->feature_categories_is_active)
        <!-- one cikarilan articles -->
        <section class="feature-categories mt-4">
            <div class="row">
                <div class="col-md-3 p-2" data-aos="fade-down-right" data-aos-duration="1000" data-aos-easing="ease-in-out">
                    <div style="
                background:url('https://via.placeholder.com/600x400') no-repeat center center;
                background-size: cover;
                height: 300px;"
                        class="p-4 position-relative">

                        <h2 class="text-center text-secondary">Lorem, ipsum.</h2>
                        <p class="" style="text-align: justify;">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Veniam, voluptates.</p>
                        <p class="position-absolute" style="bottom: 10px; left: 10px; right: 10px;">Lorem ipsum dolor
                            sit
                            amet.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 p-2" data-aos="fade-down-right" data-aos-duration="1000" data-aos-easing="ease-in-out">
                    <div style="
                    background:url('https://via.placeholder.com/600x400') no-repeat center center;
                    background-size: cover;
                    height: 300px;"
                        class="p-4 position-relative">

                        <h2 class="text-center text-secondary">Lorem, ipsum.</h2>
                        <p class="" style="text-align: justify;">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Veniam, voluptates.</p>
                        <p class="position-absolute" style="bottom: 10px; left: 10px; right: 10px;">Lorem ipsum dolor
                            sit
                            amet.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 p-2" data-aos="fade-down-left" data-aos-duration="1000" data-aos-easing="ease-in-out">
                    <div style="background:url('https://via.placeholder.com/600x400') no-repeat center center; background-size:cover; height: 300px;"
                        class="p-4 position-relative">

                        <h2 class="text-center text-secondary">Lorem, ipsum.</h2>
                        <p class="" style="text-align: justify;">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Veniam, voluptates.</p>
                        <p class="position-absolute" style="bottom: 10px; left: 10px; right: 10px;">Lorem ipsum dolor
                            sit
                            amet.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 p-2" data-aos="fade-down-left" data-aos-duration="1000" data-aos-easing="ease-in-out">
                    <div style="background:url('https://via.placeholder.com/600x400') no-repeat center center; background-size: cover; height: 300px;"
                        class="p-4 position-relative">

                        <h2 class="text-center text-secondary">Lorem, ipsum.</h2>
                        <p class="" style="text-align: justify;">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit.
                            Veniam, voluptates.</p>
                        <p class="position-absolute" style="bottom: 10px; left: 10px; right: 10px;">Lorem ipsum dolor
                            sit
                            amet.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('content')
    <!-- populer articles title -->
    <section class="most-popular row" data-aos="zoom-in-up" data-aos-duration="2000" data-aos-easing="ease-in-out">
        <div class="populer-title col-md-8 p-0">
            <h2 class="font-montserrat fw-semibold">En Cok Okunan Makaleler</h2>
        </div>
        <!-- swiper next-back button -->
        <div class="col-4">
            <div class="most-popular-swiper-navigation text-end">
                <span class="btn btn-secondary material-icons most-popular-swiper-button-prev">arrow_back</span>
                <span class="btn btn-secondary material-icons most-popular-swiper-button-next">arrow_forward</span>
            </div>
        </div>
        <!-- populer articles content -->
        <div class="col-12">
            <div class="swiper-most-popular mt-3">
                <div class="swiper-wrapper ">
                    <!-- Slides -->
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <a href="#">
                            <img src="https://via.placeholder.com/600x400" class="img-fluid">
                        </a>
                        <div class="most-popular-body mt-2">
                            <div class="most-popular-author most-popular-author d-flex justify-content-between">
                                <div>Yazar: <a href="#">Okan Aras</a></div>
                                <div class="text-end">Kategori: <a href="#">Css</a></div>
                            </div>
                            <div class="most-popular-title">
                                <h4 class="text-black">
                                    <a href="#">Lorem ipsum dolor sit amet consectetur
                                        adipisicing
                                        elit...</a>
                                </h4>
                            </div>
                            <div class="most-popular-date">
                                <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- telegram -->
    <section class="telegram d-flex align-items-center mt-5 p-4 rounded-2 text-white">
        <div class="me-4">
            <span class="material-icons text-black">send</span>
        </div>
        <div class="telegram body">
            <h4>Telegram grubumuza katilmayi unutma!</h4>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam, libero quidem.</p>
            <a href="{{ isset($settings) ? $settings->telegram_link : 'javascript:void(0)' }}" target="blank"
                class="btn btn-warning p-3 text-black">Telegrama Katil</a>
        </div>
    </section>

    <!-- son eklenen makaleler -->
    <section class="articles row mt-5" data-aos="flip-left" data-aos-duration="2000" data-aos-easing="ease-out-cubic">
        <div class="populer-title col-md-12 p-0">
            <h2 class="font-montserrat fw-semibold">Son Makaleler</h2>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <a href="#">
                <img src="https://via.placeholder.com/600x400" class="img-fluid">
            </a>
            <div class="most-popular-body mt-2">
                <div class="most-popular-author most-popular-author d-flex justify-content-between">
                    <div>Yazar: <a href="#">Okan Aras</a></div>
                    <div class="text-end">Kategori: <a href="#">Css</a></div>
                </div>
                <div class="most-popular-title">
                    <h4 class="text-black">
                        <a href="#">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit...</a>
                    </h4>
                </div>
                <div class="most-popular-date">
                    <span>8 Ekim 2023</span> &#x25CF; <span>10 dk</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
