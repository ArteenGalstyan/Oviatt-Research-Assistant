
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
<div class="flex flex-wrap" style="margin: 65px">
<div class="w-full">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1 flex flex-col">
        <div class="bg-cover h-48" style="background-image: url({{$data['image']}}); background-attachment: fixed;
                background-position: center;"></div>
        <div class="p-4 flex-1 flex flex-col" style="
">
            <h3 class="mb-4 text-2xl"><a href="">{{$data['title']}}</a></h3>
            <div class="mb-4 text-grey-darker text-sm flex-1">
                <p>{{$data['description']}}</p>
            </div>
            <a href="{{$data['source']}}" class="border-t border-grey-light pt-2 text-xs text-grey hover:text-red uppercase no-underline tracking-wide" style="">{{$data['source_title']}}</a>
        </div>
    </div>
</div>
</div>
<style>
    .header {
        height: 50px;
    }
</style>
