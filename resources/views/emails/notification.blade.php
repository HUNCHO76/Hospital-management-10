<x-mail::message>
# {{ $title }}

{{ $message }}

@if (!empty($data))
<x-mail::button url="{{ route('dashboard') }}">
View Details
</x-mail::button>
@endif

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
