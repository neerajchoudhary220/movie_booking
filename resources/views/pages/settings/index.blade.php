@extends('layouts.app')

@section('title', 'Application Settings')

@section('content')
<div class="max-w-6xl mx-auto p-8 bg-white rounded-xl shadow border border-gray-200 mt-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="bi bi-gear text-indigo-600"></i> Application Settings
    </h1>


    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
        @csrf

        <!-- Pusher Settings -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4 flex items-center gap-2">
                <i class="bi bi-broadcast text-indigo-500"></i> Pusher Configuration
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="PUSHER_APP_ID" value="Pusher App ID" />
                    <x-text-input id="PUSHER_APP_ID" name="PUSHER_APP_ID" type="text"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_APP_ID', $settings['PUSHER_APP_ID']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_APP_ID')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="PUSHER_APP_KEY" value="Pusher App Key" />
                    <x-text-input id="PUSHER_APP_KEY" name="PUSHER_APP_KEY" type="text"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_APP_KEY', $settings['PUSHER_APP_KEY']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_APP_KEY')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="PUSHER_APP_SECRET" value="Pusher App Secret" />
                    <x-text-input id="PUSHER_APP_SECRET" name="PUSHER_APP_SECRET" type="text"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_APP_SECRET', $settings['PUSHER_APP_SECRET']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_APP_SECRET')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="PUSHER_APP_CLUSTER" value="Pusher App Cluster" />
                    <x-text-input id="PUSHER_APP_CLUSTER" name="PUSHER_APP_CLUSTER" type="text"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_APP_CLUSTER', $settings['PUSHER_APP_CLUSTER']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_APP_CLUSTER')" class="mt-2" />
                </div>

                <!--  Added Fields -->
                <div>
                    <x-input-label for="PUSHER_PORT" value="Pusher Port" />
                    <x-text-input id="PUSHER_PORT" name="PUSHER_PORT" type="number"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_PORT', $settings['PUSHER_PORT']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_PORT')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="PUSHER_SCHEME" value="Pusher Scheme (e.g., https)" />
                    <x-text-input id="PUSHER_SCHEME" name="PUSHER_SCHEME" type="text"
                        class="block w-full mt-1"
                        value="{{ old('PUSHER_SCHEME', $settings['PUSHER_SCHEME']) }}" required />
                    <x-input-error :messages="$errors->get('PUSHER_SCHEME')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Mail Settings -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4 flex items-center gap-2">
                <i class="bi bi-envelope text-indigo-500"></i> Mail Configuration
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="MAIL_MAILER" value="Mailer" />
                    <x-text-input id="MAIL_MAILER" name="MAIL_MAILER" type="text"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_MAILER', $settings['MAIL_MAILER']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_MAILER')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="MAIL_HOST" value="Mail Host" />
                    <x-text-input id="MAIL_HOST" name="MAIL_HOST" type="text"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_HOST', $settings['MAIL_HOST']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_HOST')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="MAIL_PORT" value="Mail Port" />
                    <x-text-input id="MAIL_PORT" name="MAIL_PORT" type="number"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_PORT', $settings['MAIL_PORT']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_PORT')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="MAIL_USERNAME" value="Mail Username" />
                    <x-text-input id="MAIL_USERNAME" name="MAIL_USERNAME" type="text"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_USERNAME', $settings['MAIL_USERNAME']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_USERNAME')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="MAIL_PASSWORD" value="Mail Password" />

                    <div class="relative">
                        <x-text-input id="MAIL_PASSWORD" name="MAIL_PASSWORD" type="password"
                            class="block w-full mt-1 pr-10"
                            value="{{ old('MAIL_PASSWORD', $settings['MAIL_PASSWORD']) }}" required />

                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-indigo-600 focus:outline-none">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('MAIL_PASSWORD')" class="mt-2" />
                </div>


                <div>
                    <x-input-label for="MAIL_FROM_ADDRESS" value="Mail From Address" />
                    <x-text-input id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" type="email"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_FROM_ADDRESS', $settings['MAIL_FROM_ADDRESS']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_FROM_ADDRESS')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="MAIL_FROM_NAME" value="Mail From Name" />
                    <x-text-input id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" type="text"
                        class="block w-full mt-1"
                        value="{{ old('MAIL_FROM_NAME', $settings['MAIL_FROM_NAME']) }}" required />
                    <x-input-error :messages="$errors->get('MAIL_FROM_NAME')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                <i class="bi bi-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const $input = $('#MAIL_PASSWORD');
            const $icon = $(this).find('i');

            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                $input.attr('type', 'password');
                $icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });
    });
</script>
@endpush