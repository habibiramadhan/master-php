{{-- resources/views/public/peralatan/index.blade.php --}}
<x-public-layout :title="'Katalog Peralatan'" :pengaturan="$pengaturan">
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="fw-bold">Katalog Peralatan</h1>
                <p class="text-muted">Pilih alat berat sesuai kebutuhan proyek Anda</p>
            </div>

            @include('public.peralatan.partials.filter')
            
            @include('public.peralatan.partials.equipment-grid')
        </div>
    </section>
</x-public-layout>