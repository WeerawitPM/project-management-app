<x-filament-panels::page>
    {{ $this->form }}
    @livewire(\App\Filament\Resources\DashboardResource\Widgets\TableDetail::class)

    @if (count($data['images']) > 0)
        <section id="image-carousel" class="splide" aria-label="Beautiful Images">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($data['images'] as $index => $item)
                        <li class="splide__slide">
                            <a href="/storage/{{ $item }}" target="_blank">
                                <img src="/storage/{{ $item }}" alt="">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        <style>
            .splide__slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('#image-carousel', {
                    cover: true,
                    heightRatio: 0.5,
                }).mount();
            });
        </script>

    @endif

</x-filament-panels::page>
