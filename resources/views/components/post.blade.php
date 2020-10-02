<div class="card gedf-card mb-0">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="" />
                </div>
                <div class="ml-2">
                    <div class="h5 m-0">{{ $post->user->name }}</div>

                </div>
            </div>
            <div>
                <div class="pull-right reply">
                    <a href="/post/{{$post->id}}" target="_blanck"><span><i class="fa fa-eye"></i> </span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="text-muted h7 mb-2">
            <i class="fa fa-clock-o"></i>{{\Carbon\Carbon::parse($post->created_at)->format('d/m/y')}}
        </div>
        <a class="card-link" href="#">
            <h5 class="card-title">
                {{ $post->post_title }}
            </h5>
        </a>

        <p class="card-text">
            {{ $post->post_content }}
        </p>
    </div>



</div>