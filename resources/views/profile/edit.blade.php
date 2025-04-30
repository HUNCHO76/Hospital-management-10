<x-app-layout>
    <div class="main-panel my-5">
        <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col">
                <h2 class="h4 text-dark">
                    {{ __('Profile') }}
                </h2>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
