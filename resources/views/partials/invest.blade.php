<section class="features-section container my-5" >
    <h2 class="text-r mb-2">Invest in your career</h2>
    <div class="row text-r">
        @foreach($features as $feature)
            <div class="col-md-4 mb-4 d-flex align-items-stretch justify-content-center">
                <div class="feature-card p-3 ">
                    {!! $feature['icon'] !!}
                    <h3 class="mt-3">{{ $feature['title'] }}</h3>
                    <p>{{ $feature['description'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
