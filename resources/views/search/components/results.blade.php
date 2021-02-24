<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">

<div class="flex flex-wrap" style="margin: 65px">
    @foreach($results as $result)

        <div class="w-full sm:w-1/2 md:w-1/3 flex flex-col p-3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1 flex flex-col">
                <div class="bg-cover h-48" style="background-image: url({{$result['image']}});"></div>
                <div class="p-4 flex-1 flex flex-col" style="
">
                    <h3 class="mb-4 text-2xl"><a href="article?id={{$result['id']}}">{{$result['title']}}</a></h3>
                    <div class="mb-4 text-grey-darker text-sm flex-1">
                        <p>{{$result['description']}}</p>
                    </div>
                    <a href="{{$result['source']}}" class="border-t border-grey-light pt-2 text-xs text-grey hover:text-red uppercase no-underline tracking-wide" style="">{{$result['source_title']}}</a>
                </div>
            </div>
        </div>

    @endforeach
</div>
<style>
    .header {
        height: 50px;
    }
    .footer {
        position: relative;
    }
</style>