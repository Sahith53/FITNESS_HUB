@extends('layouts.mainLayout')

@section('title', 'Contact')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')
<main>
    <section class="contact">
        <div class="contact-container">
            <div class="left">
                <div class="form-wrapper">
                    <div class="contact-heading">
                        <h1>Let's work together<span>.</span></h1>
                        <p class="text">Or reach us via : <a href="#">FitnessHUB@gmail.com</a></p>
                    </div>
                    <form action="{{ route("contact.store") }}" method="post">
                        @csrf
                        <div class="contact-form">
                            <div class="input-wrap w-100">
                                <input type="text" class="contact-input" autocomplete="off" name="name" required>
                                <label>Full Name</label>
                                <i class="icon fa-solid fa-address-card"></i>
                            </div>
                            @error('name')
                            <div class="error">{{ $message }}</div>
                            @enderror

                            <div class="input-wrap w-100">
                                <input type="text" class="contact-input" autocomplete="off" name="phone" required>
                                <label>Phone Number</label>
                                <i class="icon fa-solid fa-phone"></i>
                            </div>
                            @error('phone')
                            <div class="error">{{ $message }}</div>
                            @enderror

                            <div class="input-wrap w-100">
                                <input type="email" class="contact-input" autocomplete="off" name="email" required>
                                <label>Email</label>
                                <i class="icon fa-solid fa-envelope"></i>
                            </div>
                            @error('email')
                            <div class="error">{{ $message }}</div>
                            @enderror

                            <div class="input-wrap textarea w-100">
                                <textarea name="message" class="contact-input" autocomplete="off" required></textarea>
                                <label>Message</label>
                                <i class="icon fa-solid fa-inbox"></i>
                            </div>
                            @error('message')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="contact-buttons">
                            <input type="submit" value="Send message" class="contact-btn" style="width: 100%;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="image-wrapper">
                    <img src="./images/bg1.jpeg" alt="background image" class="img">
                    <div class="wave-wrap">
                        <svg class="wave" viewBox="0 0 783 1536" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path id="wave"
                                d="M236.705 1356.18C200.542 1483.72 64.5004 1528.54 1 1535V1H770.538C793.858 63.1213 797.23 196.197 624.165 231.531C407.833 275.698 274.374 331.715 450.884 568.709C627.393 805.704 510.079 815.399 347.561 939.282C185.043 1063.17 281.908 1196.74 236.705 1356.18Z"
                                fill="#D9D9D9" stroke="white" />
                        </svg>
                    </div>
                    <svg class="dashed-wave" viewBox="0 0 345 877" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path id="dashed-wave"
                            d="M0.5 876C25.6667 836.167 73.2 739.8 62 673C48 589.5 35.5 499.5 125.5 462C215.5 424.5 150 365 87 333.5C24 302 44 237.5 125.5 213.5C207 189.5 307 138.5 246 87C185 35.5 297 1 344.5 1"
                            stroke="white" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
<script src="{{ asset('js/contact.js') }}"></script>
<script src="{{ asset('plugins/alert.js') }}"></script>
@if(session('alert'))
<script>
    Swal.fire({
        title: "Success",
        text: "{{ session('alert') }}",
        icon: "success"
      });
</script>
@endif
@endpush