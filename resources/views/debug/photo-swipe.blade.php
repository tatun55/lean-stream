<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ config('app.theme') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/photoswipe@5.2.2/dist/photoswipe.css">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-[100dvh] bg-base-200 flex flex-col">
    <livewire:navbar />

    <div id="pswp-wrapper">
        <div class="grid grid-cols-2 gap-4 pswp-gallery">
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 pswp-gallery">
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
            <a href="https://via.placeholder.com/150" target="_blank" class="w-full h-48 bg-gray-200">
                <img src="https://via.placeholder.com/150" alt="Image 1" class="object-cover w-full h-full">
            </a>
        </div>
    </div>

    <script type="module">
        import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe/dist/photoswipe-lightbox.esm.js';

        // Function to set width and height attributes
        function setDimensionsAndInitPhotoSwipe() {
            const galleries = document.querySelectorAll('.pswp-gallery');

            galleries.forEach((gallery, index) => {
                gallery.id = `gallery-${index}`;

                const links = gallery.querySelectorAll('a');
                let imagesLoaded = 0;

                links.forEach(link => {
                    const img = new Image();
                    img.src = link.href;

                    img.onload = () => {
                        link.setAttribute('data-pswp-width', img.naturalWidth);
                        link.setAttribute('data-pswp-height', img.naturalHeight);
                        imagesLoaded++;

                        if (imagesLoaded === links.length) {
                            const lightbox = new PhotoSwipeLightbox({
                                gallery: `#gallery-${index}`,
                                children: 'a',
                                pswpModule: () => import('https://unpkg.com/photoswipe'),
                            });
                            lightbox.init();
                        }
                    };
                });
            });
        }

        document.addEventListener('DOMContentLoaded', setDimensionsAndInitPhotoSwipe);
    </script>

</body>

</html>
