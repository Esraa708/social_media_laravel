<div class="card px-3">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="media">
                        <img width="50" height="50" class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://i.imgur.com/stD0Q19.jpg" />
                        <div class="media-body">
                            <div class="row">
                                <div class="col-8 d-flex">
                                    <h5>{{ $comment->user->name }}</h5>
                                    <!-- <span>- 2 hours ago</span> -->
                                </div>
                                <div class="col-4">
                                    <div class="pull-right reply" >
                                    </div>
                                </div>
                            </div>
                            {{ $comment->content }} <br />
                       
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>