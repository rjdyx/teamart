@extends('layouts.newapp')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">查看留言</h3>
    </div>
    <div class="panel-body">
        <table border="1" class="table">
            <tr><td>姓名</td><td>电话</td><td>内容</td><td>图片</td></tr>
        @foreach($feedbacks as $feedback)
                    <tr><td>{{$feedback->name}}</td><td>  {{$feedback->phone}}</td>
                        <td>{{$feedback->content}}</td>
                        <td>
                            @if($feedback->feedbackImage==null)

                            @else
                                <img src ='{{url(App\FeedbackImage::FEEDBACK .$feedback->feedbackImage->path) }}'>
                            @endif

                        </td></tr>
        @endforeach
        </table>
    </div>
    <div class="text-center">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection