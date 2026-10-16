@extends('layouts.app')

@section('title', 'Galeri & Video Kegiatan - Pancasuman')
@section('metaDescription', 'Arsip dokumentasi foto kegiatan, sinau bareng, majelis, dan video komunitas Maiyah Pancasuman.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    {{-- Hero Header --}}
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-blue-800 text-xs font-semibold shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
            <span>Dokumentasi & Arsip Visual</span>
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
            Galeri Kegiatan & Video
        </h1>
        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
            Menghimpun jejak kebersamaan, majelis sinau bareng, karya literasi, dan rekaman dokumentasi kegiatan jamaah Maiyah Pancasuman.
        </p>

        {{-- Tab Switcher --}}
        <div class="pt-2 flex items-center justify-center">
            <div class="inline-flex p-1.5 rounded-2xl bg-slate-200/70 dark:bg-slate-800 border border-slate-300/60 dark:border-slate-700 shadow-inner gap-1">
                <button type="button" id="tab-btn-photos" onclick="switchGalleryTab('photos')" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer bg-white dark:bg-slate-700 text-blue-700 dark:text-blue-300 shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Foto Kegiatan ({{ $galleries->total() }})</span>
                </button>

                <button type="button" id="tab-btn-videos" onclick="switchGalleryTab('videos')" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Video Dokumentasi ({{ $videos->count() }})</span>
                </button>
            </div>
        </div>
    </div>

    {{-- SECTION 1: FOTO KEGIATAN --}}
    <div id="section-photos" class="space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($galleries as $item)
            <div class="card-lift bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300 cursor-pointer"
                 onclick="openPhotoLightbox('{{ asset('storage/' . $item->image) }}', '{{ addslashes($item->title) }}', '{{ $item->activity_date ? $item->activity_date->format('d F Y') : '' }}', '{{ addslashes($item->description ?? '') }}')">
                <div>
                    <div class="h-52 w-full bg-slate-100 dark:bg-slate-800 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($item->activity_date)
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-mono shadow-xs">
                                {{ $item->activity_date->format('d M Y') }}
                            </span>
                        @endif

                        {{-- Zoom Icon Hover Indicator --}}
                        <div class="absolute inset-0 bg-blue-900/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full bg-white/90 text-blue-700 flex items-center justify-center shadow-md scale-75 group-hover:scale-100 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 space-y-1.5">
                        <h3 class="font-bold text-base text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition leading-snug line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        @if($item->description)
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $item->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="px-5 py-3 border-t border-slate-100/80 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
                    <span>Klik untuk memperbesar</span>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold group-hover:translate-x-1 transition-transform">&rarr;</span>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-12 text-center text-slate-400 dark:text-slate-500">
                <p>Belum ada dokumentasi foto kegiatan yang diunggah.</p>
            </div>
            @endforelse
        </div>

        @if($galleries->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $galleries->links() }}
        </div>
        @endif
    </div>

    {{-- SECTION 2: VIDEO DOKUMENTASI --}}
    <div id="section-videos" class="space-y-8 hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($videos as $video)
            @php
                $thumbSrc = $video->thumbnail 
                    ? (str_starts_with($video->thumbnail, 'http') ? $video->thumbnail : asset('storage/' . $video->thumbnail))
                    : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop';
            @endphp
            <div class="card-lift bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:border-purple-300 dark:hover:border-purple-500/50 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300 cursor-pointer"
                 onclick="openVideoModal('{{ $video->embed_url }}', '{{ addslashes($video->title) }}', '{{ addslashes($video->description ?? '') }}', '{{ $video->platform }}')">
                <div>
                    {{-- Thumbnail & Play Overlay --}}
                    <div class="h-52 w-full bg-slate-900 overflow-hidden relative flex items-center justify-center">
                        <img src="{{ $thumbSrc }}" alt="{{ $video->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                        
                        {{-- Dark Vignette --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                        {{-- Play Button --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-xl shadow-rose-600/40 group-hover:scale-115 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        {{-- Platform Badge --}}
                        <span class="absolute top-3 right-3 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-900/80 backdrop-blur-xs text-white border border-white/10 shadow-xs">
                            {{ $video->platform }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <h3 class="font-bold text-base text-slate-900 dark:text-slate-100 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition leading-snug line-clamp-2">
                            {{ $video->title }}
                        </h3>
                        @if($video->description)
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $video->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-rose-600 dark:text-rose-400 font-bold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                        <span>Tonton Sekarang</span>
                    </span>
                    <span class="text-slate-400 dark:text-slate-500 group-hover:text-purple-600 dark:group-hover:text-purple-400 font-medium">Buka Video &rarr;</span>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-12 text-center text-slate-400 dark:text-slate-500">
                <p>Belum ada dokumentasi video yang ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- MODAL LIGHTBOX FOTO --}}
<div id="lightbox-modal" class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md hidden flex items-center justify-center p-4" onclick="closePhotoLightbox()">
    <div class="max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl relative" onclick="event.stopPropagation()">
        <button type="button" onclick="closePhotoLightbox()" class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-slate-800/80 hover:bg-slate-700 text-white flex items-center justify-center transition cursor-pointer">
            &times;
        </button>
        <div class="max-h-[75vh] bg-black flex items-center justify-center overflow-hidden">
            <img id="lightbox-img" src="" alt="Perbesar" class="max-h-[75vh] w-auto max-w-full object-contain">
        </div>
        <div class="p-6 space-y-1 text-white bg-slate-900">
            <div class="flex items-center justify-between gap-4">
                <h3 id="lightbox-title" class="text-lg font-bold"></h3>
                <span id="lightbox-date" class="text-xs font-mono text-slate-400 shrink-0"></span>
            </div>
            <p id="lightbox-desc" class="text-xs text-slate-300 leading-relaxed"></p>
        </div>
    </div>
</div>

{{-- MODAL PEMUTAR VIDEO --}}
<div id="video-modal" class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md hidden flex items-center justify-center p-4" onclick="closeVideoModal()">
    <div class="max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl relative" onclick="event.stopPropagation()">
        <div class="p-4 bg-slate-900 border-b border-slate-800 flex items-center justify-between text-white">
            <div class="min-w-0 pr-4">
                <h3 id="video-modal-title" class="text-sm sm:text-base font-bold truncate"></h3>
                <span id="video-modal-platform" class="text-[10px] font-mono uppercase tracking-wider text-purple-400"></span>
            </div>
            <button type="button" onclick="closeVideoModal()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center text-lg transition cursor-pointer">
                &times;
            </button>
        </div>

        {{-- 16:9 Iframe Container --}}
        <div class="relative w-full pt-[56.25%] bg-black">
            <iframe id="video-modal-iframe" src="" class="absolute inset-0 w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>

        <div id="video-modal-desc-wrapper" class="p-4 bg-slate-900 border-t border-slate-800 text-xs text-slate-300">
            <p id="video-modal-desc"></p>
        </div>
    </div>
</div>

<script>
    // Tab Switcher Logic
    function switchGalleryTab(tab) {
        const secPhotos = document.getElementById('section-photos');
        const secVideos = document.getElementById('section-videos');
        const btnPhotos = document.getElementById('tab-btn-photos');
        const btnVideos = document.getElementById('tab-btn-videos');

        if (tab === 'photos') {
            secPhotos.classList.remove('hidden');
            secVideos.classList.add('hidden');
            btnPhotos.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer bg-white dark:bg-slate-700 text-blue-700 dark:text-blue-300 shadow-xs';
            btnVideos.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100';
        } else {
            secPhotos.classList.add('hidden');
            secVideos.classList.remove('hidden');
            btnVideos.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer bg-white dark:bg-slate-700 text-purple-700 dark:text-purple-300 shadow-xs';
            btnPhotos.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 cursor-pointer text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100';
        }
    }

    // Lightbox Logic
    function openPhotoLightbox(src, title, date, desc) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-title').textContent = title;
        document.getElementById('lightbox-date').textContent = date;
        document.getElementById('lightbox-desc').textContent = desc;
        document.getElementById('lightbox-modal').classList.remove('hidden');
    }

    function closePhotoLightbox() {
        document.getElementById('lightbox-modal').classList.add('hidden');
        document.getElementById('lightbox-img').src = '';
    }

    // Video Modal Logic
    function openVideoModal(embedUrl, title, desc, platform) {
        document.getElementById('video-modal-title').textContent = title;
        document.getElementById('video-modal-platform').textContent = 'Platform: ' + platform;
        document.getElementById('video-modal-desc').textContent = desc;
        
        const descWrap = document.getElementById('video-modal-desc-wrapper');
        if (desc) {
            descWrap.classList.remove('hidden');
        } else {
            descWrap.classList.add('hidden');
        }

        document.getElementById('video-modal-iframe').src = embedUrl;
        document.getElementById('video-modal-modal', 'video-modal');
        document.getElementById('video-modal').classList.remove('hidden');
    }

    function closeVideoModal() {
        document.getElementById('video-modal').classList.add('hidden');
        document.getElementById('video-modal-iframe').src = '';
    }

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePhotoLightbox();
            closeVideoModal();
        }
    });

    // Support query param ?tab=videos
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'videos' || window.location.hash === '#video' || window.location.hash === '#videos') {
            switchGalleryTab('videos');
        }
    });
</script>
@endsection
