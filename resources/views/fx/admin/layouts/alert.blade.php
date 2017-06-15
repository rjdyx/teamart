    <script>
      //搜索
      function search(page, arrs) {
        var url = window.location.href.split('?')[0] + '?page=' + page;
        for(var i=0;i<arrs.length;i++) {
          if ($("#"+arrs[i]).val() != undefined) {
            url += '&' + $("#"+arrs[i]).attr('name') + '=' + $("#"+arrs[i]).val();
          }
        }
        window.location.href = url;
      }
      //单条删除
      function del(id) {
        if (confirm('确定要删除这条记录吗？')==true){ 
          $("#del").attr('action', window.location.href + '/' + id);
          $("#del").submit();
        }
      }
      //多条删除
      function dels() {
        if ($(".check:checked").length > 0) {
          if (confirm('确定要删除选中记录吗？')==true){ 
            var ids = Array();
            $("#dels").attr('action', window.location.href + '/dels');
            $(".check:checked").each(function(){
                ids.push($(this).val());
            });
            $("#delsIds").val(ids);
            $("#dels").submit();
          }
        }

      }
    </script>

    <style>
      .alert{
        width:180px;
        height:40px;
        position:absolute;
        left: 60%;
        top:55px;
        color:white;
        text-align: center;
        line-height: 10px;
        border-radius: 5px;
        font-size:18px;
        opacity: 0;
        -webkit-animation-name: fadeDown; /*动画名称*/
        -webkit-animation-duration: 2s; /*动画持续时间*/
        -webkit-animation-iteration-count: 1; /*动画次数*/
        -webkit-animation-delay: 0s; /*延迟时间*/
      }
      @-webkit-keyframes fadeDown {
        10% {
        opacity: 1; /*开始状态 透明度为0*/
        }
        80% {
        opacity: 0.8; /*开始状态 透明度为0*/
        }
        100% {
        opacity: 0; /*结尾状态 透明度为1*/
        }
      }
      .success{background: #00a65a;}
      .danger{background: #dd4b39;}
    </style>

    <!-- 单条数据删除 -->
    <form action="" method="POST" id="del">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
    </form>

    <!-- 多条数据删除 -->
    <form action="" method="POST" id="dels">
      {{ csrf_field() }}
      <input type="hidden" name="ids" id="delsIds" value="">
    </form>

    @if (session('status'))
    <div class="alert success">
        {{ session('status') }}
    </div>
    @endif
    @if (count($errors) > 0)
    <div class="alert danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif