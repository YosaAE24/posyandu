<x-home-layout>

    <div class="w-full max-w-6xl mx-auto space-y-12 py-14 p-8 flex justify-center" x-data="{
        selected: '{{ $activity->thumbnail }}',
        openModal() {
            $dispatch('open-modal', 'open-detail-modal')
        },
        close() {
            $dispatch('close-modal', 'open-detail-modal')
        }
    }">
        <div class="flex flex-col gap-4 max-w-3xl w-full">
            <h1 class="text-4xl font-black leading-relaxed ">{{ $activity->title }}</h1>
            <div class="inline-flex items-center gap-4 border-b pb-4 flex-wrap">
                <img src="{{ $activity->user->picture }}" alt="{{ $activity->user->name }}"
                    class="h-6 w-6 object-cover rounded-full">
                <div class="text-gray-500 text-sm">{{ $activity->user->name }} &middot;
                    {{ $activity->created_at->diffForHumans() }}</div>
                &middot;
                @foreach ($activity->tags as $tag)
                    <a href="{{ $tag->slug }}"
                        class="bg-cyan-500/20 text-cyan-700 px-2 py-1 rounded-md text-xs whitespace-nowrap">{{ $tag->name }}</a>
                @endforeach
            </div>
            <div>
                <article class="prose prose-md w-full max-w-none ">
                    <picture class="w-full mx-auto flex items-center justify-center mb-8">
                        <img src="{{ $activity->thumbnail }}" alt="{{ $activity->title }}"
                            class="max-h-[480px] object-contain rounded-xl border w-fit">
                    </picture>


                    {!! $activity->render() !!}


                    <h2 class="w-full border-b">Dokumentasi</h2>
                    <div class="not-prose grid grid-cols-3 md:grid-cols-4 gap-4">
                        @if (empty($activity->medias))
                            <div class="w-full flex items-center justify-center gap-4">

                            </div>
                        @else
                            @foreach (json_decode($activity->medias) as $media)
                                <img src="{{ $media }}" alt=""
                                    @click="selected = '{{ $media }}'; openModal()"
                                    class="w-full h-full object-contain rounded-xl border cursor-pointer">
                            @endforeach
                        @endif
                    </div>
                </article>
            </div>
        </div>
        <x-modal name="open-detail-modal" x-show="openModal" @close="close">
            <img :src="selected" alt="" class="w-full h-full object-contain rounded-xl border">
        </x-modal>
    </div>
    <div class="pt-8 mt-8 border-t flex flex-col gap-4 max-w-7xl mx-auto p-8">

        <h1 class="text-3xl font-black">Mungkin Anda Juga Suka</h1>
        @if ($recommendations->count() == 0)
            <div class="w-full flex justify-center" style="box-shadow: 10px 40px 50px 0 #e5f6f56b">
                <x-guest.empty header="Tidak Ada Aktivitas Lainnya"
                    message="Sepertinya kami perlukan waktu untuk menyiapkan aktivitas terbaru. Silahkan kembali lagi nanti." />
            </div>
        @else
            <div class="flex items-center justify-start gap-4 flex-col">
                @foreach ($recommendations as $item)
                    <div class="bg-white shadow-cyan-200 rounded-xl overflow-hidden border border-gray-100 relative z-10"
                        style="box-shadow: 10px 40px 50px 0 #e5f6f56b">
                        <a href="{{ route('activity.show', $item['slug']) }}"
                            class="w-full flex flex-col-reverse md:flex-row">
                            <div class="p-8 flex flex-col gap-3 shrink">
                                <h2 class="text-xl font-bold leading-relaxed line-clamp-2">{{ $item['title'] }}
                                </h2>
                                <p>{{ $item->getDiff() }}</p>
                                <p class="leading-normal text-sm text-gray-400">{{ $item->getExcerpt(200) }}</p>
                                <p class="text-cyan-500">
                                    Baca Selengkapnya...
                                </p>
                            </div>
                            <div
                                class="w-full md:w-56 lg:w-96 shrink-0 h-auto aspect-video flex items-center justify-center relative bg-white object-cover">
                                <img src="{{ $item['thumbnail'] }}" alt=""
                                    class="w-full h-full object-cover aspect-video">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-home-layout>
