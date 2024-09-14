@extends('frontend.layout.main')
@section('main-container')

<section>    
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
          <h3>{{ session('success') }}</h3>
        </div>
        @endif
    </div>
    <div class="parent-services-container">
        <div class="services-container container-fluid">
            <div class="services-content">
                <div class="service-icon"><i class="bi bi-globe2"></i></div>
                <h2>Connect Globally</h2>
                <p>Experience fast and reliable delivery within 24 hours. We ensure your package arrives on time and
                    in perfect condition.</p>
                <a href="#">Read More</a>
            </div>
            <div class="services-content">
                <div class="service-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <h2>Spread The Words</h2>
                <p>Take advantage of our monthly discount coupons and enjoy savings on your favorite products. Check
                    back often for new offers!</p>
                <a href="#">Read More</a>
            </div>
            <div class="services-content">
                <div class="service-icon"><i class="bi bi-people-fill"></i></div>
                <h2>Helping Peoples</h2>
                <p>Enjoy peace of mind with our package check service. Verify your order before payment to ensure
                    satisfaction.</p>
                <a href="#">Read More</a>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($campaigns as $campaign)
        <div class="col">
            <a href="{{ url('/donation_details/' . $campaign->id) }}" class="card text-decoration-none border h-100">
                <!-- Display the campaign image -->
                <img src="{{ Storage::url($campaign->campaign_images) }}" class="card-img-top" alt="{{ $campaign->campaign_title }}" style="aspect-ratio:5/4;object-fit:cover">
                                 
                <!-- Card content -->
                <div class="card-body">
                    <h5 class="card-title">{{ $campaign->campaign_title }}</h5>
                    <p class="card-text text-muted">{{ $campaign->campaign_description }}</p>
                                  
                    <p class="mt-2">{{ $campaign->funding_goal }} PKR Goal</p>
    
                    <!-- Donate button and modal -->
                    <div class="card-footer">
                        <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#donateModal{{ $campaign->id }}">Donate</button>
                    </div>
                </div>
            </a>
        </div>
    
        @include('frontend.components.donate_modal', ['campaign' => $campaign])
    @endforeach
        
        </div>
  </div>
      <div class="container my-5">
        <h2 class=" text-center">Frequently Asked Questions</h2>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item ">
              <h2 class="accordion-header ">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Is SupportSquad safe and trust worthy
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat illo est ducimus doloribus exercitationem, eos repellat atque. Eos deserunt reiciendis illum? Eligendi ad soluta quo, nulla asperiores amet harum voluptatem.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  How SupportSquad use our Donation
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                  Can we directly send donation to campaign
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
              </div>
            </div>
          </div>
    </div>
</section>


@endsection
