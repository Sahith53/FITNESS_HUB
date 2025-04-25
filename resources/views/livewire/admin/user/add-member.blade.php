<div x-show="addMember" style="display: none">
    <form wire:submit='create' enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h3 class="text-light ms-2 font-weight-bolder">Add New Member</h3>
                <button x-on:click="addMember = false, usersTable = true" class="btn btn-sm btn-dark mb-0 me-4">View All Users</button>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6>Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Name</label>
                                <input type="text" wire:model='name' class="form-control" placeholder="User Full Name" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Email</label>
                                <input type="email" wire:model='email' class="form-control" placeholder="Email Address" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Gender</label>
                                <select wire:model='gender' class="form-control" required>
                                    <option value="" selected>Select Gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="O">Others</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Date of Birth</label>
                                <input type="date" wire:model='dob' class="form-control" required>
                                @error('dob')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Phone Number</label>
                                <input type="number" wire:model='phone' class="form-control" placeholder="Phone Number" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Role</label>
                                <input type="text" class="form-control" value="Member" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-control-label">Address</label>
                                <textarea cols="30" rows="4" wire:model='address' class="form-control" placeholder="Your Address..."></textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label">City</label>
                                <input type="text" wire:model='city' class="form-control" placeholder="City">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label">Zip Code</label>
                                <input type="text" wire:model='zip_code' class="form-control" placeholder="Zip Code">
                                @error('zip_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label">State</label>
                                <input type="text" wire:model='state' class="form-control">
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-control-label">Profile Bio</label>
                                <textarea cols="30" rows="3" wire:model='bio' class="form-control" placeholder="Bio.."></textarea>
                                @error('bio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-control-label">Profile Picture</label>
                                <input type="file" accept="image/png, image/jpeg" wire:model='profile_pic' class="form-control">
                                @error('profile_pic')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                @if ($profile_pic)
                                    <p class="mt-2">Preview:</p>
                                    <img src="{{ $profile_pic->temporaryUrl() }}" class="rounded h-20 w-20">
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Password</label>
                                <input type="password" wire:model='password' class="form-control" placeholder="New Password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label">Confirm Password</label>
                                <input type="password" wire:model='confirm_password' class="form-control" placeholder="Confirm Password" required>
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div wire:loading.block>
                                <button class="btn btn-sm btn-success m-0 text-white">Processing....</button>
                            </div>
                            <div wire:loading.remove class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary m-0">Add Member</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>