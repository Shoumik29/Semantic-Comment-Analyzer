<div>
    <h2>Update Comment</h2>
    <form action="/update-comment/{{$data->ID}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="put"/>
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your ID", name="userID" value="{{$data->ID}}">
            <span style="color:red">@error('userID'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your Name", name="userName" value="{{$data->Name}}">
            <span style="color:red">@error('userName'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <input type="text", placeholder="Enter Your Comment", name="userComment" value="{{$data->Comment}}">
            <span style="color:red">@error('userComment'){{$message}}@enderror</span>
        </div>
        <div class="input-wrapper">
            <button>Update Comment</button>
        </div>
    </form>
    <a href="/home">Go to Home</a>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
