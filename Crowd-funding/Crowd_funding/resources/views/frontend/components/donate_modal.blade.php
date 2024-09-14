<div class="modal fade" id="donateModal{{ $campaign->id }}" tabindex="-1" aria-labelledby="donateModalLabel{{ $campaign->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donateModalLabel{{ $campaign->id }}">Donate to {{ $campaign->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="fs-1 text-center my-3">Make Donation</h1>
                {{-- <form action="{{ route('donate', $campaign->id) }}" method="POST"> --}}
                    <form action="/Donate" method="POST">
                        @csrf
                    <h3 class="text-success my-2">Enter Donation Amount</h3>
                    <div class="form-floating mb-3">
                        <input type="number" name="Donation_amount" class="form-control" id="floatingInput" placeholder="8000.00" required>
                        <label for="floatingInput">PKR 0.00</label>
            @error('Donation_amount') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <!-- Additional Fields -->
                    <h6 class="mt-4">Enter Your Full Name</h6>
                    <div class="form-floating">
                        <input type="text" name="Donater_name" class="form-control" placeholder="Full Name">
                        <label for="name">Name</label>
            @error('Donation_name') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <h6 class="mt-4">Enter Your E-Mail</h6>
                    <div class="form-floating">
                        <input type="email" name="Donater_email" class="form-control" placeholder="E-Mail">
                        <label for="email">E-Mail</label>
            @error('Donater_email') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <h6 class="mt-4">Add a Comment (Optional)</h6>
                    <div class="form-floating">
                        <textarea class="form-control" name="Donater_comment" placeholder="Leave a comment" style="height: 100px"></textarea>
                        <label for="comment">Comments</label>
            @error('Donater_comment') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <button class="btn btn-lg btn-primary w-100 my-3">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>
