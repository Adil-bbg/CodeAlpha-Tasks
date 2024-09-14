@extends('frontend.layout.main')

@section('main-container')
<section class="container my-5">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
          <h3>{{ session('success') }}</h3>
        </div>
        @endif
    </div>

    <div class="row">
        <!-- Campaign Details -->
        <div class="col-lg-8 col-md-8 col-sm-12 mb-4">
            <div class="bg-light p-4 rounded shadow-sm">
                <div class="mb-4">
                    <img src="{{ Storage::url($campaign->campaign_images) }}" class="card-img-top" alt="{{ $campaign->campaign_title }}" style="aspect-ratio:5/4;object-fit:contain;width:100%;">
                </div>
    
                <h1 class="mb-3">{{ $campaign->title }}</h1>
                <p class="lead">{{ $campaign->description }}</p>

                <ul class="list-unstyled">
                    <li><strong>Name:</strong> {{ $campaign->name }}</li>
                    <li><strong>Email:</strong> {{ $campaign->email }}</li>
                    <li><strong>Contact No:</strong> {{ $campaign->contact_no }}</li>
                    <li><strong>Funding Deadline:</strong> {{ $campaign->funding_deadline }}</li>
                    <li><strong>Funding Category:</strong> {{ $campaign->funding_category }}</li>
                    <li><strong>Address:</strong> {{ $campaign->address }}</li>
                    <li><strong>Country:</strong> {{ $campaign->country }}</li>
                    <li><strong>City:</strong> {{ $campaign->city }}</li>
                    <li><strong>State:</strong> {{ $campaign->state }}</li>
                    <li><strong>Zip:</strong> {{ $campaign->zip }}</li>
                    <li><strong>Funding Goal:</strong> {{ $campaign->funding_goal }}</li>
                    <li><strong>Budget Breakdown:</strong> {{ $campaign->budget_breakdown }}</li>
                    <li><strong>Government ID:</strong> {{ $campaign->government_id }}</li>
                </ul>

                <h2 class="mt-4">Bank Info</h2>
                <ul class="list-unstyled">
                    <li><strong>Bank Name:</strong> {{ $campaign->bank_name }}</li>
                    <li><strong>Account Name:</strong> {{ $campaign->account_name }}</li>
                    <li><strong>Account Number:</strong> {{ $campaign->account_number }}</li>
                    <li><strong>CVV:</strong> {{ $campaign->cvv }}</li>
                    <li><strong>Expiry Date:</strong> {{ $campaign->expiry_date }}</li>
                </ul>
            </div>
        </div>

        <!-- Fundraising Info -->
        <div class="col-lg-4 col-md-4 col-sm-12 py-5">
            <div class="bg-light p-4 rounded shadow-sm text-center">
                <h1 class="fs-4 mb-3 text-primary">{{ $campaign->funding_goal }} PKR</h1>
                <p class="text-muted mb-4">Goal for {{ $campaign->funding_goal }}</p>
                <p class="text-muted mb-4">2 Funders</p>
                <div class="card-footer">
                    <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#donateModal{{ $campaign->id }}">Donate</button>
                </div>

                <hr>
                <p class="text-muted">Help this ongoing fundraising campaign by making a donation and spreading the word.</p>
            </div>
            
        <div class="container my-4 bg-muted">
            @foreach ($donators as $donator)
                <div class="card my-2 p-3">
                    <h3>{{ $donator->Donater_name }}</h3>
                    <p>{{ $donator->Donater_comment }}</p>
                    <p>Amount Donated: {{ $donator->Donation_amount }}</p>
                    <p>Email: {{ $donator->Donater_email }}</p>
                </div>
            @endforeach
        </div>
        </div>

    </div>
        
    @include('frontend.components.donate_modal', ['campaign' => $campaign])
</section>
@endsection
