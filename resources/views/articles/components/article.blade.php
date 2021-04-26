<script src="{{asset('js/api.js')}}"></script>
<script>
    function favoriteArticle(articleId, userId) {
        post('/article/favorite',
            {
                'id': articleId,
                'user_id': userId
            },
            (res) => {alert(JSON.parse(res).reason); window.location.reload()},
            (res) => {alert(JSON.parse(res).reason); window.location.reload()}
        );
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
<div class="flex flex-wrap" style="margin: 65px">
<div class="w-full mb-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1 flex flex-col">
        <div class="bg-cover h-12" style="background-image: url({{$data['image']}}); background-attachment: fixed;
                background-position: center;"></div>
        <div class="p-4 flex-1 flex flex-col" style="
">
            <h3 class="mb-4 text-2xl"><a href="">{{$data['title']}}</a></h3>
            <div class="mb-4 text-grey-darker text-sm flex-1">
                <p>{{$data['description']}}</p>
                <br>
                <p><b>Keywords</b>: {{str_replace('\n', ', ', $data['keywords'])}}</p>
                <p><b>Subjects</b>: {{str_replace('\n', ', ', $data['subjects'])}}</p>
                <p><b>Publication Type</b>: {{str_replace('\n', ', ', $data['pub_type'])}}</p>
                <p><b>Publisher</b>: {{str_replace('\n', ', ', $data['publisher'])}}</p>
                <p><b>Year</b>: {{str_replace('\n', ', ', $data['year'])}}</p>
                <p><b>ISSN</b>: {{str_replace('\n', ', ', $data['issn'])}}</p>
                <p><b>ISBN</b>: {{str_replace('\n', ', ', $data['isbn'])}}</p>
            </div>
            <a href="{{$data['source']}}" class="border-t border-grey-light pt-2 text-xs text-grey hover:text-red uppercase no-underline tracking-wide" style="">{{$data['source_title']}}</a>
            <br>
            <a style="cursor: pointer" onclick="favoriteArticle({{$data['id']}}, {{Auth::user()->id}})"><i class="fas fa-heart" style="color: {{$data['is_favorited'] ? "red" : "gray"}}" ></i></a>
        </div>
    </div>
</div>
    <div class="container" style="margin-top: 0px; padding: 0;">
        <h4 class="mb-4 text-2xl">Related Articles</h4>
    </div>
    @foreach($suggested as $suggestion)
        <div class="w-full sm:w-1/2 md:w-1/3 flex flex-col p-3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex-1 flex flex-col">
                <div class="p-4 flex-1 flex flex-col" style="">
                    <h3 class="mb-4 text-1xl"><a href="article?id={{$suggestion->ID}}">{{$suggestion->TITLE}}</a></h3>
                    <div class="mb-4 text-grey-darker text-sm flex-1">
                        <p>{{substr($suggestion->ABSTRACT, 0, 64) . '...' }}</p>
                    </div>
                    <a href="{{$suggestion->SOURCE}}" class="border-t border-grey-light pt-2 text-xs text-grey hover:text-red uppercase no-underline tracking-wide" style="">{{$suggestion->SOURCE}}</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<style>
    .header {
        height: 50px;
    }
</style>
