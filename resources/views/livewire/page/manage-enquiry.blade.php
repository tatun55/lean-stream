<div class="grid grid-cols-1 p-3 gap-3 lg:grid-cols-3 flex-grow max-h-full">

    <livewire:page.manage-enquiry.show-clients />

    <livewire:page.manage-enquiry.manage-message />

    <livewire:page.manage-enquiry.manage-remark />

</div>

@push('heads')
    <link rel="stylesheet" href="https://unpkg.com/photoswipe@5.2.2/dist/photoswipe.css">
@endpush

@push('scripts')
    <script type="module">
        import PhotoSwipeLightbox from 'https://unpkg.com/photoswipe/dist/photoswipe-lightbox.esm.js';

        // Function to set width and height attributes
        function initPswp() {
            alert('initPswp');
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
        Livewire.on('rendered', () => {
            initPswp();
        })
        document.addEventListener('livewire:init', () => {
            Livewire.on('rendered', () => {
                initPswp();
            })
        });
        
    </script>
@endpush