<div class="lonyo-section-padding4">
        <div class="container">

            @php
                 $title = App\Models\Title::find(1);
            @endphp
            <div class="lonyo-section-title center">
                <h2 id="answer-title" contenteditable="{{ auth()->check() ? 'true' : 'false' }}"
                        data-id="{{ $title->id }}">{{ $title->answers }}
                    </h2>
                
            </div>
            @php
                $faqs = App\Models\Faq::latest()->limit(5)->get();
            @endphp
            <div class="lonyo-faq-shape"></div>
            <div class="lonyo-faq-wrap1">
                @foreach ($faqs as $faq)
                <div class="lonyo-faq-item item2 open" data-aos="fade-up" data-aos-duration="500">
                    <div class="lonyo-faq-header">
                        <h4>{{$faq->title}}</h4>
                        <div class="lonyo-active-icon">
                            <img class="plasicon" src="{{asset('frontend/assets/images/v1/mynus.svg')}}" alt="">
                            <img class="mynusicon" src="{{asset('frontend/assets/images/v1/plas.svg')}}" alt="">
                        </div>
                    </div>
                    <div class="lonyo-faq-body body2">
                        <p>{{$faq->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="faq-btn" data-aos="fade-up" data-aos-duration="700">
                <a class="lonyo-default-btn faq-btn2" href="faq.html">Can't find your answer</a>
            </div>
        </div>
    </div>