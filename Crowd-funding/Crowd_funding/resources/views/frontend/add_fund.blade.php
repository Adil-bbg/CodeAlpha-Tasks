@extends('frontend.layout.main')
@section('main-container')

<div class="container">
  @if (session('error'))
  <div class="alert alert-danger">
    <h1>{{ session('error') }}</h1>
  </div>
  @endif
</div>
<div class="container">
  <form action="/add_fund" method="POST" enctype="multipart/form-data">
    @csrf
      <div class="row">
        <h1 class="text-center my-5">Campaign Information</h1>

        <div class="col-md-6">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" name="Name" class="form-control form-control-lg" id="fullName" placeholder="John Doe" value="{{ old('Name') }}">
            @error('Name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
            <label for="contactNumber" class="form-label">Contact Number</label>
            <input type="number" name="Contact_No" class="form-control form-control-lg" id="contactNumber" placeholder="0300-1234567" value="{{ old('Contact_No') }}">
            @error('Contact_No') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="Email" class="form-control form-control-lg" id="email" placeholder="john.doe@example.com" value="{{ old('Email') }}">
          @error('Email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <h1 class="my-3 text-center">Fund Details</h1>

        <div class="col-md-12">
          <label for="campaignTitle" class="form-label">Campaign Title</label>
          <input type="text" name="Campaign_Title" class="form-control form-control-lg" id="campaignTitle" placeholder="Collecting funds for education, books & school building" value="{{ old('Campaign_Title') }}">
          @error('Campaign_Title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12">
          <label for="campaignDescription" class="form-label">Campaign Description</label>
          <textarea name="Campaign_Description" class="form-control form-control-lg" id="campaignDescription">{{ old('Campaign_Description') }}</textarea>
          @error('Campaign_Description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
          <label for="fundingDeadline" class="form-label">Funding Deadline</label>
          <input type="date" name="Funding_Deadline" class="form-control form-control-lg" id="fundingDeadline" value="{{ old('Funding_Deadline') }}">
          @error('Funding_Deadline') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6">
          <label for="fundingCategory" class="form-label">Funding Category</label>
          <input type="text" name="Funding_Category" class="form-control form-control-lg" id="fundingCategory" placeholder="Education" value="{{ old('Funding_Category') }}">
          @error('Funding_Category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-12">
          <label for="address" class="form-label">Address</label>
          <input type="text" name="Address" class="form-control form-control-lg" id="address" placeholder="1234 Main St" value="{{ old('Address') }}">
          @error('Address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
          <label for="country" class="form-label">Country</label>
          <input type="text" name="Country" class="form-control form-control-lg" id="country" placeholder="Pakistan" value="{{ old('Country') }}">
          @error('Country') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
          <label for="city" class="form-label">City</label>
          <input type="text" name="City" class="form-control form-control-lg" id="city" placeholder="Lahore" value="{{ old('City') }}">
          @error('City') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
          <label for="state" class="form-label">State</label>
          <input type="text" name="State" class="form-control form-control-lg" id="state" placeholder="Punjab" value="{{ old('State') }}">
          @error('State') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-5">
          <label for="zip" class="form-label">Zip</label>
          <input type="text" name="Zip" class="form-control form-control-lg" id="zip" placeholder="54000" value="{{ old('Zip') }}">
          @error('Zip') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-7">
          <label for="fundingGoal" class="form-label">Funding Goal (target amount)</label>
          <input type="text" name="Funding_Goal" class="form-control form-control-lg" id="fundingGoal" placeholder="$ 2,000.00 | PKR 15,000,00" value="{{ old('Funding_Goal') }}">
          @error('Funding_Goal') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-12">
          <label for="budgetBreakdown" class="form-label">Budget Breakdown (how funds will be used)</label>
          <input type="text" name="Budget_Breakdown" placeholder="we are building school to help childrens educaions" class="form-control form-control-lg" id="budgetBreakdown" value="{{ old('Budget_Breakdown') }}">
          @error('Budget_Breakdown') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
          <label for="campaignImages" class="form-label">Campaign Image</label>
          <input type="file" name="Campaign_Images" class="form-control form-control-lg" id="campaignImages">
          @error('Campaign_Images') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-4">
            <label for="governmentID" class="form-label">Government-issued ID Number (CNIC Number)</label>
            <input type="number" name="Government_ID" class="form-control form-control-lg" id="governmentID" placeholder="0000-0000-0000" value="{{ old('Government_ID') }}">
            @error('Government_ID') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <h1 class="text-center my-5">Bank Information</h1>

          <div class="col-md-4">
            <label for="bankName" class="form-label">Bank Name</label>
            <input type="text" name="Bank_Name" class="form-control form-control-lg" id="bankName" placeholder="Bank of Pakistan" value="{{ old('Bank_Name') }}">
            @error('Bank_Name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-md-4">
            <label for="accountName" class="form-label">Account Name</label>
            <input type="text" name="Account_Name" class="form-control form-control-lg" id="accountName" placeholder="John Doe" value="{{ old('Account_Name') }}">
            @error('Account_Name') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-md-4">
            <label for="accountNumber" class="form-label">Account Number</label>
            <input type="number" name="Account_Number" class="form-control form-control-lg" id="accountNumber" placeholder="0000-0000-0000" value="{{ old('Account_Number') }}">
            @error('Account_Number') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-md-4">
            <label for="cvc" class="form-label">CVC</label>
            <input type="text" name="CVC" class="form-control form-control-lg" id="cvc" placeholder="000" value="{{ old('CVC') }}">
            @error('CVC') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-md-4">
            <label for="expiryDate" class="form-label">Expiry Date</label>
            <input type="date" name="Expiry_Date" class="form-control form-control-lg" id="expiryDate" value="{{ old('Expiry_Date') }}">
            @error('Expiry_Date') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="col-12">
            <button type="submit" class="btn my-3 btn-lg btn-primary">Submit</button>
          </div>
      </div>
  </form>
</div>

@endsection
