<link rel="stylesheet" href="{{asset('css/history/history.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
<div class="wrap">
    <div class="row form-group">
        <div class="table_controls col-sm-12">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="col-md-1">Favorites</th>
                        <th scope="col" class="col-md-1">Publisher</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($favorites as $favorite)
                        <tr data-seq="1">
                            <td class="td_row_text"><a href="article?id={{$favorite->article_id}}">{{$favorite->TITLE}}</a></td>
                            <td class="td_row_text">{{$favorite->PUBLISHER}}</td>
                            <td class="text-center"><i onclick="unfavoriteArticle({{$favorite->article_id}})" class="fas fa-trash remove_row"></i></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <pre>
                {!! $citation !!}
                </pre>
            </div>
        </div>
    </div>
</div>
<style>
    .header {
        height: 50px;
    }
</style>

<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('js/api.js')}}"></script>
<script>
    function unfavoriteArticle(id) {
        post('/article/favorite', {'id': id, 'user_id': '{{Auth::user()->id}}',}, () => {alert('Successfuly unfavorited article'); window.location.reload()}, () => {alert('Failed'); window.location.reload()})
    }
</script>
