{{-- resources/views/public/welcome.blade.php --}}
<x-public-layout :title="'Beranda'" :pengaturan="$pengaturan">
    @include('public.partials.hero')
    
    @include('public.partials.featured-equipment', ['peralatan' => $peralatan])
    
    @include('public.partials.how-it-works')
    
    
</x-public-layout>